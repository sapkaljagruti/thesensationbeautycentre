
<?php

class Product {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getproducts() {
        $products_res = $this->conn->query('SELECT * FROM products ORDER BY id DESC');
        return $products_res;
    }

    public function getproduct($id) {
        $product = $this->conn->query('SELECT * FROM products WHERE id=' . $id);
        return $product;
    }

    public function addproduct($product_category_id, $brand_id, $product_code, $name, $qty, $price, $description, $hsn_code, $calculation_type, $taxability, $integrated_tax, $cess) {
        $product = $this->conn->query('INSERT INTO products(product_category_id, brand_id, product_code, name, qty, price, description, hsn_code, calculation_type, taxability, integrated_tax, cess) VALUES("' . $product_category_id . '", "' . $brand_id . '", "' . $product_code . '", "' . $name . '", "' . $qty . '", "' . $price . '", "' . $description . '", "' . $hsn_code . '", "' . $calculation_type . '", "' . $taxability . '", "' . $integrated_tax . '", "' . $cess . '")');
        if ($product === TRUE) {
            return mysqli_insert_id($this->conn);
        } else {
            return FALSE;
        }
    }

    public function updateproduct($product_category_id, $brand_id, $product_code, $name, $qty, $price, $description, $hsn_code, $calculation_type, $taxability, $integrated_tax, $cess) {
        $product = $this->conn->query('UPDATE products SET product_category_id="' . $product_category_id . '", brand_id="' . $brand_id . '", product_code="' . $product_code . '", name="' . $name . '", hsn_code="' . $hsn_code . '", qty="' . $qty . '", price="' . $price . '", input_tax="' . $input_tax . '", output_tax="' . $output_tax . '", description="' . $description . '" WHERE id=' . $id);
        if ($product === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function deleteproduct($id) {
        $product = $this->conn->query('DELETE FROM products WHERE id=' . $id);
        if ($product === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

}

?>