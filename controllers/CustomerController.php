<?php

class CustomerController {

    public $customerobj;
    public $ex_ins_staff_members_nots;
    public $extra_js_files;

    public function __construct() {

        require_once 'models/Customer.php';
        $this->customerobj = new Customer();

        require_once 'models/Staff.php';
        $this->staffobj = new Staff();

        $this->ex_ins_staff_members_nots = array();

        $ex_ins_staff_members_res = $this->staffobj->getInsuranceExStaff();
        if ($ex_ins_staff_members_res->num_rows > 0) {
            while ($ex_ins_staff_members = mysqli_fetch_assoc($ex_ins_staff_members_res)) {
                $this->ex_ins_staff_members_nots[] = $ex_ins_staff_members;
            }
        }

        $this->extra_js_files = array('plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables/dataTables.bootstrap.min.js', 'plugins/input-mask/jquery.inputmask.js', 'plugins/input-mask/jquery.inputmask.date.extensions.js', 'plugins/input-mask/jquery.inputmask.extensions.js', 'js/customers.js');
    }

    public function getCustomers() {
        $page_header = 'Customers';
        $extra_js_files = $this->extra_js_files;
        $customers = $this->customerobj->getCustomers();
        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/customers.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function getCustomer() {
        $id = trim($_POST['id']);
        $customer = $this->customerobj->getCustomer($id);
        if ($customer->num_rows == 1) {
            while ($c = mysqli_fetch_assoc($customer)) {
                $c['name'] = ucwords($c['name']);
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
                $rows[] = $c;
            }
            echo json_encode($rows);
        } else {
            echo '0';
        }
    }

    public function addCustomer() {
        $page_header = 'Add New Customer';
        $extra_js_files = $this->extra_js_files;

        if (!empty($_POST)) {
            $errors = array();

            if (empty($errors)) {
                $name = trim($_POST['name']);
                $gender = $_POST['gender'];
                $area = !empty($_POST['area']) ? $_POST['area'] : NULL;
                $city = !empty($_POST['city']) ? $_POST['city'] : NULL;
                $pincode = !empty($_POST['pincode']) ? $_POST['pincode'] : NULL;
                $mobile1 = !empty($_POST['mobile1']) ? trim($_POST['mobile1']) : NULL;
                $mobile2 = !empty($_POST['mobile2']) ? trim($_POST['mobile2']) : NULL;
                $residence_no = !empty($_POST['residence_no']) ? trim($_POST['residence_no']) : NULL;
                $office_no = !empty($_POST['office_no']) ? trim($_POST['office_no']) : NULL;

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

                $customer = $this->customerobj->addCustomer($name, $gender, $area, $city, $pincode, $mobile1, $mobile2, $residence_no, $office_no, $dob, $doa, $email);
                if ($customer) {
                    header('location: home.php?controller=customer&action=getCustomers');
                } else {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
            }
        }

        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/add_customer.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function updateCustomer() {
        $page_header = 'Update Customer Details';
        $extra_js_files = $this->extra_js_files;

        $id = trim($_GET['id']);

        if (!empty($_POST)) {
            $errors = array();

            if (empty($errors)) {
                $name = trim($_POST['name']);
                $gender = $_POST['gender'];
                $area = !empty($_POST['area']) ? $_POST['area'] : NULL;
                $city = !empty($_POST['city']) ? $_POST['city'] : NULL;
                $pincode = !empty($_POST['pincode']) ? $_POST['pincode'] : NULL;
                $mobile1 = !empty($_POST['mobile1']) ? trim($_POST['mobile1']) : NULL;
                $mobile2 = !empty($_POST['mobile2']) ? trim($_POST['mobile2']) : NULL;
                $residence_no = !empty($_POST['residence_no']) ? trim($_POST['residence_no']) : NULL;
                $office_no = !empty($_POST['office_no']) ? trim($_POST['office_no']) : NULL;

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

                $customer = $this->customerobj->updateCustomer($id, $name, $gender, $area, $city, $pincode, $mobile1, $mobile2, $residence_no, $office_no, $dob, $doa, $email);

                if ($customer) {
                    header('location: home.php?controller=customer&action=getCustomers');
                } else {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
            }
        }

        $customer = $this->customerobj->getCustomer($id);
        if ($customer->num_rows == 1) {
            while ($c = mysqli_fetch_assoc($customer)) {
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
                $customer_detail[] = $c;
            }

            $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
            $view_file = '/views/update_customer.php';
            require_once APP_DIR . '/views/layout.php';
        } else {
            header('location: home.php?controller=error&action=index');
        }
    }

    public function deleteCutomer() {
        if (is_array($_POST['id'])) {
            $ids = $_POST['id'];
            $deleted = array();
            foreach ($ids as $id) {
                $customer = $this->customerobj->deleteCutomer($id);
                if ($customer) {
                    array_push($deleted, $id);
                }
            }
            echo json_encode($deleted);
        } else {
            $id = $_POST['id'];
            $customer = $this->customerobj->deleteCutomer($id);
            if ($customer) {
                echo 'deleted';
            }
        }
    }

}

?>