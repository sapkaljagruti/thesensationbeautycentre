<?php

class AccountgroupController {

    public $accountgroupobj;
    public $gst_obj;
    public $brand_obj;
    public $ex_ins_staff_members_nots;

    public function __construct() {

        require_once 'models/AccountGroup.php';
        $this->accountgroupobj = new AccountGroup();

        require_once 'models/Gst.php';
        $this->gst_obj = new Gst();

        require_once 'models/Brand.php';
        $this->brand_obj = new Brand();

        require_once 'models/Staff.php';
        $this->staffobj = new Staff();

        $this->ex_ins_staff_members_nots = array();

        $ex_ins_staff_members_res = $this->staffobj->getInsuranceExStaff();
        if ($ex_ins_staff_members_res->num_rows > 0) {
            while ($ex_ins_staff_members = mysqli_fetch_assoc($ex_ins_staff_members_res)) {
                $this->ex_ins_staff_members_nots[] = $ex_ins_staff_members;
            }
        }

        $this->extra_js_files = array('plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables/dataTables.bootstrap.min.js', 'plugins/select2/select2.full.js', 'js/account_groups.js');
    }

    public function getall() {
        $page_header = 'Account Groups';
        $extra_js_files = $this->extra_js_files;
        $account_groups_res = $this->accountgroupobj->getall();
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

    public function get() {
        $page_header = 'Account Group Details';
        $extra_js_files = $this->extra_js_files;

        $id = trim($_GET['id']);
        $account_group_res = $this->accountgroupobj->getAccountGroup($id);
        if ($account_group_res->num_rows > 0) {
            $account_groups = array();
            while ($account_group = mysqli_fetch_assoc($account_group_res)) {
                $account_group['name'] = ucwords($account_group['name']);

                $account_group['parent'] = '';

                $parent_group_res = $this->accountgroupobj->getAccountGroup($account_group['parent_id']);
                if ($parent_group_res) {
                    if ($parent_group_res->num_rows > 0) {
                        while ($parent_group = $parent_group_res->fetch_assoc()) {
                            $account_group['parent'] = ucwords($parent_group['name']);
                            $grand_parent_group_res = $this->accountgroupobj->getAccountGroup($parent_group['parent_id']);
                            if ($grand_parent_group_res) {
                                if ($grand_parent_group_res->num_rows > 0) {
                                    while ($grand_parent_group = $grand_parent_group_res->fetch_assoc()) {
                                        $account_group['parent'] = ucwords($parent_group['name']) . '<br/><i>(' . $grand_parent_group['name'] . ')</i>';
                                    }
                                }
                            }
                        }
                    } else {
                        $account_group['parent'] = '';
                    }
                } else {
                    $account_group['parent'] = '';
                }

                $account_group['contact_person'] = ucwords($account_group['contact_person']);

                if (!empty($account_group['gst_type_id'])) {
                    $gst_type_res = $this->gst_obj->getGstType($account_group['gst_type_id']);
                    if ($gst_type_res->num_rows > 0) {
                        while ($gst_type = mysqli_fetch_assoc($gst_type_res)) {
                            $account_group['gst_type'] = ucwords($gst_type['title']);
                        }
                    } else {
                        $account_group['gst_type'] = '';
                    }
                } else {
                    $account_group['gst_type'] = '';
                }

                if (!empty($account_group['gst_state_code_id'])) {
                    $gst_state_res = $this->gst_obj->getGstState($account_group['gst_state_code_id']);
                    if ($gst_state_res->num_rows > 0) {
                        while ($gst_state = mysqli_fetch_assoc($gst_state_res)) {
                            $account_group['state'] = ucwords($gst_state['state']);
                        }
                    } else {
                        $account_group['state'] = '';
                    }
                } else {
                    $account_group['state'] = '';
                }

                if (!empty($account_group['brand_ids'])) {
                    $brand_ids = explode(',', $account_group['brand_ids']);
                    $account_group_brands = array();

                    foreach ($brand_ids as $brand_id) {
                        $gst_brand_res = $this->brand_obj->getBrand($brand_id);
                        if ($gst_brand_res->num_rows > 0) {
                            while ($brand = mysqli_fetch_assoc($gst_brand_res)) {
                                array_push($account_group_brands, ucwords($brand['name']));
                            }
                        }
                    }

                    if (!empty($account_group_brands)) {
                        $account_group['brands'] = implode(', ', $account_group_brands);
                    } else {
                        $account_group['brands'] = '';
                    }
                } else {
                    $account_group['brands'] = '';
                }

                $account_groups[] = $account_group;
            }
            $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
            $view_file = '/views/account_group_details.php';
            require_once APP_DIR . '/views/layout.php';
        } else {
            header('location: home.php?controller=error&action=index');
        }
    }

    public function getParentName($parent_id = NULL) {
        if (empty($parent_id)) {
            $parent_id = trim($_POST['parent_id']);
        }
        $parent_name = '0';
        $parent_group_res = $this->accountgroupobj->getAccountGroup($parent_id);
        if ($parent_group_res) {
            if ($parent_group_res->num_rows > 0) {
                while ($parent_group = $parent_group_res->fetch_assoc()) {
                    $parent_group['name'] = '(' . ucwords($parent_group['name']) . ')';
                    $parent_name = $parent_group['name'];
                }
            } else {
                $parent_name = '0';
            }
        } else {
            $parent_name = '0';
        }
        echo $parent_name;
    }

    public function add() {
        $page_header = 'Account Group Entry';
        $extra_js_files = $this->extra_js_files;

        if (!empty($_POST)) {
            $errors = array();

            $name = strtolower(trim($_POST['name']));

            $groupExistsres = $this->accountgroupobj->checkNameExist(NULL, $name);
            if ($groupExistsres) {
                array_push($errors, 'Group name already exists. Please try with different name.');
            }

            if (empty($errors)) {
                $parent_id = !empty($_POST['parent_id']) ? $_POST['parent_id'] : NULL;
                $opening_balance = !empty($_POST['opening_balance']) ? $_POST['opening_balance'] : NULL;
                $contact_person = !empty($_POST['contact_person']) ? $_POST['contact_person'] : NULL;
                $area = !empty($_POST['area']) ? $_POST['area'] : NULL;
                $city = !empty($_POST['city']) ? $_POST['city'] : NULL;
                $pincode = !empty($_POST['pincode']) ? $_POST['pincode'] : NULL;
                $gst_state_code_id = !empty($_POST['gst_state_code_id']) ? $_POST['gst_state_code_id'] : NULL;
                $email = !empty($_POST['email']) ? trim($_POST['email']) : NULL;
                $mobile1 = !empty($_POST['mobile1']) ? trim($_POST['mobile1']) : NULL;
                $mobile2 = !empty($_POST['mobile2']) ? trim($_POST['mobile2']) : NULL;
                $bank_name = !empty($_POST['bank_name']) ? trim($_POST['bank_name']) : NULL;
                $bank_branch = !empty($_POST['bank_branch']) ? trim($_POST['bank_branch']) : NULL;
                $ifsc_code = !empty($_POST['ifsc_code']) ? trim($_POST['ifsc_code']) : NULL;
                $bank_account_no = !empty($_POST['bank_account_no']) ? trim($_POST['bank_account_no']) : NULL;
                $pan = !empty($_POST['pan']) ? strtoupper(trim($_POST['pan'])) : NULL;
                $gst_type_id = !empty($_POST['gst_type_id']) ? trim($_POST['gst_type_id']) : NULL;
                $gstin = !empty($_POST['gstin']) ? strtoupper(trim($_POST['gstin'])) : NULL;
                $brand_ids = !empty($_POST['brand_ids']) ? implode(',', $_POST['brand_ids']) : NULL;

                $accountgroup = $this->accountgroupobj->add($name, $parent_id, $opening_balance, $contact_person, $area, $city, $pincode, $gst_state_code_id, $email, $mobile1, $mobile2, $bank_name, $bank_branch, $ifsc_code, $bank_account_no, $pan, $gst_type_id, $gstin, $brand_ids);
                if ($accountgroup) {
                    header('location: home.php?controller=accountgroup&action=getall');
                } else {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
            }
        }

        $account_groups_res = $this->accountgroupobj->getall();
        if ($account_groups_res->num_rows > 0) {
            while ($account_group = $account_groups_res->fetch_assoc()) {
                $account_group['name'] = ucwords($account_group['name']);
                $account_groups[] = $account_group;
            }
        }

        $gst_types_res = $this->gst_obj->getGstTypes();
        if ($gst_types_res->num_rows > 0) {
            while ($gst_type = mysqli_fetch_assoc($gst_types_res)) {
                $gst_type['title'] = ucwords($gst_type['title']);
                $gst_types[] = $gst_type;
            }
        }

        $gst_states_res = $this->gst_obj->getGstStates();
        if ($gst_states_res->num_rows > 0) {
            while ($gst_state = mysqli_fetch_assoc($gst_states_res)) {
                $gst_state['state'] = ucwords($gst_state['state']);
                $gst_states[] = $gst_state;
            }
        }

        $brands_res = $this->brand_obj->getAll();
        if ($brands_res->num_rows > 0) {
            while ($brand = mysqli_fetch_assoc($brands_res)) {
                $brand['name'] = ucwords($brand['name']);
                $brands[] = $brand;
            }
        }

        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/add_account_group.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function update() {
        $page_header = 'Update Account Group';
        $extra_js_files = $this->extra_js_files;

        $id = trim($_GET['id']);

        if (!empty($_POST)) {
            $errors = array();

            $name = strtolower(trim($_POST['name']));

            $groupExistsres = $this->accountgroupobj->checkNameExist($id, $name);
            if ($groupExistsres) {
                array_push($errors, 'Group name already exists. Please try with different name.');
            }

            if (empty($errors)) {
                $id = trim($_POST['id']);
                $parent_id = !empty($_POST['parent_id']) ? $_POST['parent_id'] : NULL;
                $opening_balance = !empty($_POST['opening_balance']) ? $_POST['opening_balance'] : NULL;
                $contact_person = !empty($_POST['contact_person']) ? $_POST['contact_person'] : NULL;
                $area = !empty($_POST['area']) ? $_POST['area'] : NULL;
                $city = !empty($_POST['city']) ? $_POST['city'] : NULL;
                $pincode = !empty($_POST['pincode']) ? $_POST['pincode'] : NULL;
                $gst_state_code_id = !empty($_POST['gst_state_code_id']) ? $_POST['gst_state_code_id'] : NULL;
                $email = !empty($_POST['email']) ? trim($_POST['email']) : NULL;
                $mobile1 = !empty($_POST['mobile1']) ? trim($_POST['mobile1']) : NULL;
                $mobile2 = !empty($_POST['mobile2']) ? trim($_POST['mobile2']) : NULL;
                $bank_name = !empty($_POST['bank_name']) ? trim($_POST['bank_name']) : NULL;
                $bank_branch = !empty($_POST['bank_branch']) ? trim($_POST['bank_branch']) : NULL;
                $ifsc_code = !empty($_POST['ifsc_code']) ? trim($_POST['ifsc_code']) : NULL;
                $bank_account_no = !empty($_POST['bank_account_no']) ? trim($_POST['bank_account_no']) : NULL;
                $pan = !empty($_POST['pan']) ? strtoupper(trim($_POST['pan'])) : NULL;
                $gst_type_id = !empty($_POST['gst_type_id']) ? trim($_POST['gst_type_id']) : NULL;
                $gstin = !empty($_POST['gstin']) ? strtoupper(trim($_POST['gstin'])) : NULL;
                $brand_ids = !empty($_POST['brand_ids']) ? implode(',', $_POST['brand_ids']) : NULL;

                $accountgroup = $this->accountgroupobj->update($id, $name, $parent_id, $opening_balance, $contact_person, $area, $city, $pincode, $gst_state_code_id, $email, $mobile1, $mobile2, $bank_name, $bank_branch, $ifsc_code, $bank_account_no, $pan, $gst_type_id, $gstin, $brand_ids);
                if ($accountgroup) {
                    header('location: home.php?controller=accountgroup&action=getall');
                } else {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
            }
        }

        $account_group_details = array();

        $account_group_res = $this->accountgroupobj->getAccountGroup($id);
        if ($account_group_res->num_rows == 1) {
            while ($account_group_detail = mysqli_fetch_assoc($account_group_res)) {
                $account_group_details[] = $account_group_detail;
            }

            $account_groups_res = $this->accountgroupobj->getallExceptThis($id);
            if ($account_groups_res->num_rows > 0) {
                while ($account_group = $account_groups_res->fetch_assoc()) {
                    $account_group['name'] = ucwords($account_group['name']);
                    $account_groups[] = $account_group;
                }
            }

            $gst_types_res = $this->gst_obj->getGstTypes();
            if ($gst_types_res->num_rows > 0) {
                while ($gst_type = mysqli_fetch_assoc($gst_types_res)) {
                    $gst_type['title'] = ucwords($gst_type['title']);
                    $gst_types[] = $gst_type;
                }
            }

            $gst_states_res = $this->gst_obj->getGstStates();
            if ($gst_states_res->num_rows > 0) {
                while ($gst_state = mysqli_fetch_assoc($gst_states_res)) {
                    $gst_state['state'] = ucwords($gst_state['state']);
                    $gst_states[] = $gst_state;
                }
            }

            $brands_res = $this->brand_obj->getAll();
            if ($brands_res->num_rows > 0) {
                while ($brand = mysqli_fetch_assoc($brands_res)) {
                    $brand['name'] = ucwords($brand['name']);
                    $brands[] = $brand;
                }
            }

            $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
            $view_file = '/views/update_account_group.php';
            require_once APP_DIR . '/views/layout.php';
        } else {
            header('location: home.php?controller=error&action=index');
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

    public function checkNameExist() {
        $id = !empty(trim($_POST['id'])) ? trim($_POST['id']) : NULL;
        $name = strtolower(trim($_POST['name']));
        $group_res = $this->accountgroupobj->checkNameExist($id, $name);
        if ($group_res) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function getById() {
        $id = trim($_POST['id']);
        $party_res = $this->accountgroupobj->getAccountGroup($id);
        if ($party_res->num_rows == 1) {
            while ($party = mysqli_fetch_assoc($party_res)) {
                $party['name'] = ucwords($party['name']);
                $party['contact_person'] = ucwords($party['contact_person']);

                if (!empty($party['gst_type_id'])) {
                    $gst_type_res = $this->gst_obj->getGstType($party['gst_type_id']);
                    if ($gst_type_res->num_rows > 0) {
                        while ($gst_type = mysqli_fetch_assoc($gst_type_res)) {
                            $party['gst_type'] = ucwords($gst_type['title']);
                        }
                    } else {
                        $party['gst_type'] = '';
                    }
                } else {
                    $party['gst_type'] = '';
                }

                if (!empty($party['gst_state_code_id'])) {
                    $gst_state_res = $this->gst_obj->getGstState($party['gst_state_code_id']);
                    if ($gst_state_res->num_rows > 0) {
                        while ($gst_state = mysqli_fetch_assoc($gst_state_res)) {
                            $party['state'] = ucwords($gst_state['state']);
                        }
                    } else {
                        $party['state'] = '';
                    }
                } else {
                    $party['state'] = '';
                }

                if (!empty($party['brand_ids'])) {
                    $brand_ids = explode(',', $party['brand_ids']);
                    $party_brands = array();

                    foreach ($brand_ids as $brand_id) {
                        $gst_brand_res = $this->brand_obj->getBrand($brand_id);
                        if ($gst_brand_res->num_rows > 0) {
                            while ($brand = mysqli_fetch_assoc($gst_brand_res)) {
                                array_push($party_brands, ucwords($brand['name']));
                            }
                        }
                    }

                    if (!empty($party_brands)) {
                        $party['brands'] = implode(', ', $party_brands);
                    } else {
                        $party['brands'] = '';
                    }
                } else {
                    $party['brands'] = '';
                }

                $parent_group_res = $this->accountgroupobj->getAccountGroup($party['parent_id']);
                if ($parent_group_res) {
                    if ($parent_group_res->num_rows > 0) {
                        while ($parent_group = $parent_group_res->fetch_assoc()) {
                            $grand_parent_group_res = $this->accountgroupobj->getAccountGroup($parent_group['parent_id']);

                            if ($grand_parent_group_res->num_rows > 0) {
                                while ($grand_parent_group = $grand_parent_group_res->fetch_assoc()) {
                                    $grand_parent_group['name'] = '(' . ucwords($grand_parent_group['name']) . ')';
                                    $party['parent_name'] = $grand_parent_group['name'];
                                }
                            } else {
                                $party['parent_name'] = '';
                            }
                        }
                    }
                }

                $parties[] = $party;
            }
            echo json_encode($parties);
        }
    }

    public function findSalesLedgerByTerm() {
        $term = trim($_POST['term']);
        $res = array();
        $sale_ledgers_res = $this->accountgroupobj->findSalesLedgerByTerm($term);
        if ($sale_ledgers_res->num_rows > 0) {
            while ($sale_ledger = $sale_ledgers_res->fetch_assoc()) {
                $res[] = [
                    'id' => $sale_ledger['id'],
                    'ledger_name' => $sale_ledger['name'],
                    'invoice_no' => '123',
//                    'invoice_date' => $sale_ledger['invoice_date'],
//                    'total_amount' => $sale_ledger['total_amount']
                ];
            }
        }
        echo json_encode($res);
    }
    
    public function findPurchaseLedgerByTerm() {
        $term = trim($_POST['term']);
        $res = array();
        $sale_ledgers_res = $this->accountgroupobj->findPurchaseLedgerByTerm($term);
        if ($sale_ledgers_res->num_rows > 0) {
            while ($sale_ledger = $sale_ledgers_res->fetch_assoc()) {
                $res[] = [
                    'id' => $sale_ledger['id'],
                    'ledger_name' => $sale_ledger['name'],
                    'invoice_no' => '123',
//                    'invoice_date' => $sale_ledger['invoice_date'],
//                    'total_amount' => $sale_ledger['total_amount']
                ];
            }
        }
        echo json_encode($res);
    }

}

?>