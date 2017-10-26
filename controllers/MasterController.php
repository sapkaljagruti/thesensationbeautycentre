<?php

class MasterController {

    public $managerobj;
    public $brandobj;
    public $branchobj;
    public $ex_ins_staff_members_nots;

    public function __construct() {
        require_once 'models/Managers.php';
        $this->managerobj = new Managers();

        require_once 'models/Brands.php';
        $this->brandobj = new Brands();

        require_once 'models/Branches.php';
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

    public function index() {
        $page_header = 'Welcome To Sensation Beauty Center';
        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/home.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function managers() {
        $page_header = 'Managers';
        $extra_js_files = array('plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables/dataTables.bootstrap.min.js', 'js/managers.js');
        $managers = $this->managerobj->getAll();
        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/managers.php';
        require_once APP_DIR . '/views/layout.php';
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

    public function getManager() {
        $id = trim($_POST['id']);
        $manager = $this->managerobj->getManager($id);
        if ($manager->num_rows == 1) {
            while ($m = mysqli_fetch_assoc($manager)) {
                $mobiles = explode(',', $m['mobile_nums']);
                $mobile1 = $mobiles[0];
                $mobile2 = $mobiles[1];
                $m['mobile1'] = $mobile1;
                $m['mobile2'] = $mobile2;
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

    public function brands() {
        $page_header = 'Brands';
        $extra_js_files = array('plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables/dataTables.bootstrap.min.js', 'js/brands.js');
        $brands = $this->brandobj->getAll();
        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/brands.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function addBrand() {
        $name = trim($_POST['name']);
        $brand = $this->brandobj->addBrand($name);
        if ($brand) {
            echo $brand;
        } else {
            echo '0';
        }
    }

    public function getBrand() {
        $id = trim($_POST['id']);
        $brand = $this->brandobj->getBrand($id);
        if ($brand->num_rows == 1) {
            while ($b = mysqli_fetch_assoc($brand)) {
                $rows[] = $b;
            }
            echo json_encode($rows);
        } else {
            echo '0';
        }
    }

    public function updateBrand() {
        $id = trim($_POST['id']);
        $name = trim($_POST['name']);
        $brand = $this->brandobj->updateBrand($id, $name);
        if ($brand) {
            echo $brand;
        } else {
            echo '0';
        }
    }

    public function deleteBrand() {
        if (is_array($_POST['id'])) {
            $ids = $_POST['id'];
            $deleted = array();
            foreach ($ids as $id) {
                $brand = $this->brandobj->deleteBrand($id);
                if ($brand) {
                    array_push($deleted, $id);
                }
            }
            echo json_encode($deleted);
        } else {
            $id = $_POST['id'];
            $brand = $this->brandobj->deleteBrand($id);
            if ($brand) {
                echo 'deleted';
            }
        }
    }

    public function branches() {
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