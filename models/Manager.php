
<?php

class Manager {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAll() {
        $managers = $this->conn->query('SELECT * FROM managers ORDER BY id DESC');
        return $managers;
    }

    public function getManager($id) {
        $managers = $this->conn->query('SELECT * FROM managers WHERE id=' . $id);
        return $managers;
    }

    public function checkManager($manager, $manager_id) {
        $managers = $this->conn->query('SELECT * FROM managers WHERE name="' . $manager . '" AND id=' . $manager_id);
        return $managers;
    }

    public function addManager($name, $email = NULL, $mobile_nums = NULL) {
        $manager = $this->conn->query('INSERT INTO managers(name, email, mobile_nums) VALUES("' . $name . '", "' . $email . '", "' . $mobile_nums . '")');
        if ($manager === TRUE) {
            return mysqli_insert_id($this->conn);
        } else {
            return FALSE;
        }
    }

    public function updateManager($id, $name, $email = NULL, $mobile_nums) {
        $manager = $this->conn->query('UPDATE managers SET name="' . $name . '", email="' . $email . '", mobile_nums="' . $mobile_nums . '" WHERE id=' . $id);
        if ($manager === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function deleteManager($id) {
        $branches = $this->conn->query('SELECT * FROM branches WHERE manager_id=' . $id);
        if ($branches->num_rows > 0) {
            return FALSE;
        } else {
            $manager = $this->conn->query('DELETE FROM managers WHERE id=' . $id);
            if ($manager === TRUE) {
                return TRUE;
            }
        }
    }

}

?>