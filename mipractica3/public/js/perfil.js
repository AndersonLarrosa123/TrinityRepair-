// Obtener elementos del DOM
const profileBtn = document.getElementById('profileBtn');
const profileDropdown = document.getElementById('profileDropdown');

// Verificar que existan los elementos
if (profileBtn && profileDropdown) {
    // Mostrar u ocultar mini perfil al hacer clic en la foto
    profileBtn.addEventListener('click', () => {
        if (profileDropdown.style.display === 'block') {
            profileDropdown.style.display = 'none';
        } else {
            profileDropdown.style.display = 'block';
        }
    });

    // Ocultar mini perfil si se hace clic fuera
    window.addEventListener('click', (e) => {
        if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
            profileDropdown.style.display = 'none';
        }
    });
}
