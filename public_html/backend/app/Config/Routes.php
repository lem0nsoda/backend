<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//Startseite
$routes->get('/', 'Menu::newContentUpload');


//Routen für Menu
$routes->get('menu/newContentUpload', 'Menu::newContentUpload');
$routes->get('menu/allContent', 'Menu::allContent');
$routes->get('menu/allSchedules', 'Menu::allSchedules');
$routes->get('menu/devices', 'Menu::devices');
$routes->get('menu/newPlaylist', 'Menu::newPlaylist');
$routes->get('menu/newSchedule', 'Menu::newSchedule');
$routes->get('menu/statistic', 'Menu::statistic');
$routes->get('menu/users', 'Menu::users');
$routes->get('menu/allPlaylists', 'Menu::allPlaylists');

//Client-Eingabe & Weiterleitung zu UI
$routes->get('menu/client', 'Menu::client'); 
//$routes->get('menu/redirect', 'Menu::newContentUpload'); 

$routes->get('menu/login', 'LoginController::index');
$routes->post('menu/login', 'LoginController::authenticate');
//$routes->post('login/authenticate', 'LoginController::authenticate');

$routes->get('menu/users_new', 'Menu::users_new'); 
$routes->get('menu/users_table', 'Menu::users_table'); 

$routes->get('menu/playlistBearbeiten', 'Menu::playlistBearbeiten'); 







