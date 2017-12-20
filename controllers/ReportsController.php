<?php

class ReportsController {

    public $productcategoryobj;
    public $productobj;
    public $brandobj;
    public $targetaccountobj;
    public $purchaseobj;
    public $saleobj;
    public $staffobj;
    public $ex_ins_staff_members_nots;

    public function __construct() {

        require_once 'models/ProductCategory.php';
        $this->productcategoryobj = new ProductCategory();

        require_once 'models/Product.php';
        $this->productobj = new Product();

        require_once 'models/Brand.php';
        $this->brandobj = new Brand();

        require_once 'models/TargetAccount.php';
        $this->targetaccountobj = new TargetAccount();

        require_once 'models/Purchase.php';
        $this->purchaseobj = new Purchase();

        require_once 'models/Sale.php';
        $this->saleobj = new Sale();

        require_once 'models/Staff.php';
        $this->staffobj = new Staff();

        $this->ex_ins_staff_members_nots = array();

        $ex_ins_staff_members_res = $this->staffobj->getInsuranceExStaff();
        if ($ex_ins_staff_members_res->num_rows > 0) {
            while ($ex_ins_staff_members = mysqli_fetch_assoc($ex_ins_staff_members_res)) {
                $this->ex_ins_staff_members_nots[] = $ex_ins_staff_members;
            }
        }

        $this->extra_js_files = array('plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables/dataTables.bootstrap.min.js', 'plugins/moment/moment.min.js', 'plugins/daterangepicker/daterangepicker.js');
    }

    public function getStockReports() {
        $page_header = 'Stock Reports';
        array_push($this->extra_js_files, 'js/stock_reports.js');
        if (in_array('js/pl_reports.js', $this->extra_js_files)) {
            unset($this->extra_js_files['js/pl_reports.js']);
        }
        $extra_js_files = $this->extra_js_files;

        $product_categories_res = $this->productcategoryobj->getcategories();
        if ($product_categories_res->num_rows > 0) {
            while ($product_category = $product_categories_res->fetch_assoc()) {
                $product_category['name'] = ucwords($product_category['name']);
                $product_categories[] = $product_category;
            }
        }

        $target_accounts = array();
        $target_account_res = $this->targetaccountobj->getall();
        if ($target_account_res->num_rows > 0) {
            while ($target_account = $target_account_res->fetch_assoc()) {
                $target_account['name'] = ucwords($target_account['name']);
                $target_accounts[] = $target_account;
            }
        }

        $products = array();

        if (isset($_POST['show_all'])) {
            $products_res = $this->productobj->getproducts();
            if ($products_res->num_rows > 0) {
                while ($product = $products_res->fetch_assoc()) {
                    $product['name'] = ucwords($product['name']);
                    $products[] = $product;
                }
            }
            if (empty($products)) {
                $products = array(
                    'no_data' => 'no_data'
                );
            }
            echo json_encode($products);
        } elseif (isset($_POST['product_category_id']) || isset($_POST['top'])) {
            $cats_product_ids = array();
            $top_product_ids = array();
            $tp_ids = array();

            if (isset($_POST['product_category_id'])) {
                $cats_products_res = $this->productobj->getProdcutsByCat($_POST['product_category_id']);
                if ($cats_products_res->num_rows > 0) {
                    while ($cats_product = $cats_products_res->fetch_assoc()) {
                        $cats_product_ids[] = $cats_product['id'];
                    }
                }
            }

            if (isset($_POST['top'])) {
                $top = $_POST['top'];
                if ($top == 'selling') {
                    $sales_vouchers_res = $this->saleobj->getSaleVouchers();
                    if ($sales_vouchers_res->num_rows > 0) {
                        while ($sales_voucher = $sales_vouchers_res->fetch_assoc()) {
                            $products_data = $sales_voucher['products_data'];
                            $products_data_arr = explode(',', $products_data);
                            foreach ($products_data_arr as $product) {
                                $product_arr = explode('_', $product);
                                $product_id = $product_arr[0];
                                array_push($top_product_ids, $product_id);
                            }
                        }
                    }
                } elseif ($top == 'purchased') {
                    $purchased_ids = array();
                    $purchase_vouchers_res = $this->purchaseobj->getPurchaseVouchers();
                    if ($purchase_vouchers_res->num_rows > 0) {
                        while ($purchase_voucher = $purchase_vouchers_res->fetch_assoc()) {
                            $products_data = $purchase_voucher['products_data'];
                            $products_data_arr = explode(',', $products_data);
                            foreach ($products_data_arr as $product) {
                                $product_arr = explode('_', $product);
                                $product_id = $product_arr[0];
                                array_push($top_product_ids, $product_id);
                            }
                        }
                    }
                }
                $top_product_ids = array_count_values($top_product_ids);
                arsort($top_product_ids);
                foreach ($top_product_ids as $key => $value) {
                    $tp_ids[] = $key;
                }
            }

            if (!empty($cats_product_ids) && !empty($tp_ids)) {
                $product_ids = array_intersect($cats_product_ids, $tp_ids);
            } else {
                if (!empty($cats_product_ids)) {
                    $product_ids = $cats_product_ids;
                } elseif (!empty($tp_ids)) {
                    $product_ids = $tp_ids;
                }
            }

            foreach ($product_ids as $product_id) {
                $products_res = $this->productobj->getproduct($product_id);
                if ($products_res->num_rows > 0) {
                    while ($product = $products_res->fetch_assoc()) {
                        $product['name'] = ucwords($product['name']);
                        $products[] = $product;
                    }
                }
            }

            if (empty($products)) {
                $products = array(
                    'no_data' => 'no_data'
                );
            }
            echo json_encode($products);
        } else {
            $products_res = $this->productobj->getproducts();
            if ($products_res->num_rows > 0) {
                while ($product = $products_res->fetch_assoc()) {
                    $product['name'] = ucwords($product['name']);
                    $products[] = $product;
                }
            }
            $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
            $view_file = '/views/stock_reports.php';
            require_once APP_DIR . '/views/layout.php';
        }
    }

