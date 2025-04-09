<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Signage - Users</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url('assets/css/Userstyle.css')?>" rel="stylesheet">
</head>
<body>
    <h1>Eigene Daten</h1>
    <div class="container my-3">
        <table class="table table-striped table-bordered" id="own-data-table">  
            <tbody>
                <!-- Eigene Daten werden hier eingefügt -->
            </tbody>
        </table>
    </div>

    <!--Buttons -->
    <div id="buttons-container" class="my-3">
        <a id="all-users-button" onclick="allUser()" href="/backend/public/index.php/menu/users_table" class="btn btn-primary d-none">Alle Benutzer</a>
        <a id="add-users-button" onclick="addUser()" href="/backend/public/index.php/menu/users_new" class="btn">Neuen Benutzer anlegen</a>
    </div>

    <script src="<?=base_url('assets/js/userscript.js')?>"></script>
</body>
</html>


<?= $this->endSection() ?>
