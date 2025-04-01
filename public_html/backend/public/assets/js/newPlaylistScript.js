document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.querySelector('#content-table tbody');
    const save = document.querySelector('#save-playlist');
    const previewArea = document.getElementById('preview-area');
    const totalDurationSpan = document.getElementById('total-duration');
    let selectedContent = [];

    const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";
    var req = apiurl + "/content/getInfo?limit=50";

    var userID = 1;  // USER

    save.addEventListener('click', () => safePlaylist());

    fetch(req)
        .then(response => response.json())
        .then(data => {
            populateTable(data)
            new DataTable('#content-table');
            loadContentPreviews(data);
        })
        .catch(error => console.error('Error fetching data:', error));

    function populateTable(data) {
        tableBody.innerHTML = data.map(item => `
            <tr draggable="true" data-json='${JSON.stringify(item)}' data-id="${item.id}" data-type="${item.type}">
                <td class="preview-cell" style="text-align: center; vertical-align: middle;"></td>
                
                <td>${item.name}</td>
                <td>${item.duration}</td>
                <td>${item.type}</td>
            </tr>
        `).join('');
//<td class="preview-cell"><img src="${item.data}" class="preview-img"></td>


        document.querySelectorAll('#content-table tr').forEach(row => {
            row.addEventListener('dragstart', e => {
                e.dataTransfer.setData('text/plain', row.dataset.json);
            });
        });
    }


    function loadContentPreviews(rows) {
        rows.forEach(row => {
            const cell = document.querySelector(`tr[data-id='${row.id}'] .preview-cell`);
            
            fetch(`${apiurl}/content/getThis?id=${row.id}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    console.log(data);
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

    previewArea.addEventListener('dragover', e => e.preventDefault());
    previewArea.addEventListener('drop', e => {
        e.preventDefault();
        const item = JSON.parse(e.dataTransfer.getData('text/plain'));
        selectedContent.push(JSON.stringify(item));
        addToPreview(item);
    });

    function addToPreview(item) {
        const div = document.createElement('div');
        div.className = 'preview-item';
        div.dataset.dauer = item.duration;
        div.dataset.contentId = item.id;

        div.innerHTML = `
            <div class="preview-thumbnail">
                <img class="preview-img" preview-id="${item.id}">
            </div>
            <div class="preview-details">
                <span class="file-name">${item.name}</span>
                <span class="file-type">${item.type}</span>
                <div class="controls">
                    <button class="minus">-</button>
                    <span class="duration">${item.duration}s</span>
                    <button class="plus">+</button>
                </div>
            </div>
        `;

        fetch(`${apiurl}/content/getThis?id=${item.id}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    
                    const previewContent = document.querySelector(`img[preview-id='${data[0].id}']`);

                    if (previewContent) {
                        previewContent.setAttribute("src", data[0].data);  // Using setAttribute
                    } else {
                        console.error('Preview image element not found');
                    }
                    
                })
                .catch(error => console.error('Error loading preview:', error));

        

        const decreaseBtn = div.querySelector('.minus');
        const increaseBtn = div.querySelector('.plus');
        const durationSpan = div.querySelector('.duration');

        decreaseBtn.addEventListener('click', () => adjustDuration(div, durationSpan, -1));
        increaseBtn.addEventListener('click', () => adjustDuration(div, durationSpan, 1));

        previewArea.appendChild(div);
        TotalDuration();

        new Sortable(previewArea, { animation: 150 });
    }

    function adjustDuration(element, durationSpan, change) {
        let currentDuration = parseInt(element.dataset.dauer);
        currentDuration = Math.max(0, currentDuration + change);
        element.dataset.dauer = currentDuration;
        durationSpan.textContent = `${currentDuration}s`;
        TotalDuration();
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
            created_by: userID      
        }

        //user benutzen
        fetch(`${apiurl}/user/use?id=${userID}`)
        .then(response => response.json()) // Antwort als JSON parsen
        .then(data => {})
        .catch(error => {
            console.error('Fehler beim Hinzufügen des Inhalts:', error); // Fehlerbehandlung
        });

        //playlist speichern
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

            //contnet benutzen
                fetch(`${apiurl}/content/use?id=${content.dataset.contentId}`)
                .then(response => response.json()) // Antwort als JSON parsen
                .then(data => {})
                .catch(error => {
                    console.error('Fehler beim Hinzufügen des Inhalts:', error); // Fehlerbehandlung
                });

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
