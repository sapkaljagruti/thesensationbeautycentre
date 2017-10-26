
<?php

class Brand {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAll() {
        $brands = $this->conn->query('SELECT * FROM brands ORDER BY id DESC');
        return $brands;
    }

    public function getBrand($id) {
        $brand = $this->conn->query('SELECT * FROM brands WHERE id=' . $id);
        return $brand;
    }

    public function addBrand($name) {
        $brand = $this->conn->query('INSERT INTO brands(name) VALUES("' . $name . '")');
        if ($brand === TRUE) {
            return mysqli_insert_id($this->conn);
        } else {
            return FALSE;
        }
    }

    public function updateBrand($id, $name) {
        $brand = $this->conn->query('UPDATE brands SET name="' . $name . '" WHERE id=' . $id);
        if ($brand === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function deleteBrand($id) {
        $products_res = $this->conn->query('SELECT * FROM products WHERE brand_id=' . $id);

        if ($products_res->num_rows > 0) {
            return FALSE;
        } else {
            $brand = $this->conn->query('DELETE FROM brands WHERE id=' . $id);
            if ($brand === TRUE) {
                return $id;
            } else {
                return FALSE;
            }
        }
    }

}

?>