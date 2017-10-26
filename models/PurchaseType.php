
<?php

class PurchaseType {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getTypes() {
        $purchase_types_res = $this->conn->query('SELECT * FROM purchase_types ORDER BY id DESC');
        return $purchase_types_res;
    }

    public function getType($id) {
        $purchase_type_res = $this->conn->query('SELECT * FROM purchase_types WHERE id=' . $id);
        return $purchase_type_res;
    }

}

?>