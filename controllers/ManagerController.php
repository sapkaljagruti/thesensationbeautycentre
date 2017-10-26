<?php

class ManagerController {

    public $managerobj;
    public $ex_ins_staff_members_nots;

    public function __construct() {
        require_once 'models/Manager.php';
        $this->managerobj = new Managers();
        
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

    public function getManagers() {
        $page_header = 'Managers';
        $extra_js_files = array('plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables/dataTables.bootstrap.min.js', 'js/managers.js');
        $managers = $this->managerobj->getAll();
        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/managers.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function getManager() {
        $id = trim($_POST['id']);
        $manager = $this->managerobj->getManager($id);
        if ($manager->num_rows == 1) {
            while ($m = mysqli_fetch_assoc($manager)) {
                if (!is_null($m['mobile_nums'])) {
                    $mobiles = explode(',', $m['mobile_nums']);
                    $mobile1 = (isset($mobiles[0]) && !empty($mobiles[0])) ? $mobiles[0] : '';
                    $mobile2 = (isset($mobiles[1]) && !empty($mobiles[1])) ? $mobiles[1] : '';
                    $m['mobile1'] = $mobile1;
                    $m['mobile2'] = $mobile2;
                }

                $rows[] = $m;
            }
            echo json_encode($rows);
        } else {
            echo '0';
        }
    }

    public function addManager() {
        $phone_nums = '';
        $mobile_nums = '';
        $name = trim($_POST['name']);
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $mobile1 = isset($_POST['mobile1']) ? trim($_POST['mobile1']) : '';
        $mobile2 = isset($_POST['mobile2']) ? trim($_POST['mobile2']) : '';
        if (empty($mobile1) && empty($mobile2)) {
            $mobile_nums = '';
        } else {
            $mobile_nums = $mobile1 . ',' . $mobile2;
        }

        $manager = $this->managerobj->addManager($name, $email, $mobile_nums);
        if ($manager) {
            echo $manager;
        } else {
            echo '0';
        }
    }

    public function updateManager() {
        $id = trim($_POST['id']);
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $mobile_nums = trim($_POST['mobile1']) . ',' . trim($_POST['mobile2']);
        $manager = $this->managerobj->updateManager($id, $name, $email, $mobile_nums);
        if ($manager) {
            echo $manager;
        } else {
            echo '0';
        }
    }

    public function deleteManager() {
        if (is_array($_POST['id'])) {
            $ids = $_POST['id'];
            $deleted = array();
            foreach ($ids as $id) {
                $manager = $this->managerobj->deleteManager($id);
                if ($manager) {
                    array_push($deleted, $id);
                }
            }
            echo json_encode($deleted);
        } else {
            $id = $_POST['id'];
            $manager = $this->managerobj->deleteManager($id);
            if ($manager) {
                echo 'deleted';
            } else {
                echo 'You cannot delete this manager.';
            }
        }
    }

    public function getManagersForAutoComp() {
        $managers = $this->managerobj->getAll();
        $response_data = array();
        if ($managers->num_rows > 0) {
            while ($m = mysqli_fetch_assoc($managers)) {
                $response_data[] = array(
                    'label' => $m['name'],
                    'value' => $m['id']
                );
            }
            echo json_encode($response_data);
        } else {
            echo '0';
        }
    }

}

?>