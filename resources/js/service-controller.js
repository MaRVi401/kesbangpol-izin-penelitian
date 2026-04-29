const SubdomainFormHandler = () => {
    const form = document.getElementById('form-subdomain');
    const step1 = document.getElementById('step-1');
    const step2 = document.getElementById('step-2');
    const indicatorStep1 = document.getElementById('indicator-step-1');
    const indicatorStep2 = document.getElementById('indicator-step-2');

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
                step1.classList.add('opacity-0');
                
                // Menangkap nomor tiket dari controller dan menampilkannya di UI
                const nomorTiketElement = document.getElementById('nomor-tiket');
                if (nomorTiketElement && result.no_tiket) {
                    nomorTiketElement.textContent = result.no_tiket;
                }
                
                setTimeout(() => {
                    step1.classList.add('hidden');
                    step2.classList.remove('hidden');
                    step2.classList.add('opacity-100');
                    
                    updateStepperUI(indicatorStep1, indicatorStep2);
                    window.scrollTo({ top: 0, behavior: 'smooth' });

                    if (result.download_url) {
                        setTimeout(() => {
                            window.location.href = result.download_url;
                        }, 500);
                    }

                }, 300);
            } else {
                // Menggunakan SweetAlert untuk pesan error validasi/server
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: result.message || 'Terjadi kesalahan, mohon periksa kembali form Anda.',
                    confirmButtonColor: '#3085d6',
                });
            }
        } catch (error) {
            console.error('Error:', error);
            // Menggunakan SweetAlert untuk pesan error jaringan/sistem
            Swal.fire({
                icon: 'error',
                title: 'Sistem Error',
                text: 'Gagal mengirim data. Pastikan server berjalan dengan baik.',
                confirmButtonColor: '#d33',
            });
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }
    });
};

function updateStepperUI(step1, step2) {
    step1.classList.remove('text-blue-600', 'dark:text-blue-500');
    step1.classList.add('text-gray-500', 'dark:text-gray-400');
    step1.querySelector('span').classList.replace('border-blue-600', 'border-gray-500');

    step2.classList.remove('text-gray-500', 'dark:text-gray-400');
    step2.classList.add('text-blue-600', 'dark:text-blue-500');
    step2.querySelector('span').classList.replace('border-gray-500', 'border-blue-600');
}



document.addEventListener('DOMContentLoaded', SubdomainFormHandler);