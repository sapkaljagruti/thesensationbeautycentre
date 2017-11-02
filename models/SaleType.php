
<?php

class SaleType {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getTypes() {
        $sale_types_res = $this->conn->query('SELECT * FROM sale_types ORDER BY id DESC');
        return $sale_types_res;
    }

    public function getType($id) {
        $sale_types_res = $this->conn->query('SELECT * FROM sale_types WHERE id=' . $id);
        return $sale_types_res;
    }

}

?>