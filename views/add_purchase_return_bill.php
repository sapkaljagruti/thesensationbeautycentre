<style>
    #party_pan, #party_gstin {
        text-transform: uppercase;
    }
</style>
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

<link rel="stylesheet" href="public/plugins/jQueryUI/jquery-ui.css">
<style>
    .loadinggif 
    {
        background:
            url('public/images/loader.gif')
            no-repeat
            right center;
    }
</style>
<style>
    .table-responsive { overflow-x: initial; }
</style>
<!-- form start -->
<form class="form-horizontal" method="post">
    <input type="hidden" id="save_type" name="save_type" value="add"/>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Invoice Details</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <?php
                        $today = date('d-m-Y');
                        ?>
                        <label for="date" class="col-sm-2 control-label" id="date_label">Date</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="date" name="date" placeholder="Date" value="<?php echo isset($_POST['date']) ? $_POST['date'] : $today; ?>" required="required">
                            <span id="date_help_block" class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="invoice_no" class="col-sm-2 control-label" id="invoice_no_label">Invoice No</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="invoice_no" name="invoice_no" placeholder="Invoice No" value="<?php echo isset($_POST['invoice_no']) ? $_POST['invoice_no'] : ''; ?>" required="required">
                            <span id="invoice_no_help_block" class="help-block"></span>
                        </div>
                        <input type="hidden" id="valid_invoice_no" name="valid_invoice_no" value="0"/>
                        <label for="invoice_date" class="col-sm-2 control-label" id="invoice_date_label">Invoice Date</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="invoice_date" name="invoice_date" placeholder="Invoice Date" value="<?php echo isset($_POST['invoice_date']) ? $_POST['invoice_date'] : ''; ?>" required="required">
                            <span id="invoice_date_help_block" class="help-block"></span>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div id="overlay_invoice" class="overlay" style="display: none;">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Purchase Voucher Details</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body party_detail_form">
                    <div class="form-group">
                        <label for="party_id" class="col-sm-2 control-label">Select Party</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="party_id" name="party_id">
                                <option value="">Select Party</option>
                                <?php
                                if (isset($not_default_ledgers)) {
                                    foreach ($not_default_ledgers as $not_default_ledger) {
                                        if (isset($_POST['party_id'])) {
                                            $party_id = $_POST['party_id'];
                                        } else {
                                            $party_id = '0';
                                        }
                                        if ($party_id == $not_default_ledger['id']) {
                                            $party_selected = ' selected="selected"';
                                        } else {
                                            $party_selected = '';
                                        }
                                        ?>
                                        <option value="<?php echo $not_default_ledger['id']; ?>"<?php echo $party_selected; ?>><?php echo $not_default_ledger['name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="purchase_invoice_no" class="col-sm-2 control-label">Purchase Invoice No</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="purchase_invoice_no" name="purchase_invoice_no" placeholder="Purchase Invoice No" value="<?php echo isset($_POST['purchase_invoice_no']) ? $_POST['purchase_invoice_no'] : ''; ?>">
                        </div>
                        <label for="purchase_invoice_date_range" class="col-sm-2 control-label">Invoice Date Range</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="purchase_invoice_date_range" name="purchase_invoice_date_range" placeholder="Invoice Date Range" value="<?php echo isset($_POST['purchase_invoice_date_range']) ? $_POST['purchase_invoice_date_range'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-block btn-info" id="proceed_product">Search For Bill</button>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div id="overlay_party" class="overlay" style="display: none;">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- ./col -->
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Prodcut Details</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <div class="col-sm-2">
                            <select class="form-control" id="target_account_id" name="target_account_id">
                                <?php
                                if (isset($target_accounts)) {
                                    foreach ($target_accounts as $target_account) {
                                        ?>
                                        <option value="<?php echo $target_account['id']; ?>"><?php echo $target_account['name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Product Name" value="<?php echo isset($_POST['product_name']) ? $_POST['product_name'] : ''; ?>" onkeypress="return productEnterKeyEvent(event)">
                            <span id="product_name_help_block" class="help-block"></span>
                        </div>
                        <input type="hidden" name="product_id" id="product_id">
                        <input type="hidden" name="hsn_code" id="hsn_code">
                        <input type="hidden" name="qty1" id="qty1">
                        <input type="hidden" name="qty2" id="qty2">
                        <div class="col-sm-2">
                            <input type="text" class="form-control decimal" id="mrp" name="mrp" placeholder="MRP" value="<?php echo isset($_POST['mrp']) ? $_POST['mrp'] : ''; ?>" onkeypress="return allowOnlyNumberWithDecimal(event)" oncopy="return false;" onpaste="return false;" autocomplete="off">
                            <span id="mrp_help_block" class="help-block"></span>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="text" class="form-control" id="product_qty" name="product_qty" placeholder="Quantity" value="<?php echo isset($_POST['product_qty']) ? $_POST['product_qty'] : ''; ?>" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off">
                                <span class="input-group-addon" id="product_qty_addon">Nos</span>
                            </div>
                            <span id="product_qty_help_block" class="help-block"></span>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control decimal" id="price" name="price" placeholder="Product Price" value="<?php echo isset($_POST['price']) ? $_POST['price'] : ''; ?>" onkeypress="return allowOnlyNumberWithDecimal(event)" oncopy="return false;" onpaste="return false;" autocomplete="off">
                            <span id="price_help_block" class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="radio" name="discount" value="percentage" id="discount_percentage">
                                </span>
                                <input type="text" class="form-control decimal" id="discount_rate" name="discount_rate" placeholder="Discount Rate" value="<?php echo isset($_POST['discount_rate']) ? $_POST['discount_rate'] : ''; ?>" onkeypress="return allowOnlyNumberWithDecimal(event)" oncopy="return false;" onpaste="return false;" autocomplete="off">
                                <span class="input-group-addon" id="discount_rate_addon">%</span>
                            </div>
                            <span id="product_qty_help_block" class="help-block"></span>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="radio" name="discount" value="rs" id="discount_rs">
                                </span>
                                <input type="text" class="form-control decimal" id="discount_price" name="discount_price" placeholder="Discount Price" value="<?php echo isset($_POST['discount_price']) ? $_POST['discount_price'] : ''; ?>" onkeypress="return allowOnlyNumberWithDecimal(event)" oncopy="return false;" onpaste="return false;" autocomplete="off">
                                <span class="input-group-addon" id="discount_rate_addon">Rs</span>
                            </div>
                            <span id="product_qty_help_block" class="help-block"></span>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="text" class="form-control decimal" id="cgst" name="cgst" placeholder="CGST" value="<?php echo isset($_POST['cgst']) ? $_POST['cgst'] : ''; ?>" onkeypress="return allowOnlyNumberWithDecimal(event)" oncopy="return false;" onpaste="return false;" autocomplete="off">
                                <span class="input-group-addon" id="cgst_addon">%</span>
                            </div>
                            <span id="cgst_help_block" class="help-block"></span>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="text" class="form-control decimal" id="sgst" name="sgst" placeholder="SGST" value="<?php echo isset($_POST['sgst']) ? $_POST['sgst'] : ''; ?>" onkeypress="return allowOnlyNumberWithDecimal(event)" oncopy="return false;" onpaste="return false;" autocomplete="off">
                                <span class="input-group-addon" id="sgst_addon">%</span>
                            </div>
                            <span id="cgst_help_block" class="help-block"></span>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="text" class="form-control decimal" id="igst" name="igst" placeholder="IGST" value="<?php echo isset($_POST['igst']) ? $_POST['igst'] : ''; ?>" onkeypress="return allowOnlyNumberWithDecimal(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" disabled="disabled">
                                <span class="input-group-addon" id="igst_addon">%</span>
                            </div>
                            <span id="cgst_help_block" class="help-block"></span>
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-block btn-info" id="proceed_product"><i class="fa fa-plus"></i> Add</button>
                        </div>
                    </div>

                    <div class="row" id="products_table_div">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="products_table" class="table table-bordered table-hover" role="grid" aria-describedby="products_table_info">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Target Account</th>
                                            <th>Product</th>
                                            <th>HSN Code</th>
                                            <th>MRP</th>
                                            <th>Quantity</th>
                                            <th>Rate Per Unit</th>
                                            <th>Discount %</th>
                                            <th>Discount Rs</th>
                                            <th>CGST %</th>
                                            <th>CGST Rs</th>
                                            <th>SGST %</th>
                                            <th>SGST Rs</th>
                                            <th>IGST %</th>
                                            <th>IGST Rs</th>
                                            <th>Total Price</th>
                                            <th data-orderable="false">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" style="text-align:right">Total:</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div id="overlay_product" class="overlay" style="display: none;">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <textarea style="display: none;" name="products_data" id="products_data"></textarea>
            <a type="button" class="btn btn-danger" href="?controller=purchasereturn&action=getbills">
                <i class="fa fa-fw fa-arrow-circle-left"></i> Cancel
            </a>
            <button type="submit" id="save" class="btn btn-success pull-right">
                <i class="fa fa-credit-card"></i> Save
            </button>
        </div>
    </div>
</form>