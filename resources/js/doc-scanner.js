import * as tf from '@tensorflow/tfjs';

let model;
const IMGSZ = 640;
const testImage = document.getElementById('test-image');
const overlay = document.getElementById('overlay');
const captureBtn = document.getElementById('capture-btn');
const ctx = overlay.getContext('2d');

const POINT_RADIUS = 10;
const HIT_RADIUS = 30;

let points = []; 
let draggingPoint = null;

async function loadAI() {
    try {
        model = await tf.loadGraphModel('/assets/images/models/doc-scanner/model.json');
        console.log("AI Ready");
    } catch (e) { console.error("AI Error", e); }
}

function orderPoints(pts) {
    // Urutkan berdasarkan sumbu X
    let sortedX = pts.slice().sort((a, b) => a.x - b.x);
    let leftSide = sortedX.slice(0, 2);
    let rightSide = sortedX.slice(2, 4);
    
    // Sisi Kiri: Y terkecil = Atas, Y terbesar = Bawah
    leftSide.sort((a, b) => a.y - b.y);
    let tl = leftSide[0]; // Top-Left
    let bl = leftSide[1]; // Bottom-Left
    
    // Sisi Kanan: Y terkecil = Atas, Y terbesar = Bawah
    rightSide.sort((a, b) => a.y - b.y);
    let tr = rightSide[0]; // Top-Right
    let br = rightSide[1]; // Bottom-Right
    
    return [tl, tr, br, bl];
}

function snapToEdges(imageElement, displayW, displayH, fallbackPoints) {
    try {
        let src = cv.imread(imageElement);
        let resized = new cv.Mat();
        // Samakan resolusi pencarian OpenCV dengan resolusi visual layar
        cv.resize(src, resized, new cv.Size(displayW, displayH));
        
        let gray = new cv.Mat();
        cv.cvtColor(resized, gray, cv.COLOR_RGBA2GRAY, 0);
        
        // Blur untuk menghilangkan noise/serat kertas
        let blur = new cv.Mat();
        cv.GaussianBlur(gray, blur, new cv.Size(5, 5), 0, 0, cv.BORDER_DEFAULT);
        
        // Cari garis tepi (Edge Detection)
        let edges = new cv.Mat();
        cv.Canny(blur, edges, 75, 200);
        
        // Pertebal garis tepi agar tidak terputus
        let kernel = cv.Mat.ones(5, 5, cv.CV_8U);
        cv.dilate(edges, edges, kernel, new cv.Point(-1, -1), 1);
        cv.erode(edges, edges, kernel, new cv.Point(-1, -1), 1);
        
        // Temukan kontur/bentuk
        let contours = new cv.MatVector();
        let hierarchy = new cv.Mat();
        cv.findContours(edges, contours, hierarchy, cv.RETR_LIST, cv.CHAIN_APPROX_SIMPLE);
        
        let maxArea = 0;
        let bestApprox = new cv.Mat();
        let found = false;
        
        for (let i = 0; i < contours.size(); i++) {
            let cnt = contours.get(i);
            let area = cv.contourArea(cnt);
            
            // Abaikan bentuk kecil (minimal harus 10% dari luas layar)
            if (area > (displayW * displayH * 0.1)) {
                let peri = cv.arcLength(cnt, true);
                let approx = new cv.Mat();
                // Toleransi sudut
                cv.approxPolyDP(cnt, approx, 0.02 * peri, true);
                
                // Jika bentuknya segiempat (4 sudut) dan ukurannya paling besar
                if (approx.rows === 4 && area > maxArea) {
                    maxArea = area;
                    approx.copyTo(bestApprox);
                    found = true;
                }
                approx.delete();
            }
            cnt.delete();
        }
        
        let refinedPoints = fallbackPoints;
        
        // Jika garis tepi segiempat kertas berhasil ditemukan
        if (found) {
            let data = bestApprox.data32S;
            let tempPts = [
                {x: data[0], y: data[1]},
                {x: data[2], y: data[3]},
                {x: data[4], y: data[5]},
                {x: data[6], y: data[7]}
            ];
            // Urutkan titik agar sesuai format Kiri-Atas s.d Kiri-Bawah
            refinedPoints = orderPoints(tempPts);
        }
        
        // Bersihkan memori OpenCV (WAJIB agar browser tidak crash)
        src.delete(); resized.delete(); gray.delete(); blur.delete(); 
        edges.delete(); kernel.delete(); contours.delete(); 
        hierarchy.delete(); bestApprox.delete();
        
        return refinedPoints;

    } catch (err) {
        console.error("OpenCV Snap gagal, kembali ke AI:", err);
        return fallbackPoints; // Jika OpenCV gagal, tetap gunakan titik dari AI
    }
}

