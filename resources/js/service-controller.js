const IzinPenelitianFormHandler = () => {
    const form = document.getElementById('form-penelitian');

    if (!form) return;

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;

        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin h-5 w-5 mr-3 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Memproses...
        `;

        try {
            const url = form.getAttribute('action');
            
            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const result = await response.json();

            if (response.ok) {
                // ... (Kode sukses biarkan seperti sebelumnya) ...
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: `Permohonan Izin Penelitian dengan nomor tiket ${result.no_tiket || ''} berhasil diajukan.`,
                    confirmButtonText: 'Ke Riwayat Tiket',
                    confirmButtonColor: '#3085d6',
                    allowOutsideClick: false
                }).then((sweetResult) => {
                    if (sweetResult.isConfirmed) {
                        window.location.href = '/history';
                    }
                });
            } else {
                // --- PERUBAHAN DI SINI: Menyusun Error Menjadi List HTML ---
                let errorHtml = '';
                
                if (result.errors) {
                    errorHtml = '<div style="text-align: left;"><ul class="pl-5 text-sm list-disc text-gray-700">';
                    Object.values(result.errors).forEach(err => {
                        // Ambil pesan error pertama dari setiap kolom yang bermasalah
                        errorHtml += `<li class="mb-1">${err[0]}</li>`; 
                    });
                    errorHtml += '</ul></div>';
                } else {
                    errorHtml = `<p>${result.message || 'Terjadi kesalahan, mohon periksa kembali form Anda.'}</p>`;
                }

                Swal.fire({
                    icon: 'warning',
                    title: 'Periksa Kembali Form Anda',
                    html: errorHtml, // Menggunakan property 'html', bukan 'text'
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Perbaiki Data'
                });
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Sistem Error',
                text: 'Gagal mengirim data. Pastikan jaringan stabil atau hubungi administrator.',
                confirmButtonColor: '#d33',
            });
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }
    });
};

document.addEventListener('DOMContentLoaded', IzinPenelitianFormHandler);