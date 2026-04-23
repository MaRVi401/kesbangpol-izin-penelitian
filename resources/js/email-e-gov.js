import Swal from 'sweetalert2';

window.goToStep = function(stepNumber, category = null) {
    document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));

    const targetStep = document.getElementById('step-' + stepNumber);
    if(targetStep) targetStep.classList.remove('hidden');

    if (stepNumber === 2 && category) {
        document.querySelectorAll('.form-section').forEach(el => el.classList.add('hidden'));

        const inputKategori = document.getElementById('kategori_aktif');
        if (inputKategori) {
            inputKategori.value = category;
        }

        if (category === 'asn') {
            const formAsn = document.getElementById('form-asn');
            if(formAsn) formAsn.classList.remove('hidden');
        } else if (category === 'perangkat_daerah') {
            const formPD = document.getElementById('form-perangkat-daerah');
            if(formPD) formPD.classList.remove('hidden');
        }
    }

    updateStepper(stepNumber);
}

window.updateStepper = function(activeStep) {
    for (let i = 1; i <= 3; i++) {
        let indicator = document.getElementById('indicator-step-' + i);
        if(!indicator) continue;
        
        let circle = indicator.querySelector('span:first-child');
        
        if (i === activeStep) {
            indicator.className = "flex items-center space-x-2.5 text-blue-600 dark:text-blue-500";
            circle.className = "flex items-center justify-center w-8 h-8 border border-blue-600 rounded-full shrink-0 dark:border-blue-500 bg-white dark:bg-gray-800";
        } else if (i < activeStep) {
            indicator.className = "flex items-center space-x-2.5 text-gray-900 dark:text-gray-300";
            circle.className = "flex items-center justify-center w-8 h-8 border border-gray-900 rounded-full shrink-0 dark:border-gray-300 bg-gray-100 dark:bg-gray-700";
        } else {
            indicator.className = "flex items-center space-x-2.5 text-gray-500 dark:text-gray-400";
            circle.className = "flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400 bg-white dark:bg-gray-800";
        }
    }
}

window.toggleOpsiAkun = function() {
    const containerAlasan = document.getElementById('field-alasan');
    const containerUsulan = document.getElementById('field-usulan-nama');

    const radioHapus = document.getElementById('opsi-hapus');
    const radioGanti = document.getElementById('opsi-ganti');

    const pilihHapus = radioHapus ? radioHapus.checked : false;
    const pilihGanti = radioGanti ? radioGanti.checked : false;

    if (containerAlasan) {
        if (pilihHapus || pilihGanti) {
            containerAlasan.classList.remove('hidden');
        } else {
            containerAlasan.classList.add('hidden');
        }
    }

    if (containerUsulan) {
        if (pilihGanti) {
            containerUsulan.classList.remove('hidden');
        } else {
            containerUsulan.classList.add('hidden');
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form-pengajuan');
    
    if(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); 
            
            Swal.fire({
                title: 'Konfirmasi Pengajuan',
                text: "Apakah Anda yakin data yang diisikan sudah benar?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1A56DB', // Warna biru 
                cancelButtonColor: '#EF4444', // Warna merah 
                confirmButtonText: 'Ya, Kirim!',
                cancelButtonText: 'Batal Periksa Lagi'
            }).then((result) => {
                if (result.isConfirmed) {
                    prosesPengajuanForm(form, e.submitter || form.querySelector('button[type="submit"]'));
                }
            });
        });
    }

    function prosesPengajuanForm(formElement, btnSubmit) {
        const originalBtnText = btnSubmit.innerHTML;
        
        resetValidationErrors();
        
        btnSubmit.innerHTML = '<span class="animate-spin inline-block mr-2">↻</span> Memproses...';
        btnSubmit.disabled = true;

        let formData = new FormData(formElement);

        fetch(formElement.action, {
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
                throw new Error("Server tidak merespon dengan JSON valid.");
            }

            if (!response.ok) {
                const error = new Error(data.message || 'Terjadi kesalahan.');
                error.status = response.status;
                error.data = data;
                throw error;
            }

            return data;
        })
        .then(data => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Pengajuan email Anda telah berhasil dikirim.',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                
                const noTiketElement = document.getElementById('nomor-tiket');
                if(noTiketElement && data.no_tiket) {
                    noTiketElement.innerText = data.no_tiket;
                }
                // -------------------------------
                
                goToStep(3); 
                if(data.uuid) {
                    window.location.href = `/services/email-gov/download/${data.uuid}`;
                }
            });
        })
        .catch(error => {
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = originalBtnText;

            if (error.status === 422) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Validasi Gagal',
                    text: 'Mohon periksa kembali inputan form Anda yang bertanda merah.',
                    confirmButtonColor: '#1A56DB'
                });

                if(error.data && error.data.errors) {
                    showValidationErrors(error.data.errors);
                }
            } else if (error.status === 500) {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Terjadi kesalahan pada server. Silakan coba lagi nanti.',
                    confirmButtonColor: '#1A56DB'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: error.message || 'Gagal menghubungi server.',
                    confirmButtonColor: '#1A56DB'
                });
            }
        });
    }

    function resetValidationErrors() {
        document.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));
        document.querySelectorAll('.text-red-500').forEach(el => el.remove());
    }

    function showValidationErrors(errors) {
        for (const [field, messages] of Object.entries(errors)) {
            const input = document.querySelector(`[name="${field}"]`);
            if (input) {
                input.classList.add('border-red-500');
                
                const msgElement = document.createElement('p');
                msgElement.className = 'text-red-500 text-xs mt-1 italic';
                msgElement.innerText = messages[0];
                input.parentElement.appendChild(msgElement);
            }
        }
    }
});