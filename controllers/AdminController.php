<?php

class AdminController {

    public function __construct() {
        
    }

    public function logout() {
        session_destroy();
        session_unset();
        header('location: ../index.php');
    }

}

?>