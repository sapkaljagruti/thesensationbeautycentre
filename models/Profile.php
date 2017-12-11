<?php

class Profile {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getProfile() {
        $profile = $this->conn->query('SELECT * FROM admins');
        return $profile;
    }

}

?>