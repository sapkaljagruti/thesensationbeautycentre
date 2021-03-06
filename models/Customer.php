
<?php

class Customer {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getCustomers() {
        $customers = $this->conn->query('SELECT * FROM customers WHERE is_deleted!="1" ORDER BY id DESC');
        return $customers;
    }

    public function getCustomer($id) {
        $customer = $this->conn->query('SELECT * FROM customers WHERE id=' . $id);
        return $customer;
    }

    public function addCustomer($name, $gender, $area, $city, $pincode, $mobile1, $mobile2, $residence_no, $office_no, $dob, $doa, $email) {
        $customer = $this->conn->query('INSERT INTO customers(name, gender, area, city, pincode, mobile1, mobile2, residence_no, office_no, dob, doa, email) VALUES("' . $name . '", "' . $gender . '", "' . $area . '", "' . $city . '", "' . $pincode . '", "' . $mobile1 . '", "' . $mobile2 . '", "' . $residence_no . '", "' . $office_no . '", "' . $dob . '", "' . $doa . '", "' . $email . '")');
        if ($customer === TRUE) {
            return mysqli_insert_id($this->conn);
        } else {
            return FALSE;
        }
    }

    public function updateCustomer($id, $name, $gender, $area, $city, $pincode, $mobile1, $mobile2, $residence_no, $office_no, $dob, $doa, $email) {
        $customer = $this->conn->query('UPDATE customers SET name="' . $name . '", gender="' . $gender . '", area="' . $area . '", city="' . $city . '", pincode="' . $pincode . '", mobile1="' . $mobile1 . '", mobile2="' . $mobile2 . '", residence_no="' . $residence_no . '", office_no="' . $office_no . '", dob="' . $dob . '", doa="' . $doa . '", email="' . $email . '" WHERE id=' . $id);
        if ($customer === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function deleteCutomer($id) {
        $customer = $this->conn->query('UPDATE customers SET is_deleted="1" WHERE id=' . $id);
        if ($customer === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

}

?>