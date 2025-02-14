document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('lastOnlineChart').getContext('2d');
    const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";
    let chart;

    
    console.log(apiurl);

    //update the chart
    function updateChart(usernames, usageCounts, headingText, xAxisLabel, yAxisLabel) {
        document.getElementById('heading').textContent = headingText;

        if (chart) {
            chart.destroy(); // Destroy existing chart before creating a new one
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

        console.log("hello");

       /* fetch(req)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                console.log('Fetched data:', data);

                /*const groupedData = data.reduce((acc, content) => {
                    const creator = content.added_by;
                    acc[creator] = (acc[creator] || 0) + 1;
                    return acc;
                }, {});

                const usernames = Object.keys(groupedData);
                const usageCounts = Object.values(groupedData);
                updateChart(usernames, usageCounts, "Statistik: Contentupload von Benutzern", "Benutzer", "Anzahl der Uploads");
            })
            .catch(error => console.error('Error fetching content data:', error));
            */
    };

    window.handlePlaylistCreation = function () {

        console.log("playlist create");
        /*
        fetch('/playlists')
            .then(response => response.json())
            .then(data => {
                const groupedData = data.reduce((acc, playlist) => {
                    const creator = playlist.created_by;
                    acc[creator] = (acc[creator] || 0) + 1;
                    return acc;
                }, {});

                const usernames = Object.keys(groupedData);
                const usageCounts = Object.values(groupedData);
                updateChart(usernames, usageCounts, "Statistik: Playlisterstellung von Benutzern", "Benutzer", "Anzahl der Playlists");
            })
            .catch(error => console.error('Error fetching playlist data:', error));*/
    };

    window.handleContentUsage = function () {
        fetch('/content')
            .then(response => response.json())
            .then(data => {
                const usernames = data.map(content => content.name);
                const usageCounts = data.map(content => content.times_used);
                updateChart(usernames, usageCounts, "Statistik: Content-Verwendung", "Content", "Verwendungshäufigkeit");
            })
            .catch(error => console.error('Error fetching content data:', error));
    };

    window.handlePlaylistUsage = function () {
        fetch('/playlists')
            .then(response => response.json())
            .then(data => {
                const usernames = data.map(playlist => playlist.title);
                const usageCounts = data.map(playlist => playlist.times_used);
                updateChart(usernames, usageCounts, "Statistik: Playlist-Verwendung", "Playlists", "Verwendungshäufigkeit");
            })
            .catch(error => console.error('Error fetching playlist data:', error));
    };

    window.handleUsersOnline = function () {
        fetch('/users')
            .then(response => response.json())
            .then(data => {
                const usernames = data.map(user => user.username);
                const usageCounts = data.map(user => user.times_used);
                updateChart(usernames, usageCounts, "Statistik: Benutzer online", "Benutzer", "Online-Zeit");
            })
            .catch(error => console.error('Error fetching user data:', error));
    };
});
