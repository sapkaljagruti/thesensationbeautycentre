<?php

class ProductController {

    public $productobj;
    public $productcategoryobj;
    public $staffobj;
    public $ex_ins_staff_members_nots;

    public function __construct() {

        require_once 'models/Product.php';
        $this->productobj = new Product();

        require_once 'models/ProductCategory.php';
        $this->productcategoryobj = new ProductCategory();

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

        $this->extra_js_files = array('plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables/dataTables.bootstrap.min.js', 'js/products.js');
    }

    public function getproducts() {
        $page_header = 'Products';
        $extra_js_files = $this->extra_js_files;
        $products_res = $this->productobj->getproducts();
        if ($products_res->num_rows > 0) {
            while ($product = $products_res->fetch_assoc()) {
                $product['name'] = ucwords($product['name']);
                $products[] = $product;
            }
        }

        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/products.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function getproduct() {
        $id = trim($_POST['id']);
        $products = $this->productobj->getproduct($id);
        if ($products->num_rows == 1) {
            while ($product = mysqli_fetch_assoc($products)) {
                $product_category_id = $product['product_category_id'];
                $product_category_res = $this->productcategoryobj->getcategory($product_category_id);
                if ($product_category_res->num_rows == 1) {
                    while ($product_category = mysqli_fetch_assoc($product_category_res)) {
                        $product['product_category'] = ucwords($product_category['name']);
                    }
                } else {
                    $product['product_category'] = '';
                }

                $brand_id = $product['brand_id'];
                $brand_res = $this->brandobj->getBrand($brand_id);
                if ($brand_res->num_rows == 1) {
                    while ($brand = mysqli_fetch_assoc($brand_res)) {
                        $product['brand'] = ucwords($brand['name']);
                    }
                } else {
                    $product['brand'] = '';
                }

                $product['name'] = ucwords($product['name']);
                $product['qty'] = $product['qty'] . ' Nos';
                $product['price'] = 'Rs. ' . $product['price'];

                if ($product['calculation_type'] == 'on_item_rate') {
                    $product['calculation_type'] = 'On Item Rate';
                } elseif (($product['calculation_type'] == 'on_value')) {
                    $product['calculation_type'] = 'On Value';
                }

                if ($product['taxability'] == 'exempt') {
                    $product['taxability'] = 'Exempt';
                } elseif (($product['taxability'] == 'nil_rated')) {
                    $product['taxability'] = 'Nil rated';
                } elseif (($product['taxability'] == 'taxable')) {
                    $product['taxability'] = 'Taxable';
                }

                $product['integrated_tax'] = $product['integrated_tax'] . ' %';
                $product['cess'] = $product['cess'] . ' %';

                $rows[] = $product;
            }
            echo json_encode($rows);
        } else {
            echo '0';
        }
    }

    public function addproduct() {
        $page_header = 'Product Master Entry';
        $extra_js_files = $this->extra_js_files;

        if (!empty($_POST)) {
            $errors = array();

            if (empty($errors)) {
                $product_category_id = $_POST['product_category_id'];
                $brand_id = $_POST['brand_id'];
                $product_code = !empty($_POST['product_code']) ? trim($_POST['product_code']) : NULL;
                $name = trim($_POST['name']);
                $qty = !empty($_POST['qty']) ? $_POST['qty'] : '0';
                $price = !empty($_POST['price']) ? $_POST['price'] : '0';
                $description = !empty($_POST['description']) ? trim($_POST['description']) : NULL;
                $hsn_code = !empty($_POST['hsn_code']) ? trim($_POST['hsn_code']) : NULL;
                $calculation_type = $_POST['calculation_type'];
                $taxability = $_POST['taxability'];
                $cgst = !empty($_POST['cgst']) ? $_POST['cgst'] : '0.00';
                $sgst = !empty($_POST['sgst']) ? $_POST['sgst'] : '0.00';
                $integrated_tax = !empty($_POST['integrated_tax']) ? $_POST['integrated_tax'] : '0.00';
                $cess = !empty($_POST['cess']) ? $_POST['cess'] : '0.00';

                $product = $this->productobj->addproduct($product_category_id, $brand_id, $product_code, $name, $qty, $price, $description, $hsn_code, $calculation_type, $taxability, $cgst, $sgst, $integrated_tax, $cess);

                if ($product) {
//                    if ($calculation_type == 'on_item_rate') {
//                        $product_id = $product;
//                    }
                    header('location: home.php?controller=product&action=getproducts');
                } else {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
            }
        }

        $product_categories_res = $this->productcategoryobj->getcategories();
        if ($product_categories_res->num_rows > 0) {
            while ($product_category = $product_categories_res->fetch_assoc()) {
                $product_category['name'] = ucwords($product_category['name']);
                $product_categories[] = $product_category;
            }
        }

        $brands_res = $this->brandobj->getAll();
        if ($brands_res->num_rows > 0) {
            while ($brand = $brands_res->fetch_assoc()) {
                $brand['name'] = ucwords($brand['name']);
                $brands[] = $brand;
            }
        }

        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/add_product.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function updateproduct() {
        $page_header = 'Update Product Details';
        $extra_js_files = $this->extra_js_files;

        $id = trim($_GET['id']);

        if (!empty($_POST)) {
            $errors = array();

            if (empty($errors)) {
                $product_category_id = $_POST['product_category_id'];
                $brand_id = $_POST['brand_id'];
                $product_code = !empty($_POST['product_code']) ? trim($_POST['product_code']) : NULL;
                $name = trim($_POST['name']);
                $qty = !empty($_POST['qty']) ? $_POST['qty'] : '0';
                $price = !empty($_POST['price']) ? $_POST['price'] : '0';
                $description = !empty($_POST['description']) ? trim($_POST['description']) : NULL;
                $hsn_code = !empty($_POST['hsn_code']) ? trim($_POST['hsn_code']) : NULL;
                $calculation_type = $_POST['calculation_type'];
                $taxability = $_POST['taxability'];
                $cgst = !empty($_POST['cgst']) ? $_POST['cgst'] : '0.00';
                $sgst = !empty($_POST['sgst']) ? $_POST['sgst'] : '0.00';
                $integrated_tax = !empty($_POST['integrated_tax']) ? $_POST['integrated_tax'] : '0.00';
                $cess = !empty($_POST['cess']) ? $_POST['cess'] : '0.00';

                $product = $this->productobj->updateproduct($id, $product_category_id, $brand_id, $product_code, $name, $qty, $price, $description, $hsn_code, $calculation_type, $taxability, $cgst, $sgst, $integrated_tax, $cess);

                if ($product) {
                    header('location: home.php?controller=product&action=getproducts');
                } else {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
            }
        }

        $products = $this->productobj->getproduct($id);

        if ($products->num_rows == 1) {

            while ($product = mysqli_fetch_assoc($products)) {
                $product_details[] = $product;
            }

            $product_categories_res = $this->productcategoryobj->getcategories();
            if ($product_categories_res->num_rows > 0) {
                while ($product_category = $product_categories_res->fetch_assoc()) {
                    $product_category['name'] = ucwords($product_category['name']);
                    $product_categories[] = $product_category;
                }
            }

            $brands_res = $this->brandobj->getAll();
            if ($brands_res->num_rows > 0) {
                while ($brand = $brands_res->fetch_assoc()) {
                    $brand['name'] = ucwords($brand['name']);
                    $brands[] = $brand;
                }
            }
            $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
            $view_file = '/views/update_product.php';
            require_once APP_DIR . '/views/layout.php';
        } else {
            header('location: home.php?controller=error&action=index');
        }
    }

    public function deleteproduct() {
        if (is_array($_POST['id'])) {
            $ids = $_POST['id'];
            $deleted = array();
            foreach ($ids as $id) {
                $product = $this->productobj->deleteproduct($id);
                if ($product) {
                    array_push($deleted, $id);
                }
            }
            echo json_encode($deleted);
        } else {
            $id = $_POST['id'];
            $product = $this->productobj->deleteproduct($id);
            if ($product) {
                echo 'deleted';
            }
        }
    }

}

?>