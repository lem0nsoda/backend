document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.querySelector('#content-table tbody');

    const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";

    var playClients = new Map();
    var play_data;

    console.log("open");

    //zugriff auf PlaysOn daten per API
    function fetchPlayData() {

        const req = apiurl + "/playlist/get?table=play_playlist";
        //fetch play playlist
        fetch(req)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data_pp => {
                console.log('Fetched data:', data_pp);
                play_data = data_pp;

                fetchClientsData(data_pp);

            })
            .catch(error => console.error('Error fetching data:', error));
    }
    
    function fetchClientsData(play_playlist){
        var fetched = 0;

        const uploadPromises = play_playlist.map(play =>  {
            req = apiurl + "/playlist/getBy?table=plays_on&where=play_ID&is=" + play.id;

            return fetch(req)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    fetched ++;

                    console.log('Fetched playlistdata:', data);
                    //übergabe: daten der playlist, daten von playplaylist,
                    if(data[0]){
                        clients = {};
                        let first = true;

                        data.forEach(d => {
                            if(d.client_ID != undefined){
                                if(first){
                                    clients.client = d.client_ID;
                                    first = false;
                                }else{
                                    clients.client += ", " + d.client_ID;
                                }}
                        });

                        console.log("c" + JSON.stringify(clients));
                        playClients.set(play.id, JSON.stringify(clients));
                    }else{
                        playClients.set(play.id, {client: null});
                    }

                })
                .catch(error => console.error('Error fetching data:', error));
        });

        // Verwende `Promise.all()` um zu warten, dass alle Uploads abgeschlossen sind
        Promise.all(uploadPromises)
        .then(() => {
             // Wenn alle Dateien erfolgreich hochgeladen wurden, leere das Array
             if (fetched === play_playlist.length) {
                
                console.log("clients: " + playClients.get(9));
                fetchPlaylistData(play_playlist);
             }
         })
         .catch(error => {
             console.error('Ein Fehler trat beim Hochladen auf:', error);
         });
    }

    function fetchPlaylistData(play_playlist){
        var fetched = 0;

        const uploadPromises = play_playlist.map(play =>  {
            req = apiurl + "/playlist/getThis?table=playlist&id=" + play.playlist_id;

            return fetch(req)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    fetched ++;

                    console.log('Fetched playlistdata:', data);
                    //übergabe: daten der playlist, daten von playplaylist, 
                    populateTable(data[0], play);

                })
                .catch(error => console.error('Error fetching data:', error));
        });

        // Verwende `Promise.all()` um zu warten, dass alle Uploads abgeschlossen sind
        Promise.all(uploadPromises)
        .then(() => {
             // Wenn alle Dateien erfolgreich hochgeladen wurden, leere das Array
             if (fetched === play_playlist.length) {                 
                new DataTable('#content-table');
             }
         })
         .catch(error => {
             console.error('Ein Fehler trat beim Hochladen auf:', error);
         });
    }

    function populateTable(playlist, play_playlist) {
        tableBody.innerHTML += `
        <tr>
            <td>${play_playlist.id}</td> 
            <td>${playlist.id}</td> 
            <td>${playlist.name}</td> 
            <td>
                <button class="btn btn-sm btn-outline-primary ms-2" onclick="editStart(${play_playlist.id})">
                    <i class="bi bi-pencil"></i>
                </button>
                ${play_playlist.start}
            </td> 
            <td>${playlist.duration}</td> 
            <td>     
                <button class="btn btn-sm btn-outline-primary ms-2" onclick="editClients(${play_playlist.id})">
                    <i class="bi bi-pencil"></i>
                </button>
                ${playClients.get(play_playlist.id).client}
            </td> 
            <td>${playlist.created_by}</td> 
            <td>
                <button class="btn btn-sm btn-outline-danger" onclick="deleteRow(${play_playlist.id})">
                    <i class="bi bi-trash3"></i>
                </button>
            </td>
        </tr>
        `;
    }

    window.deleteRow = function(id) {
        if (confirm('Möchten Sie diesen Eintrag wirklich löschen?')) {
            const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";
            fetch(`${apiurl}/content/delete/${id}`, { method: 'DELETE' })
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
            fetch(`${apiurl}/content/update/${id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name: newName })
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

    window.editClients = function(id) {
        const newDuration = prompt('Clients:');
        if (newDuration) {
            const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";
            fetch(`${apiurl}/content/update/${id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ duration: newDuration })
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

    window.editStart = function(id) {
        const newDuration = prompt('Neuer Startzeitpunkt:');
        if (newDuration) {
            const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";
            fetch(`${apiurl}/content/update/${id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ duration: newDuration })
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

    fetchPlayData(); 
});
