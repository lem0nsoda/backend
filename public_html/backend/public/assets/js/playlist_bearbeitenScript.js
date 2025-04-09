document.addEventListener('DOMContentLoaded', () => {
    const ownDataTableBody = document.querySelector('#data-table tbody');
    const contentTableBody = document.querySelector('#content-table tbody');
    const clientsRow = document.querySelector('#clients-row');
    const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";

    const params = new URLSearchParams(window.location.search);
    const playlistID = params.get('id');
    
    let containsData = [];
    let contentData = [];

    //playlistdaten holen
    function fetchPlaylistData() {
        const req = `${apiurl}/playlist/getThis?table=playlist&id=${playlistID}`;

        fetch(req)
            .then(response => response.json())
            .then(data => {
                console.log('Fetched data:', data);
                populateDataTable(data[0]);
            })
            .catch(error => console.error('Error fetching playlist data:', error));
    }

    function fetchContainsData() {
        const req = `${apiurl}/playlist/getBy?table=playlist_contains&where=playlist_ID&is=${playlistID}&by=arrangement`;

        fetch(req)
            .then(response => response.json())
            .then(data => {
                console.log('Fetched contains data:', data);
                data.forEach(element => containsData.push(element));
                console.log('contains', containsData);
                fetchContentData();
            })
            .catch(error => console.error('Error fetching contains data:', error));
    }

    //contentdaten holen
    function fetchContentData() {
        //const req = `${apiurl}/content/getThis?id=${containsData.content_ID}`;
        let get = 0;


        // Erstelle ein Array von Promises für alle `fetch()`-Anfragen
        const uploadPromises = containsData.map(content => {
            const req = apiurl + "/content/getThis?id=" + content.content_ID;

            return fetch(req)
            .then(response => response.json()) // Antwort als JSON parsen
            .then(data => {
                contentData.push(data);
                get++; // Zähle erfolgreiche Uploads
            })
            .catch(error => {
                console.error('Fehler beim Hinzufügen des Inhalts:', error); // Fehlerbehandlung
            });
        });

        // Verwende `Promise.all()` um zu warten, dass alle Uploads abgeschlossen sind
        Promise.all(uploadPromises)
            .then(() => {
                // Wenn alle Dateien erfolgreich hochgeladen wurden, leere das Array
                if (get === containsData.length) {
                    console.log(contentData);
                    populateContentTable();

                    new DataTable('#content-table');
                }
            })
            .catch(error => {
                console.error('Ein Fehler trat beim Hochladen auf:', error);
            });

    }

    //arrays leeren / zurücksetzten
    function reset(){
        containsData = [];
        contentData = [];
    }

    //füllen der tabelle mit playlistname und dauer
    function populateDataTable(playlist) {
        ownDataTableBody.innerHTML = `
            <tr>
                <td><strong>Playlistname:</strong></td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" onclick="editPlaylistName(${playlist.id})">
                         <i class="bi bi-pencil"></i>
                    </button>
                    ${playlist.name}
                </td>
            </tr>
            <tr>
                <td><strong>Duration:</strong></td>
                <td>${playlist.duration}</td>
            </tr>
        `;
    }

    //zum bearbeiten des playlistnamens
    window.editPlaylistName = function() {
        const newName = prompt('Neuer Dateiname:');
        if (newName) {
            const req = apiurl + "/playlist/updatePlaylist"

            fetch(req, {
                method: 'POST',
                headers: { 'Playlist-Type': 'application/json' },
                body: JSON.stringify({ id: playlistID, name: newName })
            })
                .then(response => {
                    console.log(newName);
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    console.log('Updated name:', data);
                    fetchPlaylistData();
                })
                .catch(error => {
                    console.error('Error updating name:', error)
                    alert('Failed to update the name. Please try again.');
                });
        }
    };

    //tabelle befüllen mit contents der playlist
    function populateContentTable() {
        contentTableBody.innerHTML = contentData.map((content) =>{
            content= content[0]; 
            let data;
            let duration = 0;

            containsData.forEach(contains =>{
                if(content.id == contains.content_ID)
                    data = contains;
            });

            if(data.duration)
                duration = data.duration;
            else if(content.duration)
                duration = content.duration;

            return `
            <tr data-id="${content.id}" data-order="${data.arrangement}">
                <td>
                    
                    <button class="btn btn-sm btn-outline-primary ms-2" onclick="editOrder(${content.id})">
                        <i class="bi bi-pencil"></i>
                    </button>
                    ${data.arrangement}
                </td>
                <td>${content.id} - ${content.name}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary ms-2" onclick="editDuration(${content.id})">
                        <i class="bi bi-pencil"></i>
                    </button>
                    ${duration}
                </td>
                <td>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteRow(${content.id})">
                        <i class="bi bi-trash3"></i>
                    </button>
                </td>
            </tr>
        `}).join('');
        
    }

    //dauer der playlist aktuellieren (wenn von einem content die dauer verändert wird)
    function updatePlaylistDuration(){
        console.log("playlist duration");
        let newDuration = 0;
        containsData.forEach(contains =>{
            if(contains.duration){
                console.log(contains.duration);
                newDuration += contains.duration;
            }
            else{
                console.log("else");
                const index = containsData.findIndex(item => item.content_ID === id);
                if (index === -1) return;

                const cDuration = containsData[index].duration;

                if(cDuration)
                    newDuration += cDuration;
            }
        });
        
        const req = apiurl + "/playlist/updatePlaylist";

        fetch(req, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: playlistID, duration: newDuration })
        })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                console.log('Updated duration:', data);
                fetchPlaylistData();
            })
            .catch(error => console.error('Error updating duration:', error));
        
    }

    //dauer eines contents bearbeiten
    window.editDuration = function(id) {
        const index = containsData.findIndex(item => item.content_ID === id);
        if (index === -1) return;

        const containsID = containsData[index].id;
        console.log('ID', containsID);

        const newDuration = prompt('Neue Dauer:');

        console.log('dauer', newDuration);
        
        if (newDuration) {
            const req = apiurl + "/playlist/updatePlaylistContains";

            fetch(req, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: containsID, duration: newDuration })
            })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    console.log('Updated duration:', data);
                    reset();
                    fetchContainsData();
                    updatePlaylistDuration();
                })
                .catch(error => console.error('Error updating duration:', error));
        }

    };

    //reihenfolge des contents in der playlist ändern
    window.editOrder = function(id) {
        console.log("helo");
        
        const index = containsData.findIndex(item => item.content_ID === id);
        if (index === -1) return;

        const containsID = containsData[index].id;
        const newArrangement = prompt('Neue Reihenfolgen position (kleinste -> erste Position):');

        console.log('arrangement', newArrangement);
        
        if (newArrangement) {
            const req = apiurl + "/playlist/updatePlaylistContains";

            fetch(req, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: containsID, arrangement: newArrangement })
            })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    console.log('Updated duration:', data);
                    reset();
                    fetchPlaylistData();
                    fetchContainsData();
                })
                .catch(error => console.error('Error updating duration:', error));
        }
    };

    //weiteren content zur playlist hinzufügen
    window.contentDazu = function() {
        console.log("add content");

        const newContent = prompt("Content hinzufügen (id eingeben) : ");

        if(!isNaN(newContent)){
            console.log(newContent);
            const req = apiurl + "/playlist/addPlaylistContains";

            const data = { content_id: Number(newContent), playlist_id: Number(playlistID) };

            console.log(data);

            fetch(req, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    console.log('Updated duration:', data);
                    reset();
                    fetchPlaylistData();
                    fetchContainsData();
                    updatePlaylistDuration();
                })
                .catch(error => console.error('Error updating duration:', error));

        }
    };

    fetchPlaylistData();
    fetchContainsData();
});
