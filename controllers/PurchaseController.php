<?php

class PurchaseController {

    public $purchaseobj;
    public $purchase_type_obj;
    public $gst_obj;
    public $productobj;
    public $accountgroupobj;
    public $targetaccountobj;
    public $ex_ins_staff_members_nots;

    public function __construct() {

        require_once 'models/Purchase.php';
        $this->purchaseobj = new Purchase();

        require_once 'models/PurchaseType.php';
        $this->purchase_type_obj = new PurchaseType();

        require_once 'models/Gst.php';
        $this->gst_obj = new Gst();

        require_once 'models/Product.php';
        $this->productobj = new Product();

        require_once 'models/AccountGroup.php';
        $this->accountgroupobj = new AccountGroup();

        require_once 'models/TargetAccount.php';
        $this->targetaccountobj = new TargetAccount();

        require_once 'models/Staff.php';
        $this->staffobj = new Staff();

        $this->ex_ins_staff_members_nots = array();

        $ex_ins_staff_members_res = $this->staffobj->getInsuranceExStaff();
        if ($ex_ins_staff_members_res->num_rows > 0) {
            while ($ex_ins_staff_members = mysqli_fetch_assoc($ex_ins_staff_members_res)) {
                $this->ex_ins_staff_members_nots[] = $ex_ins_staff_members;
            }
        }

        $this->extra_js_files = array('plugins/jQueryUI/jquery-ui.js', 'plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables/dataTables.bootstrap.min.js', 'plugins/input-mask/jquery.inputmask.js', 'plugins/input-mask/jquery.inputmask.date.extensions.js', 'plugins/input-mask/jquery.inputmask.extensions.js', 'js/purchase_bills.js');
    }

