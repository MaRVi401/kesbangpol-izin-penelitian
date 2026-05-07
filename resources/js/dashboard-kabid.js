document.addEventListener('DOMContentLoaded', function() {
    setInterval(() => {
        const clock = document.getElementById('realtime-clock');
        if (clock) clock.textContent = new Date().toLocaleTimeString('en-GB');
    }, 1000);
});

window.bukaModalTolak = function(uuid, noTiket) {
    document.getElementById('nomor_tiket_tolak').innerText = noTiket;
    let form = document.getElementById('formTolakTiket');
    form.action = `/tiket/${uuid}/proses`; 
    document.getElementById('modalTolakTiket').classList.remove('hidden');
};

window.tutupModalTolak = function() {
    document.getElementById('modalTolakTiket').classList.add('hidden');
};


function bukaModalLihat(uuid) {
    // Ambil data JSON dari attribute button
    const btn = document.getElementById('btn-lihat-' + uuid);
    const tiket = JSON.parse(btn.getAttribute('data-tiket'));

    // Tampilkan Modal
    document.getElementById('modalLihatTiket').classList.remove('hidden');
    
    // Set Nomor Tiket
    document.getElementById('lihat_no_tiket').innerText = tiket.no_tiket;

    // Reset elemen foto
    const imgElement = document.getElementById('lihat_pas_foto');
    const placeholder = document.getElementById('lihat_foto_placeholder');
    imgElement.classList.add('hidden');
    placeholder.classList.remove('hidden');

    // Cek apakah relasi surat_permohonan_izin_penelitian ada
    const permohonan = tiket.surat_permohonan_izin_penelitian; 
    
    if (permohonan) {
        document.getElementById('lihat_nama').innerText = permohonan.nama || '-';
        document.getElementById('lihat_institusi').innerText = permohonan.institusi_pendidikan || '-';
        document.getElementById('lihat_kegiatan').innerText = permohonan.kegiatan || '-';
        document.getElementById('lihat_lokasi').innerText = permohonan.lokasi_kegiatan || '-';

        // Render Pas Foto jika path-nya tersedia
        if (permohonan.path_pas_foto) {
            // Encode path file agar aman dilempar via URL query parameter
            const encodedPath = encodeURIComponent(permohonan.path_pas_foto);
            
            // Arahkan ke route private-file yang dibuat tadi
            imgElement.src = `/private-file/pas-foto?path=${encodedPath}`;
            
            imgElement.onload = function() {
                placeholder.classList.add('hidden');
                imgElement.classList.remove('hidden');
            };
        }
    } else {
        document.getElementById('lihat_nama').innerText = 'Data tidak ditemukan';
        // Reset field lainnya jika diperlukan...
    }
}

function tutupModalLihat() {
    document.getElementById('modalLihatTiket').classList.add('hidden');
}