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
?>

<style>
    .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
        border: 1px solid black;
    }
    .table-bordered {
        border: 1px solid black;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Product Details</h3>
                <!--<a href="?controller=customer&action=getCustomers" class="btn btn-danger pull-right">&times;</a>-->
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" id="product_form">
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
                                            if (isset($_POST['product_category_id'])) {
                                                $product_category_id = $_POST['account_group_id'];
                                                if ($product_category_id == $product_category['id']) {
                                                    $category_selected = ' selected="selected"';
                                                } else {
                                                    $category_selected = '';
                                                }
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
                                            if (isset($_POST['brand_id'])) {
                                                $brand_id = $_POST['brand_id'];
                                                if ($brand_id == $brand['id']) {
                                                    $brand_selected = ' selected="selected"';
                                                } else {
                                                    $brand_selected = '';
                                                }
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
                            <input type="text" class="form-control" id="product_code" name="product_code" placeholder="Product Code" value="<?php echo isset($_POST['product_code']) ? $_POST['product_code'] : ''; ?>">
                        </div>
                        <label for="name" class="col-sm-2 control-label">Product Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" rows="3" placeholder="Description" id="description" name="description"><?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="qty" class="col-sm-2 control-label">Quantity</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="qty" name="qty" placeholder="Total Items" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['qty']) ? $_POST['qty'] : ''; ?>">
                        </div>
                        <label for="price" class="col-sm-2 control-label">Rate Per No</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="price" name="price" placeholder="0.00" onkeypress="return allowOnlyNumberWithDecimal(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['price']) ? $_POST['price'] : ''; ?>">
                        </div>
                    </div>
                    <hr> <h4> GST Details </h5> <hr>
                        <div class="form-group">
                            <label for="hsn_code" class="col-sm-2 control-label">HSN/SAC Code</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="hsn_code" name="hsn_code" placeholder="HSN/SAC Code" value="<?php echo isset($_POST['hsn_code']) ? $_POST['hsn_code'] : ''; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <?php
                            $on_value_selected = ' selected="selected"';
                            $on_item_rate_selected = '';
                            if (isset($_POST['calculation_type'])) {
                                if ($_POST['calculation_type'] == 'on_value') {
                                    $on_value_selected = ' selected="selected"';
                                    $on_item_rate_selected = '';
                                } else {
                                    $on_value_selected = '';
                                    $on_item_rate_selected = ' selected="selected"';
                                }
                            }
                            ?>
                            <label for="calculation_type" class="col-sm-2 control-label">Calculation Type</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="calculation_type" name="calculation_type">
                                    <option value="on_item_rate"<?php echo $on_item_rate_selected; ?>>On Item Rate</option>
                                    <option value="on_value"<?php echo $on_value_selected; ?>>On Value</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" id="item_rates_div" style="display: none;">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="item_rates_table">
                                        <thead>
                                            <tr>
                                                <th colspan="2" style="text-align: center;">Rate</th>
                                                <th>Tax Type</th>
                                                <th>Integrated Tax Rate</th>
                                                <th colspan="2" style="text-align: center;">Cess</th>
                                            </tr>
                                            <tr>
                                                <th width='150px' style="font-weight: normal;">Grater Than</th>
                                                <th width='150px' style="font-weight: normal;">Upto</th>
                                                <th colspan="2" style="font-weight: normal;"></th>
                                                <th style="font-weight: normal;">Valuation Type</th>
                                                <th style="font-weight: normal;">Rate</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="text" class="form-control greater_than first_item_rate" id="" name="greater_than[]" value="0" readonly="readonly" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off"/></td>
                                                <td><input type="text" class="form-control upto" id="" name="upto[]" value="" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off"/></td>
                                                <td>
                                                    <select class="form-control tax_type" id="" name="tax_type[]">
                                                        <option value="exempt">Exempt</option>
                                                        <option value="nil_rated">Nil Rated</option>
                                                        <option value="taxable" selected="selected">Taxable</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control integrated_tax" id="" name="integrated_tax_on_item_rate[]" value="" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off"/>
                                                        <span class="input-group-addon">%</span>
                                                    </div>
                                                </td>
                                                <td><input type="text" class="form-control" id="" name="" value="Based On Value" readonly="readonly"/></td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control cess" id="" name="cess_on_item_rate[]" value="" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off"/>
                                                        <span class="input-group-addon">%</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php
                            $taxable_selected = ' selected="selected"';
                            $exempt_selected = '';
                            $nil_rated_selected = '';
                            if (isset($_POST['taxability'])) {
                                if ($_POST['taxability'] == 'exempt') {
                                    $exempt_selected = ' selected="selected"';
                                    $taxable_selected = '';
                                    $nil_rated_selected = '';
                                } else if ($_POST['taxability'] == 'nil_rated') {
                                    $nil_rated_selected = ' selected="selected"';
                                    $exempt_selected = '';
                                    $taxable_selected = '';
                                } else {
                                    $taxable_selected = ' selected="selected"';
                                    $exempt_selected = '';
                                    $nil_rated_selected = '';
                                }
                            }
                            ?>
                            <label for="taxability" class="col-sm-2 control-label">Taxability</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="taxability" name="taxability">
                                    <option value="exempt"<?php echo $exempt_selected; ?>>Exempt</option>
                                    <option value="nil_rated"<?php echo $nil_rated_selected; ?>>Nil Rated</option>
                                    <option value="taxable"<?php echo $taxable_selected; ?>>Taxable</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="integrated_tax" class="col-sm-2 control-label">Integrated Tax</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="integrated_tax" name="integrated_tax" placeholder="0.00" onkeypress="return allowOnlyNumberWithDecimal(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['integrated_tax']) ? $_POST['integrated_tax'] : ''; ?>">
                                <span style="margin-top: -27px; float: right; margin-right: -20px;">%</span>
                            </div>
                            <label for="cess" class="col-sm-2 control-label">Cess</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="cess" name="cess" placeholder="0.00" onkeypress="return allowOnlyNumberWithDecimal(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['cess']) ? $_POST['cess'] : ''; ?>">
                                <span style="margin-top: -27px; float: right; margin-right: -20px;">%</span>
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