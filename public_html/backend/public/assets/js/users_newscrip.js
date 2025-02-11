document.addEventListener('DOMContentLoaded', () => {
    const saveButton = document.querySelector('#save-button');

    function saveUser() {
        const username = document.querySelector('#username').value;
        const password = document.querySelector('#password').value;
        const rights = document.querySelector('#rights').value === 'true';

        const newUser = { username, password, rights };

        console.log('Neuer Benutzer:', newUser);
        
    }

    saveButton.addEventListener('click', saveUser);
});
