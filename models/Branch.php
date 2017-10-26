
<?php

class Branch {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAll() {
        $branches = $this->conn->query('SELECT * FROM branches ORDER BY id DESC');
        return $branches;
    }

    public function getBranch($id) {
        $branches = $this->conn->query('SELECT * FROM branches WHERE id=' . $id);
        return $branches;
    }

    public function addBranch($postData) {
        $branch = $this->conn->query('INSERT INTO branches(name, code, address, city, state, pincode, phone_nums, mobile_nums, manager_id, email, is_active) VALUES("' . $postData['name'] . '", "' . $postData['code'] . '", "' . $postData['address'] . '", "' . $postData['city'] . '", "' . $postData['state'] . '", "' . $postData['pincode'] . '", "' . $postData['phone_nums'] . '", "' . $postData['mobile_nums'] . '", "' . $postData['manager_id'] . '", "' . $postData['email'] . '", "' . $postData['is_active'] . '")');
        if ($branch === TRUE) {
            return mysqli_insert_id($this->conn);
        } else {
            return $branch;
        }
    }

    public function updateBranch($id, $name, $email = NULL, $mobile_nums) {
        $branch = $this->conn->query('UPDATE branches SET name="' . $name . '", email="' . $email . '", mobile_nums="' . $mobile_nums . '" WHERE id=' . $id);
        if ($branch === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function deleteBranch($id) {
        $branch = $this->conn->query('DELETE FROM branches WHERE id=' . $id);
        if ($branch === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

}

?>