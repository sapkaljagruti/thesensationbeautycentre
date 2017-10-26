
<?php

class ProductCategory {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getcategories() {
        $product_categories_res = $this->conn->query('SELECT * FROM product_categories ORDER BY id DESC');
        return $product_categories_res;
    }

    public function getcategory($id) {
        $product_category = $this->conn->query('SELECT * FROM product_categories WHERE id=' . $id);
        return $product_category;
    }

    public function addcategory($name, $parent_id) {
        $product_category = $this->conn->query('INSERT INTO product_categories(name, parent_id) VALUES("' . $name . '", ' . $parent_id . ')');
        if ($product_category === TRUE) {
            return mysqli_insert_id($this->conn);
        } else {
            return FALSE;
        }
    }

    public function updatecategory($id, $name, $parent_id) {
        $product_category = $this->conn->query('UPDATE product_categories SET name="' . $name . '", parent_id=' . $parent_id . ' WHERE id=' . $id);
        if ($product_category === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function deletecategory($id) {
        $product_categories_res = $this->conn->query('SELECT * FROM product_categories WHERE parent_id=' . $id);
        $products_res = $this->conn->query('SELECT * FROM products WHERE product_category_id=' . $id);

        if ($product_categories_res->num_rows > 0 || $products_res->num_rows > 0) {
            return FALSE;
        } else {
            $product_category = $this->conn->query('DELETE FROM product_categories WHERE id=' . $id);
            if ($product_category === TRUE) {
                return $id;
            } else {
                return FALSE;
            }
        }
    }

}

?>