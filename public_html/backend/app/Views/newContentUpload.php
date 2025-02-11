<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/newContentUploadStyle.css') ?>">
    <title>Drag and Drop</title>
</head>
<body class="bg-light text-dark">

<div class="container my-5">
    <h1>Drag and Drop</h1>

    <div id="dropArea" class="border border-primary rounded-3 bg-info p-4 text-center mb-4">
        Ziehe eine Bild- oder Videodatei hierher
    </div>

    <!--Dateien werden hier klein angezeigt -->
    <div id="dataInput" class="d-flex flex-wrap gap-2 mb-3 border p-2 rounded bg-white"></div>

    <label for="duration">Dauer des Contents:</label><br>
    <input type="number" id="duration" name="duration"><br><br>

    <button id="saveButton" class="btn btn-primary">Speichern</button>



</div>

<script src="<?= base_url('assets/js/newContentUpload.js')?>"></script>
</body>
</html>


<?= $this->endSection() ?>

