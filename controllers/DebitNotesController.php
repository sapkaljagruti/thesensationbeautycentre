<?php

class DebitNotesController {

    public $debitnotesobj;
    public $partyobj;
    public $gst_obj;
    public $ex_ins_staff_members_nots;
    public $extra_js_files;

    public function __construct() {

        require_once 'models/DebitNotes.php';
        $this->debitnotesobj = new DebitNotes();

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

        $this->extra_js_files = array('plugins/jQueryUI/jquery-ui.js', 'plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables/dataTables.bootstrap.min.js', 'plugins/input-mask/jquery.inputmask.js', 'plugins/input-mask/jquery.inputmask.date.extensions.js', 'plugins/input-mask/jquery.inputmask.extensions.js', 'js/debit_notes.js');
    }

    public function getall() {
        $page_header = 'Debit Notes';
        $extra_js_files = $this->extra_js_files;
        $debit_notes = $this->debitnotesobj->getAll();
        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/debit_notes.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function add() {
        $page_header = 'Debit Note Entry';
        $extra_js_files = $this->extra_js_files;

        if (!empty($_POST)) {
            $errors = array();

            $debit_note_no = trim($_POST['debit_note_no']);

            $checkDebitNoteExistRes = $this->debitnotesobj->checkDebitNoteExist(NULL, $debit_note_no);
            if ($checkDebitNoteExistRes) {
                array_push($errors, 'Debit Note no already exists. Please try again.');
            }

            if (empty($errors)) {
                $party_id = trim($_POST['party_id']);
                $purchase_invoice_data = !empty($_POST['purchase_invoice_data']) ? trim($_POST['purchase_invoice_data']) : NULL;
                $narration = $_POST['narration'];
                $total_amount = !empty($_POST['total_amount']) ? $_POST['total_amount'] : NULL;

                if (!empty($_POST['date'])) {
                    $post_date = date_create($_POST['date']);
                    $date = date_format($post_date, 'Y-m-d');
                } else {
                    $date = NULL;
                }

                $debit_note = $this->debitnotesobj->addDebitNote($debit_note_no, $date, $party_id, $purchase_invoice_data, $narration, $total_amount);

                if ($debit_note) {
                    header('location: home.php?controller=debitnotes&action=getall');
                } else {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
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
        $view_file = '/views/add_debit_note.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function checkDebitNoteExist() {
        $id = !empty(trim($_POST['id'])) ? trim($_POST['id']) : NULL;
        $debit_note_no = trim($_POST['debit_note_no']);
        $debit_note_res = $this->debitnotesobj->checkDebitNoteExist($id, $debit_note_no);
        if ($debit_note_res) {
            echo '1';
        } else {
            echo '0';
        }
    }

}

?>