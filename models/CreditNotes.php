
<?php

class CreditNotes {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAll() {
        $credit_notes = $this->conn->query('SELECT * FROM credit_notes ORDER BY id DESC');
        return $credit_notes;
    }

    public function getPurchaseVoucher($id) {
        $purchase_voucher = $this->conn->query('SELECT * FROM credit_notes WHERE id=' . $id);
        return $purchase_voucher;
    }

    public function checkCreditNoteExist($id, $credit_note_no) {
        if (empty($id)) {
            $credit_note_res = $this->conn->query('SELECT * FROM credit_notes WHERE credit_note_no="' . $credit_note_no . '" AND is_deleted!="1"');
        } else {
            $credit_note_res = $this->conn->query('SELECT * FROM credit_notes WHERE credit_note_no="' . $credit_note_no . '" AND id!="' . $id . '" AND is_deleted!="1"');
        }

        if ($credit_note_res->num_rows > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function addCreditNote($credit_note_no, $date, $party_id, $sales_invoice_data, $narration, $total_amount) {
        $credit_note = $this->conn->query('INSERT INTO credit_notes(credit_note_no, date, party_id, sales_invoice_data, narration, total_amount) VALUES("' . $credit_note_no . '", "' . $date . '", "' . $party_id . '", "' . $sales_invoice_data . '", "' . $narration . '", "' . $total_amount . '")');
        if ($credit_note === TRUE) {
            return mysqli_insert_id($this->conn);
        } else {
            return FALSE;
        }
    }

}

?>