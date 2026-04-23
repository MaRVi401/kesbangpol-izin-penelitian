let ticketChart;

function renderMonitoringChart(chartLabels, chartData) {
    const chartCtx = document.getElementById('ticketDonutChart');
    if (!chartCtx) return;

    if (ticketChart) {
        ticketChart.destroy();
    }
    ticketChart = new Chart(chartCtx.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: chartLabels,
            datasets: [{
                data: chartData,
                backgroundColor: ['#3b82f6', '#f59e0b', '#10b981', '#ef4444'],
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            cutout: '80%',
            plugins: { legend: { display: false } }
        }
    });
}

function fetchData(url, config) {
    const contentBody = document.getElementById('ajax-table-content');
    if (contentBody) contentBody.style.opacity = '0.3';

    fetch(url, {
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "Accept": "text/html"
        }
    })
    .then(response => {
        if (!response.ok) throw new Error("Gagal memuat data");
        return response.text();
    })
    .then(html => {
        if (contentBody) {
            contentBody.innerHTML = html;
            contentBody.style.opacity = '1';
        }
        renderMonitoringChart(config.labels, config.data);
        window.history.pushState(null, null, url);
    })
    .catch(error => {
        console.error("AJAX Error:", error);
        if (contentBody) contentBody.style.opacity = '1';
    });
}

function initDashboard(config) {
    renderMonitoringChart(config.labels, config.data);

    setInterval(() => {
        const clock = document.getElementById('realtime-clock');
        if (clock) clock.textContent = new Date().toLocaleTimeString('en-GB');
    }, 1000);

    document.addEventListener('click', function (e) {
        const link = e.target.closest('#table-container a');
        if (link && link.href && link.href.includes('page=')) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            fetchData(link.href, config);
        }
    });
}

function toggleModalUsulan() {
    const modal = document.getElementById('modalUsulanKadis');
    if (modal.classList.contains('hidden')) {
        modal.classList.remove('hidden');
    } else {
        modal.classList.add('hidden');
    }
}

