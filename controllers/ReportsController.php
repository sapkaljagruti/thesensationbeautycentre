<?php

class ReportsController {

    public $productcategoryobj;
    public $productobj;
    public $brandobj;
    public $targetaccountobj;
    public $purchaseobj;
    public $saleobj;
    public $accountgroupobj;
    public $journalobj;
    public $staffobj;
    public $ex_ins_staff_members_nots;
    public $extra_js_files;

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

        require_once 'models/AccountGroup.php';
        $this->accountgroupobj = new AccountGroup();

        require_once 'models/Journal.php';
        $this->journalobj = new Journal();

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

    public function getprofitlossreports() {
        $page_header = 'Profit/Loss Reports';
        array_push($this->extra_js_files, 'plugins/input-mask/jquery.inputmask.js', 'plugins/input-mask/jquery.inputmask.date.extensions.js', 'plugins/input-mask/jquery.inputmask.extensions.js', 'js/profitloss_reports.js');
        if (in_array('js/pl_reports.js', $this->extra_js_files)) {
            unset($this->extra_js_files['js/stock_reports.js']);
        }
        $extra_js_files = $this->extra_js_files;

        $today = date('Y-m-d');
        $curr_year = date('Y');

        $start_date = $curr_year . '-04-01';
        $end_date = $today;

        $start_date_to_print = '01-Apr-' . $curr_year;
        $end_date_to_print = date('d-M-Y');

        $total_sales_amount = 0;
        $getCustomSales = $this->saleobj->getCustomSales($start_date, $end_date);
        if ($getCustomSales->num_rows > 0) {
            while ($sales_voucher = $getCustomSales->fetch_assoc()) {
                if ($sales_voucher['is_deleted'] != 1) {
                    $products_data_arr = explode(',', $sales_voucher['products_data']);
                    foreach ($products_data_arr as $product) {
                        $product_arr = explode('_', $product);
                        $target_account_id = $product_arr[1];
                        $product_total_amount = $product_arr[15];

                        if ($target_account_id == '1') { //Asha Account
                            $total_sales_amount += $product_total_amount;
                        }
                    }
                }
            }
        }

        $total_sales_amount = number_format((float) $total_sales_amount, 2, '.', '');

        $total_purchase_amount = 0;
        $purchase_res = $this->purchaseobj->getCustomPurchases($start_date, $end_date);
        if ($purchase_res->num_rows > 0) {
            while ($purchase_voucher = $purchase_res->fetch_assoc()) {
                if ($purchase_voucher['is_deleted'] != 1) {
                    $products_data_arr = explode(',', $purchase_voucher['products_data']);
                    foreach ($products_data_arr as $product) {
                        $product_arr = explode('_', $product);
                        $target_account_id = $product_arr[1];
                        $product_total_amount = $product_arr[16];

                        if ($target_account_id == '1') { //Asha Account
                            $total_purchase_amount += $product_total_amount;
                        }
                    }
                }
            }
        }

        $total_purchase_amount = number_format((float) $total_purchase_amount, 2, '.', '');

        $total_direct_expenses = 0;
        $direct_expense_ids = array();

        $direct_expenses_res = $this->accountgroupobj->getDirectExpensesAccountGroups();
        if ($direct_expenses_res->num_rows > 0) {
            while ($direct_expense = $direct_expenses_res->fetch_assoc()) {
                if ($direct_expense['is_deleted'] != 1) {
                    $direct_expense_id = $direct_expense['id'];
                    array_push($direct_expense_ids, $direct_expense_id);
                }
            }
        }

        $total_direct_incomes = 0;
        $direct_income_ids = array();

        $direct_incomes_res = $this->accountgroupobj->getDirectIncomesAccountGroups();
        if ($direct_incomes_res->num_rows > 0) {
            while ($direct_income = $direct_incomes_res->fetch_assoc()) {
                if ($direct_income['is_deleted'] != 1) {
                    $direct_income_id = $direct_income['id'];
                    array_push($direct_income_ids, $direct_income_id);
                }
            }
        }


        $total_indirect_expenses = 0;
        $indirect_expense_ids = array();

        $indirect_expenses_res = $this->accountgroupobj->getIndirectExpensesAccountGroups();
        if ($indirect_expenses_res->num_rows > 0) {
            while ($indirect_expense = $indirect_expenses_res->fetch_assoc()) {
                if ($indirect_expense['is_deleted'] != 1) {
                    $indirect_expense_id = $indirect_expense['id'];
                    array_push($indirect_expense_ids, $indirect_expense_id);
                }
            }
        }

        $total_indirect_incomes = 0;
        $indirect_income_ids = array();

        $indirect_incomes_res = $this->accountgroupobj->getIndirectIncomesAccountGroups();
        if ($indirect_incomes_res->num_rows > 0) {
            while ($indirect_income = $indirect_incomes_res->fetch_assoc()) {
                if ($indirect_income['is_deleted'] != 1) {
                    $indirect_income_id = $indirect_income['id'];
                    array_push($indirect_income_ids, $indirect_income_id);
                }
            }
        }

        $journal_vouchers_res = $this->journalobj->getCustomVouchers($start_date, $end_date);
        if ($journal_vouchers_res->num_rows > 0) {
            while ($journal_voucher = $journal_vouchers_res->fetch_assoc()) {
                if ($journal_voucher['is_deleted'] != 1) {
                    $entry_data_err = explode(',', $journal_voucher['entry_data']);
                    foreach ($entry_data_err as $entry) {
                        $entry_arr = explode('_', $entry);
                        $jd_type = $entry_arr[0];
                        $jd_id = $entry_arr[1];
                        $jd_amount = $entry_arr[2];

                        if (in_array($jd_id, $direct_expense_ids)) {
                            if ($jd_type == 'cr') {
                                $total_direct_expenses += $jd_amount;
                            } elseif ($jd_type == 'dr') {
                                $total_direct_expenses -= $jd_amount;
                            }
                        }

                        if (in_array($jd_id, $direct_income_ids)) {
                            if ($jd_type == 'cr') {
                                $total_direct_incomes += $jd_amount;
                            } elseif ($jd_type == 'dr') {
                                $total_direct_incomes -= $jd_amount;
                            }
                        }

                        if (in_array($jd_id, $indirect_expense_ids)) {
                            if ($jd_type == 'cr') {
                                $total_indirect_expenses += $jd_amount;
                            } elseif ($jd_type == 'dr') {
                                $total_indirect_expenses -= $jd_amount;
                            }
                        }

                        if (in_array($jd_id, $indirect_income_ids)) {
                            if ($jd_type == 'cr') {
                                $total_indirect_incomes += $jd_amount;
                            } elseif ($jd_type == 'dr') {
                                $total_indirect_incomes -= $jd_amount;
                            }
                        }
                    }
                }
            }
        }

        $total_direct_expenses = number_format((float) $total_direct_expenses, 2, '.', '');

        $total_direct_incomes = number_format((float) $total_direct_incomes, 2, '.', '');

        $total_left = $total_purchase_amount + $total_direct_expenses;
        $total_right = $total_sales_amount + $total_direct_incomes;

        $profit_loss = '';
        $profit_loss_amt = '';

        if ($total_left > $total_right) {
            $equal_amount = $total_left;
            $equal_amount = number_format((float) $equal_amount, 2, '.', '');

            $profit_loss = ' Loss';
            $profit_loss_amt = $total_left - $total_right;

            $profit_loss_amt = number_format((float) $profit_loss_amt, 2, '.', '');
        } else if ($total_left < $total_right) {
            $equal_amount = $total_right;
            $equal_amount = number_format((float) $equal_amount, 2, '.', '');

            $profit_loss = ' Profit';
            $profit_loss_amt = $total_right - $total_left;

            $profit_loss_amt = number_format((float) $profit_loss_amt, 2, '.', '');
        }

        $total_indirect_expenses = number_format((float) $total_indirect_expenses, 2, '.', '');

        $total_indirect_incomes = number_format((float) $total_indirect_incomes, 2, '.', '');

        $new_total_right = $profit_loss_amt + $total_indirect_incomes;
        $new_total_right = number_format((float) $new_total_right, 2, '.', '');

        $net_profit_loss = '';
        $new_profit_loss_amt = '';

        if ($total_indirect_incomes > $new_total_right) {
            $new_equal_amount = $total_indirect_incomes;
            $new_equal_amount = number_format((float) $new_equal_amount, 2, '.', '');

            $net_profit_loss = ' Loss';
            $new_profit_loss_amt = $total_indirect_incomes - $new_total_right;

            $new_profit_loss_amt = number_format((float) $new_profit_loss_amt, 2, '.', '');
        } else if ($total_indirect_incomes < $new_total_right) {
            $new_equal_amount = $new_total_right;
            $new_equal_amount = number_format((float) $new_equal_amount, 2, '.', '');

            $net_profit_loss = ' Profit';
            $new_profit_loss_amt = $new_total_right - $total_indirect_expenses;

            $new_profit_loss_amt = number_format((float) $new_profit_loss_amt, 2, '.', '');
        }

        $view_file = '/views/profitloss_reports.php';

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