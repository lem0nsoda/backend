document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.querySelector('#content-table tbody');
    const sortOptions = document.querySelector('#sort-options');

    //holen der benutzerdaten
    function fetchData(sortOption = '') { 
        const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";

        const req = apiurl + "/user/get";

        console.log(`Fetching data with sort option: ${sortOption}`);
        fetch(req)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                console.log('Fetched data:', data);
                populateTable(data);
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    //erstellung der tabelle aller benutzer*innen
    function populateTable(rows) {
        tableBody.innerHTML = rows.map(row => `
            <tr>
                <td>${row.id}</td>
                <td>${row.username}</td>
                <td>${row.password}</td>
                <td>${row.rights}</td>
                <td>${row.wie_oft_eingeloggt}</td>
                <td>${row.created_at}</td>
                <td>${row.last_online}</td>
            </tr>
        `).join('');
    }

    //zum sortieren
    sortOptions.addEventListener('change', () => fetchData(sortOptions.value));

    fetchData();
});
