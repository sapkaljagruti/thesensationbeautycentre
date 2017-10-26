<?php

class BranchController {

    public $managerobj;
    public $branchobj;
    public $ex_ins_staff_members_nots;

    public function __construct() {
        require_once 'models/Manager.php';
        $this->managerobj = new Managers();

        require_once 'models/Branch.php';
        $this->branchobj = new Branches();
        
        require_once 'models/Staff.php';
        $this->staffobj = new Staff();

        $this->ex_ins_staff_members_nots = array();

        $ex_ins_staff_members_res = $this->staffobj->getInsuranceExStaff();
        if ($ex_ins_staff_members_res->num_rows > 0) {
            while ($ex_ins_staff_members = mysqli_fetch_assoc($ex_ins_staff_members_res)) {
                $this->ex_ins_staff_members_nots[] = $ex_ins_staff_members;
            }
        }
    }

    public function getBranches() {
        $page_header = 'Branches';
        $extra_js_files = array('plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables/dataTables.bootstrap.min.js', 'js/branches.js', 'plugins/jQueryUI/jquery-ui.js');
        $rows = array();
        $branches = $this->branchobj->getAll();
        if (($branches)) {
            if ($branches->num_rows > 0) {
                while ($branch = mysqli_fetch_assoc($branches)) {
                    $branch['manager'] = '';
                    $manager = $this->managerobj->getManager($branch['manager_id']);
                    if ($manager) {
                        if ($manager->num_rows == 1) {
                            while ($m = mysqli_fetch_assoc($manager)) {
                                $branch['manager'] = ucwords($m['name']);
                            }
                        }
                    }
                    $rows[] = $branch;
                }
            }
        }
        
        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/branches.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function getBranch() {
        $id = trim($_POST['id']);
        $branches = $this->branchobj->getBranch($id);
        if ($branches->num_rows == 1) {
            while ($branch = mysqli_fetch_assoc($branches)) {
                $branch['name'] = ucwords($branch['name']);
                $branch['city'] = ucwords($branch['city']);
                $branch['state'] = ucwords($branch['state']);
                if (!is_null($branch['mobile_nums'])) {
                    $mobiles = explode(',', $branch['mobile_nums']);
                    $mobile1 = isset($mobiles[0]) && !empty($mobiles[0]) ? $mobiles[0] : '';
                    $mobile2 = isset($mobiles[1]) && !empty($mobiles[1]) ? $mobiles[1] : '';
                    $branch['mobile1'] = $mobile1;
                    $branch['mobile2'] = $mobile2;
                }

                if (!is_null($branch['phone_nums'])) {
                    $phone_nums = explode(',', $branch['phone_nums']);
                    $phone_num1 = isset($phone_nums[0]) && !empty($phone_nums[0]) ? $phone_nums[0] : '';
                    $phone_num2 = isset($phone_nums[1]) && !empty($phone_nums[1]) ? $phone_nums[1] : '';
                    $branch['phone_num1'] = $phone_num1;
                    $branch['phone_num2'] = $phone_num2;
                }

                if ($branch['is_active'] == 1) {
                    $branch['is_active'] = 'Yes';
                } else {
                    $branch['is_active'] = 'No';
                }

                $manager = $this->managerobj->getManager($branch['manager_id']);
                if ($manager->num_rows == 1) {
                    while ($m = mysqli_fetch_assoc($manager)) {
                        $branch['manager'] = ucwords($m['name']);
                    }
                }
                $rows[] = $branch;
            }
            echo json_encode($rows);
        } else {
            echo '0';
        }
    }

    public function checkManager($manager_name, $manager_id) {
        $manager_name = trim($_POST['manager_name']);
        $manager_id = trim($_POST['manager_id']);
        $manager = $this->managerobj->checkManager($manager_name, $manager_id);
        if ($manager) {
            if ($manager->num_rows > 0) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            echo '0';
        }
    }

    public function addBranch() {
        $manager_name = $_POST['manager_name'];
        $manager_id = $_POST['manager_id'];

        if (empty($manager_name)) {
            $manager_id_to_save = '';
        } else {
            $manager = $this->managerobj->checkManager($manager_name, $manager_id);

            if ($manager) {
                if ($manager->num_rows > 0) {
                    $manager_id_to_save = $manager_id;
                } else {
                    $manager_id_to_save = $this->managerobj->addManager($manager_name);
                }
            } else {
                $manager_id_to_save = $this->managerobj->addManager($manager_name);
            }
        }

        $postData = $_POST;
        $postData['manager_id'] = $manager_id_to_save;
        unset($postData['manager_name']);

        $phone_nums = '';
        $mobile_nums = '';

        $phone1 = isset($postData['phone1']) ? trim($postData['phone1']) : '';
        $phone2 = isset($postData['phone2']) ? trim($postData['phone2']) : '';
        if (empty($phone1) && empty($phone2)) {
            $phone_nums = '';
        } else {
            $phone_nums = $phone1 . ',' . $phone2;
        }
        $postData['phone_nums'] = $phone_nums;
        unset($postData['phone1']);
        unset($postData['phone2']);

        $mobile1 = isset($postData['mobile1']) ? trim($postData['mobile1']) : '';
        $mobile2 = isset($postData['mobile2']) ? trim($postData['mobile2']) : '';
        if (empty($mobile1) && empty($mobile2)) {
            $mobile_nums = '';
        } else {
            $mobile_nums = $mobile1 . ',' . $mobile2;
        }
        $postData['mobile_nums'] = $mobile_nums;
        unset($postData['mobile1']);
        unset($postData['mobile2']);

        $branch = $this->branchobj->addBranch($postData);
        if ($branch) {
            echo $branch;
        } else {
            echo '0';
        }
    }

}

?>