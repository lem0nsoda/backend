<?= $this->extend('main') ?>

<?= $this->section('content') ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/statstikStyle.css') ?>">
</head>
<body>
    <h1 id="heading">Statistik</h1>

    <div class="button-container">
        <button class="btn btn-primary" onclick="handleContentUpload()">Contentupload von Benutzern</button>
        <button class="btn btn-primary" onclick="handlePlaylistCreation()">Playlisterstellung von Benutzern</button>
        <button class="btn btn-primary" onclick="handleContentUsage()">Content-Verwendung</button>
        <button class="btn btn-primary" onclick="handlePlaylistUsage()">Playlist-Verwendung</button>
        <button class="btn btn-primary" onclick="handleUsersOnline()">Benutzer online</button>
    </div>

    <div style="width: 80%; margin: 20px auto;">
        <canvas id="lastOnlineChart"></canvas>
    </div>

    <script src="<?= base_url('assets/js/statistikScript.js') ?>"></script>
</body>
</html>



<?= $this->endSection() ?>
