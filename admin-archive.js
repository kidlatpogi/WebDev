document.addEventListener('DOMContentLoaded', () => {
    fetch('get-archive-data.php')
        .then(response => {
            console.log('Raw response:', response);
            return response.json();
        })
        .then(reservations => {
            console.log('Parsed reservations:', reservations);
            const table = document.getElementById('archiveTable');
            if (!reservations.length) {
                table.innerHTML = '<p style="text-align: center; margin-top: 30px;">No completed reservations found.</p>';
                return;
            }
            let html = '';
            reservations.forEach(reservation => {
                const dateReserved = new Date(reservation.reservation_date).toLocaleDateString('en-US', { month: 'long', day: '2-digit', year: 'numeric' });
                
                const dateCompleted = dateReserved;
                html += `
                  <div class="table-row" style="display: flex; font-weight: normal;">
                    <div style="flex:1;">${reservation.room_number}</div>
                    <div style="flex:1;">${dateReserved}</div>
                    <div style="flex:1;">${dateCompleted}</div>
                  </div>
                `;
            });
            table.innerHTML = html;
        })
        .catch(err => {
            document.getElementById('archiveTable').innerHTML = '<p style="color:red;">Failed to load data.</p>';
            console.error('Error fetching archive data:', err);
        });
});