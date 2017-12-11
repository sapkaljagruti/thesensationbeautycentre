<?php

@session_start();


$idletime = 3000; //after 60 seconds the user gets logged out

if ((time() - $_SESSION['timestamp']) > $idletime) {
    session_destroy();
    session_unset();
    header('location: login.php');
} else {
    $_SESSION['timestamp'] = time();
}

$admin_id = (isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id'])) ? $_SESSION['admin_id'] : '';
if (empty($admin_id)) {
    header('location: login.php');
} else {
    header('location: home.php');
}
?>