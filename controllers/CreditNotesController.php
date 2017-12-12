<?php

class CreditNotesController {

    public $creditnotesobj;
    public $accountgroupobj;
    public $gst_obj;
    public $ex_ins_staff_members_nots;

    public function __construct() {

        require_once 'models/CreditNotes.php';
        $this->creditnotesobj = new CreditNotes();

        require_once 'models/PurchaseType.php';
        $this->purchase_type_obj = new PurchaseType();

        require_once 'models/Gst.php';
        $this->gst_obj = new Gst();

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

        $this->extra_js_files = array('plugins/jQueryUI/jquery-ui.js', 'plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables/dataTables.bootstrap.min.js', 'plugins/input-mask/jquery.inputmask.js', 'plugins/input-mask/jquery.inputmask.date.extensions.js', 'plugins/input-mask/jquery.inputmask.extensions.js', 'js/credit_notes.js');
    }

    public function getall() {
        $page_header = 'Credit Notes';
        $extra_js_files = $this->extra_js_files;
        $credit_notes = $this->creditnotesobj->getAll();
        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/credit_notes.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function add() {
        $page_header = 'Credit Note Entry';
        $extra_js_files = $this->extra_js_files;

        if (!empty($_POST)) {
            $errors = array();

            $credit_note_no = trim($_POST['credit_note_no']);

            $checkCreditNoteExistRes = $this->creditnotesobj->checkCreditNoteExist(NULL, $credit_note_no);
            if ($checkCreditNoteExistRes) {
                array_push($errors, 'Credit Note no already exists. Please try again.');
            }

            if (empty($errors)) {
                $party_id = trim($_POST['party_id']);
                $sales_invoice_data = !empty($_POST['sales_invoice_data']) ? trim($_POST['sales_invoice_data']) : NULL;
                $narration = $_POST['narration'];
                $total_amount = !empty($_POST['total_amount']) ? $_POST['total_amount'] : NULL;

                if (!empty($_POST['date'])) {
                    $post_date = date_create($_POST['date']);
                    $date = date_format($post_date, 'Y-m-d');
                } else {
                    $date = NULL;
                }

                $credit_note = $this->creditnotesobj->addCreditNote($credit_note_no, $date, $party_id, $sales_invoice_data, $narration, $total_amount);

                if ($credit_note) {
                    header('location: home.php?controller=creditnotes&action=getall');
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

        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/add_credit_note.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function checkCreditNoteExist() {
        $id = !empty(trim($_POST['id'])) ? trim($_POST['id']) : NULL;
        $credit_note_no = trim($_POST['credit_note_no']);
        $credit_note_res = $this->creditnotesobj->checkCreditNoteExist($id, $credit_note_no);
        if ($credit_note_res) {
            echo '1';
        } else {
            echo '0';
        }
    }

}

?>