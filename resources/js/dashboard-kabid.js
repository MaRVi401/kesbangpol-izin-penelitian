document.addEventListener('DOMContentLoaded', function() {
    setInterval(() => {
        const clock = document.getElementById('realtime-clock');
        if (clock) clock.textContent = new Date().toLocaleTimeString('en-GB');
    }, 1000);

    const btnsTte = document.querySelectorAll('.btn-tte');
    btnsTte.forEach(btn => {
        btn.addEventListener('click', function() {
            const form = this.closest('form');
            const noTiket = this.dataset.notiket;
            const inputPassphrase = form.querySelector('.input-passphrase');

            Swal.fire({
                title: 'Tandatangani Dokumen',
                html: `Nomor Tiket: <b>${noTiket}</b><br><br>Masukkan Passphrase BSrE Anda:`,
                input: 'password',
                inputPlaceholder: 'Passphrase...',
                inputAttributes: {
                    autocapitalize: 'off',
                    autocorrect: 'off',
                    required: 'true'
                },
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="ti ti-signature"></i> Proses TTE',
                cancelButtonText: 'Batal',
                preConfirm: (password) => {
                    if (!password) {
                        Swal.showValidationMessage('Passphrase wajib diisi!');
                        return false;
                    }
                    return password;
                }
            }).then((result) => {
                    if (result.isConfirmed) {
                        inputPassphrase.value = result.value;
                        
                        // Memicu loading SweetAlert
                        Swal.fire({
                            title: 'Memproses TTE...',
                            html: 'Mohon tunggu, jangan tutup halaman ini.',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        form.submit();
                    }
            });
        });
    });

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
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
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
                    inputKomentar.value = result.value;
                    form.submit();
                }
            });
        });
    });
});