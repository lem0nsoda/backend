<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://use.typekit.net/xph3llu.css">
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
        <ul class="navbar-nav w-100 d-flex justify-content-around">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-folder"></i> Content
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?= base_url('index.php/menu/newContentUpload') ?>">New Upload</a></li>
                    <li><a class="dropdown-item" href="<?= base_url('index.php/menu/allContent') ?>">All Content</a></li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-play-circle"></i> Playlist
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?= base_url('index.php/menu/newPlaylist') ?>">New Playlist</a></li>
                    <li><a class="dropdown-item" href="<?= base_url('index.php/menu/allPlaylists') ?>">All Playlists</a></li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-clock"></i> Schedule
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?= base_url('index.php/menu/newSchedule') ?>">New Schedule</a></li>
                    <li><a class="dropdown-item" href="<?= base_url('index.php/menu/allSchedules') ?>">All Schedules</a></li>
                </ul>
            </li>

            <li><a class="dropdown-item" href="<?= base_url('index.php/menu/devices') ?>">
                <i class="bi bi-display" ></i> Devices
            </a></li>
            
            <li><a class="dropdown-item" href="<?= base_url('index.php/menu/statistic') ?>"> 
                <i class="bi bi-clipboard-data"></i> Statistic
            </a></li>
           
            <li><a class="dropdown-item" href="<?= base_url('index.php/menu/users') ?>">
                <i class="bi bi-people"></i> Users
            </a></li>


        </ul>
    </div>
</nav>
