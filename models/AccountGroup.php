
<?php

class AccountGroup {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAccountGroups() {
        $account_groups = $this->conn->query('SELECT * FROM account_groups ORDER BY id DESC');
        return $account_groups;
    }

    public function getAccountGroup($id) {
        $account_group = $this->conn->query('SELECT * FROM account_groups WHERE id=' . $id);
        return $account_group;
    }

    public function addGroup($name, $parent_id) {
        $account_group = $this->conn->query('INSERT INTO account_groups(name, parent_id) VALUES("' . $name . '", ' . $parent_id . ')');
        if ($account_group === TRUE) {
            return mysqli_insert_id($this->conn);
        } else {
            return FALSE;
        }
    }

    public function updategroup($id, $name, $parent_id) {
        $account_group = $this->conn->query('UPDATE account_groups SET name="' . $name . '", parent_id=' . $parent_id . ' WHERE id=' . $id);
        if ($account_group === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function deleteacgroup($id) {
        $account_groups_res = $this->conn->query('SELECT * FROM account_groups WHERE parent_id=' . $id);
        $accounts_res = $this->conn->query('SELECT * FROM accounts WHERE account_group_id=' . $id);

        if ($account_groups_res->num_rows > 0 || $accounts_res->num_rows > 0) {
            return FALSE;
        } else {
            $account_group = $this->conn->query('DELETE FROM account_groups WHERE id=' . $id);
            if ($account_group === TRUE) {
                return $id;
            } else {
                return FALSE;
            }
        }
    }

}

?>