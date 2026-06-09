const IzinPenelitianFormHandler = () => {
    const form = document.getElementById('form-penelitian');
    if (!form) return;

    const saveStatusElement = document.getElementById('save-status');
    let tiketUuidInput = document.getElementById('tiket_uuid');
    let timeoutId;

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
                let errorHtml = '';
                
                if (result.errors) {
                    errorHtml = '<div style="text-align: left;"><ul class="pl-5 text-sm list-disc text-gray-700">';
                    Object.values(result.errors).forEach(err => {
                        errorHtml += `<li class="mb-1">${err[0]}</li>`; 
                    });
                    errorHtml += '</ul></div>';
                } else {
                    errorHtml = `<p>${result.message || 'Terjadi kesalahan, mohon periksa kembali form Anda.'}</p>`;
                }

                Swal.fire({
                    icon: 'warning',
                    title: 'Periksa Kembali Form Anda',
                    html: errorHtml,
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

    const performAutosave = () => {
        saveStatusElement.innerText = "Menyimpan draft...";
        
        const formData = new FormData(form);
        const data = {};
        
        formData.forEach((value, key) => {
            const inputElement = form.querySelector(`[name="${key}"]`);
            if (key !== '_token' && inputElement && inputElement.type !== 'file') {
                data[key] = value;
            }
        });

        if (tiketUuidInput && tiketUuidInput.value) {
            data['tiket_uuid'] = tiketUuidInput.value;
        }

        const autosaveUrl = form.getAttribute('data-autosave-url');
        fetch(autosaveUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(res => {
            if (res.status === 'success') {
                tiketUuidInput.value = res.tiket_uuid; 
                saveStatusElement.innerText = res.message; 
            }
        })
        .catch(error => {
            console.error('Error autosave:', error);
            saveStatusElement.innerText = "Gagal menyimpan draft.";
        });
    };

    form.addEventListener('input', function(e) {
        if (e.target.type === 'file') return; 

        clearTimeout(timeoutId);
        saveStatusElement.innerText = "Mengetik...";
        
        timeoutId = setTimeout(performAutosave, 2000); 
    });

    const btnFillDummy = document.getElementById('btn-fill-dummy');
    if (btnFillDummy) {
        btnFillDummy.addEventListener('click', function() {
            const dummyData = {
                'nama': 'Budi Santoso',
                'nama_alias': 'Budi',
                'nama_panggilan': 'Bud',
                'no_hp': '081234567890',
                'tempat_lahir': 'Bandung',
                'tanggal_lahir': '1998-08-17',
                'jenis_kelamin': 'Laki-laki',
                'agama': 'Islam',
                'status_perkawinan': 'Belum Kawin',
                'kebangsaan': 'Indonesia',
                'alamat_lengkap': 'Jl. Merdeka No. 45, RT 01 RW 02, Kota Bandung, Jawa Barat',
                'pekerjaan_pendidikan': 'Mahasiswa',
                'pekerjaan': 'Pekerja Lepas',
                'institusi_pendidikan': 'Universitas Teknologi Nusantara', 
                'semester': '4',
                'nomor_mahasiswa': '1234567890',
                'nomor_pegawai': '198001012005011001',
                'alamat_institusi': 'Jl. Pendidikan No. 1, Kota Nusantara',
                'alamat_kantor': '-',
                'nomor_surat_institusi': '001/UNIV-TN/2026',
                'tanggal_surat_institusi': '2026-06-01',
                'tanggal_diterima_surat': '2026-06-10',
                'yth_kepada': 'Kepala Dinas Pendidikan Kota Bandung',
                'yth_cq': 'Kabid Pendidikan Menengah',
                'yth_di': 'Bandung',
                'judul_pembicara': 'Analisis Kualitas Udara Perkotaan Berbasis IoT',
                'kegiatan': 'Penelitian Lapangan',
                'dalam_rangka': 'Penyusunan Skripsi',
                'tanggal_mulai': '2026-06-15',
                'tanggal_selesai': '2026-07-15',
                'lokasi_kegiatan': 'Kota Bandung',
                'penanggung_jawab_1': 'Dr. Andi Wijaya',
                'nip_penanggung_jawab_1': '197502022000031002',
                'penanggung_jawab_2': 'Siti Aminah, M.Sc',
                'nip_penanggung_jawab_2': '198205052008012001',
                'banyak_peserta': '3',
                'tinggi_badan': '170',
                'bentuk_badan': 'Proporsional',
                'warna_kulit': 'Sawo Matang',
                'bentuk_rambut': 'Lurus',
                'bentuk_hidung': 'Mancung',
                'ciri_khusus': 'Tidak Ada',
                'hobi': 'Membaca'
            };

            Object.entries(dummyData).forEach(([key, value]) => {
                const inputElement = form.querySelector(`[name="${key}"]`);
                if (inputElement && inputElement.type !== 'file') {
                    inputElement.value = value;
                    inputElement.dispatchEvent(new Event('input', { bubbles: true }));
                }
            });

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Data Dummy Berhasil Diisi',
                    text: 'Silakan isi pas foto secara manual sebelum melakukan submit.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            }
        });
    }
};

document.addEventListener('DOMContentLoaded', IzinPenelitianFormHandler);