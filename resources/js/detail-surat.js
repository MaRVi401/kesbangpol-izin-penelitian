import Swal from 'sweetalert2';

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('simple-search');
    const clearBtn = document.querySelector('[title="Bersihkan Pencarian"]');

    if (searchInput && clearBtn) {
        clearBtn.addEventListener('click', function (e) {
            if (clearBtn.tagName !== 'A') {
                searchInput.value = '';
            }
        });
    }

    // Logic untuk konfirmasi tombol hapus dengan SweetAlert2
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault(); // Cegah button submit form otomatis
            const form = this.closest('form');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data pengajuan tiket ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // --- MULAI LOGIKA MODAL GAMBAR PENGADUAN ---
    const btnOpenImageModal = document.getElementById('btn-open-image-modal');
    const imageModalContainer = document.getElementById('image-modal-container');
    const btnCloseImageModal = document.getElementById('btn-close-image-modal');

    // Pastikan elemen-elemen modal ada di halaman ini sebelum menjalankan logika
    if (btnOpenImageModal && imageModalContainer && btnCloseImageModal) {
        
        // Fungsi untuk menutup modal
        const closeImageModal = () => {
            imageModalContainer.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Mengembalikan scroll body
        };

        // Event buka modal saat thumbnail diklik
        btnOpenImageModal.addEventListener('click', function () {
            imageModalContainer.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Menghilangkan scroll body agar fokus ke gambar
        });

        // Event tutup modal saat tombol X diklik
        btnCloseImageModal.addEventListener('click', closeImageModal);

        // Event tutup modal saat area luar gambar (backdrop hitam) diklik
        imageModalContainer.addEventListener('click', function (e) {
            if (e.target === imageModalContainer) {
                closeImageModal();
            }
        });

        // Event tutup modal menggunakan tombol Escape (Esc)
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !imageModalContainer.classList.contains('hidden')) {
                closeImageModal();
            }
        });
    }
    // --- AKHIR LOGIKA MODAL GAMBAR PENGADUAN ---

});