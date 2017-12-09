<?php

class SaleController {

    public $saleobj;
    public $sale_type_obj;
    public $gst_obj;
    public $productobj;
    public $ex_ins_staff_members_nots;

    public function __construct() {

        require_once 'models/Sale.php';
        $this->saleobj = new Sale();

        require_once 'models/SaleType.php';
        $this->sale_type_obj = new SaleType();

        require_once 'models/Gst.php';
        $this->gst_obj = new Gst();

        require_once 'models/Product.php';
        $this->productobj = new Product();

        require_once 'models/AccountGroup.php';
        $this->accountgroupobj = new AccountGroup();

        require_once 'models/TargetAccount.php';
        $this->targetaccountobj = new TargetAccount();

        require_once 'models/Staff.php';
        $this->staffobj = new Staff();

        $this->ex_ins_staff_members_nots = array();

        $ex_ins_staff_members_res = $this->staffobj->getInsuranceExStaff();
        if ($ex_ins_staff_members_res->num_rows > 0) {
            while ($ex_ins_staff_members = mysqli_fetch_assoc($ex_ins_staff_members_res)) {
                $this->ex_ins_staff_members_nots[] = $ex_ins_staff_members;
            }
        }

        $this->extra_js_files = array('plugins/jQueryUI/jquery-ui.js', 'plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables/dataTables.bootstrap.min.js', 'plugins/input-mask/jquery.inputmask.js', 'plugins/input-mask/jquery.inputmask.date.extensions.js', 'plugins/input-mask/jquery.inputmask.extensions.js', 'js/sale_bills.js');
    }

