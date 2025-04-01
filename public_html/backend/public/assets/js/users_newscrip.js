document.addEventListener('DOMContentLoaded', () => {
    const saveButton = document.querySelector('#save-button');
    const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";

    function saveUser() {
        const username = document.querySelector('#username').value;
        const password = document.querySelector('#password').value;
        const rights = document.querySelector('#rights').value === 'true';

        const newUser = { username, password, rights };

        console.log('Neuer Benutzer:', newUser);

        req = apiurl + "/user/getBy?where=username&is=" + username;

        fetch(req)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if(data[0])
                    alert("Anderen Namen wählen, gewählter name ist schon benutzt!!");
                else{
                    var reqAdd = apiurl + "/user/add";

                    const newUser = { username: username, password: password, rights: rights };

                    fetch(reqAdd, {
                        method: 'POST', // HTTP-Methode
                        headers: {
                            'Content-Type': 'application/json', // Wir senden JSON-Daten
                            // Weitere Header wie Authentifizierung können hier hinzugefügt werden
                        },
                        body: JSON.stringify(newUser) // Konvertiere das Datenobjekt in einen JSON-String
                    })
                    .then(response => response.json()) // Antwort als JSON parsen
                    .then(data => {
                        document.querySelector('#username').value = '';
                        document.querySelector('#password').value = '';

                        console.log('Erfolgreich hinzugefügt:', data); 
                    })
                    .catch(error => {
                        console.error('Fehler beim Hinzufügen des Inhalts:', error); // Fehlerbehandlung
                    });
                }

            })
            .catch(error => console.error('Error fetching data:', error));
        
    }

    saveButton.addEventListener('click', saveUser);
});
