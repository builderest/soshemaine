document.addEventListener('DOMContentLoaded', () => {
    const toggles = document.querySelectorAll('[data-toggle="offcanvas"]');
    toggles.forEach(toggle => {
        toggle.addEventListener('click', () => {
            document.body.classList.toggle('sidebar-open');
        });
    });
    const csrfInputs = document.querySelectorAll('form');
    csrfInputs.forEach(form => {
        form.addEventListener('submit', () => {
            const button = form.querySelector('button[type="submit"]');
            if (button) {
                button.disabled = true;
                button.dataset.originalText = button.textContent;
                button.textContent = 'Guardando...';
            }
        });
    });
});
