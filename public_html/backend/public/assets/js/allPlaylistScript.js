document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.querySelector('#content-table tbody');

    function fetchData() {
        const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";

        const req = apiurl + "/playlist/get?table=playlist&limit=100";
        
        fetch(req)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                console.log('Fetched data:', data);
                populateTable(data);

                new DataTable('#content-table');
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    function populateTable(rows) {
        tableBody.innerHTML = rows.map(row => `
            <tr>
                <td>${row.id}</td> 
                <td>${row.name}</td> 
                <td>${row.duration}</td> 
                <td>${row.last_use}</td> 
                <td>${row.created_at}</td> 
                <td>${row.username}</td> 
                <td>
                    <a class="btn btn-sm btn-outline-primary ms-2" href="/backend/public/index.php/menu/playlistBearbeiten?id=${row.id}">
                        <i class="bi bi-pencil"></i>
                    </a>
                  <button class="btn btn-sm btn-outline-danger" onclick="deleteRow(${row.id})">
                        <i class="bi bi-trash3"></i>
                    </button>
                </td> 
            </tr>
        `).join('');
    }

    window.deleteRow = function(id) {
        if (confirm('Möchten Sie diesen Eintrag wirklich löschen?')) {
            const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";
            fetch(`${apiurl}/playlist/delete`, { 
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 'table': 'playlist', 'id': id })
            })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    console.log('Deleted data:', data);
                    fetchData(sortOptions.value);
                })
                .catch(error => console.error('Error deleting data:', error));
        }
    };

    fetchData(); 
});