// 1. Logic Upload & Syncing
document.getElementById('image-upload').addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (!file) return;

    //document.getElementById('loading-spinner').classList.remove('hidden');
    const reader = new FileReader();
    
    reader.onload = (event) => {
        testImage.src = event.target.result;
        document.getElementById('image-placeholder').classList.add('hidden');
        testImage.classList.remove('hidden');
        
        testImage.onload = () => {
            // Tampilkan wrapper
            document.getElementById('image-wrapper').classList.remove('hidden');
            
            // PERBAIKAN: Beri jeda 1 frame agar browser selesai menghitung ukuran gambar
            requestAnimationFrame(() => {
                // Ambil ukuran gambar yang TAMPIL di layar
                const displayW = testImage.clientWidth;
                const displayH = testImage.clientHeight;

                // Set ukuran internal canvas agar resolusinya sama dengan tampilan layar
                overlay.width = displayW;
                overlay.height = displayH;

                // Inisialisasi titik default
                const marginX = displayW * 0.1;
                const marginY = displayH * 0.1;
                
                points = [
                    { x: marginX, y: marginY },
                    { x: displayW - marginX, y: marginY },
                    { x: displayW - marginX, y: displayH - marginY },
                    { x: marginX, y: displayH - marginY }
                ];

                drawPoints(); 

                // Panggil AI
                if (model) {
                    runDetection();
                } else {
                    captureBtn.disabled = false; 
                }
            });
        };
    };
    reader.readAsDataURL(file);
});

// 2. AI Detection dengan Letterbox Scaling & NMS Filtering
async function runDetection() {
    const input = tf.tidy(() => {
        return tf.browser.fromPixels(testImage)
            .resizeBilinear([IMGSZ, IMGSZ])
            .div(255.0)
            .expandDims(0);
    });

    const predictions = model.execute(input);
    const data = await predictions.data();
    
    // Output YOLOv8-pose biasanya memiliki bentuk (shape) [1, 17, 8400]
    // Artinya ada 17 baris data dan 8400 kolom tebakan
    const shape = predictions.shape;
    const numAnchors = shape[2]; // Biasanya 8400

    // 1. CARI TEBAKAN DENGAN SKOR TERTINGGI
    let maxConf = 0;
    let bestIndex = 0;
    
    for (let i = 0; i < numAnchors; i++) {
        // Baris ke-4 (index 4) adalah letak skor confidence object
        const conf = data[4 * numAnchors + i]; 
        
        if (conf > maxConf) {
            maxConf = conf;
            bestIndex = i;
        }
    }

    // 2. AMBIL TITIK KOORDINAT DARI TEBAKAN TERBAIK TERSEBUT
    // Jika AI cukup yakin (Confidence di atas 30%)
    if (maxConf > 0.3) {
        let aiPoints = [];
        
        for (let j = 0; j < 4; j++) {
            const rowX = 5 + (j * 3); 
            const rowY = 6 + (j * 3); 

            const px = data[rowX * numAnchors + bestIndex];
            const py = data[rowY * numAnchors + bestIndex];

            aiPoints.push({
                x: px * (overlay.width / IMGSZ),
                y: py * (overlay.height / IMGSZ)
            });
        }
        
        points = snapToEdges(testImage, overlay.width, overlay.height, aiPoints);
        
        document.getElementById('ai-status-text').innerText = `DOKUMEN TERDETEKSI (${Math.round(maxConf * 100)}% YAKIN)`;
        document.getElementById('ai-status-dot').className = 'w-2 h-2 rounded-full bg-emerald-500';
    } else {
        // PERBAIKAN: Jika AI gagal, langsung panggil mode manual agar titik tidak hilang
        document.getElementById('ai-status-text').innerText = "DOKUMEN TIDAK TERDETEKSI - GESER MANUAL";
        document.getElementById('ai-status-dot').className = 'w-2 h-2 rounded-full bg-red-500';
        setManualPoints(); 
    }

    const manualBtn = document.getElementById('manual-btn');
    if (manualBtn) manualBtn.classList.remove('hidden');

    const spinner = document.getElementById('loading-spinner');
    if (spinner) spinner.classList.add('hidden');
    
    drawPoints();
    captureBtn.disabled = false;
    
    tf.dispose([input, predictions]);
}


