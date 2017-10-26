
<?php

class Staff {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getstaffmembers() {
        $staff_members = $this->conn->query('SELECT * FROM staff_members ORDER BY id DESC');
        return $staff_members;
    }

    public function getstaffmember($id) {
        $staff_member = $this->conn->query('SELECT * FROM staff_members WHERE id=' . $id);
        return $staff_member;
    }

    public function addstaff($staff_code, $name, $designation, $gender, $address, $permanent_address, $mobile1, $mobile2, $residence_no, $dob, $doa, $email, $insurance_type, $insurance_name, $insurance_amount, $insurance_from, $insurance_to) {
        $staff_member = $this->conn->query('INSERT INTO staff_members(staff_code, name, designation, gender, address, permanent_address, mobile1, mobile2, residence_no, dob, doa, email, insurance_type, insurance_name, insurance_amount, insurance_from, insurance_to) VALUES("' . $staff_code . '", "' . $name . '", "' . $designation . '", "' . $gender . '", "' . $address . '", "' . $permanent_address . '", "' . $mobile1 . '", "' . $mobile2 . '", "' . $residence_no . '", "' . $dob . '", "' . $doa . '", "' . $email . '", "' . $insurance_type . '", "' . $insurance_name . '", "' . $insurance_amount . '", "' . $insurance_from . '", "' . $insurance_to . '")');
        if ($staff_member === TRUE) {
            return mysqli_insert_id($this->conn);
        } else {
            return FALSE;
        }
    }

    public function updatestaff($id, $staff_code, $name, $designation, $gender, $address, $permanent_address, $mobile1, $mobile2, $residence_no, $dob, $doa, $email, $insurance_type, $insurance_name, $insurance_amount, $insurance_from, $insurance_to) {
        $staff_member = $this->conn->query('UPDATE staff_members SET staff_code="' . $staff_code . '", name="' . $name . '", designation="' . $designation . '", gender="' . $gender . '", address="' . $address . '", permanent_address="' . $permanent_address . '", mobile1="' . $mobile1 . '", mobile2="' . $mobile2 . '", residence_no="' . $residence_no . '", dob="' . $dob . '", doa="' . $doa . '", email="' . $email . '", insurance_type="' . $insurance_type . '", insurance_name="' . $insurance_name . '", insurance_amount="' . $insurance_amount . '", insurance_from="' . $insurance_from . '", insurance_to="' . $insurance_to . '" WHERE id=' . $id);
        if ($staff_member === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function deletestaff($id) {
        $staff_member = $this->conn->query('DELETE FROM staff_members WHERE id=' . $id);
        if ($staff_member === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function getInsuranceExStaff() {
        $today = date('Y-m-d');
        $staff_members = $this->conn->query('SELECT * FROM staff_members WHERE insurance_to="' . $today . '" ORDER BY id DESC');
        return $staff_members;
    }

}

?>