document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.querySelector('#content-table tbody');
    const save = document.querySelector('#save-playlist');
    const previewArea = document.getElementById('preview-area');
    const totalDurationSpan = document.getElementById('total-duration');
    let selectedContent = [];

    const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";
    var req = apiurl + "/content/get?limit=15";

    save.addEventListener('click', () => safePlaylist());

    // Fetch data from the server
    fetch(req)
        .then(response => response.json())
        .then(data => {
            populateTable(data)
            
            new DataTable('#content-table');
        })
        .catch(error => console.error('Error fetching data:', error));

    // Tabelle 
    function populateTable(data) {
        tableBody.innerHTML = data.map(item => `
            <tr draggable="true" data-json='${JSON.stringify(item)}'>
                <td>${item.name}</td>
                <td>${item.duration}</td>
                <td>${item.type}</td>
            </tr>
        `).join('');

        // Drag-Event für Tabellenzeilen
        document.querySelectorAll('#content-table tr').forEach(row => {
            row.addEventListener('dragstart', e => {
                e.dataTransfer.setData('text/plain', row.dataset.json);
            });
        });
    }

    // Rechte Vorschau-Box: Drag-and-Drop ermöglichen
    previewArea.addEventListener('dragover', e => e.preventDefault());
    previewArea.addEventListener('drop', e => {
        e.preventDefault();
        const item = JSON.parse(e.dataTransfer.getData('text/plain'));

        const data  = {
            content: item.id,
            order: 0,
            duration: item.duration
        }

        selectedContent.push(JSON.stringify(data));
        console.log(selectedContent);
        addToPreview(item);
    });

    function addToPreview(item) {

        const div = document.createElement('div');
        div.className = 'preview-item';
        div.dataset.dauer = item.duration;
        div.dataset.contentId = item.id;

        div.innerHTML = `
            <span>${item.name} (${item.type})</span>
            <div>
                <button class="btn btn-sm btn-outline-danger decrease-btn">-</button>
                <span class="duration">${item.duration}s</span>
                <button class="btn btn-sm btn-outline-success increase-btn">+</button>
            </div>
        `;

        // Buttons hinzufügen für Dauer-Steuerung
        const decreaseBtn = div.querySelector('.decrease-btn');
        const increaseBtn = div.querySelector('.increase-btn');

        const durationSpan = div.querySelector('.duration');

        decreaseBtn.addEventListener('click', () => adjustDuration(div, durationSpan, -1));
        increaseBtn.addEventListener('click', () => adjustDuration(div, durationSpan, 1));

        previewArea.appendChild(div);
        TotalDuration();

        // Sortierung der Elemente in der Vorschau ermöglichen
        new Sortable(previewArea, {
            //Dauer der Anzeige bei verschiebung von inhalt
            animation: 150,
        });
    }

    function adjustDuration(element, durationSpan, change) {
        let currentDuration = parseInt(element.dataset.dauer);

        if(isNaN(currentDuration))
            currentDuration = 0;

        currentDuration = Math.max(0, currentDuration + change); // Keine negative Dauer
        element.dataset.dauer = currentDuration;
        durationSpan.textContent = `${currentDuration}s`;

        TotalDuration();
        //updateContainsDuration(element.dataset.contentId, currentDuration);
    }

    function TotalDuration() {
        let total = 0;
        Duration = [...previewArea.children].map(el => {
            let dur = parseInt(el.dataset.dauer)
            if(!isNaN(dur))
                total += dur;
        });

        console.log(total);
        totalDurationSpan.textContent = `Gesamtdauer: ${total}s`;
        return total;
    }

    function safePlaylist(){
        let name = prompt('Playlist Name:');
        let req = apiurl + "/playlist/addPlaylist";

        let fileData = {
            name: name,
            duration: TotalDuration(),
            created_by: 1       /// USERRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR
        }

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

            addContains(data.newID);
        })
        .catch(error => {
            console.error('Fehler beim Hinzufügen des Inhalts:', error); // Fehlerbehandlung
        });
    }

    function addContains(playlist){
        let order = 1;
        let uploaded = 0;
        let toUpload = 0;

        let req = apiurl + "/playlist/addPlaylistContains";

        const uploadPromises = [...previewArea.children].map(content => {
            if(content.dataset.contentId){
                toUpload ++;

                fileData = {
                    content_id: content.dataset.contentId,
                    playlist_id: playlist,
                    arrangement: order,
                    duration: content.dataset.dauer
                };

                console.log(fileData);

                order ++;

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
            }else
                return 0;
        });

            // Verwende `Promise.all()` um zu warten, dass alle Uploads abgeschlossen sind
        Promise.all(uploadPromises)
        .then(() => {
            // Wenn alle Dateien erfolgreich hochgeladen wurden, leere das Array
            if (uploaded === toUpload) {
                alert("playlist erfolgreich hinzugefügt");
                previewArea.innerHTML = '<p>Content von der Tabelle hierher ziehen</p>';
            }
        })
        .catch(error => {
            console.error('Ein Fehler trat beim Hochladen auf:', error);
        });
    }
});
