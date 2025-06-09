document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".account-form");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch("update_account.php", {
            method: "POST",
            body: formData
        })
        .then(response => {
            // First try to parse as JSON
            return response.text().then(text => {
                try {
                    return JSON.parse(text);
                } catch (e) {
                    // If not JSON, treat as plain text
                    return {
                        success: text.toLowerCase().includes('success'),
                        message: text
                    };
                }
            });
        })
        .then(data => {
            if (data.success) {
                alert(data.message || "Update successful!");
                // Optionally reload or update UI here
            } else {
                alert(data.message || "Update failed.");
            }
        })
        .catch(error => {
            console.error("❌ Error:", error);
            alert("Something went wrong. Please try again.");
        });
    });
});