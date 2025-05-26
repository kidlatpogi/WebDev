// Handles sign up and login logic for index.html

document.addEventListener("DOMContentLoaded", function () {
    // Set a temporary/demo account if none exists
    if (!localStorage.getItem('user-email')) {
        localStorage.setItem('user-email', 'demo@example.com');
        localStorage.setItem('user-password', 'demo1234');
    }

    // Sign up
    document.querySelector('.signup .submit-btn').onclick = function () {
        const inputs = document.querySelectorAll('.signup .form-holder .input');
        const fname = inputs[0].value.trim();
        const lname = inputs[1].value.trim();
        const email = inputs[2].value.trim();
        const password = inputs[3].value;
        const confirm = inputs[4].value;

        if (!fname || !lname || !email || !password || !confirm) {
            alert('Please fill in all fields.');
            return;
        }
        if (password !== confirm) {
            alert('Passwords do not match.');
            return;
        }
        // Save to localStorage (for demo only, not secure)
        localStorage.setItem('user-email', email);
        localStorage.setItem('user-password', password);
        alert('Sign up successful! You can now log in.');
    };

    // Log in
    document.querySelector('.login .submit-btn').onclick = function () {
        const inputs = document.querySelectorAll('.login .form-holder .input');
        const email = inputs[0].value.trim();
        const password = inputs[1].value;
        const storedEmail = localStorage.getItem('user-email');
        const storedPassword = localStorage.getItem('user-password');

        if (email === storedEmail && password === storedPassword) {
            window.location.href = "nav-rooms.html";
        } else {
            alert('Invalid email or password.');
        }
    };
});