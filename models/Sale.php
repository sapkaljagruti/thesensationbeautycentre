
<?php

class Sale {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getSaleVouchers() {
        $sale_vouchers = $this->conn->query('SELECT * FROM sale_vouchers ORDER BY id DESC');
        return $sale_vouchers;
    }

    public function getSaleVoucher($id) {
        $sale_voucher = $this->conn->query('SELECT * FROM sale_vouchers WHERE id=' . $id);
        return $sale_voucher;
    }

    public function checkInovieExist($target_account, $invoice_no) {
        $sale_vouchers = $this->conn->query('SELECT * FROM sale_vouchers WHERE invoice_no="' . $invoice_no . '" AND target_account="' . $target_account . '"');
        if ($sale_vouchers->num_rows > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function addSaleVoucher($date, $ledger_name, $invoice_no, $invoice_date, $sale_type_id, $target_account, $party_id, $party_name, $party_address, $party_contact_person, $party_email, $party_mobile1, $party_mobile2, $party_residence_no, $party_office_no, $party_bank_name, $party_bank_branch, $party_ifsc_code, $party_bank_account_no, $party_pan, $party_gst_state_code_id, $party_gst_type_id, $party_gstin, $products_data, $total_cgst, $total_sgst, $total_igst, $total_amount) {
        $sale_voucher = $this->conn->query('INSERT INTO sale_vouchers(date, ledger_name, invoice_no, invoice_date, sale_type_id, target_account, party_id, party_name, party_address, party_contact_person, party_email, party_mobile1, party_mobile2, party_residence_no, party_office_no, party_bank_name, party_bank_branch, party_ifsc_code, party_bank_account_no, party_pan, party_gst_state_code_id, party_gst_type_id, party_gstin, products_data, total_cgst, total_sgst, total_igst, total_amount) VALUES("' . $date . '", "' . $ledger_name . '", "' . $invoice_no . '", "' . $invoice_date . '", "' . $sale_type_id . '", "' . $target_account . '", "' . $party_id . '", "' . $party_name . '", "' . $party_address . '", "' . $party_contact_person . '", "' . $party_email . '", "' . $party_mobile1 . '", "' . $party_mobile2 . '", "' . $party_residence_no . '", "' . $party_office_no . '", "' . $party_bank_name . '", "' . $party_bank_branch . '", "' . $party_ifsc_code . '", "' . $party_bank_account_no . '", "' . $party_pan . '", "' . $party_gst_state_code_id . '", "' . $party_gst_type_id . '", "' . $party_gstin . '", "' . $products_data . '", "' . $total_cgst . '", "' . $total_sgst . '", "' . $total_igst . '" , "' . $total_amount . '")');
        if ($sale_voucher === TRUE) {
            return mysqli_insert_id($this->conn);
        } else {
            return FALSE;
        }
    }

    public function findLedgerByTerm($term, $party_id) {
        $sale_vouchers_res = $this->conn->query('SELECT * FROM sale_vouchers WHERE ledger_name LIKE "%' . $term . '%" AND party_id="' . $party_id . '" LIMIT 10');
        return $sale_vouchers_res;
    }

    public function checkLedgerNameExist($ledger_name, $party_id) {
        $sale_vouchers_res = $this->conn->query('SELECT * FROM sale_vouchers WHERE ledger_name="' . $ledger_name . '" AND party_id="' . $party_id . '"');
        return $sale_vouchers_res;
    }

}

?>