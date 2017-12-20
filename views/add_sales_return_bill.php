<link rel="stylesheet" href="public/plugins/jQueryUI/jquery-ui.css">
<!-- daterange picker -->
<link rel="stylesheet" href="public/plugins/daterangepicker/daterangepicker.css">
<style>
    .loadinggif 
    {
        background:
            url('public/images/loader.gif')
            no-repeat
            right center;
    }

    .table-responsive { overflow-x: initial; }
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
                    <h3 class="box-title">Sales Voucher Details</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body party_detail_form">
                    <div class="form-group" id="sales_bill_error_div" style="display: none;">
                        <label for="sales_bill_error" class="col-sm-2 control-label" id="sales_bill_error"></label>
                    </div>
                    <div class="form-group">
                        <label for="party_id" class="col-sm-2 control-label" id="party_id_label">Select Party</label>
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
                            <span id="party_id_help_block" class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sales_invoice_no" class="col-sm-2 control-label">Sales Invoice No</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="sales_invoice_no" name="sales_invoice_no" placeholder="Sales Invoice No" value="<?php echo isset($_POST['sales_invoice_no']) ? $_POST['sales_invoice_no'] : ''; ?>">
                        </div>
                        <label for="sales_invoice_date_range" class="col-sm-2 control-label">Invoice Date Range</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control" id="sales_invoice_date_range" name="sales_invoice_date_range" placeholder="Invoice Date Range" value="<?php echo isset($_POST['sales_invoice_date_range']) ? $_POST['sales_invoice_date_range'] : ''; ?>">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-block btn-info" id="proceed_sales_bill">Search For Bill</button>
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
                            <select class="form-control" id="s_invoice_no" name="s_invoice_no">
                                <option value="">Select Invoice No</option>
                            </select>
                        </div>
                        <input type="hidden" id="sales_voucher_id" name="sales_voucher_id" value=""/>
                        <div class="col-sm-2">
                            <select class="form-control" id="product_id" name="product_id">
                                <option value="">Select Product</option>
                            </select>
                            <span id="product_id_help_block" class="help-block"></span>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="qty" name="qty" placeholder="Quantity" value="<?php echo isset($_POST['qty']) ? $_POST['qty'] : ''; ?>" min="1" max="5" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off">
                            <span id="qty_help_block" class="help-block"></span>
                        </div>
                        <input type="hidden" id="sales_qty" name="sales_qty" value=""/>
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
            <a type="button" class="btn btn-danger" href="?controller=salessereturn&action=getbills">
                <i class="fa fa-fw fa-arrow-circle-left"></i> Cancel
            </a>
            <button type="submit" id="save" class="btn btn-success pull-right">
                <i class="fa fa-credit-card"></i> Save
            </button>
        </div>
    </div>
</form>