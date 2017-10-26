<?php
if (isset($errors)) {
    ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
        <ul>
            <?php
            foreach ($errors as $error) {
                echo "<li>" . $error . "</li>";
            }
            ?>
        </ul>
    </div>
    <?php
}
if (isset($product_details)) {
    if (!empty($product_details)) {
        foreach ($product_details as $product) {
            $id = $product['id'];
            $product_category_id = isset($_POST['product_category_id']) ? $_POST['product_category_id'] : $product['product_category_id'];
            $brand_id = isset($_POST['brand_id']) ? $_POST['brand_id'] : $product['brand_id'];
            $product_code = isset($_POST['product_code']) ? $_POST['product_code'] : $product['product_code'];
            $name = isset($_POST['name']) ? $_POST['name'] : $product['name'];
            $hsn_code = isset($_POST['hsn_code']) ? $_POST['hsn_code'] : $product['hsn_code'];
            $qty = isset($_POST['qty']) ? $_POST['qty'] : $product['qty'];
            $price = isset($_POST['price']) ? $_POST['price'] : $product['price'];
            $input_tax = isset($_POST['input_tax']) ? $_POST['input_tax'] : $product['input_tax'];
            $output_tax = isset($_POST['output_tax']) ? $_POST['output_tax'] : $product['output_tax'];
            $description = isset($_POST['description']) ? $_POST['description'] : $product['description'];
            ?>
            <div class="row">
                <div class="col-md-12">
                    <!-- Horizontal Form -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Detail Form</h3>
                            <!--<a href="?controller=customer&action=getCustomers" class="btn btn-danger pull-right">&times;</a>-->
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal" method="post">
                            <input type="hidden" id="id" name="id" value=""<?php echo $id; ?>/>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="product_category_id" class="col-sm-2 control-label">Product Category</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="product_category_id" name="product_category_id" required="required">
                                            <?php
                                            if (isset($product_categories)) {
                                                $category_selected = '';
                                                if (count($product_categories) > 0) {
                                                    foreach ($product_categories as $product_category) {
                                                        if ($product_category_id == $product_category['id']) {
                                                            $category_selected = ' selected="selected"';
                                                        } else {
                                                            $category_selected = '';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $product_category['id']; ?>"<?php echo $category_selected; ?>><?php echo ucwords($product_category['name']); ?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <label for="brand_id" class="col-sm-2 control-label">Brand</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="brand_id" name="brand_id" required="required">
                                            <?php
                                            if (isset($brands)) {
                                                $brand_selected = '';
                                                if (count($brands) > 0) {
                                                    foreach ($brands as $brand) {
                                                        if ($brand_id == $brand['id']) {
                                                            $brand_selected = ' selected="selected"';
                                                        } else {
                                                            $brand_selected = '';
                                                        }
                                                        ?>
                                                        <option value="<?php echo $brand['id']; ?>"<?php echo $brand_selected; ?>><?php echo ucwords($brand['name']); ?></option>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="product_code" class="col-sm-2 control-label">Product Code</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="product_code" name="product_code" placeholder="Product Code" value="<?php echo $product_code; ?>">
                                    </div>
                                    <label for="name" class="col-sm-2 control-label">Product Name</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo $name; ?>" required="required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="hsn_code" class="col-sm-2 control-label">HSN/SAC Code</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="hsn_code" name="hsn_code" placeholder="HSN/SAC Code" value="<?php echo $hsn_code; ?>">
                                    </div>
                                    <label for="qty" class="col-sm-2 control-label">Quantity</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="qty" name="qty" placeholder="Total Items" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo $qty; ?>">
                                    </div>
                                    <label for="price" class="col-sm-2 control-label">Rate Per No</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="price" name="price" placeholder="0.00" onkeypress="return allowOnlyNumberWithDecimal(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo $price; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input_tax" class="col-sm-2 control-label">Input Tax</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="input_tax" name="input_tax" placeholder="0.00" onkeypress="return allowOnlyNumberWithDecimal(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo $input_tax; ?>">
                                        <span style="margin-top: -27px; float: right; margin-right: -20px;">%</span>
                                    </div>
                                    <label for="output_tax" class="col-sm-2 control-label">Output Tax</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="output_tax" name="output_tax" placeholder="0.00" onkeypress="return allowOnlyNumberWithDecimal(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo $output_tax; ?>">
                                        <span style="margin-top: -27px; float: right; margin-right: -20px;">%</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description" class="col-sm-2 control-label">Description</label>
                                    <div class="col-sm-4">
                                        <textarea class="form-control" rows="3" placeholder="Description" id="description" name="description"><?php echo $description; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="form-group">
                                    <div class="col-sm-10 pull-right">
                                        <button type="submit" class="btn btn-success">Save</button>
                                        <a href="?controller=product&action=getproducts" type="button" class="btn btn-default">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <?php
        }
    }
}
?>