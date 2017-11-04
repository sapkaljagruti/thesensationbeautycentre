
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

    public function findLedgerByTerm($term, $party_id) {
        $contra_vouchers_res = $this->conn->query('SELECT * FROM contra_vouchers WHERE ledger_name LIKE "%' . $term . '%" AND party_id="' . $party_id . '" LIMIT 10');
        return $contra_vouchers_res;
    }

    public function checkLedgerNameExist($ledger_name, $party_id) {
        $contra_vouchers_res = $this->conn->query('SELECT * FROM contra_vouchers WHERE ledger_name="' . $ledger_name . '" AND party_id="' . $party_id . '"');
        return $contra_vouchers_res;
    }

}

?>