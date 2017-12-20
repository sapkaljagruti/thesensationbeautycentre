
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

    public function checkInovieExist($id, $invoice_no) {
        if (empty($id)) {
            $purchase_voucher_res = $this->conn->query('SELECT * FROM purchase_vouchers WHERE invoice_no="' . $invoice_no . '" AND is_deleted!="1"');
        } else {
            $purchase_voucher_res = $this->conn->query('SELECT * FROM purchase_vouchers WHERE invoice_no="' . $invoice_no . '" AND id!="' . $id . '" AND is_deleted!="1"');
        }

        if ($purchase_voucher_res->num_rows > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function addPurchaseVoucher($date, $purchase_ledger_id, $invoice_no, $invoice_date, $purchase_type_id, $party_id, $products_data, $total_qty, $total_rate_per_unit, $total_discount_percentage, $total_discount_rs, $total_cgst_percentage, $total_cgst_rs, $total_sgst_percentage, $total_sgst_rs, $total_igst_percentage, $total_igst_rs, $total_bill_amount) {
        $purchase_voucher = $this->conn->query('INSERT INTO purchase_vouchers(date, purchase_ledger_id, invoice_no, invoice_date, purchase_type_id, party_id, products_data, total_qty, total_rate_per_unit, total_discount_percentage, total_discount_rs, total_cgst_percentage, total_cgst_rs, total_sgst_percentage, total_sgst_rs, total_igst_percentage, total_igst_rs, total_bill_amount) VALUES("' . $date . '", "' . $purchase_ledger_id . '", "' . $invoice_no . '", "' . $invoice_date . '", "' . $purchase_type_id . '", "' . $party_id . '", "' . $products_data . '", "' . $total_qty . '", "' . $total_rate_per_unit . '", "' . $total_discount_percentage . '", "' . $total_discount_rs . '", "' . $total_cgst_percentage . '", "' . $total_cgst_rs . '", "' . $total_sgst_percentage . '", "' . $total_sgst_rs . '", "' . $total_igst_percentage . '", "' . $total_igst_rs . '" ,"' . $total_bill_amount . '")');
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

    public function delete($id) {
        $purchase_voucher = $this->conn->query('UPDATE purchase_vouchers SET is_deleted="1" WHERE id=' . $id);
        if ($purchase_voucher) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function updatePurchaseVoucher($id, $date, $purchase_ledger_id, $invoice_no, $invoice_date, $purchase_type_id, $party_id, $products_data, $total_qty, $total_rate_per_unit, $total_discount_percentage, $total_discount_rs, $total_cgst_percentage, $total_cgst_rs, $total_sgst_percentage, $total_sgst_rs, $total_igst_percentage, $total_igst_rs, $total_bill_amount) {
        $purchase_voucher = $this->conn->query('UPDATE purchase_vouchers SET date="' . $date . '", purchase_ledger_id="' . $purchase_ledger_id . '", invoice_no="' . $invoice_no . '", invoice_date="' . $invoice_date . '", purchase_type_id="' . $purchase_type_id . '", party_id="' . $party_id . '", products_data="' . $products_data . '", total_qty="' . $total_qty . '", total_rate_per_unit="' . $total_rate_per_unit . '", total_discount_percentage="' . $total_discount_percentage . '", total_discount_rs="' . $total_discount_rs . '", total_cgst_percentage="' . $total_cgst_percentage . '", total_cgst_rs="' . $total_cgst_rs . '", total_sgst_percentage="' . $total_sgst_percentage . '", total_sgst_rs="' . $total_sgst_rs . '", total_igst_percentage="' . $total_igst_percentage . '", total_igst_rs="' . $total_igst_rs . '", total_bill_amount="' . $total_bill_amount . '" WHERE id=' . $id);
        if ($purchase_voucher === TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function filterBillForReturn($party_id, $purchase_invoice_no = NULL, $purchase_invoice_from_date = NULL, $purchase_invoice_to_date = NULL) {
        $query = 'SELECT * FROM purchase_vouchers WHERE is_deleted!="1" AND party_id="' . $party_id . '"';
        if (!empty($purchase_invoice_no)) {
            $query .= ' AND invoice_no="' . $purchase_invoice_no . '"';
        }
        if (!empty($purchase_invoice_from_date) && !empty($purchase_invoice_to_date)) {
            $query .= ' AND invoice_date>="' . $purchase_invoice_from_date . '" AND invoice_date<="' . $purchase_invoice_to_date . '"';
        }
        $purchase_voucher = $this->conn->query($query);
        return $purchase_voucher;
    }

    public function getFromInvoiceNo($invoice_no) {
        $purchase_voucher = $this->conn->query('SELECT * FROM purchase_vouchers WHERE is_deleted!="1" AND invoice_no="' . $invoice_no . '"');
        return $purchase_voucher;
    }

    public function getThisMonthPurchases($this_month, $this_year) {
        $purchase_voucher = $this->conn->query('SELECT * FROM purchase_vouchers WHERE is_deleted!="1" AND MONTH(invoice_date)="' . $this_month . '" AND YEAR(invoice_date)="' . $this_year . '"');
        return $purchase_voucher;
    }

    public function getCustomPurchases($start_date, $end_date) {
        $purchase_voucher = $this->conn->query('SELECT * FROM purchase_vouchers WHERE is_deleted!="1" AND invoice_date>="' . $start_date . '" AND invoice_date<="' . $end_date . '"');
        return $purchase_voucher;
    }

}

?>