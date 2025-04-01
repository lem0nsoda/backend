document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.querySelector('#content-table tbody');
    const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";

    function fetchData() {
        const req = `${apiurl}/content/getInfo?limit=200`;

        fetch(req)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                console.log('Fetched data:', data);
                populateTable(data);
                new DataTable('#content-table');
                loadPreviews(data);
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    function populateTable(rows) {
        tableBody.innerHTML = rows.map(row => `
            <tr data-id="${row.id}" data-type="${row.type}">
                <td class="preview-cell" style="text-align: center; vertical-align: middle;"></td>
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

    function loadPreviews(rows) {
        rows.forEach(row => {
            const cell = document.querySelector(`tr[data-id='${row.id}'] .preview-cell`);
            
            fetch(`${apiurl}/content/getThis?id=${row.id}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    if (data[0].data.includes("image")) {
                        const img = document.createElement("img");
                        img.src = data[0].data;
                        img.style.height = "25px";
                        img.style.width = "auto";
                        img.style.display = "block";
                        img.style.margin = "auto";
                        cell.appendChild(img);
                    } else if (data[0].data.includes("video")) {
                        const img = document.createElement("img");
                        img.src = `${data[0].data}#t=0.1`; // Versucht, das erste Frame zu laden
                        img.style.height = "25px";
                        img.style.width = "auto";
                        img.style.display = "block";
                        img.style.margin = "auto";
                        cell.appendChild(img);
                    }
                })
                .catch(error => console.error('Error loading preview:', error));
        });
    }

    window.deleteRow = function(id) {
        if (confirm('Möchten Sie diesen Eintrag wirklich löschen?')) {
            fetch(`${apiurl}/content/delete`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id })
            })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    console.log('Deleted data:', data);
                    fetchData();
                })
                .catch(error => console.error('Error deleting data:', error));
        }
    };

    window.editName = function(id) {
        const newName = prompt('Neuer Dateiname:');
        if (newName) {
            const req = apiurl + "/content/update";

            fetch(req, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 'id': id, 'name': newName })
            })
            .then(response => {
                console.log(newName);
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                console.log('Updated name:', data);
                tableBody= "";
                fetchData();
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
                    fetchData();
                })
                .catch(error => console.error('Error updating duration:', error));
        }
    };

    fetchData();
});



