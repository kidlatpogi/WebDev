document.querySelectorAll('.desktop-navbar li a').forEach(link => {
        const linkPath = new URL(link.href).pathname;
        const currentPath = window.location.pathname;

        if (linkPath === currentPath || currentPath.endsWith(link.getAttribute('href'))) {
            link.classList.add('active');
        }
    });