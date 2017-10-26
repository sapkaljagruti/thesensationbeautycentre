<?php

class Database {

    public function connect() {
        $conn = new mysqli('localhost', 'root', '', 'thesensationbeautycentre');

//        Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            return $conn;
        }
    }

}

?>