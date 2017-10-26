<?php

class BrandController {

    public $brandobj;
    public $ex_ins_staff_members_nots;

    public function __construct() {

        require_once 'models/Brand.php';
        $this->brandobj = new Brand();

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

    public function getBrands() {
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

}

?>