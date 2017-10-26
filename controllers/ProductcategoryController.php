<?php

class ProductcategoryController {

    public $productcategoryobj;
    public $ex_ins_staff_members_nots;

    public function __construct() {

        require_once 'models/ProductCategory.php';
        $this->productcategoryobj = new ProductCategory();

        require_once 'models/Staff.php';
        $this->staffobj = new Staff();

        $this->ex_ins_staff_members_nots = array();

        $ex_ins_staff_members_res = $this->staffobj->getInsuranceExStaff();
        if ($ex_ins_staff_members_res->num_rows > 0) {
            while ($ex_ins_staff_members = mysqli_fetch_assoc($ex_ins_staff_members_res)) {
                $this->ex_ins_staff_members_nots[] = $ex_ins_staff_members;
            }
        }

        $this->extra_js_files = array('plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables/dataTables.bootstrap.min.js', 'js/product_categories.js');
    }

    public function getcategories() {
        $page_header = 'Product Categories';
        $extra_js_files = $this->extra_js_files;
        $product_categories_res = $this->productcategoryobj->getcategories();
        if ($product_categories_res->num_rows > 0) {
            while ($product_category = $product_categories_res->fetch_assoc()) {
                $product_category['name'] = ucwords($product_category['name']);
                $product_categories[] = $product_category;
            }
        }
        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/product_categories.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function getcategory() {
        $id = trim($_POST['id']);
        $product_category = $this->productcategoryobj->getcategory($id);
        if ($product_category->num_rows == 1) {
            while ($pc = mysqli_fetch_assoc($product_category)) {
                $pc['name'] = ucwords($pc['name']);
                $rows[] = $pc;
            }
            echo json_encode($rows);
        } else {
            echo '0';
        }
    }

    public function addcategory() {
        $name = trim($_POST['name']);
        $parent_id = trim($_POST['parent_id']);
        $product_category = $this->productcategoryobj->addcategory($name, $parent_id);
        if ($product_category) {
            echo $product_category;
        } else {
            echo '0';
        }
    }

    public function updatecategory() {
        $id = trim($_POST['id']);
        $name = trim($_POST['name']);
        $parent_id = trim($_POST['parent_id']);

        $product_category = $this->productcategoryobj->updatecategory($id, $name, $parent_id);
        if ($product_category) {
            echo $product_category;
        } else {
            echo '0';
        }
    }

    public function deletecategory() {
        if (is_array($_POST['id'])) {
            $ids = $_POST['id'];
            $deleted = array();
            foreach ($ids as $id) {
                $product_category = $this->productcategoryobj->deletecategory($id);
                if ($product_category) {
                    array_push($deleted, $id);
                }
            }
            echo json_encode($deleted);
        } else {
            $id = trim($_POST['id']);
            $product_category = $this->productcategoryobj->deletecategory($id);
            if ($product_category) {
                echo 'deleted';
            } else {
                echo 'You cannot delete this category.';
            }
        }
    }

}

?>