    public function getbills() {
        $page_header = 'Purchase Vouchers';
        $extra_js_files = $this->extra_js_files;

        $purchase_vouchers = array();
        $purchase_vouchers_res = $this->purchaseobj->getPurchaseVouchers();
        if ($purchase_vouchers_res->num_rows > 0) {
            while ($purchase_voucher = $purchase_vouchers_res->fetch_assoc()) {

                $purchase_ledger_res = $this->accountgroupobj->getAccountGroup($purchase_voucher['purchase_ledger_id']);
                if ($purchase_ledger_res->num_rows > 0) {
                    while ($purchase_ledger = mysqli_fetch_assoc($purchase_ledger_res)) {
                        $purchase_voucher['purchase_ledger_name'] = ucwords($purchase_ledger['name']);
                    }
                }

                $party_res = $this->accountgroupobj->getAccountGroup($purchase_voucher['party_id']);
                if ($party_res->num_rows > 0) {
                    while ($party = mysqli_fetch_assoc($party_res)) {
                        $purchase_voucher['party_ac_name'] = ucwords($party['name']);
                    }
                }

                $purchase_vouchers[] = $purchase_voucher;
            }
        }

        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/purchase_bills.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function checkInovieExist() {
        $id = !empty(trim($_POST['id'])) ? trim($_POST['id']) : NULL;
        $invoice_no = trim($_POST['invoice_no']);
        $purchase_voucher_res = $this->purchaseobj->checkInovieExist($id, $invoice_no);
        if ($purchase_voucher_res) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function add() {
        $page_header = 'Purchase Voucher Entry';
        $extra_js_files = $this->extra_js_files;

        if (!empty($_POST)) {
            $errors = array();

            $invoice_no = trim($_POST['invoice_no']);

            $invoiceExistsRes = $this->purchaseobj->checkInovieExist(NULL, $invoice_no);
            if ($invoiceExistsRes) {
                array_push($errors, 'Invoice no already exists. Please try again.');
            }

            if (empty($_POST['party_id'])) {
                $party_name = trim($_POST['party_name']);
                $party_parent_id = !empty($_POST['party_parent_id']) ? $_POST['party_parent_id'] : NULL;
                $opening_balance = !empty($_POST['opening_balance']) ? $_POST['opening_balance'] : NULL;
                $contact_person = !empty($_POST['contact_person']) ? $_POST['contact_person'] : NULL;
                $area = !empty($_POST['area']) ? $_POST['area'] : NULL;
                $city = !empty($_POST['city']) ? $_POST['city'] : NULL;
                $pincode = !empty($_POST['pincode']) ? $_POST['pincode'] : NULL;
                $gst_state_code_id = !empty($_POST['party_gst_state_code_id']) ? $_POST['party_gst_state_code_id'] : NULL;
                $email = !empty($_POST['email']) ? trim($_POST['email']) : NULL;
                $mobile1 = !empty($_POST['mobile1']) ? trim($_POST['mobile1']) : NULL;
                $mobile2 = !empty($_POST['mobile2']) ? trim($_POST['mobile2']) : NULL;
                $bank_name = !empty($_POST['party_bank_name']) ? trim($_POST['party_bank_name']) : NULL;
                $bank_branch = !empty($_POST['party_bank_branch']) ? trim($_POST['party_bank_branch']) : NULL;
                $ifsc_code = !empty($_POST['party_ifsc_code']) ? trim($_POST['party_ifsc_code']) : NULL;
                $bank_account_no = !empty($_POST['party_bank_account_no']) ? trim($_POST['party_bank_account_no']) : NULL;
                $pan = !empty($_POST['party_pan']) ? strtoupper(trim($_POST['party_pan'])) : NULL;
                $gst_type_id = !empty($_POST['party_gst_type_id']) ? trim($_POST['party_gst_type_id']) : NULL;
                $gstin = !empty($_POST['party_gstin']) ? strtoupper(trim($_POST['party_gstin'])) : NULL;

                $party_id = $this->accountgroupobj->add($party_name, $party_parent_id, $opening_balance, $contact_person, $area, $city, $pincode, $gst_state_code_id, $email, $mobile1, $mobile2, $bank_name, $bank_branch, $ifsc_code, $bank_account_no, $pan, $gst_type_id, $gstin, NULL);

                if (!$party_id) {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
            } else {
                $party_id = $_POST['party_id'];
            }

            if (empty($errors)) {
                $purchase_ledger_id = trim($_POST['purchase_ledger_id']);
                $purchase_type_id = !empty($_POST['purchase_type_id']) ? trim($_POST['purchase_type_id']) : NULL;
                $products_data = !empty($_POST['products_data']) ? trim($_POST['products_data']) : NULL;

                $total_qty = !empty($_POST['total_qty']) ? trim($_POST['total_qty']) : NULL;
                $total_rate_per_unit = !empty($_POST['total_rate_per_unit']) ? trim($_POST['total_rate_per_unit']) : NULL;
                $total_discount_percentage = !empty($_POST['total_discount_percentage']) ? trim($_POST['total_discount_percentage']) : NULL;
                $total_discount_rs = !empty($_POST['total_discount_rs']) ? trim($_POST['total_discount_rs']) : NULL;
                $total_cgst_percentage = !empty($_POST['total_cgst_percentage']) ? trim($_POST['total_cgst_percentage']) : NULL;
                $total_cgst_rs = !empty($_POST['total_cgst_rs']) ? trim($_POST['total_cgst_rs']) : NULL;
                $total_sgst_percentage = !empty($_POST['total_sgst_percentage']) ? trim($_POST['total_sgst_percentage']) : NULL;
                $total_sgst_rs = !empty($_POST['total_sgst_rs']) ? trim($_POST['total_sgst_rs']) : NULL;
                $total_igst_percentage = !empty($_POST['total_igst_percentage']) ? trim($_POST['total_igst_percentage']) : NULL;
                $total_igst_rs = !empty($_POST['total_igst_rs']) ? trim($_POST['total_igst_rs']) : NULL;
                $total_bill_amount = !empty($_POST['total_bill_amount']) ? trim($_POST['total_bill_amount']) : NULL;
                $total_bill_amount = number_format((float) $total_bill_amount, 2, '.', '');

                if (!empty($_POST['date'])) {
                    $post_date = date_create($_POST['date']);
                    $date = date_format($post_date, 'Y-m-d');
                } else {
                    $date = NULL;
                }

                if (!empty($_POST['invoice_date'])) {
                    $post_invoice_date = date_create($_POST['invoice_date']);
                    $invoice_date = date_format($post_invoice_date, 'Y-m-d');
                } else {
                    $invoice_date = NULL;
                }

                $purchase_voucher = $this->purchaseobj->addPurchaseVoucher($date, $purchase_ledger_id, $invoice_no, $invoice_date, $purchase_type_id, $party_id, $products_data, $total_qty, $total_rate_per_unit, $total_discount_percentage, $total_discount_rs, $total_cgst_percentage, $total_cgst_rs, $total_sgst_percentage, $total_sgst_rs, $total_igst_percentage, $total_igst_rs, $total_bill_amount);

                if ($purchase_voucher) {
                    $products_data_arr = explode(',', $products_data);
                    foreach ($products_data_arr as $product) {
                        $product_arr = explode('_', $product);
                        $product_id = $product_arr[0];
                        $target_account_id = $product_arr[1];
                        $product_mrp = $product_arr[4];
                        $product_qty = $product_arr[6];
                        $product_cgst = $product_arr[10];
                        $product_sgst = $product_arr[12];
                        $product_igst = $product_arr[14];

                        if ($purchase_type_id == '1') { //Interstate Purchase
                            $product_cgst = '0.00';
                            $product_sgst = '0.00';
                        } else if ($purchase_type_id == '2') { //Local Purchase
                            $product_igst = '0.00';
                        }

                        $update_mrp_res = $this->productobj->updateProductMRP($product_id, $product_mrp);
                        $update_qty_res = $this->productobj->updateProductQty($target_account_id, $product_id, $product_qty);
                        $update_gst_res = $this->productobj->updateProductGST($product_id, $product_cgst, $product_sgst, $product_igst);
                    }
                    header('location: home.php?controller=purchase&action=getbills');
                } else {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
            }
        }

        $purchase_types_res = $this->purchase_type_obj->getTypes();
        if ($purchase_types_res->num_rows > 0) {
            while ($purchase_type = mysqli_fetch_assoc($purchase_types_res)) {
                $purchase_type['title'] = ucwords($purchase_type['title']);
                $purchase_types[] = $purchase_type;
            }
        }

        $gst_states_res = $this->gst_obj->getGstStates();
        if ($gst_states_res->num_rows > 0) {
            while ($gst_state = mysqli_fetch_assoc($gst_states_res)) {
                $gst_state['state'] = ucwords($gst_state['state']);
                $gst_states[] = $gst_state;
            }
        }

        $gst_types_res = $this->gst_obj->getGstTypes();
        if ($gst_types_res->num_rows > 0) {
            while ($gst_type = mysqli_fetch_assoc($gst_types_res)) {
                $gst_type['title'] = ucwords($gst_type['title']);
                $gst_types[] = $gst_type;
            }
        }

        $purchase_ledgers = array();
        $purchase_ledgers_res = $this->accountgroupobj->getPurchaseLedgers();
        if ($purchase_ledgers_res->num_rows > 0) {
            while ($purchase_ledger = mysqli_fetch_assoc($purchase_ledgers_res)) {
                $purchase_ledger['name'] = ucwords($purchase_ledger['name']);
                $purchase_ledgers[] = $purchase_ledger;
            }
        }

        $not_default_ledgers = array();
        $not_default_ledgers_res = $this->accountgroupobj->getNotDefaultLedgers();
        if ($not_default_ledgers_res->num_rows > 0) {
            while ($not_default_ledger = mysqli_fetch_assoc($not_default_ledgers_res)) {
                $not_default_ledger['name'] = ucwords($not_default_ledger['name']);
                $not_default_ledgers[] = $not_default_ledger;
            }
        }

        $account_groups = array();
        $account_groups_res = $this->accountgroupobj->getall();
        if ($account_groups_res->num_rows > 0) {
            while ($account_group = $account_groups_res->fetch_assoc()) {
                $account_group['name'] = ucwords($account_group['name']);
                $account_groups[] = $account_group;
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

        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/add_purchase_bill.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function findLedgerByTerm() {
        $term = trim($_POST['term']);
        $party_id = trim($_POST['party_id']);
        $res = array();
        $purchase_vouchers_res = $this->purchaseobj->findLedgerByTerm($term, $party_id);
        if ($purchase_vouchers_res->num_rows > 0) {
            while ($purchase_voucher = $purchase_vouchers_res->fetch_assoc()) {
                $res[] = [
                    'id' => $purchase_voucher['id'],
                    'ledger_name' => $purchase_voucher['ledger_name'],
                    'invoice_no' => $purchase_voucher['invoice_no'],
                    'invoice_date' => $purchase_voucher['invoice_date'],
                    'total_amount' => $purchase_voucher['total_amount']
                ];
            }
        }
        echo json_encode($res);
    }

    public function checkLedgerNameExist() {
        $ledger_name = trim($_POST['ledger_name']);
        $party_id = trim($_POST['party_id']);
        $purchase_vouchers_res = $this->purchaseobj->checkLedgerNameExist($ledger_name, $party_id);
        if ($purchase_vouchers_res->num_rows > 0) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function delete() {
        if (is_array($_POST['id'])) {
            $ids = $_POST['id'];
            $deleted = array();
            foreach ($ids as $id) {
                $purchase_voucher = $this->purchaseobj->delete($id);
                if ($purchase_voucher) {
                    array_push($deleted, $id);
                }
            }
            echo json_encode($deleted);
        } else {
            $id = trim($_POST['id']);
            $purchase_voucher = $this->purchaseobj->delete($id);
            if ($purchase_voucher) {
                echo 'deleted';
            } else {
                echo 'You cannot delete this voucher.';
            }
        }
    }

    public function update() {
        $page_header = 'Update Purchase Voucher';
        $extra_js_files = $this->extra_js_files;

        $id = trim($_GET['id']);

        if (!empty($_POST)) {
            $errors = array();

            $invoice_no = trim($_POST['invoice_no']);

            $invoiceExistsRes = $this->purchaseobj->checkInovieExist($id, $invoice_no);
            if ($invoiceExistsRes) {
                array_push($errors, 'Invoice no already exists. Please try again.');
            }

            if (empty($_POST['party_id'])) {
                $party_name = trim($_POST['party_name']);
                $party_parent_id = !empty($_POST['party_parent_id']) ? $_POST['party_parent_id'] : NULL;
                $opening_balance = !empty($_POST['opening_balance']) ? $_POST['opening_balance'] : NULL;
                $contact_person = !empty($_POST['contact_person']) ? $_POST['contact_person'] : NULL;
                $area = !empty($_POST['area']) ? $_POST['area'] : NULL;
                $city = !empty($_POST['city']) ? $_POST['city'] : NULL;
                $pincode = !empty($_POST['pincode']) ? $_POST['pincode'] : NULL;
                $gst_state_code_id = !empty($_POST['party_gst_state_code_id']) ? $_POST['party_gst_state_code_id'] : NULL;
                $email = !empty($_POST['email']) ? trim($_POST['email']) : NULL;
                $mobile1 = !empty($_POST['mobile1']) ? trim($_POST['mobile1']) : NULL;
                $mobile2 = !empty($_POST['mobile2']) ? trim($_POST['mobile2']) : NULL;
                $bank_name = !empty($_POST['party_bank_name']) ? trim($_POST['party_bank_name']) : NULL;
                $bank_branch = !empty($_POST['party_bank_branch']) ? trim($_POST['party_bank_branch']) : NULL;
                $ifsc_code = !empty($_POST['party_ifsc_code']) ? trim($_POST['party_ifsc_code']) : NULL;
                $bank_account_no = !empty($_POST['party_bank_account_no']) ? trim($_POST['party_bank_account_no']) : NULL;
                $pan = !empty($_POST['party_pan']) ? strtoupper(trim($_POST['party_pan'])) : NULL;
                $gst_type_id = !empty($_POST['party_gst_type_id']) ? trim($_POST['party_gst_type_id']) : NULL;
                $gstin = !empty($_POST['party_gstin']) ? strtoupper(trim($_POST['party_gstin'])) : NULL;

                $party_id = $this->accountgroupobj->add($party_name, $party_parent_id, $opening_balance, $contact_person, $area, $city, $pincode, $gst_state_code_id, $email, $mobile1, $mobile2, $bank_name, $bank_branch, $ifsc_code, $bank_account_no, $pan, $gst_type_id, $gstin, NULL);

                if (!$party_id) {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
            } else {
                $party_id = $_POST['party_id'];
            }

            if (empty($errors)) {
                $purchase_ledger_id = trim($_POST['purchase_ledger_id']);
                $purchase_type_id = !empty($_POST['purchase_type_id']) ? trim($_POST['purchase_type_id']) : NULL;
                $products_data = !empty($_POST['products_data']) ? trim($_POST['products_data']) : NULL;

                $total_qty = !empty($_POST['total_qty']) ? trim($_POST['total_qty']) : NULL;
                $total_rate_per_unit = !empty($_POST['total_rate_per_unit']) ? trim($_POST['total_rate_per_unit']) : NULL;
                $total_discount_percentage = !empty($_POST['total_discount_percentage']) ? trim($_POST['total_discount_percentage']) : NULL;
                $total_discount_rs = !empty($_POST['total_discount_rs']) ? trim($_POST['total_discount_rs']) : NULL;
                $total_cgst_percentage = !empty($_POST['total_cgst_percentage']) ? trim($_POST['total_cgst_percentage']) : NULL;
                $total_cgst_rs = !empty($_POST['total_cgst_rs']) ? trim($_POST['total_cgst_rs']) : NULL;
                $total_sgst_percentage = !empty($_POST['total_sgst_percentage']) ? trim($_POST['total_sgst_percentage']) : NULL;
                $total_sgst_rs = !empty($_POST['total_sgst_rs']) ? trim($_POST['total_sgst_rs']) : NULL;
                $total_igst_percentage = !empty($_POST['total_igst_percentage']) ? trim($_POST['total_igst_percentage']) : NULL;
                $total_igst_rs = !empty($_POST['total_igst_rs']) ? trim($_POST['total_igst_rs']) : NULL;
                $total_bill_amount = !empty($_POST['total_bill_amount']) ? trim($_POST['total_bill_amount']) : NULL;

                if (!empty($_POST['date'])) {
                    $post_date = date_create($_POST['date']);
                    $date = date_format($post_date, 'Y-m-d');
                } else {
                    $date = NULL;
                }

                if (!empty($_POST['invoice_date'])) {
                    $post_invoice_date = date_create($_POST['invoice_date']);
                    $invoice_date = date_format($post_invoice_date, 'Y-m-d');
                } else {
                    $invoice_date = NULL;
                }

                $purchase_voucher = $this->purchaseobj->updatePurchaseVoucher($id, $date, $purchase_ledger_id, $invoice_no, $invoice_date, $purchase_type_id, $party_id, $products_data, $total_qty, $total_rate_per_unit, $total_discount_percentage, $total_discount_rs, $total_cgst_percentage, $total_cgst_rs, $total_sgst_percentage, $total_sgst_rs, $total_igst_percentage, $total_igst_rs, $total_bill_amount);

                if ($purchase_voucher) {
                    $products_data_arr = explode(',', $products_data);
                    foreach ($products_data_arr as $product) {
                        $product_arr = explode('_', $product);
                        $product_id = $product_arr[0];
                        $target_account_id = $product_arr[1];
                        $product_mrp = $product_arr[4];
                        $product_qty = $product_arr[6];
                        $product_cgst = $product_arr[10];
                        $product_sgst = $product_arr[12];
                        $product_igst = $product_arr[14];

                        if ($purchase_type_id == '1') { //Interstate Purchase
                            $product_cgst = '0.00';
                            $product_sgst = '0.00';
                        } else if ($purchase_type_id == '2') { //Local Purchase
                            $product_igst = '0.00';
                        }

                        $update_mrp_res = $this->productobj->updateProductMRP($product_id, $product_mrp);
                        $update_qty_res = $this->productobj->updateProductQty($target_account_id, $product_id, $product_qty);
                        $update_gst_res = $this->productobj->updateProductGST($product_id, $product_cgst, $product_sgst, $product_igst);
                    }
                    header('location: home.php?controller=purchase&action=getbills');
                } else {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
            }
        }

        $purchase_voucher_res = $this->purchaseobj->getPurchaseVoucher($id);

        $purchase_voucher_data = array();

        if ($purchase_voucher_res->num_rows == 1) {

            while ($purchase_voucher = mysqli_fetch_assoc($purchase_voucher_res)) {
                $party_res = $this->accountgroupobj->getAccountGroup($purchase_voucher['party_id']);
                if ($party_res->num_rows > 0) {
                    while ($party = mysqli_fetch_assoc($party_res)) {
                        $purchase_voucher['party_name'] = ucwords($party['name']);
                        $purchase_voucher['party_parent_id'] = ucwords($party['parent_id']);

                        $purchase_voucher['group_parent'] = '';

                        $parent_group_res = $this->accountgroupobj->getAccountGroup($party['parent_id']);
                        if ($parent_group_res) {
                            if ($parent_group_res->num_rows > 0) {
                                while ($parent_group = $parent_group_res->fetch_assoc()) {
                                    $grand_parent_group_res = $this->accountgroupobj->getAccountGroup($parent_group['parent_id']);
                                    if ($grand_parent_group_res) {
                                        if ($grand_parent_group_res->num_rows > 0) {
                                            while ($grand_parent_group = $grand_parent_group_res->fetch_assoc()) {
                                                $purchase_voucher['group_parent'] = ucwords($parent_group['name']) . '<br/><i>(' . $grand_parent_group['name'] . ')</i>';
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        $purchase_voucher['contact_person'] = ucwords($party['contact_person']);
                        $purchase_voucher['opening_balance'] = $party['opening_balance'];
                        $purchase_voucher['email'] = $party['email'];
                        $purchase_voucher['area'] = $party['area'];
                        $purchase_voucher['city'] = $party['city'];
                        $purchase_voucher['pincode'] = $party['pincode'];
                        $purchase_voucher['mobile1'] = $party['mobile1'];
                        $purchase_voucher['mobile2'] = $party['mobile2'];
                        $purchase_voucher['party_bank_name'] = $party['bank_name'];
                        $purchase_voucher['party_bank_branch'] = $party['bank_branch'];
                        $purchase_voucher['party_ifsc_code'] = $party['ifsc_code'];
                        $purchase_voucher['party_bank_account_no'] = $party['bank_account_no'];
                        $purchase_voucher['party_pan'] = $party['pan'];
                        $purchase_voucher['party_gst_state_code_id'] = $party['gst_state_code_id'];
                        $purchase_voucher['party_gst_type_id'] = $party['gst_type_id'];
                        $purchase_voucher['party_gstin'] = $party['gstin'];
                    }
                }

                $purchase_voucher_data[] = $purchase_voucher;
            }

            $purchase_types_res = $this->purchase_type_obj->getTypes();
            if ($purchase_types_res->num_rows > 0) {
                while ($purchase_type = mysqli_fetch_assoc($purchase_types_res)) {
                    $purchase_type['title'] = ucwords($purchase_type['title']);
                    $purchase_types[] = $purchase_type;
                }
            }

            $gst_states_res = $this->gst_obj->getGstStates();
            if ($gst_states_res->num_rows > 0) {
                while ($gst_state = mysqli_fetch_assoc($gst_states_res)) {
                    $gst_state['state'] = ucwords($gst_state['state']);
                    $gst_states[] = $gst_state;
                }
            }

            $gst_types_res = $this->gst_obj->getGstTypes();
            if ($gst_types_res->num_rows > 0) {
                while ($gst_type = mysqli_fetch_assoc($gst_types_res)) {
                    $gst_type['title'] = ucwords($gst_type['title']);
                    $gst_types[] = $gst_type;
                }
            }

            $purchase_ledgers = array();
            $purchase_ledgers_res = $this->accountgroupobj->getPurchaseLedgers();
            if ($purchase_ledgers_res->num_rows > 0) {
                while ($purchase_ledger = mysqli_fetch_assoc($purchase_ledgers_res)) {
                    $purchase_ledger['name'] = ucwords($purchase_ledger['name']);
                    $purchase_ledgers[] = $purchase_ledger;
                }
            }

            $not_default_ledgers = array();
            $not_default_ledgers_res = $this->accountgroupobj->getNotDefaultLedgers();
            if ($not_default_ledgers_res->num_rows > 0) {
                while ($not_default_ledger = mysqli_fetch_assoc($not_default_ledgers_res)) {
                    $not_default_ledger['name'] = ucwords($not_default_ledger['name']);
                    $not_default_ledgers[] = $not_default_ledger;
                }
            }

            $account_groups = array();
            $account_groups_res = $this->accountgroupobj->getall();
            if ($account_groups_res->num_rows > 0) {
                while ($account_group = $account_groups_res->fetch_assoc()) {
                    $account_group['name'] = ucwords($account_group['name']);
                    $account_groups[] = $account_group;
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

            $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
            $view_file = '/views/update_purchase_bill.php';
            require_once APP_DIR . '/views/layout.php';
        } else {
            header('location: home.php?controller=error&action=index');
        }
    }

    public function printBill() {
        $id = trim($_GET['id']);
        $purchase_voucher_res = $this->purchaseobj->getPurchaseVoucher($id);

        $purchase_voucher_data = array();

        if ($purchase_voucher_res->num_rows == 1) {
            while ($purchase_voucher = mysqli_fetch_assoc($purchase_voucher_res)) {
                $party_res = $this->accountgroupobj->getAccountGroup($purchase_voucher['party_id']);
                if ($party_res->num_rows > 0) {
                    while ($party = mysqli_fetch_assoc($party_res)) {
                        $purchase_voucher['party_name'] = ucwords($party['name']);
                        $purchase_voucher['party_parent_id'] = ucwords($party['parent_id']);

                        $purchase_voucher['group_parent'] = '';

                        $parent_group_res = $this->accountgroupobj->getAccountGroup($party['parent_id']);
                        if ($parent_group_res) {
                            if ($parent_group_res->num_rows > 0) {
                                while ($parent_group = $parent_group_res->fetch_assoc()) {
                                    $grand_parent_group_res = $this->accountgroupobj->getAccountGroup($parent_group['parent_id']);
                                    if ($grand_parent_group_res) {
                                        if ($grand_parent_group_res->num_rows > 0) {
                                            while ($grand_parent_group = $grand_parent_group_res->fetch_assoc()) {
                                                $purchase_voucher['group_parent'] = ucwords($parent_group['name']) . '<br/><i>(' . $grand_parent_group['name'] . ')</i>';
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        if (!empty($party['gst_state_code_id'])) {
                            $purchase_voucher['party_gst_state_code_id'] = $party['gst_state_code_id'];
                            $gst_state_res = $this->gst_obj->getGstState($party['gst_state_code_id']);
                            if ($gst_state_res->num_rows > 0) {
                                while ($gst_state = mysqli_fetch_assoc($gst_state_res)) {
                                    $purchase_voucher['state'] = ucwords($gst_state['state']);
                                }
                            } else {
                                $purchase_voucher['state'] = '';
                            }
                        } else {
                            $purchase_voucher['party_gst_state_code_id'] = '';
                            $purchase_voucher['state'] = '';
                        }

                        $purchase_voucher['contact_person'] = ucwords($party['contact_person']);
                        $purchase_voucher['opening_balance'] = $party['opening_balance'];
                        $purchase_voucher['email'] = $party['email'];
                        $purchase_voucher['area'] = $party['area'];
                        $purchase_voucher['city'] = $party['city'];
                        $purchase_voucher['pincode'] = $party['pincode'];
                        $purchase_voucher['mobile1'] = $party['mobile1'];
                        $purchase_voucher['mobile2'] = $party['mobile2'];
                        $purchase_voucher['party_bank_name'] = $party['bank_name'];
                        $purchase_voucher['party_bank_branch'] = $party['bank_branch'];
                        $purchase_voucher['party_ifsc_code'] = $party['ifsc_code'];
                        $purchase_voucher['party_bank_account_no'] = $party['bank_account_no'];
                        $purchase_voucher['party_pan'] = $party['pan'];
                        $purchase_voucher['party_gst_type_id'] = $party['gst_type_id'];
                        $purchase_voucher['party_gstin'] = $party['gstin'];
                    }
                }

                $purchase_voucher_data[] = $purchase_voucher;
            }
            require_once APP_DIR . '/views/print_purchase_voucher.php';
        } else {
            header('location: home.php?controller=error&action=index');
        }
    }

}

?>