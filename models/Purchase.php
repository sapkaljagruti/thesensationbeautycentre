
<?php

class Purchase {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getPurchaseVouchers() {
        $purchase_vouchers = $this->conn->query('SELECT * FROM purchase_vouchers ORDER BY id DESC');
        return $purchase_vouchers;
    }

    public function getPurchaseVoucher($id) {
        $purchase_voucher = $this->conn->query('SELECT * FROM purchase_vouchers WHERE id=' . $id);
        return $purchase_voucher;
    }

    public function checkInovieExist($target_account, $invoice_no) {
        $purchase_voucher = $this->conn->query('SELECT * FROM purchase_vouchers WHERE invoice_no="' . $invoice_no . '" AND target_account="' . $target_account . '"');
        if ($purchase_voucher->num_rows > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function addPurchaseVoucher($date, $ledger_name, $invoice_no, $invoice_date, $purchase_type_id, $target_account, $party_id, $party_name, $party_address, $party_contact_person, $party_email, $party_mobile1, $party_mobile2, $party_residence_no, $party_office_no, $party_bank_name, $party_bank_branch, $party_ifsc_code, $party_bank_account_no, $party_pan, $party_gst_state_code_id, $party_gst_type_id, $party_gstin, $products_data, $total_cgst, $total_sgst, $total_igst, $total_amount) {
        $purchase_voucher = $this->conn->query('INSERT INTO purchase_vouchers(date, ledger_name, invoice_no, invoice_date, purchase_type_id, target_account, party_id, party_name, party_address, party_contact_person, party_email, party_mobile1, party_mobile2, party_residence_no, party_office_no, party_bank_name, party_bank_branch, party_ifsc_code, party_bank_account_no, party_pan, party_gst_state_code_id, party_gst_type_id, party_gstin, products_data, total_cgst, total_sgst, total_igst, total_amount) VALUES("' . $date . '", "' . $ledger_name . '", "' . $invoice_no . '", "' . $invoice_date . '", "' . $purchase_type_id . '", "' . $target_account . '", "' . $party_id . '", "' . $party_name . '", "' . $party_address . '", "' . $party_contact_person . '", "' . $party_email . '", "' . $party_mobile1 . '", "' . $party_mobile2 . '", "' . $party_residence_no . '", "' . $party_office_no . '", "' . $party_bank_name . '", "' . $party_bank_branch . '", "' . $party_ifsc_code . '", "' . $party_bank_account_no . '", "' . $party_pan . '", "' . $party_gst_state_code_id . '", "' . $party_gst_type_id . '", "' . $party_gstin . '", "' . $products_data . '", "' . $total_cgst . '", "' . $total_sgst . '", "' . $total_igst . '" , "' . $total_amount . '")');
        if ($purchase_voucher === TRUE) {
            return mysqli_insert_id($this->conn);
        } else {
            return FALSE;
        }
    }

    public function findLedgerByTerm($term, $party_id) {
        $purchase_vouchers_res = $this->conn->query('SELECT * FROM purchase_vouchers WHERE ledger_name LIKE "%' . $term . '%" AND party_id="' . $party_id . '" LIMIT 10');
        return $purchase_vouchers_res;
    }

    public function checkLedgerNameExist($ledger_name, $party_id) {
        $purchase_vouchers_res = $this->conn->query('SELECT * FROM purchase_vouchers WHERE ledger_name="' . $ledger_name . '" AND party_id="' . $party_id . '"');
        return $purchase_vouchers_res;
    }

}

?>