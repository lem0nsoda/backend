document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('lastOnlineChart').getContext('2d');
    const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";
    let chart;

    //update the chart
    function updateChart(usernames, usageCounts, headingText, xAxisLabel, yAxisLabel) {
        document.getElementById('heading').textContent = headingText;

        if (chart) {
            chart.destroy(); 
        }

        chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: usernames,
                datasets: [{
                    label: 'Häufigkeit',
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

    //button aufruf funktionen
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

                    for(let i = 0; i < userID.length; i++){
                        count[i] = countUser.get(userID[i]);
                    }

                    updateChart(userID, count, "Statistik", "Benutzer", "Anzahl der Uploads");
          
                }
            })
            .catch(error => console.error('Error fetching content data:', error));
    };

    window.handlePlaylistCreation = function () {
        fetch(`${apiurl}/playlist/get?table=playlist&by=created_by&limit=100`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if(data[0]){
                    var userID = [];
                    var countUser = new Map();
                    var count = [];

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

                    for(let i = 0; i < userID.length; i++){
                        count[i] = countUser.get(userID[i]);
                    }

                }

                updateChart(userID, count, "Statistik", "Benutzer-ID", "Anzahl der erstellten Playlists");
            })
            .catch(error => console.error('Error fetching playlist data:', error));
    };

    window.handleContentUsage = function () {
        fetch(`${apiurl}/content/getInfo?by=added_by&limit=100`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if(data[0]){
                    var contentID = [];
                    var countContent = new Map();
                    var count = [];

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

                    updateChart(contentID, count, "Statistik", "Content-ID", "Anzahl der Benutzungen");
                }
            })
            .catch(error => console.error('Error fetching content data:', error));
    };

    window.handlePlaylistUsage = function () {
        fetch(`${apiurl}/playlist/get?table=playlist&limit=100`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if(data[0]){
                    var playlistID = [];
                    var countPlaylist = new Map();
                    var count = [];

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

                    updateChart(playlistID, count, "Statistik", "Playlist-ID", "Anzahl der Benutzungen");
                }
            })
            .catch(error => console.error('Error fetching content data:', error));
    };

});

document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.button-container .btn');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            // Entferne die "active"-Klasse von allen Buttons
            buttons.forEach(btn => btn.classList.remove('active'));
            // Füge die "active"-Klasse zum geklickten Button hinzu
            this.classList.add('active');
        });
    });
});

