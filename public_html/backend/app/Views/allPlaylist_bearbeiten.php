<?= $this->extend('main') ?>

<?= $this->section('content') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Signage - All Playlists</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/allPlaylistBearbeitenStyle.css') ?>">

    <!-- für tabellensorteirung mit datatables-->
    <link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <h1 class="mb-4">Playlist bearbeiten</h1>
    <div class="container my-3">
        <!-- playlistname und duration -->
        <table class="table table-striped table-bordered" id="data-table">  
            <tbody>

            </tbody>
        </table>
    </div>
    <strong>Content in Playlist:</strong>
    <!--contents der playlist in tabelle-->
    <div class="container my-3">
        <table class="table table-striped table-bordered" id="content-table">  
            <thead class="table-dark">
                <th data-dt-column='0'>Reihenfolge</th>
                <th data-dt-column='1'>ID - Name</th>
                <th data-dt-column='2'>Dauer [Sek.]</th>
                <th>löschen</th>
            </thead>    
        
            <tbody>

            </tbody>
        </table>
    </div>

    <button id="contentDazu" class="btn btn-primary" onclick="contentDazu()" class="btn">Content hinzufügen</button>
    <br><br>
    <a id="save-button" class="btn btn-primary" href = '<?= site_url("menu/allPlaylists") ?>'>Speichern</a>


    <script src="<?= base_url('assets/js/playlist_bearbeitenScript.js') ?>"></script>

</body>

<?= $this->endSection() ?>