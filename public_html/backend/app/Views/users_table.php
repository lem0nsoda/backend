<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/users_tablestyle.css') ?>" >
</head>
<body>
    <div class="container my-5">
        <h1 class="mb-4">Alle Benutzer</h1>
        <div class="row align-items-center mb-3">
            <div class="col-auto">
                <label for="sort-options" class="form-label mb-0">Nach</label>
            </div>
            <div class="col-auto">
                <select id="sort-options" class="form-select">
                    <option value="dateiname-asc">Dateiname (A-Z)</option>
                    <option value="dateiname-desc">Dateiname (Z-A)</option>
                    <option value="dauer-asc">Dauer (kurz-lang)</option>
                    <option value="dauer-desc">Dauer (lang-kurz)</option>
                    <option value="geraeteid-asc">Geräte-ID (aufsteigend)</option>
                    <option value="geraeteid-desc">Geräte-ID (absteigend)</option>
                    <option value="typ-asc">Dateityp (A-Z)</option>
                    <option value="typ-desc">Dateityp (Z-A)</option>
                </select>
            </div>
        </div>
        <table class="table table-striped table-bordered" id="content-table">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Rechte</th>
                    <th>wie oft eingeloggt</th>
                    <th>Erstellungsdatum</th>
                    <th>zuletzt online</th>
                </tr>
            </thead>
            <tbody>
                <!-- zeilen kommen hierhin -->
            </tbody>
        </table>
        <a id="back" href="<?=site_url('menu/users')?>" class="btn btn-primary">zurück</a>
    </div>

    <script src="<?=base_url('assets/js/users_tableScript.js')?>"></script>
</body>
</html>


<?= $this->endSection() ?>
