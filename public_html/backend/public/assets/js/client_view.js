document.addEventListener('DOMContentLoaded', function () {

    document.getElementById('sendButton').onclick = function () {
        const clientID = document.getElementById('name').value;
        if (!clientID) {
            alert('Bitte eine ClientID eingeben!');
            return;
        }

        const message = {
            clientID: clientID,
            screenWidth: window.innerWidth,
            screenHeight: window.innerHeight,
        };

        document.getElementById('result').textContent = 'ClientID: ' + message.clientID;
        document.getElementById('name').style.display = 'none';
        document.getElementById('text').style.display = 'none';
        document.getElementById('sendButton').style.display = 'none';

        // anzeige

        if (message.action === 'showVideo') {
            console.log(`Videoqulle: ${message.video}`);

            //dateipfad für <img> mit base64
            const videoSrc = `data:${message.fileType};base64,${message.data}`;

            let content = document.querySelector("#content");

            // Einblenden
            content.classList.remove("hidden");
            content.classList.add("shown");
            //alle inhalte von content löschen(überschreiben)
            content.innerHTML = "";

            // Bild erzeugen
            let vid = document.createElement("video");
            let source = document.createElement("source");
            source.src = videoSrc;

            //an content einbinden
            vid.appendChild ( source );
            content.appendChild ( vid );

            //Video laden und abspielen
            vid.load();
            vid.play();
        }

        if (message.action === 'showDia') {
            //source in console ausgeben
            console.log('Diashow Bild:', message.currentImage);

            //dateipfad für <img> mit base64
            const imageSrc = `data:${message.fileType};base64,${message.data}`;

            let content = document.querySelector("#content");

            // Einblenden
            content.classList.remove("hidden");
            content.classList.add("shown");
            content.innerHTML = "";

            // Bild erzeugen
            let img = document.createElement("img");
            img.src = imageSrc;
            content.appendChild ( img );
        }
    };

    }); 

   