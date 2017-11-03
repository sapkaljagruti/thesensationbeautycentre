<?php

class CreditNotesController {

    public $creditnotesobj;
    public $partyobj;
    public $gst_obj;
    public $ex_ins_staff_members_nots;

    public function __construct() {

        require_once 'models/CreditNotes.php';
        $this->creditnotesobj = new CreditNotes();

        require_once 'models/PurchaseType.php';
        $this->purchase_type_obj = new PurchaseType();

        require_once 'models/Gst.php';
        $this->gst_obj = new Gst();

        require_once 'models/Party.php';
        $this->partyobj = new Party();

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

            if (empty($errors)) {
                $credit_note_no = trim($_POST['credit_note_no']);
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

        $parties_res = $this->partyobj->getall();
        if ($parties_res->num_rows > 0) {
            while ($party = mysqli_fetch_assoc($parties_res)) {
                $party['name'] = ucwords($party['name']);
                $parties[] = $party;
            }
        }

        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/add_credit_note.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function checkCreditNoteExist() {
        $credit_note_no = trim($_POST['credit_note_no']);
        $credit_note = $this->creditnotesobj->checkCreditNoteExist($credit_note_no);
        if ($credit_note) {
            echo '1';
        } else {
            echo '0';
        }
    }

}

?>