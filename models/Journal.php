
<?php

class Journal {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getall() {
        $journal_vouchers = $this->conn->query('SELECT * FROM journal_vouchers ORDER BY id DESC');
        return $journal_vouchers;
    }

    public function getLatestVoucher() {
        $journal_vouchers = $this->conn->query('SELECT * FROM journal_vouchers ORDER BY id DESC LIMIT 1');
        return $journal_vouchers;
    }

    public function addJournalVoucher($date, $entry_data, $total_amount, $narration) {
        $journal_voucher = $this->conn->query('INSERT INTO journal_vouchers(date, entry_data, total_amount, narration) VALUES("' . $date . '", "' . $entry_data . '", "' . $total_amount . '", "' . $narration . '")');
        if ($journal_voucher === TRUE) {
            return mysqli_insert_id($this->conn);
        } else {
            return FALSE;
        }
    }

}

?>