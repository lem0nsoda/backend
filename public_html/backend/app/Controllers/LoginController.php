<?php


namespace App\Controllers;


namespace App\Controllers;

use App\Models\UserModel;

class LoginController extends BaseController
{
    public function index()
    {

        //session_start();
        ?>

        <!DOCTYPE html>
        <html lang="de">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="<?= base_url('assets/css/loginStyle.css') ?>">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
            <title>Login</title>
        </head>
        <body>
            
            <form method="POST" action="">
            <h1>Login</h1>
                <!--inputfelder für name und passwort-->
                <label for="benutzername">Benutzername:</label>
                <input type="text" id="benutzername" name="benutzername" required>
                <br>
                <label for="passwort">Passwort:</label>
                <input type="password" id="passwort" name="passwort" required>
                <br>
                <!--login button-->
                <input type="submit" value="Login">
            </form>

            <div id="errorField"></div>

                
        </body>
        </html>

        <?php

    }

    public function authenticate()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $benutzername = $_POST['benutzername'];
            $passwort = $_POST['passwort'];


            // Die URL der API, die du aufrufen möchtest
            $apiUrl = "https://digital-signage.htl-futurezone.at/api/index.php/user/get?limit=50";

            // Initialisiere cURL
            $ch = curl_init();

            // Setze Optionen für die cURL-Anfrage
            curl_setopt($ch, CURLOPT_URL, $apiUrl);         // Die API-URL
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Die Antwort als String zurückgeben
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);  // Weiterleitungen folgen, falls vorhanden
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(      // Header setzen, falls benötigt
                "Content-Type: application/json"
            ));

            // Führe die cURL-Anfrage aus
            $response = curl_exec($ch);

            // Fehlerbehandlung
            if(curl_errno($ch)) {
                echo 'cURL Fehler: ' . curl_error($ch);
            } else {
                // Die Antwort wird in $response gespeichert
                // Um sicherzustellen, dass es ein gültiges JSON ist, kannst du es dekodieren
                $alldata = json_decode($response, true);
                if ($alldata) {
                    //echo $response;  // Angenommene Eigenschaft 'name' der Playlist
                    // Überprüfen, ob die Eingaben korrekt sind
                    foreach($alldata as $data){
                        if ($benutzername === $data['username'] && $passwort === $data['password']) {
                            // Benutzer eingeloggt, Session Variable setzen
                            $_SESSION['loggedin'] = true;
                            $_SESSION['user_id'] = $data['id'];
                            // Weiterleitung zur index.html
                            //echo $_SESSION['user_id'];
                            header('Location: allContent');
                            exit();
                        }
                    }
                    ?>
                        <script>alert("Benutzer oder Passwort falsch!");</script>
                    <?php
                } else {
                    ?>
                        <script>alert( "Fehler beim Dekodieren der API-Antwort.");</script>
                    <?php
                }
            }
            
            // Schließe die cURL-Verbindung
            curl_close($ch);
            
        }

    }
}


