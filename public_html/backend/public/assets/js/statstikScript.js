document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('lastOnlineChart').getContext('2d');
    const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";
    let chart;

    // erstellt/ aktualisiert das balkendiagramm mit neuen daten
    function updateChart(usernames, usageCounts, headingText, xAxisLabel, yAxisLabel) {
        document.getElementById('heading').textContent = headingText;

        //löscht das vorherige diagramm, falls vorhanden
        if (chart) {
            chart.destroy(); 
        }

        // initialisiert das diagramm mit den übergebenen werten
        chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: usernames,
                datasets: [{
                    label: 'häufigkeit',
                    data: usageCounts,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: xAxisLabel
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: yAxisLabel
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    }

    //häufigkeit von content-uploads je Benutzer
    window.handleContentUpload = function () {
        let req = apiurl + "/content/get?by=added_by&limit=100";

        fetch(req)
            .then(response => response.json())
            .then(data => {
                console.log(data);

                if(data[0]){
                    var userID = [];
                    var countUser = new Map();
                    var count = [];

                    // zählt uploads pro user
                    data.map(content => {
                        if(!userID.includes(content.added_by)){
                            userID.push(content.added_by);
                            countUser.set(content.added_by, 0);
                        }
                        else{
                            var old = countUser.get(content.added_by);
                            countUser.set(content.added_by, old+1);
                        }
                    });

                    //map in array
                    for(let i = 0; i < userID.length; i++){
                        count[i] = countUser.get(userID[i]);
                    }

                    updateChart(userID, count, "statistik", "benutzer", "anzahl der uploads");
                }
            })
            .catch(error => console.error('error fetching content data:', error));
    };

    //wie viele playlists von welchen benutzern erstellt wurden
    window.handlePlaylistCreation = function () {
        fetch(`${apiurl}/playlist/get?table=playlist&by=created_by&limit=100`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if(data[0]){
                    var userID = [];
                    var countUser = new Map();
                    var count = [];

                    // zählt playlists pro user
                    data.map(playlist => {
                        if(!userID.includes(playlist.created_by)){
                            userID.push(playlist.created_by);
                            countUser.set(playlist.created_by, 0);
                        }
                        else{
                            var old = countUser.get(playlist.created_by);
                            countUser.set(playlist.created_by, old+1);
                        }
                    });

                    // wandelt map in array um
                    for(let i = 0; i < userID.length; i++){
                        count[i] = countUser.get(userID[i]);
                    }

                }

                // zeigt das diagramm
                updateChart(userID, count, "statistik", "benutzer-id", "anzahl der erstellten playlists");
            })
            .catch(error => console.error('error fetching playlist data:', error));
    };

    //Anzahl der verwendungen von contents
    window.handleContentUsage = function () {
        fetch(`${apiurl}/content/getInfo?by=added_by&limit=100`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if(data[0]){
                    var contentID = [];
                    var countContent = new Map();
                    var count = [];

                    // speichert verwendungsanzahl pro content-ID
                    data.map(content => {
                        if(!contentID.includes(content.id)){
                            contentID.push(content.id);
                            countContent.set(content.id, content.times_used);
                        }
                        else{
                            countContent.set(content.id, content.times_used);
                        }
                    });

                    for(let i = 0; i < contentID.length; i++){
                        count[i] = countContent.get(contentID[i]);
                    }

                    updateChart(contentID, count, "statistik", "content-id", "anzahl der benutzungen");
                }
            })
            .catch(error => console.error('error fetching content data:', error));
    };

    //die anzahl der verwendungen von playlists
    window.handlePlaylistUsage = function () {
        fetch(`${apiurl}/playlist/get?table=playlist&limit=100`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if(data[0]){
                    var playlistID = [];
                    var countPlaylist = new Map();
                    var count = [];

                    // speichert verwendungsanzahl pro playlist-id
                    data.map(playlist => {
                        if(!playlistID.includes(playlist.id)){
                            playlistID.push(playlist.id);
                            countPlaylist.set(playlist.id, playlist.times_used);
                        }
                        else{
                            countPlaylist.set(playlist.id, playlist.times_used);
                        }
                    });

                    for(let i = 0; i < playlistID.length; i++){
                        count[i] = countPlaylist.get(playlistID[i]);
                    }
                    updateChart(playlistID, count, "statistik", "playlist-id", "anzahl der benutzungen");
                }
            })
            .catch(error => console.error('error fetching content data:', error));
    };
});

//bei klick auf einen buttn wird dieser als "active" markiert 
document.addEventListener('DMContentLoaded', () => {
    const buttons = document.querySelectorAll('.button-container .btn');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            // entfernt die "active"-klasse von allen buttons
            buttons.forEach(btn => btn.classList.remove('active'));
            //"active"-klasse auf gewählten button
            this.classList.add('active');
        });
    });
});
