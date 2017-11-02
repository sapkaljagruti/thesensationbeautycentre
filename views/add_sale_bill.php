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
                        <label for="ledger_name" class="col-sm-2 control-label">Sales Ledger</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="ledger_name" name="ledger_name" placeholder="Sale Ledger" value="" required="required">
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
                    <div class="form-group">
                        <label for="sale_type_id" class="col-sm-2 control-label">Sale Type</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="sale_type_id" name="sale_type_id">
                                <?php
                                if (isset($sale_types)) {
                                    $sale_type_selected = '';
                                    foreach ($sale_types as $sale_type) {
                                        if (isset($_POST['sale_type_id'])) {
                                            $sale_type_id = $_POST['sale_type_id'];
                                        } else {
                                            $sale_type_id = '';
                                        }
                                        if ($sale_type_id == $sale_type['id']) {
                                            $sale_type_selected = ' selected="selected"';
                                        } else {
                                            $sale_type_selected = '';
                                        }
                                        ?>
                                        <option value="<?php echo $sale_type['id']; ?>"<?php echo $sale_type_selected; ?>><?php echo $sale_type['title']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <label for="target_account" class="col-sm-2 control-label">Targer Account</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="target_account" name="target_account">
                                <option value="asha">Asha</option>
                                <option value="lakhan">Lakhan</option>
                            </select>
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
                    <h3 class="box-title">Party Details</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body party_detail_form">
                    <input type="hidden" id="party_id" name="party_id" value=""/>
                    <div class="form-group">
                        <label for="party_name" class="col-sm-2 control-label">Party Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="party_name" name="party_name" placeholder="Party Name" value="<?php echo isset($_POST['party_name']) ? $_POST['party_name'] : ''; ?>" required="required" onkeypress="return enterKeyEvent(event)">
                        </div>
                        <label for="party_contact_person" class="col-sm-2 control-label">Contact Person</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="party_contact_person" name="party_contact_person" placeholder="Contact Person" value="<?php echo isset($_POST['party_contact_person']) ? $_POST['party_contact_person'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="party_address" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" rows="3" placeholder="Address" id="party_address" name="party_address"><?php echo isset($_POST['party_address']) ? $_POST['party_address'] : ''; ?></textarea>
                        </div>
                        <label for="party_email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-4">
                            <input type="party_email" class="form-control" id="party_email" name="party_email" placeholder="Email" value="<?php echo isset($_POST['party_email']) ? $_POST['party_email'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="party_mobile1" class="col-sm-2 control-label">Mobile 1</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="party_mobile1" name="party_mobile1" placeholder="Enter Mobile No" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['party_mobile1']) ? $_POST['party_mobile1'] : ''; ?>">
                        </div>
                        <label for="party_mobile2" class="col-sm-2 control-label">Mobile 2</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="party_mobile2" name="party_mobile2" placeholder="Enter Mobile No" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['party_mobile2']) ? $_POST['party_mobile2'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="party_residence_no" class="col-sm-2 control-label">Residence No</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="party_residence_no" name="party_residence_no" placeholder="Enter Residence No" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['party_residence_no']) ? $_POST['party_residence_no'] : ''; ?>">
                        </div>
                        <label for="party_office_no" class="col-sm-2 control-label">Office No</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="party_office_no" name="party_office_no" placeholder="Enter Office Contact No" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" value="<?php echo isset($_POST['party_office_no']) ? $_POST['party_office_no'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="party_bank_name" class="col-sm-2 control-label">Bank Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="party_bank_name" name="party_bank_name" placeholder="Bank Name" value="<?php echo isset($_POST['party_bank_name']) ? $_POST['party_bank_name'] : ''; ?>">
                        </div>
                        <label for="party_bank_branch" class="col-sm-2 control-label">Bank Branch</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="party_bank_branch" name="party_bank_branch" placeholder="Bank Branch" value="<?php echo isset($_POST['party_bank_branch']) ? $_POST['party_bank_branch'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="party_ifsc_code" class="col-sm-2 control-label">IFSC Code</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="party_ifsc_code" name="party_ifsc_code" placeholder="Bank IFSC Code" value="<?php echo isset($_POST['party_ifsc_code']) ? $_POST['party_ifsc_code'] : ''; ?>">
                        </div>
                        <label for="party_bank_account_no" class="col-sm-2 control-label">Bank A/C No</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="party_bank_account_no" name="party_bank_account_no" placeholder="Bank A/C no" value="<?php echo isset($_POST['party_bank_account_no']) ? $_POST['party_bank_account_no'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="party_pan" class="col-sm-2 control-label" id="pan_label">PAN</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="party_pan" name="party_pan" placeholder="PAN" value="<?php echo isset($_POST['party_pan']) ? $_POST['party_pan'] : ''; ?>">
                            <span id="pan_help_block" class="help-block"></span>
                        </div>
                        <label for="party_gst_state_code_id" class="col-sm-2 control-label" id="state_label">State</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="party_gst_state_code_id" name="party_gst_state_code_id">
                                <option value="0">Select State</option>
                                <?php
                                if (isset($gst_states)) {
                                    foreach ($gst_states as $gst_state) {
                                        if (isset($_POST['party_gst_state_code_id'])) {
                                            $gst_state_code_id = $_POST['party_gst_state_code_id'];
                                        } else {
                                            $gst_state_code_id = '0';
                                        }
                                        if ($gst_state_code_id == $gst_state['state_code']) {
                                            $gst_state_selected = ' selected="selected"';
                                        } else {
                                            $gst_state_selected = '';
                                        }
                                        ?>
                                        <option value="<?php echo $gst_state['state_code']; ?>"<?php echo $gst_state_selected; ?>><?php echo $gst_state['state']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <span id="state_help_block" class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="party_gst_type_id" class="col-sm-2 control-label">GST Type</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="party_gst_type_id" name="party_gst_type_id">
                                <?php
                                if (isset($gst_types)) {
                                    foreach ($gst_types as $gst_type) {
                                        if (isset($_POST['party_gst_type_id'])) {
                                            $gst_type_id = $_POST['party_gst_type_id'];
                                        } else {
                                            $gst_type_id = '3';
                                        }
                                        if ($gst_type_id == $gst_type['id']) {
                                            $gst_type_selected = ' selected="selected"';
                                        } else {
                                            $gst_type_selected = '';
                                        }
                                        ?>
                                        <option value="<?php echo $gst_type['id']; ?>"<?php echo $gst_type_selected; ?>><?php echo $gst_type['title']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <label for="party_gstin" class="col-sm-2 control-label" id="gstin_label">GSTIN</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="party_gstin" name="party_gstin" placeholder="GSTIN" value="<?php echo isset($_POST['party_gstin']) ? $_POST['party_gstin'] : ''; ?>" maxlength="15" minlength="15" oncopy="return false;" onpaste="return false;" autocomplete="off">
                            <span id="gstin_help_block" class="help-block"></span>
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
                    <div class="row">
                        <div class="form-group">
                            <input type="hidden" name="product_id" id="product_id">
                            <input type="hidden" name="price" id="price">
                            <input type="hidden" name="cgst" id="cgst">
                            <input type="hidden" name="sgst" id="sgst">
                            <input type="hidden" name="igst" id="igst">
                            <label for="product_name" class="col-sm-2 control-label" id="product_name_label"> Product</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Product Name" value="<?php echo isset($_POST['product_name']) ? $_POST['product_name'] : ''; ?>" onkeypress="return productEnterKeyEvent(event)">
                                <span id="product_name_help_block" class="help-block"></span>
                            </div>
                            <label for="product_qty" class="col-sm-2 control-label" id="product_qty_label">Quantity</label>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="product_qty" name="product_qty" placeholder="Quantity" value="<?php echo isset($_POST['product_qty']) ? $_POST['product_qty'] : ''; ?>" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off">
                                    <span class="input-group-addon" id="product_qty_addon">Nos</span>
                                </div>
                                <span id="product_qty_help_block" class="help-block"></span>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-block btn-info" id="proceed_product"><i class="fa fa-plus"></i> Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="products_table_div">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="products_table" class="table table-bordered table-hover" role="grid" aria-describedby="products_table_info">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Rate Per Unit</th>
                                            <th>Price</th>
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
                                        </tr>
                                        <tr>
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
                                            <td style="text-align:right"><b>CGST:</b></td>
                                            <td id="cgst_td">0.00</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align:right"><b>SGST:</b></td>
                                            <td id="sgst_td">0.00</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align:right"><b>IGST:</b></td>
                                            <td id="igst_td">0.00</td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" style="text-align:right">Total:</th>
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
            <input type="hidden" id="total_cgst" name="total_cgst" value="0.00"/>
            <input type="hidden" id="total_sgst" name="total_sgst" value="0.00"/>
            <input type="hidden" id="total_igst" name="total_igst" value="0.00"/>
            <a type="button" class="btn btn-danger" href="?controller=sale&action=getbills">
                <i class="fa fa-fw fa-arrow-circle-left"></i> Cancel
            </a>
            <button type="submit" id="save" class="btn btn-success pull-right">
                <i class="fa fa-credit-card"></i> Save
            </button>
        </div>
    </div>
</form>