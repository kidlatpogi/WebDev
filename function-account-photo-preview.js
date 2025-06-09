document.getElementById('account-photo-input').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        // preview image
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('account-photo-preview').src = e.target.result;
        };
        reader.readAsDataURL(file);
        document.getElementById('photo-upload-form').submit();
    }
});
