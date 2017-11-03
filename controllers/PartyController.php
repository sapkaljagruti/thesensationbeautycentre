<?php

class PartyController {

    public $partyobj;
    public $gst_obj;
    public $brand_obj;
    public $ex_ins_staff_members_nots;

    public function __construct() {

        require_once 'models/Party.php';
        $this->partyobj = new Party();

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

        $this->extra_js_files = array('plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables/dataTables.bootstrap.min.js', 'plugins/input-mask/jquery.inputmask.js', 'plugins/input-mask/jquery.inputmask.date.extensions.js', 'plugins/input-mask/jquery.inputmask.extensions.js', 'js/parties.js');
    }

    public function getall() {
        $page_header = 'All Party';
        $extra_js_files = $this->extra_js_files;
        $parties = $this->partyobj->getall();
        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/parties.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function get() {
        $page_header = 'Party Details';
        $extra_js_files = $this->extra_js_files;

        $id = trim($_GET['id']);
        $party_res = $this->partyobj->get($id);
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

                $parties[] = $party;
            }
        }
        $view_file = '/views/party_details.php';
        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        require_once APP_DIR . '/views/layout.php';
    }

    public function add() {
        $page_header = 'Party Master Entry';
        $extra_js_files = $this->extra_js_files;

        if (!empty($_POST)) {
            $errors = array();

            if (empty($errors)) {
                $name = trim($_POST['name']);
                $address = !empty($_POST['address']) ? $_POST['address'] : NULL;
                $contact_person = trim($_POST['contact_person']);
                $email = !empty($_POST['email']) ? trim($_POST['email']) : NULL;
                $mobile1 = !empty($_POST['mobile1']) ? trim($_POST['mobile1']) : NULL;
                $mobile2 = !empty($_POST['mobile2']) ? trim($_POST['mobile2']) : NULL;
                $residence_no = !empty($_POST['residence_no']) ? trim($_POST['residence_no']) : NULL;
                $office_no = !empty($_POST['office_no']) ? trim($_POST['office_no']) : NULL;
                $bank_name = !empty($_POST['bank_name']) ? trim($_POST['bank_name']) : NULL;
                $bank_branch = !empty($_POST['bank_branch']) ? trim($_POST['bank_branch']) : NULL;
                $ifsc_code = !empty($_POST['ifsc_code']) ? trim($_POST['ifsc_code']) : NULL;
                $bank_account_no = !empty($_POST['bank_account_no']) ? trim($_POST['bank_account_no']) : NULL;
                $pan = !empty($_POST['pan']) ? strtoupper(trim($_POST['pan'])) : NULL;
                $gst_state_code_id = !empty($_POST['gst_state_code_id']) ? trim($_POST['gst_state_code_id']) : NULL;
                $gst_type_id = !empty($_POST['gst_type_id']) ? trim($_POST['gst_type_id']) : NULL;
                $gstin = !empty($_POST['gstin']) ? strtoupper(trim($_POST['gstin'])) : NULL;
                $brand_ids = !empty($_POST['brand_ids']) ? implode(',', $_POST['brand_ids']) : NULL;

                $party = $this->partyobj->add($name, $address, $contact_person, $email, $mobile1, $mobile2, $residence_no, $office_no, $bank_name, $bank_branch, $ifsc_code, $bank_account_no, $pan, $gst_state_code_id, $gst_type_id, $gstin, $brand_ids);
                if ($party) {
                    header('location: home.php?controller=party&action=getall');
                } else {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
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
        $view_file = '/views/add_party.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function update() {
        $page_header = 'Update Party Details';
        $extra_js_files = $this->extra_js_files;

        $id = trim($_GET['id']);

        if (!empty($_POST)) {
            $errors = array();

            if (empty($errors)) {
                $name = trim($_POST['name']);
                $address = !empty($_POST['address']) ? $_POST['address'] : NULL;
                $contact_person = trim($_POST['contact_person']);
                $email = !empty($_POST['email']) ? trim($_POST['email']) : NULL;
                $mobile1 = !empty($_POST['mobile1']) ? trim($_POST['mobile1']) : NULL;
                $mobile2 = !empty($_POST['mobile2']) ? trim($_POST['mobile2']) : NULL;
                $residence_no = !empty($_POST['residence_no']) ? trim($_POST['residence_no']) : NULL;
                $office_no = !empty($_POST['office_no']) ? trim($_POST['office_no']) : NULL;
                $bank_name = !empty($_POST['bank_name']) ? trim($_POST['bank_name']) : NULL;
                $bank_branch = !empty($_POST['bank_branch']) ? trim($_POST['bank_branch']) : NULL;
                $ifsc_code = !empty($_POST['ifsc_code']) ? trim($_POST['ifsc_code']) : NULL;
                $bank_account_no = !empty($_POST['bank_account_no']) ? trim($_POST['bank_account_no']) : NULL;
                $pan = !empty($_POST['pan']) ? strtoupper(trim($_POST['pan'])) : NULL;
                $gst_state_code_id = !empty($_POST['gst_state_code_id']) ? trim($_POST['gst_state_code_id']) : NULL;
                $gst_type_id = !empty($_POST['gst_type_id']) ? trim($_POST['gst_type_id']) : NULL;
                $gstin = !empty($_POST['gstin']) ? strtoupper(trim($_POST['gstin'])) : NULL;
                $brand_ids = !empty($_POST['brand_ids']) ? implode(',', $_POST['brand_ids']) : NULL;

                $party = $this->partyobj->update($id, $name, $address, $contact_person, $email, $mobile1, $mobile2, $residence_no, $office_no, $bank_name, $bank_branch, $ifsc_code, $bank_account_no, $pan, $gst_state_code_id, $gst_type_id, $gstin, $brand_ids);

                if ($party) {
                    header('location: home.php?controller=party&action=getall');
                } else {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
            }
        }

        $party = $this->partyobj->get($id);
        if ($party->num_rows == 1) {
            while ($c = mysqli_fetch_assoc($party)) {
                $party_detail[] = $c;
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
            $view_file = '/views/update_party.php';
            require_once APP_DIR . '/views/layout.php';
        } else {
            header('location: home.php?controller=error&action=index');
        }
    }

    public function deleteCutomer() {
        if (is_array($_POST['id'])) {
            $ids = $_POST['id'];
            $deleted = array();
            foreach ($ids as $id) {
                $party = $this->customerobj->deleteCutomer($id);
                if ($party) {
                    array_push($deleted, $id);
                }
            }
            echo json_encode($deleted);
        } else {
            $id = $_POST['id'];
            $party = $this->customerobj->deleteCutomer($id);
            if ($party) {
                echo 'deleted';
            }
        }
    }

    public function getPartyNameByTerm() {
        $term = trim($_POST['term']);
        $res = array();
        $party_res = $this->partyobj->getPartyNameByTerm($term);
        if ($party_res->num_rows > 0) {
            while ($party = $party_res->fetch_assoc()) {
                $res[] = [
                    'id' => $party['id'],
                    'name' => $party['name'],
                    'address' => $party['address'],
                    'contact_person' => $party['contact_person'],
                    'email' => $party['email'],
                    'mobile1' => $party['mobile1'],
                    'mobile2' => $party['mobile2'],
                    'mobile2' => $party['mobile2'],
                    'residence_no' => $party['residence_no'],
                    'office_no' => $party['office_no'],
                    'bank_name' => $party['bank_name'],
                    'bank_branch' => $party['bank_branch'],
                    'ifsc_code' => $party['ifsc_code'],
                    'bank_account_no' => $party['bank_account_no'],
                    'pan' => $party['pan'],
                    'gst_state_code_id' => $party['gst_state_code_id'],
                    'gst_type_id' => $party['gst_type_id'],
                    'gstin' => $party['gstin'],
                ];
            }
        }
        echo json_encode($res);
    }

    public function getById() {
        $id = trim($_POST['id']);
        $party_res = $this->partyobj->get($id);
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

                $parties[] = $party;
            }
            echo json_encode($parties);
        }
    }

}

?>