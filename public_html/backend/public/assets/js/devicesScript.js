

document.addEventListener('DOMContentLoaded', function () {


    const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";
    const req = apiurl + "/client/getBy?where=status&is=1";

    const clientsContainer = document.getElementById('clientsList');
    const SCALE_FACTOR = 0.3; // Skalierungsfaktor

    fetch(req)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Fehler beim Laden der JSON-Datei: ${response.statusText}`);
            }
            return response.json();
        })
        .then(clientsList => {
            clientsContainer.innerHTML = '';
            clientsList.forEach(client => {
                const scaledWidth = Math.max(50, client.width * SCALE_FACTOR); // Minimiere zu kleine Rechtecke
                const scaledHeight = Math.max(50, client.height * SCALE_FACTOR);
                addClientToContainer(client, scaledWidth, scaledHeight);
            });
        })
        .catch(error => console.error('Fehler beim Laden der JSON-Daten:', error));

    // Füge Rechteck (Client) in den Container ein
    function addClientToContainer(client, width, height) {
        const clientDiv = document.createElement('div');
        clientDiv.classList.add('client');
        clientDiv.setAttribute('id', `client-${client.id}`);

        // Setze Breite und Höhe (skaliert)
        clientDiv.style.width = `${width}px`;
        clientDiv.style.height = `${height}px`;

        // Zufällige Position innerhalb des Containers
        clientDiv.style.left = `${Math.random() * (clientsContainer.clientWidth - width)}px`;
        clientDiv.style.top = `${Math.random() * (clientsContainer.clientHeight - height)}px`;

        // Inhalte hinzufügen
        clientDiv.innerHTML = `
            <p>ClientID: ${client.id}</p>
            <p>Screen: ${client.width} x ${client.height}</p>
        `;

        // Füge das Element dem Container hinzu
        clientsContainer.appendChild(clientDiv);

        // Dragging aktivieren
        enableDragging(clientDiv);
    }

    // Drag-and-Drop
    function enableDragging(clientDiv) {
        let offsetX, offsetY;

        clientDiv.addEventListener('mousedown', (e) => {
            e.preventDefault();
            const rect = clientDiv.getBoundingClientRect();
            offsetX = e.clientX - rect.left;
            offsetY = e.clientY - rect.top;

            function onMouseMove(e) {
                const containerRect = clientsContainer.getBoundingClientRect();

                let newX = e.clientX - containerRect.left - offsetX;
                let newY = e.clientY - containerRect.top - offsetY;

                // Grenzen beachten
                newX = Math.max(0, Math.min(newX, clientsContainer.clientWidth - clientDiv.offsetWidth));
                newY = Math.max(0, Math.min(newY, clientsContainer.clientHeight - clientDiv.offsetHeight));

                clientDiv.style.left = `${newX}px`;
                clientDiv.style.top = `${newY}px`;
            }

            function onMouseUp() {
                document.removeEventListener('mousemove', onMouseMove);
                document.removeEventListener('mouseup', onMouseUp);
            }

            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        });
    }

    //TABELLE

    const tableBody = document.querySelector('#content-table tbody');
    const sortOptions = document.querySelector('#sort-options');

    function fetchData(sortOption = 'id-asc') {
        
        const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";

        sort = sortOption.split('-');

        const req = apiurl + "/client/get?by=" + sort[0] + "&order=" + sort[1];

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
    function status(statusInt){
        let statusString;
        switch(statusInt){
            case 1: statusString = "online";
                break;
            case 0: statusString = "offline";
                break;
            default: statusString = "undefined - " + statusInt;
                break;
        }
        return statusString;
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
                <td>${status(row.status)}</td>
                <td>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteRow(${row.id})">
                        <i class="bi bi-trash3"></i>
                    </button>
                </td>
            </tr>
        `).join('');

    }

    // Buttons zum ändern und löschen

    window.deleteRow = function(id) {
        if (confirm('Möchten Sie diesen Eintrag wirklich löschen?')) {
            const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";
            fetch(`${apiurl}/client/delete`, {
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
                    fetchData(sortOptions.value);
                })
                .catch(error => console.error('Error deleting data:', error));
        }
    };

    window.editName = function(id) {
        const newName = prompt('Neuer Gerätename:');
        if (newName) {
            const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";
            fetch(`${apiurl}/client/update`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id, name: newName })
            })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    console.log('Updated name:', data);
                    fetchData(sortOptions.value);
                })
                .catch(error => console.error('Error updating name:', error));
        }
    };


    fetchData();
});
