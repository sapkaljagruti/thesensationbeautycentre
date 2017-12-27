<?php

class JournalController {

    public $journalobj;
    public $accountgroupobj;
    public $ex_ins_staff_members_nots;
    public $extra_js_files;

    public function __construct() {

        require_once 'models/Journal.php';
        $this->journalobj = new Journal();

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

        $this->extra_js_files = array('plugins/jQueryUI/jquery-ui.js', 'plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables/dataTables.bootstrap.min.js', 'plugins/input-mask/jquery.inputmask.js', 'plugins/input-mask/jquery.inputmask.date.extensions.js', 'plugins/input-mask/jquery.inputmask.extensions.js', 'js/journal_vouchers.js');
    }

    public function getall() {
        $page_header = 'Journal Vouchers';
        $extra_js_files = $this->extra_js_files;
        $journal_vouchers = $this->journalobj->getall();
        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/journal_vouchers.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function getAllAccounts() {
        $res = array();
        $term = trim($_POST['term']);

        $accounts_res = $this->accountgroupobj->getNotDefaultLedgers($term);

        if ($accounts_res->num_rows > 0) {
            while ($account = $accounts_res->fetch_assoc()) {
                $res[] = [
                    'id' => $account['id'],
                    'name' => $account['name']
                ];
            }
        }

        echo json_encode($res);
    }

    public function checkLedgerNameExist() {
        $ledger_name = trim($_POST['ledger_name']);
        $exist = 1;

        $accounts_res = $this->accountgroupobj->checkLedgerNameExist($ledger_name);
        if ($accounts_res->num_rows <= 0) {
            $exist = 0;
        }

        if ($exist == 1) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function add() {
        $page_header = 'Journal Voucher Entry';
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

                $journal_voucher = $this->journalobj->addJournalVoucher($date, $entry_data, $total_amount, $narration);

                if ($journal_voucher) {
                    $entry_data_arr = explode(',', $entry_data);
                    foreach ($entry_data_arr as $entry) {
                        $entry_arr = explode('_', $entry);
                        $entry_type = $entry_arr[0];
                        $entry_id = $entry_arr[1];
                        $entry_amount = $entry_arr[2];

                        $update_balance_res = $this->accountgroupobj->updateOpeningBalance($entry_id, $entry_amount, $entry_type);
                    }

                    header('location: home.php?controller=journal&action=getall');
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

        $latest_journal_vouchers = $this->journalobj->getLatestVoucher();
        if ($latest_journal_vouchers->num_rows > 0) {
            while ($latest_journal_voucher = $latest_journal_vouchers->fetch_assoc()) {
                $last_journal_no = $latest_journal_voucher['id'];
            }
        } else {
            $last_journal_no = 0;
        }
        $journal_no = $last_journal_no + 1;
        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/add_journal_voucher.php';
        require_once APP_DIR . '/views/layout.php';
    }

}

?>