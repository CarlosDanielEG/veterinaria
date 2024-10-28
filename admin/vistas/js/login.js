document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.querySelector('input[name="clave_login"]');
        const eyeIcon = document.getElementById('eyeIcon');
        passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        eyeIcon.classList.toggle('fa-eye-slash');
        eyeIcon.classList.toggle('fa-eye');
    });

    