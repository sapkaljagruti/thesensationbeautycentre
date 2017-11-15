
<?php

class Party {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getall() {
        $parties = $this->conn->query('SELECT * FROM parties WHERE is_deleted!="1" ORDER BY id DESC');
        return $parties;
    }

    public function get($id) {
        $party = $this->conn->query('SELECT * FROM parties WHERE id=' . $id);
        return $party;
    }

    public function add($name, $address, $contact_person, $email, $mobile1, $mobile2, $residence_no, $office_no, $bank_name, $bank_branch, $ifsc_code, $bank_account_no, $pan, $gst_state_code_id, $gst_type_id, $gstin, $brand_ids) {
        $party = $this->conn->query('INSERT INTO parties(name, address, contact_person, email, mobile1, mobile2, residence_no, office_no, bank_name, bank_branch, ifsc_code, bank_account_no, pan, gst_state_code_id, gst_type_id, gstin, brand_ids) VALUES("' . $name . '", "' . $address . '", "' . $contact_person . '", "' . $email . '", "' . $mobile1 . '", "' . $mobile2 . '", "' . $residence_no . '", "' . $office_no . '", "' . $bank_name . '", "' . $bank_branch . '", "' . $ifsc_code . '", "' . $bank_account_no . '", "' . $pan . '", "' . $gst_state_code_id . '", "' . $gst_type_id . '", "' . $gstin . '", "' . $brand_ids . '")');
        if ($party === TRUE) {
            return mysqli_insert_id($this->conn);
        } else {
            return FALSE;
        }
    }

    public function update($id, $name, $address, $contact_person, $email, $mobile1, $mobile2, $residence_no, $office_no, $bank_name, $bank_branch, $ifsc_code, $bank_account_no, $pan, $gst_state_code_id, $gst_type_id, $gstin, $brand_ids) {
        $party = $this->conn->query('UPDATE parties SET name="' . $name . '", address="' . $address . '", contact_person="' . $contact_person . '", email="' . $email . '", mobile1="' . $mobile1 . '", mobile2="' . $mobile2 . '", residence_no="' . $residence_no . '", office_no="' . $office_no . '", bank_name="' . $bank_name . '", bank_branch="' . $bank_branch . '", ifsc_code="' . $ifsc_code . '", bank_account_no="' . $bank_account_no . '", pan="' . $pan . '", gst_state_code_id="' . $gst_state_code_id . '", gst_type_id="' . $gst_type_id . '", gstin="' . $gstin . '", brand_ids="' . $brand_ids . '" WHERE id=' . $id);
        if ($party === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function delete($id) {
        $party = $this->conn->query('UPDATE parties SET is_deleted="1" WHERE id=' . $id);
        if ($party === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function getPartyNameByTerm($term) {
        $party_res = $this->conn->query('SELECT * FROM parties WHERE name LIKE "%' . $term . '%" LIMIT 10');
        return $party_res;
    }

    public function checkPartyNameExist($id, $name) {
        if (empty($id)) {
            $party_res = $this->conn->query('SELECT * FROM parties WHERE name="' . $name . '" AND is_deleted!="1"');
        } else {
            $party_res = $this->conn->query('SELECT * FROM parties WHERE name="' . $name . '" AND id!="' . $id . '" AND is_deleted!="1"');
        }

        if ($party_res->num_rows > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

?>