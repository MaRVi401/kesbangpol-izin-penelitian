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

        if (category === 'pembangunan_awal') {
            const formAwal = document.getElementById('form-pembangunan-awal');
            if(formAwal) formAwal.classList.remove('hidden');
        } else if (category === 'pengembangan_fitur') {
            const formFitur = document.getElementById('form-pengembangan-fitur');
            if(formFitur) formFitur.classList.remove('hidden');
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

document.addEventListener('DOMContentLoaded', function() {
    const fiturContainers = document.querySelectorAll('.fitur-container');
    const maxFitur = 20;

    fiturContainers.forEach(container => {
        const inputName = container.getAttribute('data-name'); 

        function updateButtons() {
            const rows = container.querySelectorAll('.fitur-row');
            const count = rows.length;

            rows.forEach((row, index) => {
                const btnTambah = row.querySelector('.btn-tambah-fitur');
                const btnHapus = row.querySelector('.btn-hapus-fitur');

                if (count >= maxFitur) {
                    if (btnTambah) btnTambah.classList.add('hidden');
                } else {
                    if (index === 0 || index === count - 1) {
                        if (btnTambah) btnTambah.classList.remove('hidden');
                    } else {
                        if (btnTambah) btnTambah.classList.add('hidden');
                    }
                }

                if (index === 0) {
                    if (btnHapus) btnHapus.classList.add('hidden');
                } else {
                    if (btnHapus) btnHapus.classList.remove('hidden');
                }
            });

            const warningTxt = container.parentElement.querySelector('.fitur-warning');
            if (warningTxt) {
                if (count >= maxFitur) {
                    warningTxt.classList.remove('hidden');
                } else {
                    warningTxt.classList.add('hidden');
                }
            }
        }

        container.addEventListener('click', function(e) {
            const btnTambah = e.target.closest('.btn-tambah-fitur');
            const btnHapus = e.target.closest('.btn-hapus-fitur');

            if (btnTambah) {
                const currentRows = container.querySelectorAll('.fitur-row').length;
                if (currentRows >= maxFitur) return;

                const newRow = document.createElement('div');
                newRow.className = 'flex items-center space-x-2 transition-all duration-300 fitur-row';
                
                const btnColor = inputName.includes('kembang') ? 'green' : 'blue';

                newRow.innerHTML = `
                    <input type="text" name="${inputName}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-${btnColor}-500 focus:border-${btnColor}-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Fitur ke-${currentRows + 1}...">
                    <button type="button" class="btn-tambah-fitur px-3 py-2.5 text-sm font-medium text-white bg-${btnColor}-600 rounded-lg hover:bg-${btnColor}-700 focus:ring-4 focus:outline-none focus:ring-${btnColor}-300 dark:bg-${btnColor}-600 dark:hover:bg-${btnColor}-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    </button>
                    <button type="button" class="btn-hapus-fitur px-3 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" /></svg>
                    </button>
                `;
                
                container.appendChild(newRow);
                updateButtons();
            }

            if (btnHapus) {
                const rowToDel = btnHapus.closest('.fitur-row');
                if (rowToDel) {
                    rowToDel.remove();
                    const remainingRows = container.querySelectorAll('.fitur-row');
                    remainingRows.forEach((row, idx) => {
                        const input = row.querySelector('input');
                        if (input) input.placeholder = `Fitur ke-${idx + 1}...`;
                    });
                    updateButtons();
                }
            }
        });

        updateButtons();
    });

    const form = document.getElementById('form-pengajuan');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); 
            const btnSubmit = e.submitter || this.querySelector('button[type="submit"]');
            const originalBtnText = btnSubmit.innerHTML;
            resetValidationErrors();
            
            const alertError = document.getElementById('alert-error');
            if(alertError) alertError.classList.add('hidden');
            
            Swal.fire({
                title: 'Memproses Pengajuan...',
                html: 'Mohon tunggu, data sedang diverifikasi dan disimpan.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

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
                    title: 'Pengajuan Berhasil!',
                    text: 'Dokumen permohonan Anda akan segera diunduh.',
                    confirmButtonText: 'Lanjut Selesai',
                    confirmButtonColor: '#3085d6',
                }).then((result) => {
                    if (result.isConfirmed || result.isDismissed) {
                        btnSubmit.disabled = false;
                        btnSubmit.innerHTML = originalBtnText;
                        
                        const nomorTiketEl = document.getElementById('nomor-tiket');
                        if (nomorTiketEl && data.no_tiket) {
                            nomorTiketEl.textContent = data.no_tiket;
                        }
                        
                        window.goToStep(3); 
                        
                        if (data.uuid) {
                            const downloadUrl = `/service-app-creation/download/${data.uuid}`;
                            const autoDownloadLink = document.createElement('a');
                            autoDownloadLink.href = downloadUrl;
                            autoDownloadLink.style.display = 'none';
                            document.body.appendChild(autoDownloadLink);
                            autoDownloadLink.click();
                            setTimeout(() => {
                                document.body.removeChild(autoDownloadLink);
                            }, 1000);
                        }
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
                        html: '<p class="text-sm">Mohon periksa kembali isian Anda.</p>' + errorListHtml,
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Periksa Formulir'
                    }).then(() => {
                        const firstError = document.querySelector('.border-red-500');
                        if (firstError) {
                             firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    });

                } else if (error.status === 500) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gangguan Server',
                        text: 'Terjadi kesalahan internal pada sistem.',
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

    function resetValidationErrors() {
        document.querySelectorAll('.border-red-500').forEach(el => {
            el.classList.remove('border-red-500');
        });
        document.querySelectorAll('.error-text-validation').forEach(el => el.remove());
    }

    function showValidationErrors(errors) {
        for (const [field, messages] of Object.entries(errors)) {
            let inputName = field;
            let index = null;

            if (field.includes('.')) {
                const parts = field.split('.');
                inputName = parts[0] + '[]';
                index = parseInt(parts[1]);
            }
            
            const inputElements = document.querySelectorAll(`[name="${inputName}"]`);
            
            if (index !== null) {
                 if(inputElements[index]) {
                     applyErrorToInput(inputElements[index], messages[0]);
                 }
            } else {
                 if(inputElements[0]) {
                     applyErrorToInput(inputElements[0], messages[0]);
                 }
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