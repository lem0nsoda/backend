<?= $this->extend('main') ?>

<?= $this->section('content') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Content</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/allContentStyle.css') ?>">

    <!-- für tabellensorteirung mit datatables-->
    <link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container my-5">
        <h1 class="mb-4">All Content</h1>
        <table class="table table-striped table-bordered" id="content-table">
            <thead class="table-dark">
                <tr>
                    <th data-dt-column='0'>ID</th>
                    <th data-dt-column='1'>Dateiname</th>
                    <th data-dt-column='2'>Auflösung</th>
                    <th data-dt-column='3'>Dauer</th>
                    <th data-dt-column='4'>Dateityp</th>
                    <th data-dt-column='5'>Erstellungsdatum</th>
                    <th>Löschen</th>
                </tr>
            </thead>
            <tbody>
                <!-- zeilen kommen hierhin -->
            </tbody>
        </table>
    </div>
    <script src="<?= base_url('assets/js/allContentScript.js') ?>"></script>

</body>
</html>

<?= $this->endSection() ?>

