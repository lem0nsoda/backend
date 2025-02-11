
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/clientViewStyle.css') ?>">
    <title>Client</title>
</head>
<body id="anzeige">
    <div id="clientInput" class="text-center">
        <label for="name" id="text">ClientID eingeben:</label>
        <input type="text" id="name" class="form-control mb-3" placeholder="Deine ClientID">
        <button id="sendButton" class="btn">Senden</button>
        <p id="result" class="text-center mt-3"></p>
    </div>

    <!-- Button zur Weiterleitung -->
    <a id="userInterfaceButton" class="btn btn-primary" href = '<?= site_url("menu/login") ?>'>Userinterface</a>

    <!--<div id="content" class="hidden container"></div-->  
 
    <script src="<?= base_url('assets/js/client_view.js') ?>"></script>
</body>
</html>
