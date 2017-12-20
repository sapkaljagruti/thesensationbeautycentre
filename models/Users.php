
<?php

class Users {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getUsers() {
        $users = $this->conn->query('SELECT * FROM admins WHERE id!="1"');
        return $users;
    }

    public function getUser($id) {
        $user = $this->conn->query("SELECT * FROM admins WHERE id='" . $id . "'");
        return $user;
    }

    public function addUsers($fname, $lname, $email, $mobile, $username, $password, $profile_picture, $can_view, $can_add, $can_update, $can_delete) {
        $user = $this->conn->query('INSERT INTO admins(fname,lname,email,mobile,username,password,profile_picture,can_view,can_add,can_update,can_delete) VALUES("' . $fname . '", "' . $lname . '", "' . $email . '", "' . $mobile . '", "' . $username . '","' . $password . '", "' . $profile_picture . '","' . $can_view . '","' . $can_add . '","' . $can_update . '","' . $can_delete . '")');
        if ($user === TRUE) {
            return mysqli_insert_id($this->conn);
        } else {
            return FALSE;
        }
    }

    public function updateUsers($id, $fname, $lname, $email, $mobile, $username, $password, $can_view, $can_add, $can_update, $can_delete) {
        $user = $this->conn->query("update admins set fname='" . $fname . "',lname='" . $lname . "',email='" . $email . "',mobile='" . $mobile . "',username='" . $username . "',password='" . $password . "',can_view='" . $can_view . "', can_add='" . $can_add . "',can_update='" . $can_update . "', can_delete='" . $can_delete . "' where id='" . $id . "'");

        if ($user === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function deleteUsers($id) {
        $user = $this->conn->query('DELETE FROM admins WHERE id=' . $id);
        if ($user === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

}

?>