function setManualPoints() {
    const displayW = overlay.width;
    const displayH = overlay.height;
    
    
    const marginX = displayW * 0.15; 
    const marginY = displayH * 0.15;
    
    points = [
        { x: marginX, y: marginY }, // Top-Left
        { x: displayW - marginX, y: marginY }, // Top-Right
        { x: displayW - marginX, y: displayH - marginY }, // Bottom-Right
        { x: marginX, y: displayH - marginY } // Bottom-Left
    ];
    
    drawPoints();
    
    // Update UI Status
    document.getElementById('ai-status-text').innerText = "MODE MANUAL AKTIF";
    
    document.getElementById('ai-status-dot').className = 'w-2 h-2 rounded-full bg-amber-500';
    document.getElementById('capture-btn').disabled = false;
}

document.getElementById('manual-btn')?.addEventListener('click', setManualPoints);

// 3. Draggable UI Logic
function drawPoints() {
    ctx.clearRect(0, 0, overlay.width, overlay.height);
    
    // Draw Polygon Lines
    ctx.beginPath();
    ctx.strokeStyle = '#3b82f6';
    ctx.lineWidth = 3;
    ctx.setLineDash([5, 5]); // Garis putus-putus agar terlihat modern
    ctx.moveTo(points[0].x, points[0].y);
    points.forEach(p => ctx.lineTo(p.x, p.y));
    ctx.closePath();
    ctx.stroke();
    ctx.setLineDash([]); // Reset garis

    // Draw Handles (Titik Merah)
    points.forEach((p, i) => {
        ctx.beginPath();
        ctx.arc(p.x, p.y, 14, 0, 2 * Math.PI);
        ctx.fillStyle = draggingPoint === i ? '#dc2626' : '#ef4444';
        ctx.fill();
        ctx.strokeStyle = 'white';
        ctx.lineWidth = 3;
        ctx.stroke();
        
        // Glow effect
        ctx.shadowBlur = 10;
        ctx.shadowColor = "rgba(0,0,0,0.3)";
    });
}

// Event Handlers for Dragging
// --- PERBAIKAN 3: Event Handlers for Dragging (Mouse & Touch) ---

// Helper untuk mengambil posisi kursor atau jari
function getPointerPos(e) {
    const rect = overlay.getBoundingClientRect();
    const clientX = e.touches ? e.touches[0].clientX : e.clientX;
    const clientY = e.touches ? e.touches[0].clientY : e.clientY;
    
    // KUNCI: Hitung rasio perbedaan antara resolusi internal Canvas vs ukuran visual di layar
    const scaleX = overlay.width / rect.width;
    const scaleY = overlay.height / rect.height;

    return { 
        x: (clientX - rect.left) * scaleX, 
        y: (clientY - rect.top) * scaleY 
    };
}

function handleStart(e) {
    e.preventDefault();
    const pos = getPointerPos(e);
    // Area klik diperlebar (HIT_RADIUS = 30) agar mudah disentuh jari
    points.forEach((p, i) => {
        if (Math.hypot(p.x - pos.x, p.y - pos.y) < HIT_RADIUS) {
            draggingPoint = i;
        }
    });
}

function handleMove(e) {
    if (draggingPoint === null) return;
    e.preventDefault(); // Mencegah layar ikut ter-scroll saat geser titik di HP
    const pos = getPointerPos(e);
    
    // Constraint: titik tidak bisa keluar area gambar
    points[draggingPoint].x = Math.max(0, Math.min(pos.x, overlay.width));
    points[draggingPoint].y = Math.max(0, Math.min(pos.y, overlay.height));
    drawPoints();
}

function handleEnd() {
    draggingPoint = null;
}

