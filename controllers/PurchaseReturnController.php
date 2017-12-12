<?php

class PurchaseReturnController {

    public $purchasereturnobj;
    public $accountgroupobj;
    public $ex_ins_staff_members_nots;

    public function __construct() {

        require_once 'models/PurchaseReturn.php';
        $this->purchasereturnobj = new PurchaseReturn();

        require_once 'models/AccountGroup.php';
        $this->accountgroupobj = new AccountGroup();

        require_once 'models/Staff.php';
        $this->staffobj = new Staff();

        $this->ex_ins_staff_members_nots = array();

        $ex_ins_staff_members_res = $this->staffobj->getInsuranceExStaff();
        if ($ex_ins_staff_members_res->num_rows > 0) {
            while ($ex_ins_staff_members = mysqli_fetch_assoc($ex_ins_staff_members_res)) {
                $this->ex_ins_staff_members_nots[] = $ex_ins_staff_members;
            }
        }

        $this->extra_js_files = array('plugins/jQueryUI/jquery-ui.js', 'plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables/dataTables.bootstrap.min.js', 'plugins/input-mask/jquery.inputmask.js', 'plugins/input-mask/jquery.inputmask.date.extensions.js', 'plugins/input-mask/jquery.inputmask.extensions.js', 'js/purchase_return_bills.js');
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

    public function add() {
        $page_header = 'Purchase Return Entry';
        $extra_js_files = $this->extra_js_files;

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