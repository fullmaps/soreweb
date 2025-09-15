const section = document.querySelector('.perfil-container');
const select = document.getElementById('carta-select');

select.addEventListener('change', () => {
    // Limpiar clases previas
    section.classList.remove('verde', 'morado', 'oscuro');

    // Agregar la nueva clase si no está vacía
    if (select.value) {
        section.classList.add(select.value);
    }
});