    public function getPLReports() {
        $page_header = 'Profit/Loss Reports';
        array_push($this->extra_js_files, 'js/pl_reports.js');
        if (in_array('js/pl_reports.js', $this->extra_js_files)) {
            unset($this->extra_js_files['js/stock_reports.js']);
        }
        $extra_js_files = $this->extra_js_files;

        $total_purchase_res = $this->purchaseobj->getPurchaseVouchers();
        $total_purchase = $total_purchase_res->num_rows;

        $total_sales_res = $this->saleobj->getSaleVouchers();
        $total_sales = $total_sales_res->num_rows;

        $profit_loss = '';
        $profit_loss_amt = '';

        $today = date('d-m-Y');
        $today = strtotime($today);

        $this_month = date('m', $today);
        $this_year = date('Y', $today);

        $getThisMonthSales = $this->saleobj->getThisMonthSales($this_month, $this_year);
        $total_sales_amount = 0;

        if ($getThisMonthSales->num_rows > 0) {
            foreach ($getThisMonthSales as $getThisMonthSale) {
                $total_sales_amount += $getThisMonthSale['total_bill_amount'];
            }
        }

        $getThisMonthPurchases = $this->purchaseobj->getThisMonthPurchases($this_month, $this_year);
        $total_purchase_amount = 0;

        if ($getThisMonthPurchases->num_rows > 0) {
            foreach ($getThisMonthPurchases as $getThisMonthPurchase) {
                $total_purchase_amount += $getThisMonthPurchase['total_bill_amount'];
            }
        }

        if ($total_purchase_amount > $total_sales_amount) {
            $profit_loss = 'Loss';
            $profit_loss_amt = $total_purchase_amount - $total_sales_amount;
        } else {
            $profit_loss = 'Profit';
            $profit_loss_amt = $total_sales_amount - $total_purchase_amount;
        }

        $view_file = '/views/pl_reports.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function getCustomPLReports() {
        $profit_loss = '';
        $profit_loss_amt = '';

        $start_date = trim($_POST['start_date']);
        $end_date = trim($_POST['end_date']);

        $getCustomSales = $this->saleobj->getCustomSales($start_date, $end_date);
        $total_sales_amount = 0;
        if ($getCustomSales->num_rows > 0) {
            foreach ($getCustomSales as $getCustomSale) {
                $total_sales_amount += $getCustomSale['total_bill_amount'];
            }
        }

        $getCustomPurchases = $this->purchaseobj->getCustomPurchases($start_date, $end_date);
        $total_purchase_amount = 0;

        if ($getCustomPurchases->num_rows > 0) {
            foreach ($getCustomPurchases as $getCustomPurchase) {
                $total_purchase_amount += $getCustomPurchase['total_bill_amount'];
            }
        }
        if ($total_purchase_amount > $total_sales_amount) {
            $profit_loss = 'Loss';
            $profit_loss_amt = $total_purchase_amount - $total_sales_amount;
        } else {
            $profit_loss = 'Profit';
            $profit_loss_amt = $total_sales_amount - $total_purchase_amount;
        }
        $res = array();
        $res['profit_loss_amt'] = $profit_loss_amt;
        $res['profit_loss'] = $profit_loss;
        echo json_encode($res);
    }

}

?>