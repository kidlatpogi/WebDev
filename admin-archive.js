document.addEventListener('DOMContentLoaded', () => {
    fetch('get-archive-data.php')
        .then(response => response.json())
        .then(reservations => {
            const table = document.getElementById('archiveTable');
            if (!reservations.length) {
                table.innerHTML = '<p style="text-align: center; margin-top: 30px;">No completed reservations found.</p>';
                return;
            }
            let html = '';
            reservations.forEach((reservation, idx) => {
                const dateReserved = new Date(reservation.reservation_date).toLocaleDateString('en-US', { month: 'long', day: '2-digit', year: 'numeric' });
                const dateCompleted = dateReserved;
                html += `
                  <div class="archive-row" data-index="${idx}">
                    <div style="font-weight:bold;">Room ${reservation.room_number} | ${reservation.room_type}</div>
                    <div><b>Date Reserved:</b> ${dateReserved}</div>
                    <div><b>Date Completed:</b> ${dateCompleted}</div>
                    <div><b>Reserved By:</b> ${reservation.fname} ${reservation.lname}</div>
                  </div>
                `;
            });
            table.innerHTML = html;

            // Add click event to each row
            document.querySelectorAll('.archive-row').forEach(row => {
                row.addEventListener('click', function() {
                    const idx = this.getAttribute('data-index');
                    showModal(reservations[idx]);
                });
            });
        })
        .catch(err => {
            document.getElementById('archiveTable').innerHTML = '<p style="color:red;">Failed to load data.</p>';
            console.error('Error fetching archive data:', err);
        });

    // Modal logic
    const modalOverlay = document.getElementById('modal-overlay');
    const modalDetails = document.getElementById('modal-details');
    const closeModal = document.getElementById('close-modal');
    const mainContent = document.querySelector('.main-content-wrapper');

    function showModal(reservation) {
        modalDetails.innerHTML = `
            <div style="font-weight:bold; margin-bottom:10px;">Reservation Details</div>
            <div><b>Room Number:</b> ${reservation.room_number}</div>
            <div><b>Date Reserved:</b> ${new Date(reservation.reservation_date).toLocaleDateString('en-US', { month: 'long', day: '2-digit', year: 'numeric' })}</div>
            <div><b>Date Completed:</b> ${new Date(reservation.reservation_date).toLocaleDateString('en-US', { month: 'long', day: '2-digit', year: 'numeric' })}</div>
            <div><b>Room Type:</b> ${reservation.room_type}</div>
            <div><b>Reserved By:</b> ${reservation.fname} ${reservation.lname}</div>
        `;
        modalOverlay.classList.add('active');
        mainContent.classList.add('blurred-background');
    }

    closeModal.onclick = function() {
        modalOverlay.classList.remove('active');
        mainContent.classList.remove('blurred-background');
    };

    // Also close modal when clicking outside modal-content
    modalOverlay.onclick = function(e) {
        if (e.target === modalOverlay) {
            modalOverlay.classList.remove('active');
            mainContent.classList.remove('blurred-background');
        }
    };
});