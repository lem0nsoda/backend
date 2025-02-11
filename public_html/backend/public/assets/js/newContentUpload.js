// ids/bereiche von html
const dropArea = document.getElementById('dropArea');
const dataInput = document.getElementById('dataInput');
const fileListContainer = document.getElementById('fileList');
const saveButton = document.getElementById('saveButton');
const durationIn = document.getElementById('duration');

let filesData = [];

//bilder im dropfeld 'aufnehmen' (auserhalb nicht)
dropArea.addEventListener('dragover', (event) => {
    event.preventDefault();
});

//wenn eine Datei abgelegt wird
dropArea.addEventListener('drop', (event) => {
    event.preventDefault();
    
    // Liste, wo die Daten der Bilder hineinkommen
    const files = event.dataTransfer.files;

    // Iteriere durch alle Dateien
    for (let i = 0; i < files.length; i++) {
        const file = files[i];

        // Nur Bilder oder Videos akzeptieren
        if (file.type.startsWith('image/') || file.type.startsWith('video/')) {
            const fileData = {
                name: file.name,
                type: file.type,
                added_by: 1,
                preview: URL.createObjectURL(file)
            };

            // Datei in Base64 umwandeln
            const reader = new FileReader();

            reader.onload = function(event) {
                const img = new Image();
                img.onload = function() {
                    // Auf die Breite und Höhe des Bildes zugreifen
                    fileData.width = img.width;
                    fileData.height = img.height;
                }
                img.src = event.target.result;
                // Base64-encoded data
                const base64Data = event.target.result;
                
                // Füge die Base64-Daten zu fileData hinzu
                fileData.data = base64Data;
                fileData.duration = 0;
                
                // Datei in der Vorschau und in der Liste anzeigen
                displayFilePreview(fileData);
                //displayFileInList(fileData);
            };
            console.log(fileData);

            // Datei als Data URL (Base64) lesen
            reader.readAsDataURL(file);
            
            // Die Datei-Daten werden später in der onload-Callback-Funktion zu `filesData` hinzugefügt.
            filesData.push(fileData);
        } else {
            alert('Bitte nur Bild- oder Videodateien hochladen.');
        }
    }

    console.log(filesData);
});


//um bilder klein anzuzeigen
function displayFilePreview(fileData) {
    if (fileData.type.startsWith('image/')) {
        const imgPreview = document.createElement('img');
        imgPreview.src = fileData.preview;
        imgPreview.alt = fileData.name;
        dataInput.appendChild(imgPreview);
    }
      else if (fileData.type.startsWith('video/')) {
        const videoPreview = document.createElement('video');
        videoPreview.src = fileData.preview;
        videoPreview.controls = true;
        dataInput.appendChild(videoPreview);
    }
}

//Dateigröße formatieren
function formatFileSize(bytes) {
    if (bytes < 1024) return bytes + ' B';
    else if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
    else return (bytes / 1048576).toFixed(1) + ' MB';
}

// daten als JSON speichern
function saveDataAsJSON() {
    const jsonData = JSON.stringify(filesData, null, 2);  //null->enter; 2->formatierung
    //binary large objekt
    const blob = new Blob([jsonData], { type: 'application/json' });
    //link für json-file download
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'uploadedFiles.json';
    link.click();
    URL.revokeObjectURL(link.href);
}

function saveData() {
    // URL der API
    const apiUrl = "https://digital-signage.htl-futurezone.at/api/index.php/content/add";
    var uploaded = 0; // Zähler für erfolgreiche Uploads

    filesData.forEach(data =>{
        if(durationIn.value)
            data.duration = durationIn.value;
        else
            data.duration = 0;
    })

    // Erstelle ein Array von Promises für alle `fetch()`-Anfragen
    const uploadPromises = filesData.map(fileData => {
        console.log(JSON.stringify(fileData)); // Logge die Datei-Daten

        // Senden der POST-Anfrage mit den Content-Daten
        return fetch(apiUrl, {
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
            if (uploaded === filesData.length) {
                alert('Alle Dateien wurden erfolgreich hochgeladen.');
                filesData.length = 0; // Array leeren
                dataInput.innerHTML = "";
                durationIn.value ="";
            }
        })
        .catch(error => {
            console.error('Ein Fehler trat beim Hochladen auf:', error);
        });
}

saveButton.addEventListener('click', saveData);


