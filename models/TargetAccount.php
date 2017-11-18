
<?php

class TargetAccount {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAll() {
        $target_account_res = $this->conn->query('SELECT * FROM target_accounts');
        return $target_account_res;
    }

}

?>