
<?php

class PurchaseReturn {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getBills() {
        $purchase_vouchers = $this->conn->query('SELECT * FROM purchase_return_vouchers ORDER BY id DESC');
        return $purchase_vouchers;
    }

}

?>