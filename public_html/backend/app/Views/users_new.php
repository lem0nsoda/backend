<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Signage - Users</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/users_newstyle.css') ?>">
</head>
<body>
    <h1>Benutzer hinzufügen</h1>
    <div class="container my-5">
        <form id="add-user-form">
            <div class="mb-3">
                <label for="username" class="form-label">Benutzername</label>
                <input type="text" class="form-control" id="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Passwort</label>
                <input type="password" class="form-control" id="password" required>
            </div>
            <div class="mb-3">
                <label for="rights" class="form-label">Rechte</label>
                <select class="form-select" id="rights">
                    <option value="false">Nein</option>
                    <option value="true">Ja</option>
                </select>
            </div>
            <button type="button" class="btn btn-primary" id="save-button">Speichern</button>
            <a id="back" href="<?=site_url('menu/users')?>" class="btn btn-primary">zurück</a>
        </form>
    </div>

    <script src="<?= base_url('assets/js/users_newscrip.js') ?>"></script>
</body>
</html>


<?= $this->endSection() ?>
