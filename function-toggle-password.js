document.addEventListener("DOMContentLoaded", async function () {
    // Check if Brave browser
    if (navigator.brave && await navigator.brave.isBrave()) {
        // Show the toggle icons
        document.querySelectorAll('.toggle-password').forEach(eyeIcon => {
            eyeIcon.style.display = 'block'; // Ensure visible

            // Add click event to toggle password visibility
            eyeIcon.addEventListener('click', () => {
                const passwordInput = eyeIcon.previousElementSibling;
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                eyeIcon.classList.toggle('fa-eye');
                eyeIcon.classList.toggle('fa-eye-slash');
            });
        });
    }
});
