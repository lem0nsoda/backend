<?= $this->extend('main') ?>

<?= $this->section('content') ?>


<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zeitplan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.2.0/fullcalendar.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/newScheduleStyle.css') ?>" rel="stylesheet">

    <!-- für tabellensorteirung mit datatables-->
    <link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container my-5">
        <h1 class="mb-4">Zeitplan erstellen</h1>
        <div class="row">
            <!-- Tabelle -->
            <div class="col-md-4">
                <table class="table table-striped table-bordered" id="content-table">
                    <thead class="table-dark">
                        <tr>
                            <th data-dt-column='0'>Playlistname</th>
                            <th data-dt-column='1'>Dauer</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
    
            <!-- Kalender -->
            <div class="col-md-8">
                <h2>Devices:</h2>
                <div id="clients-row"></div>

                <br>

                <!-- Drop-Feld und Datum/Uhrzeit nebeneinander -->
                <div class="row mb-4">
                    <!-- Playlist-Drop-Bereich -->
                    <div class="col-md-6">
                        <h3>Playlist-Drop-Bereich</h3>
                        <div id="drop-zone" class="border p-3" style="min-height: 150px; background-color: #f8f9fa;">
                            <p>Ziehen Sie eine Playlist hierher.</p>
                            <div id="drop-details"></div>
                        </div>
                    </div>

                    <!-- Eingabefelder für Datum und Uhrzeit -->
                    <div class="col-md-6">
                        <h3>Startdatum und -uhrzeit</h3>
                        <form id="event-form">
                            <div class="form-row mb-2">
                                <div class="col">
                                    <input type="number" id="day" class="form-control" placeholder="Tag" min="1" max="31">
                                </div>
                                <div class="col">
                                    <input type="number" id="month" class="form-control" placeholder="Monat" min="1" max="12">
                                </div>
                                <div class="col">
                                    <input type="number" id="year" class="form-control" placeholder="Jahr" min="2024">
                                </div>
                                <div class="col">
                                    <input type="time" id="start-time" class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Speicher-Button -->
                <button id="save-button" class="btn btn-primary">Speichern</button>

                <div id="calendar"></div>
            </div>
        </div>
    </div>
    
    <!-- Skripte -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.2.0/fullcalendar.min.js"></script>
    <script src="<?= base_url('assets/js/newSchedulescript.js') ?>"></script>
    
    
</body>
</html>


<?= $this->endSection() ?>
