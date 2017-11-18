<?php

class PurchaseController {

    public $purchaseobj;
    public $purchase_type_obj;
    public $gst_obj;
    public $productobj;
    public $accountgroupobj;
    public $targetaccountobj;
    public $ex_ins_staff_members_nots;

    public function __construct() {

        require_once 'models/Purchase.php';
        $this->purchaseobj = new Purchase();

        require_once 'models/PurchaseType.php';
        $this->purchase_type_obj = new PurchaseType();

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

        $this->extra_js_files = array('plugins/jQueryUI/jquery-ui.js', 'plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables/dataTables.bootstrap.min.js', 'plugins/input-mask/jquery.inputmask.js', 'plugins/input-mask/jquery.inputmask.date.extensions.js', 'plugins/input-mask/jquery.inputmask.extensions.js', 'js/purchase_bills.js');
    }

    public function getbills() {
        $page_header = 'Purchase Vouchers';
        $extra_js_files = $this->extra_js_files;
        $purchase_vouchers = $this->purchaseobj->getPurchaseVouchers();
        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/purchase_bills.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function checkInovieExist() {
        $target_account = trim($_POST['target_account']);
        $invoice_no = trim($_POST['invoice_no']);
        $purchase_voucher = $this->purchaseobj->checkInovieExist($target_account, $invoice_no);
        if ($purchase_voucher) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function add() {
        $page_header = 'Purchase Voucher Entry';
        $extra_js_files = $this->extra_js_files;

        if (!empty($_POST)) {
            $errors = array();

            if (empty($errors)) {
                $ledger_name = trim($_POST['ledger_name']);
                $invoice_no = trim($_POST['invoice_no']);
                $purchase_type_id = !empty($_POST['purchase_type_id']) ? trim($_POST['purchase_type_id']) : NULL;
                $target_account = $_POST['target_account'];
                $party_id = !empty($_POST['party_id']) ? $_POST['party_id'] : NULL;
                $party_name = !empty($_POST['party_name']) ? trim($_POST['party_name']) : NULL;
                $party_address = !empty($_POST['party_address']) ? trim($_POST['party_address']) : NULL;
                $party_contact_person = !empty($_POST['party_contact_person']) ? trim($_POST['party_contact_person']) : NULL;
                $party_email = !empty($_POST['party_email']) ? trim($_POST['party_email']) : NULL;
                $party_mobile1 = !empty($_POST['party_mobile1']) ? trim($_POST['party_mobile1']) : NULL;
                $party_mobile2 = !empty($_POST['party_mobile2']) ? trim($_POST['party_mobile2']) : NULL;
                $party_residence_no = !empty($_POST['party_residence_no']) ? trim($_POST['party_residence_no']) : NULL;
                $party_office_no = !empty($_POST['party_office_no']) ? trim($_POST['party_office_no']) : NULL;
                $party_bank_name = !empty($_POST['party_bank_name']) ? trim($_POST['party_bank_name']) : NULL;
                $party_bank_branch = !empty($_POST['party_bank_branch']) ? trim($_POST['party_bank_branch']) : NULL;
                $party_ifsc_code = !empty($_POST['party_ifsc_code']) ? trim($_POST['party_ifsc_code']) : NULL;
                $party_bank_account_no = !empty($_POST['party_bank_account_no']) ? trim($_POST['party_bank_account_no']) : NULL;
                $party_pan = !empty($_POST['party_pan']) ? trim($_POST['party_pan']) : NULL;
                $party_gst_state_code_id = !empty($_POST['party_gst_state_code_id']) ? trim($_POST['party_gst_state_code_id']) : NULL;
                $party_gst_type_id = !empty($_POST['party_gst_type_id']) ? trim($_POST['party_gst_type_id']) : NULL;
                $party_gstin = !empty($_POST['party_gstin']) ? trim($_POST['party_gstin']) : NULL;
                $products_data = !empty($_POST['products_data']) ? trim($_POST['products_data']) : NULL;
                $total_cgst = !empty($_POST['total_cgst']) ? trim($_POST['total_cgst']) : NULL;
                $total_sgst = !empty($_POST['total_sgst']) ? trim($_POST['total_sgst']) : NULL;
                $total_igst = !empty($_POST['total_igst']) ? trim($_POST['total_igst']) : NULL;
                $total_amount = !empty($_POST['total_amount']) ? trim($_POST['total_amount']) : NULL;

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

                $purchase_voucher = $this->purchaseobj->addPurchaseVoucher($date, $ledger_name, $invoice_no, $invoice_date, $purchase_type_id, $target_account, $party_id, $party_name, $party_address, $party_contact_person, $party_email, $party_mobile1, $party_mobile2, $party_residence_no, $party_office_no, $party_bank_name, $party_bank_branch, $party_ifsc_code, $party_bank_account_no, $party_pan, $party_gst_state_code_id, $party_gst_type_id, $party_gstin, $products_data, $total_cgst, $total_sgst, $total_igst, $total_amount);

                if ($purchase_voucher) {
                    $products_data_arr = explode(',', $products_data);
                    foreach ($products_data_arr as $product) {
                        $product_arr = explode('_', $product);
                        $product_id = $product_arr[0];
                        $product_qty_arr = explode(' ', $product_arr[7]);
                        $product_qty = $product_qty_arr[0];
                        $product = $this->productobj->updateProductQty($product_qty, $product_id);
                    }
                    header('location: home.php?controller=purchase&action=getbills');
                } else {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
            }
        }

        $purchase_types_res = $this->purchase_type_obj->getTypes();
        if ($purchase_types_res->num_rows > 0) {
            while ($purchase_type = mysqli_fetch_assoc($purchase_types_res)) {
                $purchase_type['title'] = ucwords($purchase_type['title']);
                $purchase_types[] = $purchase_type;
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

        $purchase_ledgers = array();
        $purchase_ledgers_res = $this->accountgroupobj->getPurchaseLedgers();
        if ($purchase_ledgers_res->num_rows > 0) {
            while ($purchase_ledger = mysqli_fetch_assoc($purchase_ledgers_res)) {
                $purchase_ledger['name'] = ucwords($purchase_ledger['name']);
                $purchase_ledgers[] = $purchase_ledger;
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
        $view_file = '/views/add_purchase_bill.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function findLedgerByTerm() {
        $term = trim($_POST['term']);
        $party_id = trim($_POST['party_id']);
        $res = array();
        $purchase_vouchers_res = $this->purchaseobj->findLedgerByTerm($term, $party_id);
        if ($purchase_vouchers_res->num_rows > 0) {
            while ($purchase_voucher = $purchase_vouchers_res->fetch_assoc()) {
                $res[] = [
                    'id' => $purchase_voucher['id'],
                    'ledger_name' => $purchase_voucher['ledger_name'],
                    'invoice_no' => $purchase_voucher['invoice_no'],
                    'invoice_date' => $purchase_voucher['invoice_date'],
                    'total_amount' => $purchase_voucher['total_amount']
                ];
            }
        }
        echo json_encode($res);
    }

    public function checkLedgerNameExist() {
        $ledger_name = trim($_POST['ledger_name']);
        $party_id = trim($_POST['party_id']);
        $purchase_vouchers_res = $this->purchaseobj->checkLedgerNameExist($ledger_name, $party_id);
        if ($purchase_vouchers_res->num_rows > 0) {
            echo '1';
        } else {
            echo '0';
        }
    }

}

?>