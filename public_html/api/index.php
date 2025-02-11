<?php

require __DIR__ . "/inc/bootstrap.php";
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/api/index.php/', '', $uri);
$uri = explode( '/', $uri );


if ((!isset($uri[0])) || !isset($uri[1])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}
switch($uri[0]){
    case 'client': require PROJECT_ROOT_PATH . "/Controller/API/ClientController.php";
        $objFeedController = new ClientController();
        $strMethodName = $uri[1] . 'Action';
        break;
    case 'content': require PROJECT_ROOT_PATH . "/Controller/API/ContentController.php";
        $objFeedController = new ContentController();
        $strMethodName = $uri[1] . 'Action';
        break;
    case 'playlist': require PROJECT_ROOT_PATH . "/Controller/API/PlaylistController.php";
        $objFeedController = new PlaylistController();
        $strMethodName = $uri[1] . 'Action';
        break;
    case 'user':    require PROJECT_ROOT_PATH . "/Controller/API/UserController.php";
        $objFeedController = new UserController();
        $strMethodName = $uri[1] . 'Action';
        break;
    default:    header("HTTP/1.1 404 Not Found");
        exit();
        break;
}


/*
require PROJECT_ROOT_PATH . "/Controller/API/UserController.php";
$objFeedController = new UserController();
$strMethodName = $uri[1] . 'Action';
*/
$objFeedController->{$strMethodName}();
?>