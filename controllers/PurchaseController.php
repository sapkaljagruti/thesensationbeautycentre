<?php

class PurchaseController {

    public $purchaseobj;
    public $purchase_type_obj;
    public $gst_obj;
    public $ex_ins_staff_members_nots;

    public function __construct() {

        require_once 'models/Purchase.php';
        $this->purchaseobj = new Purchase();

        require_once 'models/PurchaseType.php';
        $this->purchase_type_obj = new PurchaseType();

        require_once 'models/Gst.php';
        $this->gst_obj = new Gst();

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
        $purchase_vouchers = $this->partyobj->getPurchaseVouchers();
        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/purchase_bills.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function getstaffmember() {
        $id = trim($_POST['id']);
        $staff_member = $this->staffobj->getstaffmember($id);
        if ($staff_member->num_rows == 1) {
            while ($c = mysqli_fetch_assoc($staff_member)) {
                $c['staff_code'] = $c['staff_code'];
                $c['name'] = ucwords($c['name']);
                $c['designation'] = $c['designation'];
                $c['gender'] = ucwords($c['gender']);
                if (!empty($c['dob'])) {
                    $dob = date_create($c['dob']);
                    $c['dob'] = date_format($dob, 'd M, Y');
                } else {
                    $c['dob'] = '';
                }

                if (!empty($c['doa'])) {
                    $doa = date_create($c['doa']);
                    $c['doa'] = date_format($doa, 'd M, Y');
                } else {
                    $c['doa'] = '';
                }

                if (!empty($c['insurance_from'])) {
                    $insurance_from = date_create($c['insurance_from']);
                    $c['insurance_from'] = date_format($insurance_from, 'd M, Y');
                } else {
                    $c['insurance_from'] = '';
                }

                if (!empty($c['insurance_to'])) {
                    $insurance_to = date_create($c['insurance_to']);
                    $c['insurance_to'] = date_format($insurance_to, 'd M, Y');
                } else {
                    $c['insurance_to'] = '';
                }

                $rows[] = $c;
            }
            echo json_encode($rows);
        } else {
            echo '0';
        }
    }

    public function add() {
        $page_header = 'Purchase Voucher Entry';
        $extra_js_files = $this->extra_js_files;

        if (!empty($_POST)) {
//            echo "<pre>";
//            print_r($_POST);
//            exit();
            $errors = array();

            if (empty($errors)) {
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

                $purchase_voucher = $this->purchaseobj->addPurchaseVoucher($date, $invoice_no, $invoice_date, $purchase_type_id, $target_account, $party_id, $party_name, $party_address, $party_contact_person, $party_email, $party_mobile1, $party_mobile2, $party_residence_no, $party_office_no, $party_bank_name, $party_bank_branch, $party_ifsc_code, $party_bank_account_no, $party_pan, $party_gst_state_code_id, $party_gst_type_id, $party_gstin, $products_data, $total_cgst, $total_sgst, $total_igst, $total_amount);
                if ($purchase_voucher) {
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

        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/add_purchase_bill.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function updatestaff() {
        $page_header = 'Update Staff Member Details';
        $extra_js_files = $this->extra_js_files;

        $id = trim($_GET['id']);

        if (!empty($_POST)) {
            $errors = array();

            if (!empty($_POST['dob'])) {
                $post_dob = date_create($_POST['dob']);

                if (!$post_dob) {
                    array_push($errors, 'Please enter proper date of birth.');
                }
            }
            if (!empty($_POST['doa'])) {
                $post_doa = date_create($_POST['doa']);

                if (!$post_doa) {
                    array_push($errors, 'Please enter proper date of anniversary.');
                }
            }

            if (!empty($_POST['insurance_from'])) {
                $post_insurance_from = date_create($_POST['insurance_from']);

                if (!$post_insurance_from) {
                    array_push($errors, 'Please enter proper insurance from date.');
                }
            }

            if (!empty($_POST['insurance_to'])) {
                $post_insurance_to = date_create($_POST['insurance_to']);

                if (!$post_insurance_to) {
                    array_push($errors, 'Please enter proper insurance to date.');
                }
            }

            if (empty($errors)) {
                $staff_code = !empty($_POST['staff_code']) ? trim($_POST['staff_code']) : NULL;
                $name = trim($_POST['name']);
                $designation = !empty($_POST['designation']) ? trim($_POST['designation']) : NULL;
                $gender = $_POST['gender'];
                $address = !empty($_POST['address']) ? $_POST['address'] : NULL;
                $permanent_address = !empty($_POST['permanent_address']) ? $_POST['permanent_address'] : NULL;
                $mobile1 = !empty($_POST['mobile1']) ? trim($_POST['mobile1']) : NULL;
                $mobile2 = !empty($_POST['mobile2']) ? trim($_POST['mobile2']) : NULL;
                $residence_no = !empty($_POST['residence_no']) ? trim($_POST['residence_no']) : NULL;

                if (!empty($_POST['dob'])) {
                    $post_dob = date_create($_POST['dob']);
                    $dob = date_format($post_dob, 'Y-m-d');
                } else {
                    $dob = NULL;
                }

                if (!empty($_POST['doa'])) {
                    $post_doa = date_create($_POST['doa']);
                    $doa = date_format($post_doa, 'Y-m-d');
                } else {
                    $doa = NULL;
                }

                $email = !empty($_POST['email']) ? trim($_POST['email']) : NULL;
                $insurance_name = !empty($_POST['insurance_name']) ? trim($_POST['insurance_name']) : NULL;

                if (!empty($_POST['insurance_from'])) {
                    $post_insurance_from = date_create($_POST['insurance_from']);
                    $insurance_from = date_format($post_insurance_from, 'Y-m-d');
                } else {
                    $insurance_from = NULL;
                }

                if (!empty($_POST['insurance_to'])) {
                    $post_insurance_to = date_create($_POST['insurance_to']);
                    $insurance_to = date_format($post_insurance_to, 'Y-m-d');
                } else {
                    $insurance_to = NULL;
                }

                $staff_member = $this->staffobj->updatestaff($id, $staff_code, $name, $designation, $gender, $address, $permanent_address, $mobile1, $mobile2, $residence_no, $dob, $doa, $email, $insurance_name, $insurance_from, $insurance_to);

                if ($staff_member) {
                    header('location: home.php?controller=staff&action=getstaffmembers');
                } else {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
            }
        }

        $staff_member = $this->staffobj->getstaffmember($id);
        if ($staff_member->num_rows == 1) {
            while ($c = mysqli_fetch_assoc($staff_member)) {
                if (!empty($c['dob'])) {
                    $dob = date_create($c['dob']);
                    $c['dob'] = date_format($dob, 'd-m-Y');
                } else {
                    $c['dob'] = '';
                }

                if (!empty($c['doa'])) {
                    $doa = date_create($c['doa']);
                    $c['doa'] = date_format($doa, 'd-m-Y');
                } else {
                    $c['doa'] = '';
                }

                if (!empty($c['insurance_from'])) {
                    $insurance_from = date_create($c['insurance_from']);
                    $c['insurance_from'] = date_format($insurance_from, 'd-m-Y');
                } else {
                    $c['insurance_from'] = '';
                }

                if (!empty($c['insurance_to'])) {
                    $insurance_to = date_create($c['insurance_to']);
                    $c['insurance_to'] = date_format($insurance_to, 'd-m-Y');
                } else {
                    $c['insurance_to'] = '';
                }

                $staff_member_detail[] = $c;
            }

            $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
            $view_file = '/views/update_staff_member.php';
            require_once APP_DIR . '/views/layout.php';
        } else {
            header('location: home.php?controller=error&action=index');
        }
    }

    public function deletestaff() {
        if (is_array($_POST['id'])) {
            $ids = $_POST['id'];
            $deleted = array();
            foreach ($ids as $id) {
                $staff_member = $this->staffobj->deletestaff($id);
                if ($staff_member) {
                    array_push($deleted, $id);
                }
            }
            echo json_encode($deleted);
        } else {
            $id = $_POST['id'];
            $staff_member = $this->staffobj->deletestaff($id);
            if ($staff_member) {
                echo 'deleted';
            }
        }
    }

}

?>