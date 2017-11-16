
<?php

class AccountGroup {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getall() {
        $account_groups = $this->conn->query('SELECT * FROM account_groups WHERE is_deleted!="1" AND is_default="0" ORDER BY id DESC');
        return $account_groups;
    }

    public function getallExceptThis($id) {
        $account_groups = $this->conn->query('SELECT * FROM account_groups WHERE is_deleted!="1" AND id!="' . $id . '" ORDER BY id DESC');
        return $account_groups;
    }

    public function getAccountGroup($id) {
        $account_group = $this->conn->query('SELECT * FROM account_groups WHERE id=' . $id);
        return $account_group;
    }
    
    public function getPurchaseLedgers() {
        $account_group = $this->conn->query('SELECT * FROM account_groups WHERE parent_id="58"');
        return $account_group;
    }

    public function add($name, $parent_id, $opening_balance, $contact_person, $area, $city, $pincode, $gst_state_code_id, $email, $mobile1, $mobile2, $bank_name, $bank_branch, $ifsc_code, $bank_account_no, $pan, $gst_type_id, $gstin, $brand_ids) {
        $account_group = $this->conn->query('INSERT INTO account_groups(name, parent_id, opening_balance, contact_person, area, city, pincode, gst_state_code_id, email, mobile1, mobile2, bank_name, bank_branch, ifsc_code, bank_account_no, pan, gst_type_id, gstin,brand_ids) VALUES("' . $name . '", "' . $parent_id . '", "' . $opening_balance . '", "' . $contact_person . '", "' . $area . '", "' . $city . '", "' . $pincode . '", "' . $gst_state_code_id . '", "' . $email . '", "' . $mobile1 . '", "' . $mobile2 . '", "' . $bank_name . '", "' . $bank_branch . '", "' . $ifsc_code . '", "' . $bank_account_no . '", "' . $pan . '", "' . $gst_type_id . '", "' . $gstin . '", "' . $brand_ids . '")');
        if ($account_group === TRUE) {
            return mysqli_insert_id($this->conn);
        } else {
            return FALSE;
        }
    }

    public function update($id, $name, $parent_id, $opening_balance, $contact_person, $area, $city, $pincode, $gst_state_code_id, $email, $mobile1, $mobile2, $bank_name, $bank_branch, $ifsc_code, $bank_account_no, $pan, $gst_type_id, $gstin, $brand_ids) {
        $account_group = $this->conn->query('UPDATE account_groups SET name="' . $name . '", parent_id="' . $parent_id . '", opening_balance="' . $opening_balance . '", contact_person="' . $contact_person . '", area="' . $area . '", city="' . $city . '", pincode="' . $pincode . '", gst_state_code_id="' . $gst_state_code_id . '", email="' . $email . '", mobile1="' . $mobile1 . '", mobile2="' . $mobile2 . '", bank_name="' . $bank_name . '", bank_branch="' . $bank_branch . '", ifsc_code="' . $ifsc_code . '", bank_account_no="' . $bank_account_no . '", pan="' . $pan . '", gst_type_id="' . $gst_type_id . '", gstin="' . $gstin . '", brand_ids="' . $brand_ids . '" WHERE id=' . $id);
        if ($account_group === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function deleteacgroup($id) {
        $account_group = $this->conn->query('UPDATE account_groups SET is_deleted="1" WHERE id=' . $id);
        if ($account_group) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function getAcGroupsByTerm($term) {
        $account_groups_res = $this->conn->query('SELECT * FROM account_groups WHERE name LIKE "%' . $term . '%"');
        return $account_groups_res;
    }

    public function checkLedgerNameExist($ledger_name) {
        $account_groups_res = $this->conn->query('SELECT * FROM account_groups WHERE ledger_name="' . $ledger_name . '"');
        return $account_groups_res;
    }

    public function checkNameExist($id, $name) {
        if (empty($id)) {
            $group_res = $this->conn->query('SELECT * FROM account_groups WHERE name="' . $name . '" AND is_deleted!="1"');
        } else {
            $group_res = $this->conn->query('SELECT * FROM account_groups WHERE name="' . $name . '" AND id!="' . $id . '" AND is_deleted!="1"');
        }

        if ($group_res->num_rows > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>