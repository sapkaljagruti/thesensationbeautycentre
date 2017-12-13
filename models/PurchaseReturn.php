
<?php

class PurchaseReturn {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getBills() {
        $purchase_vouchers = $this->conn->query('SELECT * FROM purchase_return_vouchers ORDER BY id DESC');
        return $purchase_vouchers;
    }

    public function checkInovieExist($id, $invoice_no) {
        if (empty($id)) {
            $purchase_voucher_res = $this->conn->query('SELECT * FROM purchase_return_vouchers WHERE invoice_no="' . $invoice_no . '" AND is_deleted!="1"');
        } else {
            $purchase_voucher_res = $this->conn->query('SELECT * FROM purchase_return_vouchers WHERE invoice_no="' . $invoice_no . '" AND id!="' . $id . '" AND is_deleted!="1"');
        }

        if ($purchase_voucher_res->num_rows > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function addPurchaseReturnVoucher($date, $invoice_no, $invoice_date, $purchase_voucher_id, $products_data, $total_qty, $total_rate_per_unit, $total_discount_percentage, $total_discount_rs, $total_cgst_percentage, $total_cgst_rs, $total_sgst_percentage, $total_sgst_rs, $total_igst_percentage, $total_igst_rs, $total_bill_amount) {
        $purchase_return_voucher = $this->conn->query('INSERT INTO purchase_return_vouchers(date, invoice_no, invoice_date, purchase_voucher_id, products_data, total_qty, total_rate_per_unit, total_discount_percentage, total_discount_rs, total_cgst_percentage, total_cgst_rs, total_sgst_percentage, total_sgst_rs, total_igst_percentage, total_igst_rs, total_bill_amount) VALUES("' . $date . '", "' . $invoice_no . '", "' . $invoice_date . '", "' . $purchase_voucher_id . '", "' . $products_data . '", "' . $total_qty . '", "' . $total_rate_per_unit . '", "' . $total_discount_percentage . '", "' . $total_discount_rs . '", "' . $total_cgst_percentage . '", "' . $total_cgst_rs . '", "' . $total_sgst_percentage . '", "' . $total_sgst_rs . '", "' . $total_igst_percentage . '", "' . $total_igst_rs . '" ,"' . $total_bill_amount . '")');
        if ($purchase_return_voucher === TRUE) {
            return mysqli_insert_id($this->conn);
        } else {
            return FALSE;
        }
    }

}

?>