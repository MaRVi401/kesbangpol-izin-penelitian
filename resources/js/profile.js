document.addEventListener('DOMContentLoaded', function() {
    const avatarInput = document.getElementById('avatar');
    const previewImage = document.getElementById('preview');
    const errorContainer = document.getElementById('avatar-error-container');

    if (avatarInput && previewImage) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];

            if (file) {
                const maxSize = 2 * 1024 * 1024; // 2MB

                // 1. Validasi Ukuran File
                if (file.size > maxSize) {
                    // Menghasilkan teks merah tanpa kotak latar belakang
                    errorContainer.innerHTML = `
                        <p class="text-[11px] font-bold text-red-600 dark:text-red-500 text-center leading-tight">
                            *File terlalu besar! Maksimal 2 MB.
                        </p>
                    `;

                    this.value = "";
                    return;
                }

                // 2. Validasi Tipe File
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    errorContainer.innerHTML = `
                        <p class="text-[11px] font-bold text-red-600 dark:text-red-500 text-center leading-tight">
                            Format file tidak didukung! Gunakan JPG, PNG, atau WebP.
                        </p>
                    `;
                    this.value = "";
                    return;
                }

                // 3. Jika Lolos Validasi, Tampilkan Preview
                errorContainer.innerHTML = "";
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewImage.src = event.target.result;
                    // Efek kedap-kedip dihilangkan sesuai permintaan sebelumnya
                }
                reader.readAsDataURL(file);
            }
        });
    }
});
