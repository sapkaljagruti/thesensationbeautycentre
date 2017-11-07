
<?php

class Contra {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getall() {
        $contra_vouchers = $this->conn->query('SELECT * FROM contra_vouchers ORDER BY id DESC');
        return $contra_vouchers;
    }

    public function getLatestVoucher() {
        $contra_vouchers = $this->conn->query('SELECT * FROM contra_vouchers ORDER BY id DESC LIMIT 1');
        return $contra_vouchers;
    }

    public function addContraVoucher($date, $entry_data, $total_amount, $narration) {
        $contra_voucher = $this->conn->query('INSERT INTO contra_vouchers(date, entry_data, total_amount, narration) VALUES("' . $date . '", "' . $entry_data . '", "' . $total_amount . '", "' . $narration . '")');
        if ($contra_voucher === TRUE) {
            return mysqli_insert_id($this->conn);
        } else {
            return FALSE;
        }
    }

}

?>