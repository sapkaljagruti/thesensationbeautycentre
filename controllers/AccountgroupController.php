<?php

class AccountgroupController {

    public $accountgroupobj;
    public $ex_ins_staff_members_nots;

    public function __construct() {

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

        $this->extra_js_files = array('plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables/dataTables.bootstrap.min.js', 'js/account_groups.js');
    }

    public function getacgroups() {
        $page_header = 'Account Groups';
        $extra_js_files = $this->extra_js_files;
        $account_groups_res = $this->accountgroupobj->getAccountGroups();
        if ($account_groups_res->num_rows > 0) {
            while ($account_group = $account_groups_res->fetch_assoc()) {
                $account_group['name'] = ucwords($account_group['name']);
                $account_groups[] = $account_group;
            }
        }
        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/account_groups.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function getAcGroup() {
        $id = trim($_POST['id']);
        $account_group = $this->accountgroupobj->getAccountGroup($id);
        if ($account_group->num_rows == 1) {
            while ($ac = mysqli_fetch_assoc($account_group)) {
                $ac['name'] = ucwords($ac['name']);
                $rows[] = $ac;
            }
            echo json_encode($rows);
        } else {
            echo '0';
        }
    }

    public function addgroup() {
        $name = trim($_POST['name']);
        $parent_id = trim($_POST['parent_id']);
        $account_group = $this->accountgroupobj->addgroup($name, $parent_id);
        if ($account_group) {
            echo $account_group;
        } else {
            echo '0';
        }
    }

    public function updategroup() {
        $id = trim($_POST['id']);
        $name = trim($_POST['name']);
        $parent_id = trim($_POST['parent_id']);

        $account_group = $this->accountgroupobj->updategroup($id, $name, $parent_id);
        if ($account_group) {
            echo $account_group;
        } else {
            echo '0';
        }
    }

    public function deleteacgroup() {
        if (is_array($_POST['id'])) {
            $ids = $_POST['id'];
            $deleted = array();
            foreach ($ids as $id) {
                $account_group = $this->accountgroupobj->deleteacgroup($id);
                if ($account_group) {
                    array_push($deleted, $id);
                }
            }
            echo json_encode($deleted);
        } else {
            $id = trim($_POST['id']);
            $account_group = $this->accountgroupobj->deleteacgroup($id);
            if ($account_group) {
                echo 'deleted';
            } else {
                echo 'You cannot delete this group.';
            }
        }
    }

}

?>