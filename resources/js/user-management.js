import Swal from 'sweetalert2';
import Chart from 'chart.js/auto';

window.confirmDelete = function (uuid, userName) {
    Swal.fire({
        title: 'Konfirmasi Hapus User',
        html: `Apakah Anda yakin? Data <b>${userName}</b> akan dihapus secara permanen dari MinIO dan Database.<br><br>Ketik nama user di bawah untuk konfirmasi:`,
        input: 'text',
        inputPlaceholder: 'Ketik nama lengkap user...',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Hapus Data',
        confirmButtonColor: '#d33',
        cancelButtonText: 'Batal',
        showLoaderOnConfirm: true,
        preConfirm: (inputName) => {
            if (inputName !== userName) {
                Swal.showValidationMessage(`Nama yang Anda masukkan salah! (Harus: ${userName})`);
                return false;
            }
            return true;
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + uuid).submit();
        }
    });
}

window.previewImage = function (input) {
    const preview = document.getElementById('avatar-preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('simple-search');
    const clearBtn = document.querySelector('[title="Bersihkan Pencarian"]');

    if (searchInput && clearBtn) {
        clearBtn.addEventListener('click', function (e) {
            searchInput.value = '';
        });
    }

    const chartCanvas = document.getElementById('userRoleChart');
    if (chartCanvas) {
        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#f8fafc' : '#475569';

        const labels = JSON.parse(chartCanvas.dataset.labels || '[]');
        const dataValues = JSON.parse(chartCanvas.dataset.values || '[]');

        new Chart(chartCanvas, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: dataValues,
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                    hoverOffset: 15,
                    borderWidth: 0,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: textColor,
                            padding: 20,
                            usePointStyle: true,
                            font: {
                                size: 11,
                                weight: '600'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: isDark ? '#1e293b' : '#ffffff',
                        titleColor: isDark ? '#ffffff' : '#1e293b',
                        bodyColor: isDark ? '#cbd5e1' : '#475569',
                        borderColor: isDark ? '#334155' : '#e2e8f0',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: true,
                        boxPadding: 6
                    }
                }
            }
        });
    }

    const sessionFlash = document.getElementById('session-flash');
    if (sessionFlash) {
        const successMessage = sessionFlash.getAttribute('data-success');
        const errorMessage = sessionFlash.getAttribute('data-error');

        if (successMessage) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: successMessage,
                showConfirmButton: false,
                timer: 3000
            });
        }

        if (errorMessage) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Menghapus User!',
                text: errorMessage,
                confirmButtonColor: '#3085d6',
            });
        }
    }
});