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
    <link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
                            <th>Playlistname</th>
                            <th>Dauer</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <!-- Leerraum für Abstand -->
            <div class="col-md-1"></div>

            <!-- Content-Optionen und Clients -->
            <div class="col-md-7">
                <div class="mb-3">
                    <h3>Content-Anzeigeoptionen</h3>
                    <div class="form-check">
                        <input type="radio" name="content" class="form-check-input" value="true" onclick="contentAnzeige(this)">
                        <label class="form-check-label">Content wird einmal über alle Clients angezeigt</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="content" class="form-check-input" value="false" onclick="contentAnzeige(this)" checked>
                        <label class="form-check-label">Content wird auf jeden Client parallel angezeigt</label>
                    </div>
                </div>
                
                <h3>Clients:</h3>
                <div id="clients-row" class="mb-4"></div>
                
                <div class="row">
                    <!-- Playlist-Drop-Bereich -->
                    <div class="col-md-6">
                        <h3>Playlist-Drop-Bereich</h3>
                        <div id="drop-zone" class="border p-3 bg-light" style="min-height: 150px;">
                            <p>Ziehen Sie eine Playlist hierher.</p>
                            <div id="drop-details"></div>
                        </div>
                    </div>

                    <!-- Eingabefelder für Datum und Uhrzeit -->
                    <div class="col-md-6">
                        <h3>Wie oft soll die Playlist durchlaufen?</h3>
                        <div class="col">
                            <input type="number" id="howoften" class="form-control" value="1" placeholder="Ganzzahl eingeben" min="1">
                        </div>
                        <br>

                        <h3>Startdatum und -uhrzeit</h3>
                        <form id="event-form">
                            <div class="row mb-2">
                                <div class="col">
                                    <input type="number" id="day" class="form-control" placeholder="Tag" min="1" max="31">
                                </div>
                                <div class="col">
                                    <input type="number" id="month" class="form-control" placeholder="Monat" min="1" max="12">
                                </div>
                                <div class="col">
                                    <input type="time" id="start-time" class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Speicher-Button -->
                <button id="save-button" class="btn btn-primary mt-3">Speichern</button>

                <div id="calendar"></div>
            </div>
        </div>
    </div>
    
    <!-- Skripte -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.2.0/fullcalendar.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/newSchedulescript.js') ?>"></script>
</body>
</html>

<?= $this->endSection() ?>