function lihatDetailTiketOperator(uuid, nama) {
    const container = document.getElementById('container-list-tiket');
    const labelNama = document.getElementById('label-nama-operator');
    const modal = document.getElementById('modalUsulanKadis');
    
    if(labelNama) labelNama.innerText = '(Dari ' + nama + ')';

    const rawData = modal.getAttribute('data-tiket');
    const semuaTiketEligible = rawData ? JSON.parse(rawData) : [];

    const tiketOperator = semuaTiketEligible.filter(tiket => tiket.petugas_id === uuid);

    let htmlContent = '';

    if (tiketOperator.length > 0) {
        tiketOperator.forEach(tiket => {
            const statusClass = tiket.status === 'selesai' ? 'text-green-600' : 'text-red-500';
            const deskripsiLengkap = tiket.deskripsi ? tiket.deskripsi : 'Tidak ada deskripsi yang dilampirkan pada tiket ini.';
            const shortDeskripsi = deskripsiLengkap.length > 80 ? deskripsiLengkap.substring(0, 80) + '...' : deskripsiLengkap;
            
            let lampiranHtml = '';
            if (tiket.lampiran) {
                const minioBaseUrl = 'http://localhost:9000/diskominfo-assets';
                lampiranHtml = `
                    <div class="mb-3">
                        <span class="block text-[10px] font-bold uppercase text-gray-500 tracking-wider mb-1.5">Lampiran Laporan:</span>
                        <a href="${minioBaseUrl}/${tiket.lampiran}" target="_blank" class="inline-block hover:opacity-80 transition-opacity">
                            <img src="${minioBaseUrl}/${tiket.lampiran}" alt="Lampiran" class="max-h-32 rounded-lg border border-gray-200 dark:border-gray-700 object-cover shadow-sm">
                        </a>
                    </div>
                `;
            }

            let komentarHtml = '';
            if (tiket.komentar && tiket.komentar.length > 0) {
                komentarHtml = '<div class="space-y-2">';
                komentarHtml += '<span class="block text-[10px] font-bold uppercase text-gray-500 tracking-wider mb-1.5">Komentar Operator:</span>';
                
                tiket.komentar.forEach(kom => {
                    const namaUser = kom.user ? kom.user.nama : 'Operator';
                    komentarHtml += `
                        <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                            <p class="text-[10px] font-black text-blue-600 dark:text-blue-400 mb-0.5">${namaUser}</p>
                            <p class="text-xs text-gray-700 dark:text-gray-300 leading-relaxed">${kom.komentar}</p>
                        </div>
                    `;
                });
                komentarHtml += '</div>';
            } else {
                komentarHtml = `
                    <div>
                        <span class="block text-[10px] font-bold uppercase text-gray-500 tracking-wider mb-1.5">Komentar Operator:</span>
                        <p class="text-xs text-gray-400 italic bg-gray-50 dark:bg-gray-800 p-3 rounded-xl border border-dashed border-gray-200 dark:border-gray-700">Belum ada komentar.</p>
                    </div>
                `;
            }

            htmlContent += `
                <div class="mb-4 relative">
                    <label class="block cursor-pointer relative group">
                        <input type="radio" name="tiket_id" value="${tiket.uuid}" class="peer hidden" required>
                        
                        <div class="p-4 border-2 border-gray-100 dark:border-gray-700 rounded-2xl hover:border-blue-300 dark:hover:border-blue-500/50 peer-checked:border-blue-600 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition-all duration-200 relative z-10">
                            <div class="pr-10"> 
                                <div class="flex items-center gap-2 mb-2 flex-wrap">
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-black rounded-md bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 tracking-wider">
                                        ${tiket.no_tiket}
                                    </span>
                                    <span class="inline-block px-2 py-0.5 text-[10px] font-black rounded-md bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 tracking-wider">
                                        ${tiket.layanan ? tiket.layanan.nama : 'Layanan'}
                                    </span>
                                    <span class="text-[10px] font-black uppercase tracking-wider ${statusClass}">
                                        • ${tiket.status}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-800 dark:text-gray-200 font-medium leading-relaxed">
                                    ${shortDeskripsi}
                                </p>
                            </div>
                        </div>
                        
                        <div class="absolute top-4 right-4 w-6 h-6 rounded-full border-2 border-gray-300 dark:border-gray-600 peer-checked:border-blue-600 peer-checked:bg-blue-600 pointer-events-none transition-all duration-200 z-20"></div>
                        <i class="ti ti-check absolute top-4 right-4 w-6 h-6 flex items-center justify-center text-white opacity-0 peer-checked:opacity-100 text-xs font-bold pointer-events-none transition-all duration-200 z-20"></i>
                    </label>

                    <div class="flex justify-end mt-2 px-1">
                        <button type="button" onclick="document.getElementById('detail-${tiket.uuid}').classList.toggle('hidden')" class="text-[11px] font-bold text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors flex items-center gap-1.5 bg-gray-100 hover:bg-blue-50 dark:bg-gray-800 dark:hover:bg-blue-900/30 px-3 py-1.5 rounded-lg border border-gray-200 dark:border-gray-700">
                            <i class="ti ti-list-details text-sm"></i> Buka Detail, Foto & Komentar
                        </button>
                    </div>

                    <div id="detail-${tiket.uuid}" class="hidden mt-3 p-4 bg-white dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm">
                        <div class="mb-3">
                            <span class="block text-[10px] font-bold uppercase text-gray-500 tracking-wider mb-1.5">Deskripsi Lengkap:</span>
                            <p class="text-xs text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-800 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                                ${deskripsiLengkap}
                            </p>
                        </div>
                        ${lampiranHtml}
                        ${komentarHtml}
                    </div>
                </div>
            `;
        });
    } else {
        htmlContent = `
            <div class="p-8 text-center border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-2xl flex flex-col items-center justify-center h-full">
                <i class="ti ti-inbox text-5xl text-gray-300 dark:text-gray-600 mb-3"></i>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium mt-2">Operator ini belum memiliki tiket berstatus Selesai/Ditolak.</p>
            </div>
        `;
    }

    container.innerHTML = htmlContent;
    modal.classList.remove('hidden');
}

