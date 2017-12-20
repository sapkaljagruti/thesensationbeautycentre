
<?php

class Product {

    public $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getproducts() {
        $products_res = $this->conn->query('SELECT * FROM products WHERE is_deleted!="1" ORDER BY id DESC');
        return $products_res;
    }

    public function getproduct($id) {
        $product = $this->conn->query('SELECT * FROM products WHERE id=' . $id);
        return $product;
    }

    public function addproduct($product_category_id, $brand_id, $product_code, $name, $qty1, $qty2, $price, $description, $hsn_code, $calculation_type, $taxability, $cgst, $sgst, $integrated_tax, $cess) {
        $product = $this->conn->query('INSERT INTO products(product_category_id, brand_id, product_code, name, qty1, qty2, price, description, hsn_code, calculation_type, taxability, cgst, sgst, integrated_tax, cess) VALUES("' . $product_category_id . '", "' . $brand_id . '", "' . $product_code . '", "' . $name . '", "' . $qty1 . '", "' . $qty2 . '", "' . $price . '", "' . $description . '", "' . $hsn_code . '", "' . $calculation_type . '", "' . $taxability . '", "' . $cgst . '", "' . $sgst . '", "' . $integrated_tax . '", "' . $cess . '")');
        if ($product === TRUE) {
            return mysqli_insert_id($this->conn);
        } else {
            return FALSE;
        }
    }

    public function updateproduct($id, $product_category_id, $brand_id, $product_code, $name, $qty1, $qty2, $price, $description, $hsn_code, $calculation_type, $taxability, $cgst, $sgst, $integrated_tax, $cess) {
        $product = $this->conn->query('UPDATE products SET product_category_id="' . $product_category_id . '", brand_id="' . $brand_id . '", product_code="' . $product_code . '", name="' . $name . '" , qty1="' . $qty1 . '", qty2="' . $qty2 . '", price="' . $price . '", description="' . $description . '", hsn_code="' . $hsn_code . '", calculation_type="' . $calculation_type . '", taxability="' . $taxability . '", cgst="' . $cgst . '", sgst="' . $sgst . '", integrated_tax="' . $integrated_tax . '", cess="' . $cess . '" WHERE id=' . $id);
        if ($product === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function deleteproduct($id) {
        $product = $this->conn->query('UPDATE products SET is_deleted="1" WHERE id=' . $id);
        if ($product === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function findProductByTerm($term) {
        $product_res = $this->conn->query('SELECT * FROM products WHERE name LIKE "%' . $term . '%" AND is_deleted!="1" ORDER BY id DESC');
        return $product_res;
    }

    public function checkProductNameExist($id, $product_name) {
        if (empty($id)) {
            $product_res = $this->conn->query('SELECT * FROM products WHERE name="' . $product_name . '" AND is_deleted!="1"');
        } else {
            $product_res = $this->conn->query('SELECT * FROM products WHERE name="' . $product_name . '" AND id!="' . $id . '" AND is_deleted!="1"');
        }

        if ($product_res->num_rows > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateProductMRP($product_id, $product_mrp) {
        $product = $this->conn->query('UPDATE products SET price="' . $product_mrp . '" WHERE id=' . $product_id);
        if ($product === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function updateProductQty($target_account_id, $product_id, $product_qty) {
        if ($target_account_id == '1') {
            $product = $this->conn->query('UPDATE products SET qty1="' . $product_qty . '" WHERE id=' . $product_id);
        } else {
            $product = $this->conn->query('UPDATE products SET qty2="' . $product_qty . '" WHERE id=' . $product_id);
        }
        if ($product === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function updateProductGST($product_id, $product_cgst, $product_sgst, $product_igst) {
        $product = $this->conn->query('UPDATE products SET cgst="' . $product_cgst . '", sgst="' . $product_sgst . '", integrated_tax="' . $product_igst . '" WHERE id=' . $product_id);
        if ($product === TRUE) {
            return $id;
        } else {
            return FALSE;
        }
    }

    public function getProdcutsByCat($product_category_id) {
        $products_res = $this->conn->query('SELECT * FROM products WHERE is_deleted!="1" AND product_category_id="' . $product_category_id . '" ORDER BY id DESC');
        return $products_res;
    }

}

?>