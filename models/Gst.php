
<?php

class Gst {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getGstTypes() {
        $gst_types_res = $this->conn->query('SELECT * FROM gst_types ORDER BY id DESC');
        return $gst_types_res;
    }

    public function getGstType($id) {
        $gst_type_res = $this->conn->query('SELECT * FROM gst_types WHERE id=' . $id);
        return $gst_type_res;
    }

    public function getGstStates() {
        $gst_states = $this->conn->query('SELECT * FROM gst_state_codes ORDER BY id DESC');
        return $gst_states;
    }

    public function getGstState($id) {
        $gst_states = $this->conn->query('SELECT * FROM gst_state_codes WHERE id=' . $id);
        return $gst_states;
    }

}

?>