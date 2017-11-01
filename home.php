<?php

@session_start();

date_default_timezone_set('Asia/Kolkata');

$idletime = 3000; //after 60 seconds the user gets logged out

if ((time() - $_SESSION['timestamp']) > $idletime) {
    session_destroy();
    session_unset();
} else {
    $_SESSION['timestamp'] = time();
}

$admin_id = (isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id'])) ? $_SESSION['admin_id'] : '';
if (empty($admin_id)) {
    header('location: login.php');
}

require_once 'config/constants.php';
require_once 'config/database.php';

$controller = "";
$action = "";

if (isset($_GET['controller']) || isset($_GET['action'])) {
    if (isset($_GET['controller']))
        $controller = ucfirst($_GET['controller']);
    if (isset($_GET['action']))
        $action = $_GET['action'];
} else {
    $controller = 'Home';
    $action = 'index';
}


require_once 'config/routes.php';
?>