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
            reservations.forEach(reservation => {
                const dateReserved = new Date(reservation.reservation_date).toLocaleDateString('en-US', { month: 'long', day: '2-digit', year: 'numeric' });
                // For demo, using reservation_date as completed date
                html += `
                  <div class="table-row">
                    <div>${reservation.room_number}</div>
                    <div>${dateReserved}</div>
                    <div>${dateReserved}</div>
                  </div>
                `;
            });
            table.innerHTML = html;
        })
        .catch(err => {
            document.getElementById('archiveTable').innerHTML = '<p style="color:red;">Failed to load data.</p>';
        });
});