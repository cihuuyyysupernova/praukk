import './bootstrap';

// Manajemen Tema
document.addEventListener('DOMContentLoaded', function() {
    const themeForm = document.getElementById('themeForm');
    const themeInput = document.getElementById('themeInput');
    const html = document.documentElement;

    // Terapkan tema yang tersimpan saat halaman dimuat
    const savedTheme = html.getAttribute('data-theme') || 'light';
    html.setAttribute('data-theme', savedTheme);

    if (themeForm && themeInput) {
        themeForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const currentTheme = html.getAttribute('data-theme') || 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            // Update tema secara langsung untuk UX yang lebih baik
            html.setAttribute('data-theme', newTheme);
            themeInput.value = newTheme;

            // Kirim form untuk menyimpan tema di session
            fetch(themeForm.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                                   document.querySelector('input[name="_token"]')?.value
                },
                body: new URLSearchParams(new FormData(themeForm))
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Tema berhasil diubah:', data.theme);
                    // Pertahankan tema, jangan kembali ke semula
                } else {
                    // Kembali ke tema lama jika terjadi error server
                    html.setAttribute('data-theme', currentTheme);
                    themeInput.value = currentTheme;
                }
            })
            .catch(error => {
                console.error('Error mengubah tema:', error);
                // Kembali ke tema lama jika terjadi error
                html.setAttribute('data-theme', currentTheme);
                themeInput.value = currentTheme;
            });
        });
    }
});
