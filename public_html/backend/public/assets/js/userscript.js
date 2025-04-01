document.addEventListener('DOMContentLoaded', () => {
    const ownDataTableBody = document.querySelector('#own-data-table tbody');
    const addUserButton = document.querySelector('#add-users-button');
    const allUserButton = document.querySelector('#all-users-button');

    function fetchOwnData() {
        const apiurl = "https://digital-signage.htl-futurezone.at/api/index.php";
        const req = apiurl + "/user/getBy?where=id&is=" + 1;

        fetch(req)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {

                console.log('Fetched data:', data);
                populateOwnDataTable(data[0]);

                // Rechte prüfen und Button anzeigen
                if (!data.rights) {
                    addUserButton.classList.remove('d-none');
                    allUserButton.classList.remove('d-none');
                }
            })
            .catch(error => console.error('Error fetching own data:', error));
    }

    function populateOwnDataTable(user) {
        ownDataTableBody.innerHTML = `
            <tr>
                <td><strong>User-ID:</strong></td>
                <td>${user.id}</td>
            </tr>
            <tr>
                <td><strong>Benutzername:</strong></td>
                <td>${user.username}</td>
            </tr>
            <tr>
                <td><strong>Password:</strong></td>
                <td>${user.password}</td>
            </tr>
            <tr>
                <td><strong>Zuletzt Online:</strong></td>
                <td>${new Date(user.last_online).toLocaleDateString()}</td>
            </tr>
            <tr>
                <td><strong>Erstellungsdatum:</strong></td>
                <td>${new Date(user.created_at).toLocaleDateString()}</td>
            </tr>
            <tr>
                <td><strong>Schreibrechte:</strong></td>
                <td>${user.rights ? 'Ja' : 'Nein'}</td>
            </tr>
        `;
    }

    function addUser() {
        console.log("addUser");
    }
    function allUser() {
        console.log("allUser");
    }

    // Event Listener
    addUserButton.addEventListener('click', addUser);
    allUserButton.addEventListener('click', allUser);    

    // Fetch own data on load
    fetchOwnData();
});