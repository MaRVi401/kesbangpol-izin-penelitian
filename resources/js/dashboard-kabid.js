document.addEventListener('DOMContentLoaded', function() {
    // 1. Realtime Clock
    setInterval(() => {
        const clock = document.getElementById('realtime-clock');
        if (clock) clock.textContent = new Date().toLocaleTimeString('en-GB');
    }, 1000);

    // 2. SweetAlert untuk Tombol Terima
    const btnsTerima = document.querySelectorAll('.btn-terima');
    btnsTerima.forEach(btn => {
        btn.addEventListener('click', function() {
            const form = this.closest('form');
            
            Swal.fire({
                title: 'Terima Tiket?',
                text: "Apakah Anda yakin ingin MENERIMA tiket ini? Tiket akan disetujui.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#16a34a', // green-600
                cancelButtonColor: '#6b7280',  // gray-500
                confirmButtonText: '<i class="ti ti-check"></i> Ya, Terima!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // 3. SweetAlert untuk Tombol Tolak (Dilengkapi Input Textarea)
    const btnsTolak = document.querySelectorAll('.btn-tolak');
    btnsTolak.forEach(btn => {
        btn.addEventListener('click', function() {
            const form = this.closest('form');
            const noTiket = this.dataset.notiket;
            const inputKomentar = form.querySelector('.input-komentar');

            Swal.fire({
                title: 'Tolak Tiket',
                html: `Anda akan menolak tiket dengan nomor: <b>${noTiket}</b><br><br>Silakan masukkan alasan penolakan:`,
                input: 'textarea',
                inputPlaceholder: 'Ketik alasan penolakan di sini...',
                inputAttributes: {
                    'aria-label': 'Alasan penolakan',
                    required: 'true'
                },
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626', // red-600
                cancelButtonColor: '#6b7280',  // gray-500
                confirmButtonText: '<i class="ti ti-send"></i> Konfirmasi Tolak',
                cancelButtonText: 'Batal',
                preConfirm: (text) => {
                    if (!text || text.trim() === '') {
                        Swal.showValidationMessage('Alasan penolakan wajib diisi!');
                        return false;
                    }
                    return text;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Masukkan teks dari sweetalert ke input hidden form
                    inputKomentar.value = result.value;
                    form.submit();
                }
            });
        });
    });
});