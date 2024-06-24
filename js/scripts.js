document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        const email = document.querySelector('[name="email"]').value;
        const password = document.querySelector('[name="password"]').value;
        const confirmPassword = document.querySelector('[name="confirm_password"]');
        
        if (confirmPassword && password !== confirmPassword.value) {
            alert('Las contraseñas no coinciden');
            event.preventDefault();
        }
        
        // Agregar otras validaciones aquí
    });
});
