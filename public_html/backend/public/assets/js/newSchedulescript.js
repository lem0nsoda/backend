$(document).ready(function () {
    let selectedClients = [];
    let droppedPlaylist = null; // Playlist, die in den Drop-Bereich gezogen wurde

    const tableBody = document.querySelector('#content-table tbody');
    const clientsRow = document.querySelector('#clients-row');
    const dropZone = $('#drop-zone');
    const dropDetails = $('#drop-details');

    const saveButton = document.getElementById('save-button');

    const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";

    function requestPlaylist(){
        const req = apiurl + "/playlist/get?table=playlist";
        // Fetch-Daten vom Server abrufen
        fetch(req)
            .then(response => response.json())
            .then(data => {
                populateTable(data);
                enableDragAndDrop();

                
                new DataTable('#content-table');
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    function requestClient(){
        const req = apiurl + "/client/get?limit=50";

        fetch(req)
            .then(response => response.json())
            .then(data => {
                displayClientCheckboxes(data);
                enableDragAndDrop();
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    // Funktion: Playlists in die Tabelle einfügen
    function populateTable(rows) {
        tableBody.innerHTML = rows.map(row => `
            <tr class="draggable" data-id="${row.id}" data-name="${row.name}" data-duration="${row.duration}">
                <td>${row.name}</td>
                <td>${row.duration}</td>
            </tr>
        `).join('');
    }

    // Clients mit Checkboxen anzeigen
    function displayClientCheckboxes(clients) {
        clientsRow.innerHTML = clients.map(client => `
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" value="${client.id}" id="client-${client.id}">
                <label class="form-check-label" for="client-${client.id}">${client.id}</label>
            </div>
        `).join('');
    }

    // Draggable Playlists aktivieren
    function enableDragAndDrop() {
        $('#content-table .draggable').draggable({
            helper: 'clone',
            zIndex: 999
        });
    }

    function addClients(id){
        console.log("hello");
        const req = apiurl + "/playlist/addPlaysOn";
        let uploaded = 0;

        // Erstelle ein Array von Promises für alle `fetch()`-Anfragen
        const uploadPromises = selectedClients.map(client => {

            fileData = {
                client_id: Number(client),
                play_id: id
            };

            // Senden der POST-Anfrage mit den Content-Daten
            return fetch(req, {
                method: 'POST', // HTTP-Methode
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(fileData) // Konvertiere das Datenobjekt in einen JSON-String
            })
            .then(response => response.json())
            .then(data => {
                console.log('Erfolgreich hinzugefügt:', data); // Erfolgsnachricht
                uploaded++; // Zähle erfolgreiche Uploads
            })
            .catch(error => {
                console.error('Fehler beim Hinzufügen des Inhalts:', error); // Fehlerbehandlung
            });
        });

        // Verwende `Promise.all()` um zu warten, dass alle Uploads abgeschlossen sind
        Promise.all(uploadPromises)
            .then(() => {
                // Wenn alle Dateien erfolgreich hochgeladen wurden, leere das Array
                if (uploaded === selectedClients.length) {
                    reset();
                }
            })
            .catch(error => {
                console.error('Ein Fehler trat beim Hochladen auf:', error);
            });
    }

    function addStart(startTime){
        if (!selectedClients) {
            alert('Bitte Client(s) auswählen.');
            return;
        }

        req = apiurl + "/playlist/addPlayPlaylist";

        fileData = {
            playlist_id: droppedPlaylist.id,
            start: startTime
        };

        console.log(fileData);

        fetch(req, {
            method: 'POST', // HTTP-Methode
            headers: {
                'Content-Type': 'application/json', // Wir senden JSON-Daten
                // Weitere Header wie Authentifizierung können hier hinzugefügt werden
            },
            body: JSON.stringify(fileData) // Konvertiere das Datenobjekt in einen JSON-String
        })
        .then(response => response.json()) // Antwort als JSON parsen
        .then(data => {
            console.log('Erfolgreich hinzugefügt:', data); // Erfolgsnachricht
            console.log("new id : " + data.newID);

            addClients(data.newID);
        })
        .catch(error => {
            console.error('Fehler beim Hinzufügen des Inhalts:', error); // Fehlerbehandlung
        });

    }

    // Drop-Bereich aktivieren
    dropZone.droppable({
        accept: '.draggable',
        drop: function (event, ui) {
            const playlistId = ui.helper.data('id');
            const playlistName = ui.helper.data('name');
            const playlistDuration = ui.helper.data('duration');

            getSelectedClients();

            droppedPlaylist = { id: playlistId, name: playlistName, duration: playlistDuration };

            let clients = selectedClients.join(', ') || 'Keine Clients';
            dropDetails.html(`
                <p><strong>Playlist:</strong> ${playlistName} (${playlistDuration})</p>
                <p><strong>Clients:</strong> ${clients}</p>
            `);
        }
    });

    // Funktion: Ausgewählte Clients abrufen
    function getSelectedClients() {
        let clients = [];
        document.querySelectorAll('.form-check-input:checked').forEach(checkbox => {
            clients.push(checkbox.value);
        });
        console.log(clients);
        
        selectedClients = clients;
    }

    function reset(){

        // Reset des Drop-Bereichs
        selectedClients = null;
        droppedPlaylist = null;
        dropDetails.html('');
        document.getElementById('event-form').reset();
        //alert('Ereignis erfolgreich hinzugefügt!');
    }

    // Event-Erstellung beim Speichern
    saveButton.addEventListener('click', () => {
        if (!droppedPlaylist) {
            alert('Bitte ziehen Sie zuerst eine Playlist in den Drop-Bereich.');
            return;
        }

        const day = $('#day').val();
        const month = $('#month').val();
        const year = $('#year').val();
        const startTime = $('#start-time').val();

        if (!day || !month || !year || !startTime) {
            alert('Bitte füllen Sie alle Datums- und Zeitfelder aus.');
            return;
        }
        
        const eventDate = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')} ${startTime}`;
        console.log(eventDate);

        console.log("playlist: " + droppedPlaylist.id);

        $('#calendar').fullCalendar('renderEvent', {
            name: droppedPlaylist.name,
            start: eventDate,
            description: `Clients: ${selectedClients.join(', ')}`
        }, true);

        addStart(eventDate);

    });

    // Kalender initialisieren
    $('#calendar').fullCalendar({
        locale: 'de',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: true,
        eventClick: function (event) {
            alert(event.description);
        }
    });

    requestPlaylist();
    requestClient();
});
