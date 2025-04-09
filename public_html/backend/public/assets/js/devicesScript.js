document.addEventListener('DOMContentLoaded', function () {

    // api-url 
    const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";
    // anfrage-url für clients mit status 1 (online)
    const req = apiurl + "/client/getBy?where=client_status&is=1&limit=100";

    // container, in dem die clients als divs angezeigt werden
    const clientsContainer = document.getElementById('clientsList');
    const SCALE_FACTOR = 0.3; // skalierungsfaktor für anzeigegröße

    // daten vom server laden (aktive clients) und anzeigen
    fetch(req)
        .then(response => {
            if (!response.ok) {
                throw new Error(`fehler beim laden der json-datei: ${response.statusText}`);
            }
            return response.json();
        })
        .then(clientsList => {
            clientsContainer.innerHTML = ''; // container leeren
            clientsList.map(client => {
                console.log(client);
                // berechne skalierte größe, mit mindestgröße von 50px
                const scaledWidth = Math.max(50, client.width * SCALE_FACTOR);
                const scaledHeight = Math.max(50, client.height * SCALE_FACTOR);
                // client als rechteck hinzufügen
                addClientToContainer(client, scaledWidth, scaledHeight);
            });
        })
        .catch(error => console.error('fehler beim laden der json-daten:', error));

    // erstellt ein div für einen client und fügt es in den container ein
    function addClientToContainer(client, width, height) {
        const clientDiv = document.createElement('div');
        clientDiv.classList.add('client');
        clientDiv.setAttribute('id', `client-${client.id}`);

        // breite und höhe (skaliert)
        clientDiv.style.width = `${width}px`;
        clientDiv.style.height = `${height}px`;

        // zufällige position im container (mit grenzen)
        clientDiv.style.left = `${Math.random() * (clientsContainer.clientWidth - width)}px`;
        clientDiv.style.top = `${Math.random() * (clientsContainer.clientHeight - height)}px`;

        // inhalt im div anzeigen
        clientDiv.innerHTML = `
            <p>clientid: ${client.id}</p>
            <p>screen: ${client.width} x ${client.height}</p>
        `;

        // div zum container hinzufügen
        clientsContainer.appendChild(clientDiv);

        // drag-and-drop aktivieren
        enableDragging(clientDiv);
    }

    // ermöglicht das verschieben (dragging) von client-divs
    function enableDragging(clientDiv) {
        let offsetX, offsetY;

        clientDiv.addEventListener('mousedown', (e) => {
            e.preventDefault();
            const rect = clientDiv.getBoundingClientRect();
            offsetX = e.clientX - rect.left;
            offsetY = e.clientY - rect.top;

            // mausbewegung verfolgen
            function onMouseMove(e) {
                const containerRect = clientsContainer.getBoundingClientRect();

                let newX = e.clientX - containerRect.left - offsetX;
                let newY = e.clientY - containerRect.top - offsetY;

                // grenzen prüfen
                newX = Math.max(0, Math.min(newX, clientsContainer.clientWidth - clientDiv.offsetWidth));
                newY = Math.max(0, Math.min(newY, clientsContainer.clientHeight - clientDiv.offsetHeight));

                clientDiv.style.left = `${newX}px`;
                clientDiv.style.top = `${newY}px`;
            }

            // beim loslassen der maus das dragging beenden
            function onMouseUp() {
                document.removeEventListener('mousemove', onMouseMove);
                document.removeEventListener('mouseup', onMouseUp);
            }

            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        });
    }

    // daten-tabelle anzeigen

    const tableBody = document.querySelector('#content-table tbody');

    // daten für die tabelle laden
    function fetchData(sortOption = 'id-asc') {
        sort = sortOption.split('-');
        const req = apiurl + "/client/get?limit=100&by=" + sort[0] + "&order=" + sort[1];

        fetch(req)
            .then(response => {
                if (!response.ok) throw new Error('network response was not ok');
                return response.json();
            })
            .then(data => {
                console.log('fetched data:', data);
                populateTable(data); // tabelle befüllen
                new DataTable('#content-table'); 
            })
            .catch(error => console.error('error fetching data:', error));
    }

    //status in tabelle, 0/1 zu on/offline
    function status(statusInt){
        let statusString;

        switch(statusInt){
            case 1: statusString = "online"; break;
            case 0: statusString = "offline"; break;
            default: statusString = "undefined - " + statusInt; break;
        }
        return statusString;
    }

    // füllt tabelle mit daten
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
                    <button class="btn btn-sm btn-outline-primary ms-2" onclick="editPos(${row.id})">
                        <i class="bi bi-pencil"></i>
                    </button>
                    ${row.xPosition} / ${row.yPosition}
                </td> 
                <td>${status(row.client_status)}</td>
                <td>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteRow(${row.id})">
                        <i class="bi bi-trash3"></i>
                    </button>
                </td>
            </tr>
        `).join('');
    }

    //löscht eine zeile (nach bestätigung mit alert) 
    window.deleteRow = function(id) {
        if (confirm('möchten sie diesen eintrag wirklich löschen?')) {
            fetch(`${apiurl}/client/delete`, {
                method: 'POST',
                headers: { 'content-type': 'application/json' },
                body: JSON.stringify({ id: id })
            })
                .then(response => {
                    if (!response.ok) throw new Error('network response was not ok');
                    return response.json();
                })
                .then(data => {
                    console.log('deleted data:', data);
                    fetchData(); // tabelle neu laden
                })
                .catch(error => console.error('error deleting data:', error));
        }
    };

    window.useClient = function(id) {
        fetch(`${apiurl}/client/use`, {
            method: 'POST',
            headers: { 'content-type': 'application/json' },
            body: JSON.stringify({ id: id })
        })
            .then(response => {
                if (!response.ok) throw new Error('network response was not ok');
                return response.json();
            })
            .then(data => {
                console.log('client activated:', data);
                fetchData(); // tabelle neu laden
            })
            .catch(error => console.error('error activating client:', error));
    };

    //bearbeitung des Clientnamens
    window.editName = function(id) {
        const newName = prompt('neuer gerätename:');
        if (newName) {
            fetch(`${apiurl}/client/update`, {
                method: 'POST',
                headers: { 'content-type': 'application/json' },
                body: JSON.stringify({ id: id, name: newName })
            })
                .then(response => {
                    if (!response.ok) throw new Error('network response was not ok');
                    return response.json();
                })
                .then(data => {
                    console.log('updated name:', data);
                    fetchData(); // tabelle aktualisieren
                })
                .catch(error => console.error('error updating name:', error));
        }
    };

    //Bearbeitung der position des clients (x/y)
    window.editPos = function(id) {
        const xy = prompt('neue kooridnaten: x/y').split("/");
        const x = xy[0];
        const y = xy[1];

        if (x && y) {
            fetch(`${apiurl}/client/update`, {
                method: 'POST',
                headers: { 'content-type': 'application/json' },
                body: JSON.stringify({ id: id, xPosition: x , yPosition: y })
            })
                .then(response => {
                    if (!response.ok) throw new Error('network response was not ok');
                    return response.json();
                })
                .then(data => {
                    console.log('updated position:', data);
                    fetchData(); // tabelle aktualisieren
                })
                .catch(error => console.error('error updating position:', error));
        }
    };

    // lade die daten beim seitenaufruf
    fetchData();
});