// Pasang event untuk Mouse (Laptop/PC)
overlay.addEventListener('mousedown', handleStart);
window.addEventListener('mousemove', handleMove);
window.addEventListener('mouseup', handleEnd);

// Pasang event untuk Touch (HP/Tablet)
overlay.addEventListener('touchstart', handleStart, { passive: false });
window.addEventListener('touchmove', handleMove, { passive: false });
window.addEventListener('touchend', handleEnd);

// 4. Final Warp Perspective (OpenCV)
// --- PERBAIKAN 2: Dynamic Aspect Ratio untuk Crop ---
// --- GANTI SELURUH BAGIAN TOMBOL PROSES (captureBtn) MENJADI INI ---
captureBtn.addEventListener('click', () => {
    // 1. KUNCI PERBAIKAN: Paksa OpenCV membaca resolusi ASLI (High-Res)
    let hiddenCanvas = document.createElement('canvas');
    hiddenCanvas.width = testImage.naturalWidth;
    hiddenCanvas.height = testImage.naturalHeight;
    let hCtx = hiddenCanvas.getContext('2d');
    hCtx.drawImage(testImage, 0, 0, testImage.naturalWidth, testImage.naturalHeight);
    
    // Baca gambar dari canvas full-res yang kita buat, bukan dari elemen layar
    let src = cv.imread(hiddenCanvas);
    let dst = new cv.Mat();
    
    // Hitung rasio antara resolusi asli vs ukuran visual di layar saat ini
    const ratioX = testImage.naturalWidth / overlay.width;
    const ratioY = testImage.naturalHeight / overlay.height;

    // Titik pada resolusi gambar asli
    let pTL = { x: points[0].x * ratioX, y: points[0].y * ratioY }; // Top Left
    let pTR = { x: points[1].x * ratioX, y: points[1].y * ratioY }; // Top Right
    let pBR = { x: points[2].x * ratioX, y: points[2].y * ratioY }; // Bottom Right
    let pBL = { x: points[3].x * ratioX, y: points[3].y * ratioY }; // Bottom Left

    // Hitung ukuran proporsional (Dynamic Aspect Ratio menggunakan Pythagoras)
    const widthA = Math.hypot(pTR.x - pTL.x, pTR.y - pTL.y);
    const widthB = Math.hypot(pBR.x - pBL.x, pBR.y - pBL.y);
    const outW = Math.max(1, Math.round(Math.max(widthA, widthB))); // Ambil sisi terpanjang

    const heightA = Math.hypot(pTL.x - pBL.x, pTL.y - pBL.y);
    const heightB = Math.hypot(pTR.x - pBR.x, pTR.y - pBR.y);
    const outH = Math.max(1, Math.round(Math.max(heightA, heightB))); 

    let srcArr = [pTL.x, pTL.y, pTR.x, pTR.y, pBR.x, pBR.y, pBL.x, pBL.y];
    let srcCoords = cv.matFromArray(4, 1, cv.CV_32FC2, srcArr);
    
    // Output di-map ke ukuran Proporsional yang baru dihitung
    let dstCoords = cv.matFromArray(4, 1, cv.CV_32FC2, [0, 0, outW, 0, outW, outH, 0, outH]);

    let M = cv.getPerspectiveTransform(srcCoords, dstCoords);
    cv.warpPerspective(src, dst, M, new cv.Size(outW, outH), cv.INTER_LANCZOS4);

    cv.imshow('output-canvas', dst);
    document.getElementById('result-area').classList.remove('hidden');
    document.getElementById('result-area').scrollIntoView({ behavior: 'smooth' });

    // Cleanup memori untuk mencegah kebocoran RAM
    [src, dst, M, srcCoords, dstCoords].forEach(m => m.delete());
    hiddenCanvas.remove(); // Buang canvas sementara
});
// Download Action
document.getElementById('download-btn')?.addEventListener('click', () => {
    const canvas = document.getElementById('output-canvas');
    const link = document.createElement('a');
    link.download = `Document_Scan_${Date.now()}.jpg`;
    link.href = canvas.toDataURL('image/jpeg', 0.9);
    link.click();
});

document.addEventListener('opencv-ready', () => {
    cv['onRuntimeInitialized'] = loadAI;
    if (cv.Mat) loadAI();
});

