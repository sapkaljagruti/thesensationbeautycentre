
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

    public function checkInovieExist($id, $invoice_no) {
        if (empty($id)) {
            $sales_voucher_res = $this->conn->query('SELECT * FROM sale_vouchers WHERE invoice_no="' . $invoice_no . '" AND is_deleted!="1"');
        } else {
            $sales_voucher_res = $this->conn->query('SELECT * FROM sale_vouchers WHERE invoice_no="' . $invoice_no . '" AND id!="' . $id . '" AND is_deleted!="1"');
        }

        if ($sales_voucher_res->num_rows > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function addSaleVoucher($date, $sales_ledger_id, $invoice_no, $invoice_date, $sales_type_id, $party_id, $products_data, $total_qty, $total_rate_per_unit, $total_discount_percentage, $total_discount_rs, $total_cgst_percentage, $total_cgst_rs, $total_sgst_percentage, $total_sgst_rs, $total_igst_percentage, $total_igst_rs, $total_bill_amount) {
        $sale_voucher = $this->conn->query('INSERT INTO sale_vouchers(date, sales_ledger_id, invoice_no, invoice_date, sales_type_id, party_id, products_data, total_qty, total_rate_per_unit, total_discount_percentage, total_discount_rs, total_cgst_percentage, total_cgst_rs, total_sgst_percentage, total_sgst_rs, total_igst_percentage, total_igst_rs, total_bill_amount) VALUES("' . $date . '", "' . $sales_ledger_id . '", "' . $invoice_no . '", "' . $invoice_date . '", "' . $sales_type_id . '", "' . $party_id . '", "' . $products_data . '", "' . $total_qty . '", "' . $total_rate_per_unit . '", "' . $total_discount_percentage . '", "' . $total_discount_rs . '", "' . $total_cgst_percentage . '", "' . $total_cgst_rs . '", "' . $total_sgst_percentage . '", "' . $total_sgst_rs . '", "' . $total_igst_percentage . '", "' . $total_igst_rs . '" ,"' . $total_bill_amount . '")');
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

    public function delete($id) {
        $sales_voucher = $this->conn->query('UPDATE sale_vouchers SET is_deleted="1" WHERE id=' . $id);
        if ($sales_voucher) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function filterBillForReturn($party_id, $sales_invoice_no = NULL, $sales_invoice_from_date = NULL, $sales_invoice_to_date = NULL) {
        $query = 'SELECT * FROM sale_vouchers WHERE is_deleted!="1" AND party_id="' . $party_id . '"';
        if (!empty($sales_invoice_no)) {
            $query .= ' AND invoice_no="' . $sales_invoice_no . '"';
        }
        if (!empty($sales_invoice_from_date) && !empty($sales_invoice_to_date)) {
            $query .= ' AND invoice_date>="' . $sales_invoice_from_date . '" AND invoice_date<="' . $sales_invoice_to_date . '"';
        }
        $sale_vouchers = $this->conn->query($query);
        return $sale_vouchers;
    }

    public function getFromInvoiceNo($invoice_no) {
        $sale_vouchers = $this->conn->query('SELECT * FROM sale_vouchers WHERE is_deleted!="1" AND invoice_no="' . $invoice_no . '"');
        return $sale_vouchers;
    }

    public function getThisMonthSales($this_month, $this_year) {
        $sale_vouchers = $this->conn->query('SELECT * FROM sale_vouchers WHERE is_deleted!="1" AND MONTH(invoice_date)="' . $this_month . '" AND YEAR(invoice_date)="' . $this_year . '"');
        return $sale_vouchers;
    }

    public function getCustomSales($start_date, $end_date) {
        $sale_vouchers = $this->conn->query('SELECT * FROM sale_vouchers WHERE is_deleted!="1" AND invoice_date>="' . $start_date . '" AND invoice_date<="' . $end_date . '"');
        return $sale_vouchers;
    }

}

?>