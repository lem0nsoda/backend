
<?= $this->extend('main') ?>

<?= $this->section('content') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/css/newPlaylistStyle.css') ?>">
    <title>Playlist erstellen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <!-- für tabellensorteirung mit datatables-->
    <link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="grid-container">
        <!-- Linke Seite -->
        <div class="left">
            <h1>Playlist erstellen</h1>
            <table class="table table-striped" id="content-table">
                <thead class="table-dark">
                    <tr>
                        <th data-dt-column='0'>Dateiname</th>
                        <th data-dt-column='1'>Dauer</th>
                        <th data-dt-column='2'>Dateityp</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <!-- Rechte Seite -->
        <div id="preview-area" class="preview-area">
            <p>Content von der Tabelle hierher ziehen</p>
        </div>

        <!-- Footer -->
        <div class="playlist-footer">
            <span id="total-duration">Gesamtdauer: 0s</span>
            <button class="btn btn-primary" id="save-playlist">Playlist speichern</button>
        </div>
    </div>
    
    <script src="<?= base_url('assets/js/newPlaylistScript.js') ?>"></script>
</body>
</html>

<?= $this->endSection() ?>