    public function getbills() {
        $page_header = 'Sales Vouchers';
        $extra_js_files = $this->extra_js_files;

        $sales_vouchers = array();
        $sales_vouchers_res = $this->saleobj->getSaleVouchers();
        if ($sales_vouchers_res->num_rows > 0) {
            while ($sales_voucher = $sales_vouchers_res->fetch_assoc()) {

                $sales_ledger_res = $this->accountgroupobj->getAccountGroup($sales_voucher['sales_ledger_id']);
                if ($sales_ledger_res->num_rows > 0) {
                    while ($sales_ledger = mysqli_fetch_assoc($sales_ledger_res)) {
                        $sales_voucher['sales_ledger_name'] = ucwords($sales_ledger['name']);
                    }
                }

                $party_res = $this->accountgroupobj->getAccountGroup($sales_voucher['party_id']);
                if ($party_res->num_rows > 0) {
                    while ($party = mysqli_fetch_assoc($party_res)) {
                        $sales_voucher['party_ac_name'] = ucwords($party['name']);
                    }
                }

                $sales_vouchers[] = $sales_voucher;
            }
        }

        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/sale_bills.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function checkInovieExist() {
        $id = !empty(trim($_POST['id'])) ? trim($_POST['id']) : NULL;
        $invoice_no = trim($_POST['invoice_no']);
        $sales_voucher_res = $this->saleobj->checkInovieExist($id, $invoice_no);
        if ($sales_voucher_res) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function add() {
        $page_header = 'Sale Voucher Entry';
        $extra_js_files = $this->extra_js_files;

        if (!empty($_POST)) {
            $errors = array();

            $invoice_no = trim($_POST['invoice_no']);

            $invoiceExistsRes = $this->saleobj->checkInovieExist(NULL, $invoice_no);
            if ($invoiceExistsRes) {
                array_push($errors, 'Invoice no already exists. Please try again.');
            }

            if (empty($_POST['party_id'])) {
                $party_name = trim($_POST['party_name']);
                $party_parent_id = !empty($_POST['party_parent_id']) ? $_POST['party_parent_id'] : NULL;
                $opening_balance = !empty($_POST['opening_balance']) ? $_POST['opening_balance'] : NULL;
                $contact_person = !empty($_POST['contact_person']) ? $_POST['contact_person'] : NULL;
                $area = !empty($_POST['area']) ? $_POST['area'] : NULL;
                $city = !empty($_POST['city']) ? $_POST['city'] : NULL;
                $pincode = !empty($_POST['pincode']) ? $_POST['pincode'] : NULL;
                $gst_state_code_id = !empty($_POST['party_gst_state_code_id']) ? $_POST['party_gst_state_code_id'] : NULL;
                $email = !empty($_POST['email']) ? trim($_POST['email']) : NULL;
                $mobile1 = !empty($_POST['mobile1']) ? trim($_POST['mobile1']) : NULL;
                $mobile2 = !empty($_POST['mobile2']) ? trim($_POST['mobile2']) : NULL;
                $bank_name = !empty($_POST['party_bank_name']) ? trim($_POST['party_bank_name']) : NULL;
                $bank_branch = !empty($_POST['party_bank_branch']) ? trim($_POST['party_bank_branch']) : NULL;
                $ifsc_code = !empty($_POST['party_ifsc_code']) ? trim($_POST['party_ifsc_code']) : NULL;
                $bank_account_no = !empty($_POST['party_bank_account_no']) ? trim($_POST['party_bank_account_no']) : NULL;
                $pan = !empty($_POST['party_pan']) ? strtoupper(trim($_POST['party_pan'])) : NULL;
                $gst_type_id = !empty($_POST['party_gst_type_id']) ? trim($_POST['party_gst_type_id']) : NULL;
                $gstin = !empty($_POST['party_gstin']) ? strtoupper(trim($_POST['party_gstin'])) : NULL;

                $party_id = $this->accountgroupobj->add($party_name, $party_parent_id, $opening_balance, $contact_person, $area, $city, $pincode, $gst_state_code_id, $email, $mobile1, $mobile2, $bank_name, $bank_branch, $ifsc_code, $bank_account_no, $pan, $gst_type_id, $gstin, NULL);

                if (!$party_id) {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
            } else {
                $party_id = $_POST['party_id'];
            }

            if (empty($errors)) {
                $sales_ledger_id = trim($_POST['sales_ledger_id']);
                $sales_type_id = !empty($_POST['sales_type_id']) ? trim($_POST['sales_type_id']) : NULL;
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

                $sales_voucher = $this->saleobj->addSaleVoucher($date, $sales_ledger_id, $invoice_no, $invoice_date, $sales_type_id, $party_id, $products_data, $total_qty, $total_rate_per_unit, $total_discount_percentage, $total_discount_rs, $total_cgst_percentage, $total_cgst_rs, $total_sgst_percentage, $total_sgst_rs, $total_igst_percentage, $total_igst_rs, $total_bill_amount);

                if ($sales_voucher) {
                    $products_data_arr = explode(',', $products_data);
                    foreach ($products_data_arr as $product) {
                        $product_arr = explode('_', $product);
                        $product_id = $product_arr[0];
                        $target_account_id = $product_arr[1];
                        $product_qty = $product_arr[6];

                        $update_qty_res = $this->productobj->updateProductQty($target_account_id, $product_id, $product_qty);
                    }
                    header('location: home.php?controller=sale&action=getbills');
                } else {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
            }
        }

        $sale_types_res = $this->sale_type_obj->getTypes();
        if ($sale_types_res->num_rows > 0) {
            while ($sale_type = mysqli_fetch_assoc($sale_types_res)) {
                $sale_type['title'] = ucwords($sale_type['title']);
                $sale_types[] = $sale_type;
            }
        }

        $gst_states_res = $this->gst_obj->getGstStates();
        if ($gst_states_res->num_rows > 0) {
            while ($gst_state = mysqli_fetch_assoc($gst_states_res)) {
                $gst_state['state'] = ucwords($gst_state['state']);
                $gst_states[] = $gst_state;
            }
        }

        $gst_types_res = $this->gst_obj->getGstTypes();
        if ($gst_types_res->num_rows > 0) {
            while ($gst_type = mysqli_fetch_assoc($gst_types_res)) {
                $gst_type['title'] = ucwords($gst_type['title']);
                $gst_types[] = $gst_type;
            }
        }

        $sales_ledgers = array();
        $sales_ledgers_res = $this->accountgroupobj->getSalesLedgers();
        if ($sales_ledgers_res->num_rows > 0) {
            while ($sales_ledger = mysqli_fetch_assoc($sales_ledgers_res)) {
                $sales_ledger['name'] = ucwords($sales_ledger['name']);
                $sales_ledgers[] = $sales_ledger;
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

        $account_groups = array();
        $account_groups_res = $this->accountgroupobj->getall();
        if ($account_groups_res->num_rows > 0) {
            while ($account_group = $account_groups_res->fetch_assoc()) {
                $account_group['name'] = ucwords($account_group['name']);
                $account_groups[] = $account_group;
            }
        }


        $target_accounts = array();
        $target_account_res = $this->targetaccountobj->getall();
        if ($target_account_res->num_rows > 0) {
            while ($target_account = $target_account_res->fetch_assoc()) {
                $target_account['name'] = ucwords($target_account['name']);
                $target_accounts[] = $target_account;
            }
        }

        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/add_sale_bill.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function findLedgerByTerm() {
        $term = trim($_POST['term']);
        $party_id = trim($_POST['party_id']);
        $res = array();
        $sale_vouchers_res = $this->saleobj->findLedgerByTerm($term, $party_id);
        if ($sale_vouchers_res->num_rows > 0) {
            while ($sale_voucher = $sale_vouchers_res->fetch_assoc()) {
                $res[] = [
                    'id' => $sale_voucher['id'],
                    'ledger_name' => $sale_voucher['ledger_name'],
                    'invoice_no' => $sale_voucher['invoice_no'],
                    'invoice_date' => $sale_voucher['invoice_date'],
                    'total_amount' => $sale_voucher['total_amount']
                ];
            }
        }
        echo json_encode($res);
    }

    public function checkLedgerNameExist() {
        $ledger_name = trim($_POST['ledger_name']);
        $party_id = trim($_POST['party_id']);
        $sale_vouchers_res = $this->saleobj->checkLedgerNameExist($ledger_name, $party_id);
        if ($sale_vouchers_res->num_rows > 0) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function delete() {
        if (is_array($_POST['id'])) {
            $ids = $_POST['id'];
            $deleted = array();
            foreach ($ids as $id) {
                $sales_voucher = $this->saleobj->delete($id);
                if ($sales_voucher) {
                    array_push($deleted, $id);
                }
            }
            echo json_encode($deleted);
        } else {
            $id = trim($_POST['id']);
            $sales_voucher = $this->saleobj->delete($id);
            if ($sales_voucher) {
                echo 'deleted';
            } else {
                echo 'You cannot delete this voucher.';
            }
        }
    }

}

?>