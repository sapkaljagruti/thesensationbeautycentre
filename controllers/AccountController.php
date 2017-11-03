<?php

class AccountController {

    public $accountobj;
    public $accountgroupobj;
    public $ex_ins_staff_members_nots;

    public function __construct() {

        require_once 'models/Account.php';
        $this->accountobj = new Account();

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

        $this->extra_js_files = array('plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables/dataTables.bootstrap.min.js', 'js/accounts.js');
    }

    public function getacs() {
        $page_header = 'Ledgers';
        $extra_js_files = $this->extra_js_files;
        $accounts_res = $this->accountobj->getacs();
        if ($accounts_res->num_rows > 0) {
            while ($account = $accounts_res->fetch_assoc()) {
                $account['name'] = ucwords($account['name']);
                $accounts[] = $account;
            }
        }
        
        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/accounts.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function getac() {
        $id = trim($_POST['id']);
        $account = $this->accountobj->getac($id);
        if ($account->num_rows == 1) {
            while ($ac = mysqli_fetch_assoc($account)) {
                $ac['name'] = ucwords($ac['name']);
                $ac['opening_type'] = strtoupper($ac['opening_type']);
                $ac_group_id = $ac['account_group_id'];

                if (!empty($ac_group_id) && $ac_group_id != '0') {
                    $ac_res = $this->accountgroupobj->getAccountGroup($ac_group_id);
                    if ($ac_res->num_rows == 1) {
                        while ($account_groups = $ac_res->fetch_assoc()) {
                            $ac['account_group'] = ucwords($account_groups['name']);
                        }
                    }
                } else {
                    $ac['account_group'] = '';
                }

                $ac['contact_person'] = ucwords($ac['contact_person']);
                $rows[] = $ac;
            }
            echo json_encode($rows);
        } else {
            echo '0';
        }
    }

    public function addaccount() {
        $page_header = 'Ledger Creation';
        $extra_js_files = $this->extra_js_files;

        if (!empty($_POST)) {
            $errors = array();

            if (empty($errors)) {
                $name = trim($_POST['name']);
                $account_no = trim($_POST['account_no']);
                $account_group_id = $_POST['account_group_id'];
                $opening_type = $_POST['opening_type'];
                $opening_amount = !empty($_POST['opening_amount']) ? $_POST['opening_amount'] : '0.00';
                $contact_person = !empty($_POST['contact_person']) ? $_POST['contact_person'] : NULL;
                $address = !empty($_POST['address']) ? $_POST['address'] : NULL;
                $mobile1 = !empty($_POST['mobile1']) ? trim($_POST['mobile1']) : NULL;
                $mobile2 = !empty($_POST['mobile2']) ? trim($_POST['mobile2']) : NULL;
                $office_no = !empty($_POST['office_no']) ? trim($_POST['office_no']) : NULL;
                $email = !empty($_POST['email']) ? trim($_POST['email']) : NULL;

                $account = $this->accountobj->addaccount($name, $account_no, $account_group_id, $opening_type, $opening_amount, $contact_person, $address, $mobile1, $mobile2, $office_no, $email);

                if ($account) {
                    header('location: home.php?controller=account&action=getacs');
                } else {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
            }
        }

        $account_groups_res = $this->accountgroupobj->getAccountGroups();
        if ($account_groups_res->num_rows > 0) {
            while ($account_group = $account_groups_res->fetch_assoc()) {
                $account_group['name'] = ucwords($account_group['name']);
                $account_groups[] = $account_group;
            }
        }

        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/add_account.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function updateac() {
        $page_header = 'Update Ledger Details';
        $extra_js_files = $this->extra_js_files;

        $id = trim($_GET['id']);

        if (!empty($_POST)) {
            $errors = array();

            if (empty($errors)) {
                $name = trim($_POST['name']);
                $account_no = trim($_POST['account_no']);
                $account_group_id = $_POST['account_group_id'];
                $opening_type = $_POST['opening_type'];
                $opening_amount = !empty($_POST['opening_amount']) ? $_POST['opening_amount'] : '0.00';
                $contact_person = !empty($_POST['contact_person']) ? $_POST['contact_person'] : NULL;
                $address = !empty($_POST['address']) ? $_POST['address'] : NULL;
                $mobile1 = !empty($_POST['mobile1']) ? trim($_POST['mobile1']) : NULL;
                $mobile2 = !empty($_POST['mobile2']) ? trim($_POST['mobile2']) : NULL;
                $office_no = !empty($_POST['office_no']) ? trim($_POST['office_no']) : NULL;
                $email = !empty($_POST['email']) ? trim($_POST['email']) : NULL;

                $account = $this->accountobj->updateac($id, $name, $account_no, $account_group_id, $opening_type, $opening_amount, $contact_person, $address, $mobile1, $mobile2, $office_no, $email);

                if ($account) {
                    header('location: home.php?controller=account&action=getacs');
                } else {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
            }
        }

        $account = $this->accountobj->getac($id);

        if ($account->num_rows == 1) {

            while ($ac = mysqli_fetch_assoc($account)) {
                if (is_null($ac['contact_person']) || empty($ac['contact_person'])) {
                    $ac['contact_person'] = '';
                }
                $account_details[] = $ac;
            }

            $account_groups_res = $this->accountgroupobj->getAccountGroups();
            if ($account_groups_res->num_rows > 0) {
                while ($account_group = $account_groups_res->fetch_assoc()) {
                    $account_group['name'] = ucwords($account_group['name']);
                    $account_groups[] = $account_group;
                }
            }

            $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
            $view_file = '/views/update_account.php';
            require_once APP_DIR . '/views/layout.php';
        } else {
            header('location: home.php?controller=error&action=index');
        }
    }

    public function deleteac() {
        if (is_array($_POST['id'])) {
            $ids = $_POST['id'];
            $deleted = array();
            foreach ($ids as $id) {
                $account = $this->accountobj->deleteac($id);
                if ($account) {
                    array_push($deleted, $id);
                }
            }
            echo json_encode($deleted);
        } else {
            $id = $_POST['id'];
            $account = $this->accountobj->deleteac($id);
            if ($account) {
                echo 'deleted';
            }
        }
    }

}

?>