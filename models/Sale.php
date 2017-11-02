
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

    public function updateCustomer($id, $name, $gender, $address, $mobile1, $mobile2, $residence_no, $office_no, $dob, $doa, $email) {
        $customer = $this->conn->query('UPDATE customers SET name="' . $name . '", gender="' . $gender . '", address="' . $address . '", mobile1="' . $mobile1 . '", mobile2="' . $mobile2 . '", residence_no="' . $residence_no . '", office_no="' . $office_no . '", dob="' . $dob . '", doa="' . $doa . '" WHERE id=' . $id);
        if ($customer === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function deleteCutomer($id) {
        $customer = $this->conn->query('DELETE FROM customers WHERE id=' . $id);
        if ($customer === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

}

?>