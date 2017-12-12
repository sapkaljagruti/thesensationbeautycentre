<?php

class Profile {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getProfile($id) {
        $profile = $this->conn->query("SELECT * FROM admins where id='".$id."'");
        return $profile;
    }

    public function update($id,$fname,$lname,$email,$mobile,$username,$profile_picture){
        $profile_update=  $this->conn->query("update admins set fname='".$fname."',lname='".$lname."',email='".$email."',mobile='".$mobile."',username='".$username."',profile_picture='".$profile_picture."' where id='".$id."'");
        
        if ($profile_update === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }


}

?>