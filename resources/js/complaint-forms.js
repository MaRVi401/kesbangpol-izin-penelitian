// ==========================================
// 1. LOGIKA NAVIGASI LANGKAH (STEPPER)
// ==========================================
window.goToStep = function(stepNumber) {
    // Sembunyikan semua step
    document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));

    // Tampilkan step yang dituju
    const targetStep = document.getElementById('step-' + stepNumber);
    if(targetStep) targetStep.classList.remove('hidden');

    updateStepper(stepNumber);
}

window.updateStepper = function(activeStep) {
    // Formulir pengaduan hanya memiliki 2 langkah
    for (let i = 1; i <= 2; i++) {
        let indicator = document.getElementById('indicator-step-' + i);
        if(!indicator) continue;
        
        let circle = indicator.querySelector('span:first-child');
        
        if (i === activeStep) {
            // State Aktif (Biru)
            indicator.className = "flex items-center space-x-2.5 text-blue-600 dark:text-blue-500";
            circle.className = "flex items-center justify-center w-8 h-8 border border-blue-600 rounded-full shrink-0 dark:border-blue-500 bg-white dark:bg-gray-800";
        } else if (i < activeStep) {
            // State Selesai (Abu-abu gelap)
            indicator.className = "flex items-center space-x-2.5 text-gray-900 dark:text-gray-300";
            circle.className = "flex items-center justify-center w-8 h-8 border border-gray-900 rounded-full shrink-0 dark:border-gray-300 bg-gray-100 dark:bg-gray-700";
        } else {
            // State Belum Dilalui (Abu-abu terang)
            indicator.className = "flex items-center space-x-2.5 text-gray-500 dark:text-gray-400";
            circle.className = "flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400 bg-white dark:bg-gray-800";
        }
    }
}

// ==========================================
// 2. LOGIKA FORM SUBMIT (AJAX & SWEETALERT)
// ==========================================
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form-pengaduan');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); 
            
            const btnSubmit = e.submitter || this.querySelector('button[type="submit"]');
            const originalBtnText = btnSubmit.innerHTML;
            
            // Bersihkan error sebelumnya
            resetValidationErrors();

            const fileInput = document.getElementById('lampiran_screenshot');
            if (fileInput && fileInput.files.length > 0) {
                const fileSize = fileInput.files[0].size / 1024 / 1024; // Konversi bytes ke MB
                
                if (fileSize > 2) {
                    // Tampilkan peringatan tanpa ada animasi loading yang tertumpuk
                    Swal.fire({
                        icon: 'warning',
                        title: 'File Terlalu Besar',
                        text: 'Ukuran gambar melebihi batas 2MB. Silakan kompres gambar Anda terlebih dahulu.',
                        confirmButtonColor: '#d33'
                    });
                    return; // Hentikan proses seketika
                }
            }
            
            // Tampilkan SweetAlert Loading
            Swal.fire({
                title: 'Mengirim Pengaduan...',
                html: 'Mohon tunggu, laporan Anda sedang diproses.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Ubah state tombol menjadi loading
            btnSubmit.innerHTML = '<span class="animate-spin inline-block mr-2">↻</span> Memproses...';
            btnSubmit.disabled = true;
            
            let formData = new FormData(this);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async response => {
                let data;
                try {
                    data = await response.json();
                } catch (err) {
                    throw new Error("Server tidak merespon dengan format JSON yang valid.");
                }

                if (!response.ok) {
                    const error = new Error(data.message || 'Terjadi kesalahan saat memproses data.');
                    error.status = response.status;
                    error.data = data;
                    throw error;
                }

                return data;
            })
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Dikirim!',
                    text: 'Tiket pengaduan Anda telah tercatat di sistem.',
                    confirmButtonText: 'Selesai',
                    confirmButtonColor: '#3085d6',
                }).then((result) => {
                    if (result.isConfirmed || result.isDismissed) {
                        btnSubmit.disabled = false;
                        btnSubmit.innerHTML = originalBtnText;
                        
                        // Menampilkan Nomor Tiket dari respons backend ke halaman "Selesai"
                        // Asumsi respons dari controller mengembalikan JSON: { status: 'success', no_tiket: 'TKT-123...' }
                        const labelNomorTiket = document.getElementById('nomor-tiket');
                        if (labelNomorTiket && data.no_tiket) {
                            labelNomorTiket.innerText = data.no_tiket;
                        }

                        // Pindahkan antarmuka ke Langkah 2 (Selesai)
                        window.goToStep(2); 
                    }
                });
            })
            .catch(error => {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = originalBtnText;

                if (error.status === 422) {
                    let errorListHtml = '<ul class="text-left text-sm text-red-500 list-disc pl-5 mt-3">';
                    
                    if(error.data && error.data.errors) {
                        showValidationErrors(error.data.errors);
                        
                        for (const [field, messages] of Object.entries(error.data.errors)) {
                            errorListHtml += `<li>${messages[0]}</li>`;
                        }
                    }
                    errorListHtml += '</ul>';

                    Swal.fire({
                        icon: 'warning',
                        title: 'Validasi Gagal',
                        html: '<p class="text-sm">Mohon periksa kembali isian Anda. Terdapat data berikut yang tidak sesuai:</p>' + errorListHtml,
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Periksa Formulir'
                    }).then((result) => {
                        const firstError = document.querySelector('.border-red-500');
                        if (firstError) {
                             firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    });

                } else if (error.status === 500) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gangguan Server',
                        text: 'Terjadi kesalahan internal pada sistem. Silakan coba beberapa saat lagi.',
                        confirmButtonColor: '#d33'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: error.message || 'Gagal menghubungi server.',
                        confirmButtonColor: '#d33'
                    });
                }
            });
        });
    }

    // ==========================================
    // 3. HELPER FUNCTIONS UNTUK VALIDASI
    // ==========================================
    function resetValidationErrors() {
        document.querySelectorAll('.border-red-500').forEach(el => {
            el.classList.remove('border-red-500');
        });
        document.querySelectorAll('.error-text-validation').forEach(el => el.remove());
    }

    function showValidationErrors(errors) {
        for (const [field, messages] of Object.entries(errors)) {
            // Form ini tidak memiliki input array (seperti fitur[]), sehingga logikanya lebih sederhana
            const inputElements = document.querySelectorAll(`[name="${field}"]`);
            
            if (inputElements.length > 0) {
                 applyErrorToInput(inputElements[0], messages[0]);
            }
        }
    }

    function applyErrorToInput(input, message) {
        input.classList.add('border-red-500');
        
        const msgElement = document.createElement('p');
        msgElement.className = 'text-red-500 text-xs mt-1 italic error-text-validation';
        msgElement.innerText = message;
        
        input.parentElement.appendChild(msgElement);
    }
});