<?php

class PurchaseReturnController {

    public $purchasereturnobj;
    public $accountgroupobj;
    public $productobj;
    public $ex_ins_staff_members_nots;
    public $extra_js_files;

    public function __construct() {

        require_once 'models/PurchaseReturn.php';
        $this->purchasereturnobj = new PurchaseReturn();

        require_once 'models/AccountGroup.php';
        $this->accountgroupobj = new AccountGroup();

        require_once 'models/Product.php';
        $this->productobj = new Product();

        require_once 'models/Staff.php';
        $this->staffobj = new Staff();

        $this->ex_ins_staff_members_nots = array();

        $ex_ins_staff_members_res = $this->staffobj->getInsuranceExStaff();
        if ($ex_ins_staff_members_res->num_rows > 0) {
            while ($ex_ins_staff_members = mysqli_fetch_assoc($ex_ins_staff_members_res)) {
                $this->ex_ins_staff_members_nots[] = $ex_ins_staff_members;
            }
        }

        $this->extra_js_files = array('plugins/jQueryUI/jquery-ui.js', 'plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables/dataTables.bootstrap.min.js', 'plugins/input-mask/jquery.inputmask.js', 'plugins/input-mask/jquery.inputmask.date.extensions.js', 'plugins/input-mask/jquery.inputmask.extensions.js', 'plugins/moment/moment.min.js', 'plugins/daterangepicker/daterangepicker.js', 'js/purchase_return_bills.js');
    }

    public function getbills() {
        $page_header = 'Purchase Return Vouchers';
        $extra_js_files = $this->extra_js_files;

        $purchase_return_vouchers = array();
        $purchase_return_vouchers_res = $this->purchasereturnobj->getBills();
        if ($purchase_return_vouchers_res->num_rows > 0) {
            while ($purchase_return_voucher = $purchase_return_vouchers_res->fetch_assoc()) {
                $purchase_return_vouchers[] = $purchase_return_voucher;
            }
        }

        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/purchase_return_bills.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function checkInovieExist() {
        $id = !empty(trim($_POST['id'])) ? trim($_POST['id']) : NULL;
        $invoice_no = trim($_POST['invoice_no']);
        $purchase_voucher_res = $this->purchasereturnobj->checkInovieExist($id, $invoice_no);
        if ($purchase_voucher_res) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function add() {
        $page_header = 'Purchase Return Entry';
        $extra_js_files = $this->extra_js_files;

        if (!empty($_POST)) {
            $errors = array();

            $invoice_no = trim($_POST['invoice_no']);

            $invoiceExistsRes = $this->purchasereturnobj->checkInovieExist(NULL, $invoice_no);
            if ($invoiceExistsRes) {
                array_push($errors, 'Invoice no already exists. Please try again.');
            }

            if (empty($errors)) {
                $purchase_voucher_id = !empty($_POST['purchase_voucher_id']) ? trim($_POST['purchase_voucher_id']) : NULL;
                $products_data = !empty($_POST['products_data']) ? trim($_POST['products_data']) : NULL;

                $total_qty = !empty($_POST['total_qty']) ? trim($_POST['total_qty']) : NULL;
                $total_rate_per_unit = !empty($_POST['total_rate_per_unit']) ? trim($_POST['total_rate_per_unit']) : NULL;
                $total_discount_percentage = !empty($_POST['total_discount_percentage']) ? trim($_POST['total_discount_percentage']) : NULL;
                $total_discount_rs = !empty($_POST['total_discount_rs']) ? trim($_POST['total_discount_rs']) : NULL;
                $total_cgst_percentage = !empty($_POST['total_cgst_percentage']) ? trim($_POST['total_cgst_percentage']) : NULL;
                $total_cgst_rs = !empty($_POST['total_cgst_rs']) ? trim($_POST['total_cgst_rs']) : NULL;
                $total_sgst_percentage = !empty($_POST['total_sgst_percentage']) ? trim($_POST['total_sgst_percentage']) : NULL;
                $total_sgst_rs = !empty($_POST['total_sgst_rs']) ? trim($_POST['total_sgst_rs']) : NULL;
                $total_igst_percentage = !empty($_POST['total_igst_percentage']) ? trim($_POST['total_igst_percentage']) : NULL;
                $total_igst_rs = !empty($_POST['total_igst_rs']) ? trim($_POST['total_igst_rs']) : NULL;
                $total_bill_amount = !empty($_POST['total_bill_amount']) ? trim($_POST['total_bill_amount']) : NULL;
                $total_bill_amount = number_format((float) $total_bill_amount, 2, '.', '');

                if (!empty($_POST['date'])) {
                    $post_date = date_create($_POST['date']);
                    $date = date_format($post_date, 'Y-m-d');
                } else {
                    $date = NULL;
                }

                if (!empty($_POST['invoice_date'])) {
                    $post_invoice_date = date_create($_POST['invoice_date']);
                    $invoice_date = date_format($post_invoice_date, 'Y-m-d');
                } else {
                    $invoice_date = NULL;
                }

                $purchase_return_voucher = $this->purchasereturnobj->addPurchaseReturnVoucher($date, $invoice_no, $invoice_date, $purchase_voucher_id, $products_data, $total_qty, $total_rate_per_unit, $total_discount_percentage, $total_discount_rs, $total_cgst_percentage, $total_cgst_rs, $total_sgst_percentage, $total_sgst_rs, $total_igst_percentage, $total_igst_rs, $total_bill_amount);

                if ($purchase_return_voucher) {
                    $products_data_arr = explode(',', $products_data);
                    foreach ($products_data_arr as $product) {
                        $product_arr = explode('_', $product);
                        $product_id = $product_arr[0];
                        $target_account_id = $product_arr[1];
                        $product_qty = $product_arr[6];

                        $update_qty_res = $this->productobj->updateProductQty($target_account_id, $product_id, $product_qty);
                    }
                    header('location: home.php?controller=purchasereturn&action=getbills');
                } else {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
            }
        }

        $not_default_ledgers = array();
        $not_default_ledgers_res = $this->accountgroupobj->getNotDefaultLedgers();
        if ($not_default_ledgers_res->num_rows > 0) {
            while ($not_default_ledger = mysqli_fetch_assoc($not_default_ledgers_res)) {
                $not_default_ledger['name'] = ucwords($not_default_ledger['name']);
                $not_default_ledgers[] = $not_default_ledger;
            }
        }

        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/add_purchase_return_bill.php';
        require_once APP_DIR . '/views/layout.php';
    }

}

?>