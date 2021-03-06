
<?php

class DebitNotes {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAll() {
        $debit_notes = $this->conn->query('SELECT * FROM debit_notes ORDER BY id DESC');
        return $debit_notes;
    }

    public function getPurchaseVoucher($id) {
        $purchase_voucher = $this->conn->query('SELECT * FROM debit_notes WHERE id=' . $id);
        return $purchase_voucher;
    }

    public function checkDebitNoteExist($id, $debit_note_no) {
        if (empty($id)) {
            $debit_note_res = $this->conn->query('SELECT * FROM debit_notes WHERE debit_note_no="' . $debit_note_no . '" AND is_deleted!="1"');
        } else {
            $debit_note_res = $this->conn->query('SELECT * FROM debit_notes WHERE debit_note_no="' . $debit_note_no . '" AND id!="' . $id . '" AND is_deleted!="1"');
        }

        if ($debit_note_res->num_rows > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function addDebitNote($debit_note_no, $date, $party_id, $purchase_invoice_data, $narration, $total_amount) {
        $debit_note = $this->conn->query('INSERT INTO debit_notes(debit_note_no, date, party_id, purchase_invoice_data, narration, total_amount) VALUES("' . $debit_note_no . '", "' . $date . '", "' . $party_id . '", "' . $purchase_invoice_data . '", "' . $narration . '", "' . $total_amount . '")');
        if ($debit_note === TRUE) {
            return mysqli_insert_id($this->conn);
        } else {
            return FALSE;
        }
    }

}

?>