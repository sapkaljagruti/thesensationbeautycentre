<?php

class ContraController {

    public $contraobj;
    public $accountgroupobj;
    public $ex_ins_staff_members_nots;

    public function __construct() {

        require_once 'models/Contra.php';
        $this->contraobj = new Contra();

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

        $this->extra_js_files = array('plugins/jQueryUI/jquery-ui.js', 'plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables/dataTables.bootstrap.min.js', 'plugins/input-mask/jquery.inputmask.js', 'plugins/input-mask/jquery.inputmask.date.extensions.js', 'plugins/input-mask/jquery.inputmask.extensions.js', 'js/contra_vouchers.js');
    }

    public function getall() {
        $page_header = 'Contra Vouchers';
        $extra_js_files = $this->extra_js_files;
        $contra_vouchers = $this->contraobj->getall();
        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/contra_vouchers.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function add() {
        $page_header = 'Contra Voucher Entry';
        $extra_js_files = $this->extra_js_files;

        if (!empty($_POST)) {

            $errors = array();

            if (empty($errors)) {
                if (!empty($_POST['date'])) {
                    $post_date = date_create($_POST['date']);
                    $date = date_format($post_date, 'Y-m-d');
                } else {
                    $date = NULL;
                }

                $entry_data = !empty($_POST['entry_data']) ? trim($_POST['entry_data']) : NULL;
                $total_amount = !empty($_POST['total_debit_amount']) ? trim($_POST['total_debit_amount']) : NULL;
                $narration = !empty($_POST['narration']) ? trim($_POST['narration']) : NULL;

                $contra_voucher = $this->contraobj->addContraVoucher($date, $entry_data, $total_amount, $narration);

                if ($contra_voucher) {
                    header('location: home.php?controller=contra&action=getall');
                } else {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
            }
        }

        $ledger_names = [];
        $ledger_names_res = $this->accountgroupobj->getContraLedgers();
        if ($ledger_names_res->num_rows > 0) {
            while ($ledger_name = $ledger_names_res->fetch_assoc()) {
                array_push($ledger_names, $ledger_name);
            }
        }

        $latest_contra_vouchers = $this->contraobj->getLatestVoucher();
        if ($latest_contra_vouchers->num_rows > 0) {
            while ($latest_contra_voucher = $latest_contra_vouchers->fetch_assoc()) {
                $last_contra_no = $latest_contra_voucher['id'];
            }
        } else {
            $last_contra_no = 0;
        }
        $contra_no = $last_contra_no + 1;
        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/add_contra_voucher.php';
        require_once APP_DIR . '/views/layout.php';
    }

}

?>