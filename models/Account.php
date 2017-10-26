
<?php

class Account {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getacs() {
        $accounts = $this->conn->query('SELECT * FROM accounts ORDER BY id DESC');
        return $accounts;
    }

    public function getac($id) {
        $account = $this->conn->query('SELECT * FROM accounts WHERE id=' . $id);
        return $account;
    }

    public function addaccount($name, $account_no, $account_group_id, $opening_type, $opening_amount, $contact_person, $address, $mobile1, $mobile2, $office_no, $email) {
        $account = $this->conn->query('INSERT INTO accounts(name, account_no, account_group_id, opening_type, opening_amount, contact_person, address, mobile1, mobile2, office_no, email) VALUES("' . $name . '", "' . $account_no . '", "' . $account_group_id . '", "' . $opening_type . '", "' . $opening_amount . '", "' . $contact_person . '", "' . $address . '", "' . $mobile1 . '", "' . $mobile2 . '", "' . $office_no . '", "' . $email . '")');
        if ($account === TRUE) {
            return mysqli_insert_id($this->conn);
        } else {
            return FALSE;
        }
    }

    public function updateac($id, $name, $account_no, $account_group_id, $opening_type, $opening_amount, $contact_person, $address, $mobile1, $mobile2, $office_no, $email) {
        $account = $this->conn->query('UPDATE accounts SET name="' . $name . '", account_no="' . $account_no . '", account_group_id="' . $account_group_id . '", opening_type="' . $opening_type . '", opening_amount="' . $opening_amount . '", contact_person="' . $contact_person . '", address="' . $address . '", mobile1="' . $mobile1 . '", mobile2="' . $mobile2 . '", office_no="' . $office_no . '" WHERE id=' . $id);
        if ($account === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function deleteac($id) {
        $account = $this->conn->query('DELETE FROM accounts WHERE id=' . $id);
        if ($account === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

}

?>