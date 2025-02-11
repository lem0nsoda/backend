<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url('assets/js/script.js'); ?>"></script>
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<button id="logout" onclick="logout()" class="btn">Logout</button>

<script>
    function logout(){
        window.location.href = '<?= site_url("menu/login") ?>';
    }
</script>
<style>
    #logout {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #2B71AD;
    color: white;
    border-radius: 6px;
    width: 90px;
    height: 40px;
    font-size: 16px;
    border: none;
    color: white !important;
    border: none;
    opacity: 0.9;
    }

    #logout:hover {
    background-color: #002a4b;
    }
</style>