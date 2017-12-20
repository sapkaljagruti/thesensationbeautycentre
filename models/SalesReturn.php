
<?php

class SalesReturn {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getBills() {
        $sales_voucherss = $this->conn->query('SELECT * FROM sales_return_vouchers ORDER BY id DESC');
        return $sales_voucherss;
    }

    public function checkInovieExist($id, $invoice_no) {
        if (empty($id)) {
            $sales_vouchers_res = $this->conn->query('SELECT * FROM sales_return_vouchers WHERE invoice_no="' . $invoice_no . '" AND is_deleted!="1"');
        } else {
            $sales_vouchers_res = $this->conn->query('SELECT * FROM sales_return_vouchers WHERE invoice_no="' . $invoice_no . '" AND id!="' . $id . '" AND is_deleted!="1"');
        }

        if ($sales_vouchers_res->num_rows > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function addSalesReturnVoucher($date, $invoice_no, $invoice_date, $sales_vouchers_id, $products_data, $total_qty, $total_rate_per_unit, $total_discount_percentage, $total_discount_rs, $total_cgst_percentage, $total_cgst_rs, $total_sgst_percentage, $total_sgst_rs, $total_igst_percentage, $total_igst_rs, $total_bill_amount) {
        $sales_return_voucher = $this->conn->query('INSERT INTO sales_return_vouchers(date, invoice_no, invoice_date, sales_voucher_id, products_data, total_qty, total_rate_per_unit, total_discount_percentage, total_discount_rs, total_cgst_percentage, total_cgst_rs, total_sgst_percentage, total_sgst_rs, total_igst_percentage, total_igst_rs, total_bill_amount) VALUES("' . $date . '", "' . $invoice_no . '", "' . $invoice_date . '", "' . $sales_vouchers_id . '", "' . $products_data . '", "' . $total_qty . '", "' . $total_rate_per_unit . '", "' . $total_discount_percentage . '", "' . $total_discount_rs . '", "' . $total_cgst_percentage . '", "' . $total_cgst_rs . '", "' . $total_sgst_percentage . '", "' . $total_sgst_rs . '", "' . $total_igst_percentage . '", "' . $total_igst_rs . '" ,"' . $total_bill_amount . '")');
        if ($sales_return_voucher === TRUE) {
            return mysqli_insert_id($this->conn);
        } else {
            return FALSE;
        }
    }

}

?>