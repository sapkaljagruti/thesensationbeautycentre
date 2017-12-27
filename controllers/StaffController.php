<?php

class StaffController {

    public $staffobj;
    public $ex_ins_staff_members_nots;
    public $extra_js_files;

    public function __construct() {

        require_once 'models/Staff.php';
        $this->staffobj = new Staff();

        $this->ex_ins_staff_members_nots = array();

        $ex_ins_staff_members_res = $this->staffobj->getInsuranceExStaff();
        if ($ex_ins_staff_members_res->num_rows > 0) {
            while ($ex_ins_staff_members = mysqli_fetch_assoc($ex_ins_staff_members_res)) {
                $this->ex_ins_staff_members_nots[] = $ex_ins_staff_members;
            }
        }

        $this->extra_js_files = array('plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables/dataTables.bootstrap.min.js', 'plugins/input-mask/jquery.inputmask.js', 'plugins/input-mask/jquery.inputmask.date.extensions.js', 'plugins/input-mask/jquery.inputmask.extensions.js', 'plugins/daterangepicker/moment.js', 'js/staff_members.js');
    }

    public function getstaffmembers() {
        $page_header = 'Staff Master';
        $extra_js_files = $this->extra_js_files;
        $staff_members = $this->staffobj->getstaffmembers();

        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/staff_members.php';
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

    public function addstaff() {
        $page_header = 'Staff Master Entry';
        $extra_js_files = $this->extra_js_files;

        if (!empty($_POST)) {
            $errors = array();

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
                $insurance_type = !empty($_POST['insurance_type']) ? trim($_POST['insurance_type']) : NULL;
                $insurance_name = !empty($_POST['insurance_name']) ? trim($_POST['insurance_name']) : NULL;
                $insurance_amount = !empty($_POST['insurance_amount']) ? trim($_POST['insurance_amount']) : NULL;

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

                $staff_member = $this->staffobj->addstaff($staff_code, $name, $designation, $gender, $address, $permanent_address, $mobile1, $mobile2, $residence_no, $dob, $doa, $email, $insurance_type, $insurance_name, $insurance_amount, $insurance_from, $insurance_to);
                if ($staff_member) {
                    header('location: home.php?controller=staff&action=getstaffmembers');
                } else {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
            }
        }

        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/add_staff_member.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function updatestaff() {
        $page_header = 'Update Staff Member Details';
        $extra_js_files = $this->extra_js_files;

        $id = trim($_GET['id']);

        if (!empty($_POST)) {
            $errors = array();

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
                $insurance_type = !empty($_POST['insurance_type']) ? trim($_POST['insurance_type']) : NULL;
                $insurance_name = !empty($_POST['insurance_name']) ? trim($_POST['insurance_name']) : NULL;
                $insurance_amount = !empty($_POST['insurance_amount']) ? trim($_POST['insurance_amount']) : NULL;

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

                $staff_member = $this->staffobj->updatestaff($id, $staff_code, $name, $designation, $gender, $address, $permanent_address, $mobile1, $mobile2, $residence_no, $dob, $doa, $email, $insurance_type, $insurance_name, $insurance_amount, $insurance_from, $insurance_to);

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