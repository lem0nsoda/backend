<?php
define("PROJECT_ROOT_PATH", __DIR__ . "/../");
// include main configuration file 
require_once PROJECT_ROOT_PATH . "/inc/config.php";
// include the base controller file 
require_once PROJECT_ROOT_PATH . "/Controller/API/BaseController.php";
// include the client model file 
require_once PROJECT_ROOT_PATH . "/Model/ClientModel.php";
// include the content model file 
require_once PROJECT_ROOT_PATH . "/Model/ContentModel.php";
// include the playlist model file 
require_once PROJECT_ROOT_PATH . "/Model/PlaylistModel.php";
// include the user model file 
require_once PROJECT_ROOT_PATH . "/Model/UserModel.php";

?>