document.getElementById('formUsulanKadis').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);
    let submitBtn = this.querySelector('button[type="submit"]');
    let originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<i class="ti ti-loader animate-spin"></i> Mengirim...';
    submitBtn.disabled = true;

    let actionUrl = this.getAttribute('data-url');

    if (!actionUrl) {
        alert("Error: URL Form (data-url) belum diatur!");
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        return;
    }

    fetch(actionUrl, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
            "Accept": "application/json"
        },
        body: formData
    })
    .then(async response => {
        const data = await response.json().catch(() => ({}));
        if (!response.ok) {
            throw new Error(data.message || "Terjadi kesalahan sistem (Error " + response.status + ").");
        }
        return data;
    })
    .then(data => {
        document.getElementById('modalUsulanKadis').classList.add('hidden');
        document.getElementById('formUsulanKadis').reset();
        tampilkanAlert(true, "Berhasil!", data.message || "Usulan prioritas berhasil dikirim ke Kadis.");
    })
    .catch(error => {
        tampilkanAlert(false, "Gagal Mengirim!", error.message);
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

window.tampilkanAlert = function(isSuccess, title, message) {
    const modal = document.getElementById('modalAlertCustom');
    const icon = document.getElementById('alertIcon');
    
    if (isSuccess) {
        icon.innerHTML = '<i class="ti ti-circle-check text-[70px] text-green-500 drop-shadow-md"></i>';
    } else {
        icon.innerHTML = '<i class="ti ti-alert-triangle text-[70px] text-red-500 drop-shadow-md"></i>';
    }
    
    document.getElementById('alertTitle').innerText = title;
    document.getElementById('alertMessage').innerText = message;
    
    modal.classList.remove('hidden');
}

window.tutupAlertDanKembali = function() {
    document.getElementById('modalAlertCustom').classList.add('hidden');
    window.location.reload(); 
} 

document.addEventListener('DOMContentLoaded', function() {
    const bridge = document.getElementById('dashboard-data-bridge');
    
    if (bridge && typeof window.initDashboard === 'function') {
        const labels = JSON.parse(bridge.getAttribute('data-labels'));
        const data = JSON.parse(bridge.getAttribute('data-data'));

        window.initDashboard({
            labels: labels,
            data: data
        });
    }
});

window.confirmHapusUsulan = function(uuid) {
    Swal.fire({
        title: 'Batalkan Usulan?',
        text: "Apakah Anda yakin ingin membatalkan usulan prioritas untuk tiket ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444', 
        cancelButtonColor: '#6b7280', 
        confirmButtonText: '<i class="ti ti-trash"></i> Ya, Batalkan!',
        cancelButtonText: 'Batal',
        reverseButtons: true 
    }).then((result) => {
        if (result.isConfirmed) {
            
            Swal.fire({
                title: 'Memproses...',
                text: 'Sedang membatalkan usulan prioritas',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(`/usulan/${uuid}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(async response => {
                const data = await response.json();
                if (!response.ok) throw new Error(data.message || "Gagal membatalkan usulan.");
                return data;
            })
            .then(data => {
                Swal.fire({
                    title: 'Dibatalkan!',
                    text: data.message,
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.reload(); 
                });
            })
            .catch(error => {
                Swal.fire({
                    title: 'Gagal!',
                    text: error.message,
                    icon: 'error'
                });
            });
        }
    });
}

window.bukaDetailUsulan = function(element) {
    const usulanRaw = element.getAttribute('data-usulan');
    const usulan = JSON.parse(usulanRaw);
    const contentDiv = document.getElementById('detailUsulanContent');

    let statusColor = 'text-orange-500';
    if (usulan.status_persetujuan === 'disetujui') statusColor = 'text-green-500';
    if (usulan.status_persetujuan === 'ditolak') statusColor = 'text-red-500';

    let prioColor = usulan.level_prioritas === 'tinggi' ? 'red' : (usulan.level_prioritas === 'sedang' ? 'yellow' : 'green');

    contentDiv.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-50 dark:bg-gray-700/30 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                <span class="block text-[10px] font-bold uppercase text-gray-500 tracking-wider mb-1">Nomor Tiket</span>
                <span class="font-black text-gray-900 dark:text-white">${usulan.tiket ? usulan.tiket.no_tiket : '-'}</span>
            </div>
            
            <div class="bg-gray-50 dark:bg-gray-700/30 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                <span class="block text-[10px] font-bold uppercase text-gray-500 tracking-wider mb-1">Status Persetujuan</span>
                <span class="font-black uppercase ${statusColor}">${usulan.status_persetujuan}</span>
            </div>

            <div class="md:col-span-2 bg-gray-50 dark:bg-gray-700/30 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                <span class="block text-[10px] font-bold uppercase text-gray-500 tracking-wider mb-1">Level Prioritas</span>
                <span class="px-2.5 py-1 text-[10px] font-black uppercase tracking-wider text-${prioColor}-700 bg-${prioColor}-100 rounded-lg dark:bg-${prioColor}-900/30 dark:text-${prioColor}-400 inline-block">
                    ${usulan.level_prioritas}
                </span>
            </div>

            <div class="md:col-span-2 bg-white dark:bg-gray-800 p-4 rounded-xl border-2 border-gray-100 dark:border-gray-700">
                <span class="block text-[10px] font-bold uppercase text-blue-500 tracking-wider mb-2"><i class="ti ti-user"></i> Catatan Kabid (Pengusul)</span>
                <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">${usulan.catatan_kabid || '-'}</p>
            </div>

            <div class="md:col-span-2 bg-blue-50/50 dark:bg-blue-900/10 p-4 rounded-xl border-2 border-blue-100 dark:border-blue-800/30">
                <span class="block text-[10px] font-bold uppercase text-orange-500 tracking-wider mb-2"><i class="ti ti-user-check"></i> Catatan Kadis (Balasan)</span>
                <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">${usulan.catatan_kadis || '<span class="italic text-gray-400">Belum ada balasan dari Kadis.</span>'}</p>
            </div>
        </div>
    `;

    document.getElementById('modalDetailUsulan').classList.remove('hidden');
};

window.tutupModalDetailUsulan = function() {
    document.getElementById('modalDetailUsulan').classList.add('hidden');
};

window.initDashboard = initDashboard;
window.toggleModalUsulan = toggleModalUsulan; 
window.lihatDetailTiketOperator = lihatDetailTiketOperator;