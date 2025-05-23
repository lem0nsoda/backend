<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Signage - All Schedules</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- für tabellensorteirung mit datatables-->
    <link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container my-5">
        <h1 class="mb-4">All Schedules</h1>
        <!--tabelle aller zeitpläne-->
        <table class="table table-striped table-bordered" id="content-table">
            <thead class="table-dark">
                <tr>
                    <th data-dt-column='0'>ID</th>
                    <th data-dt-column='1'>Playlist-ID</th>    
                    <th data-dt-column='2'>Playlistname</th>
                    <th data-dt-column='3'>Start-Zeitpunkt</th>
                    <th data-dt-column='4'>Dauer [Sek.]</th>
                    <th data-dt-column='5'>auf Clients (ID)</th>
                    <th data-dt-column='6'>von Benutzer erstellt</th>
                    <th>löschen</th>
                </tr>
            </thead>

            <tbody>
                <!-- zeilen kommen hierhin -->
            </tbody>
        </table>
    </div>
    <script src="<?= base_url('assets/js/allSchedulesScript.js') ?>"></script>
</body>
</html>


<?= $this->endSection() ?>
