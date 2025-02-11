document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.querySelector('#content-table tbody');

    function fetchData() {
        const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";
        const req = `${apiurl}/content/get?limit=200`;

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
                <td>
                    <button class="btn btn-sm btn-outline-primary ms-2" onclick="editName(${row.id})">
                        <i class="bi bi-pencil"></i>
                    </button>
                    ${row.name}
                </td>
                <td>${row.width} x ${row.height}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary ms-2" onclick="editDuration(${row.id})">
                        <i class="bi bi-pencil"></i>
                    </button>
                    ${row.duration}
                </td>
                <td>${row.type}</td>
                <td>${row.added_at}</td>
                <td>
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
            const req = apiurl + "/content/delete";
            fetch(req, {    
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 'id': id })
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

    window.editName = function(id) {
        const newName = prompt('Neuer Dateiname:');
        if (newName) {
            const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";
            const req = apiurl + "/content/update";

            fetch(req, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id, name: newName })
            })
            .then(response => {
                console.log(newName);
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                console.log('Updated name:', data);
                fetchData(sortOptions.value);
            })
            .catch(error => {
                console.error('Error updating name:', error)
                alert('Failed to update the name. Please try again.');
            });
        }
    };

    window.editDuration = function(id) {
        const newDuration = prompt('Neue Dauer:');
        
        if (newDuration) {
            const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";
            const req = apiurl + "/content/update";

            fetch(req, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id, duration: newDuration  })
            })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    console.log('Updated duration:', data);
                    fetchData(sortOptions.value);
                })
                .catch(error => console.error('Error updating duration:', error));
        }
    };

    fetchData();
});