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
<?php
if (isset($purchase_voucher_data)) {
    if (!empty($purchase_voucher_data)) {
        foreach ($purchase_voucher_data as $purchase_voucher) {
            $id = $purchase_voucher['id'];

            $date = isset($_POST['date']) ? $_POST['date'] : date_format(date_create($purchase_voucher['date']), 'd-m-Y');
            $purchase_ledger_id = isset($_POST['purchase_ledger_id']) ? $_POST['purchase_ledger_id'] : $purchase_voucher['purchase_ledger_id'];
            $invoice_no = isset($_POST['invoice_no']) ? $_POST['invoice_no'] : $purchase_voucher['invoice_no'];
            $invoice_date = isset($_POST['invoice_date']) ? $_POST['invoice_date'] : date_format(date_create($purchase_voucher['invoice_date']), 'd-m-Y');
            $purchase_type_id = isset($_POST['purchase_type_id']) ? $_POST['purchase_type_id'] : $purchase_voucher['purchase_type_id'];
            $party_id = isset($_POST['party_id']) ? $_POST['party_id'] : $purchase_voucher['party_id'];
            $party_name = isset($_POST['party_name']) ? $_POST['party_name'] : $purchase_voucher['party_name'];
            $parent_id = isset($_POST['party_parent_id']) ? $_POST['party_parent_id'] : $purchase_voucher['party_parent_id'];
            $opening_balance = isset($_POST['opening_balance']) ? $_POST['opening_balance'] : $purchase_voucher['opening_balance'];
            $contact_person = isset($_POST['contact_person']) ? $_POST['contact_person'] : $purchase_voucher['contact_person'];
            $email = isset($_POST['email']) ? $_POST['email'] : $purchase_voucher['email'];
            $area = isset($_POST['area']) ? $_POST['area'] : $purchase_voucher['area'];
            $city = isset($_POST['city']) ? $_POST['city'] : $purchase_voucher['city'];
            $pincode = isset($_POST['pincode']) ? $_POST['pincode'] : $purchase_voucher['pincode'];
            $mobile1 = isset($_POST['mobile1']) ? $_POST['mobile1'] : $purchase_voucher['mobile1'];
            $mobile2 = isset($_POST['mobile2']) ? $_POST['mobile2'] : $purchase_voucher['mobile2'];
            $party_bank_name = isset($_POST['party_bank_name']) ? $_POST['party_bank_name'] : $purchase_voucher['party_bank_name'];
            $party_bank_branch = isset($_POST['party_bank_branch']) ? $_POST['party_bank_branch'] : $purchase_voucher['party_bank_branch'];
            $party_ifsc_code = isset($_POST['party_ifsc_code']) ? $_POST['party_ifsc_code'] : $purchase_voucher['party_ifsc_code'];
            $party_bank_account_no = isset($_POST['party_bank_account_no']) ? $_POST['party_bank_account_no'] : $purchase_voucher['party_bank_account_no'];
            $party_pan = isset($_POST['party_pan']) ? $_POST['party_pan'] : $purchase_voucher['party_pan'];
            $party_gst_state_code_id = isset($_POST['party_gst_state_code_id']) ? $_POST['party_gst_state_code_id'] : $purchase_voucher['party_gst_state_code_id'];
            $party_gst_type_id = isset($_POST['party_gst_type_id']) ? $_POST['party_gst_type_id'] : $purchase_voucher['party_gst_type_id'];
            $party_gstin = isset($_POST['party_gstin']) ? $_POST['party_gstin'] : $purchase_voucher['party_gstin'];
            ?>
            <form class="form-horizontal" method="post">
                <input type="hidden" id="save_type" name="save_type" value="edit"/>
                <input type="hidden" id="id" name="id" value="<?php echo $id; ?>"/>
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
                                    <label for="date" class="col-sm-2 control-label" id="date_label">Date</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="date" name="date" placeholder="Date" value="<?php echo isset($_POST['date']) ? $_POST['date'] : $date; ?>" required="required">
                                        <span id="date_help_block" class="help-block"></span>
                                    </div>
                                    <label for="purchase_ledger_id" class="col-sm-2 control-label">Purchase Account</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="purchase_ledger_id" name="purchase_ledger_id" required="required">
                                            <option value="">Select Purchase Account</option>
                                            <?php
                                            if (isset($purchase_ledgers)) {
                                                $purchase_ledger_selected = '';
                                                foreach ($purchase_ledgers as $purchase_ledger) {
                                                    if ($purchase_ledger_id == $purchase_ledger['id']) {
                                                        $purchase_ledger_selected = ' selected="selected"';
                                                    } else {
                                                        $purchase_ledger_selected = '';
                                                    }
                                                    ?>
                                                    <option value="<?php echo $purchase_ledger['id']; ?>"<?php echo $purchase_ledger_selected; ?>><?php echo $purchase_ledger['name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="invoice_no" class="col-sm-2 control-label" id="invoice_no_label">Invoice No</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="invoice_no" name="invoice_no" placeholder="Invoice No" value="<?php echo $invoice_no; ?>" required="required">
                                        <span id="invoice_no_help_block" class="help-block"></span>
                                    </div>
                                    <input type="hidden" id="valid_invoice_no" name="valid_invoice_no" value="<?php echo isset($_POST['valid_invoice_no']) ? $_POST['valid_invoice_no'] : '1'; ?>"/>
                                    <label for="invoice_date" class="col-sm-2 control-label" id="invoice_date_label">Invoice Date</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="invoice_date" name="invoice_date" placeholder="Invoice Date" value="<?php echo $invoice_date; ?>" required="required">
                                        <span id="invoice_date_help_block" class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="purchase_type_id" class="col-sm-2 control-label">Purchase Type</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="purchase_type_id" name="purchase_type_id">
                                            <?php
                                            if (isset($purchase_types)) {
                                                $purchase_type_selected = '';
                                                foreach ($purchase_types as $purchase_type) {
                                                    if ($purchase_type_id == $purchase_type['id']) {
                                                        $purchase_type_selected = ' selected="selected"';
                                                    } else {
                                                        $purchase_type_selected = '';
                                                    }
                                                    ?>
                                                    <option value="<?php echo $purchase_type['id']; ?>"<?php echo $purchase_type_selected; ?>><?php echo $purchase_type['title']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
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
                                <div class="form-group">
                                    <label for="party_id" class="col-sm-2 control-label">Select Party</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="party_id" name="party_id">
                                            <option value="">Select Party</option>
                                            <?php
                                            if (isset($not_default_ledgers)) {
                                                foreach ($not_default_ledgers as $not_default_ledger) {
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
                                    <label for="party_name" class="col-sm-2 control-label" id="party_name_label">Party A/C Name</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="party_name" name="party_name" placeholder="Party A/C Name" value="<?php echo $party_name; ?>"  required="required" disabled="disabled">
                                        <span id="party_name_help_block" class="help-block"></span>
                                    </div>
                                    <input type="hidden" id="is_valid_party_name" name="is_valid_party_name" value="<?php echo isset($_POST['is_valid_party_name']) ? $_POST['is_valid_party_name'] : '1'; ?>"/>
                                    <label for="party_parent_id" class="col-sm-2 control-label">Under Group</label>
                                    <div class="col-sm-2">
                                        <select id="party_parent_id" name="party_parent_id" class="form-control" required="required" disabled="disabled">
                                            <?php
                                            if ($parent_id == '') {
                                                $default_parent_id_selected = ' selected="selected"';
                                            } else {
                                                $default_parent_id_selected = '';
                                            }
                                            ?>
                                            <option value=""<?php echo $default_parent_id_selected; ?> data-parent-id="0">Select group</option>
                                            <?php
                                            if (isset($account_groups)) {
                                                foreach ($account_groups as $account_group) {
                                                    if ($parent_id != '' && $parent_id == $account_group['id']) {
                                                        $parent_id_selected = ' selected="selected"';
                                                    } else {
                                                        $parent_id_selected = '';
                                                    }
                                                    ?>
                                                    <option value="<?php echo $account_group['id']; ?>" data-parent-id="<?php echo $account_group['parent_id']; ?>"<?php echo $parent_id_selected; ?>><?php echo $account_group['name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <span id="group_parent"><?php echo $purchase_voucher['group_parent']; ?></span>
                                    </div>
                                    <label for="opening_balance" class="col-sm-2 control-label">Opening Balance</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control decimal" id="opening_balance" name="opening_balance" placeholder="0.00" onkeypress="return allowOnlyNumberWithDecimal(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo $opening_balance; ?>" disabled="disabled">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="contact_person" class="col-sm-2 control-label">Contact Person</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Contact Person" value="<?php echo $contact_person; ?>" disabled="disabled">
                                    </div>
                                    <label for="email" class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-4">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>" disabled="disabled">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="area" class="col-sm-2 control-label">Area</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="area" name="area" placeholder="Area" value="<?php echo $area; ?>" disabled="disabled">
                                    </div>
                                    <label for="city" class="col-sm-2 control-label">City</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="city" name="city" placeholder="City" value="<?php echo $city; ?>" disabled="disabled">
                                    </div>
                                    <label for="pincode" class="col-sm-2 control-label">Pincode</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode" value="<?php echo $pincode; ?>" disabled="disabled">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="mobile1" class="col-sm-2 control-label">Mobile 1</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="mobile1" name="mobile1" placeholder="Enter Mobile No" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo $mobile1; ?>" disabled="disabled">
                                    </div>
                                    <label for="mobile2" class="col-sm-2 control-label">Mobile 2</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="mobile2" name="mobile2" placeholder="Enter Mobile No" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo $mobile2; ?>" disabled="disabled">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="party_bank_name" class="col-sm-2 control-label">Bank Name</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="party_bank_name" name="party_bank_name" placeholder="Bank Name" value="<?php echo $party_bank_name; ?>" disabled="disabled">
                                    </div>
                                    <label for="party_bank_branch" class="col-sm-2 control-label">Bank Branch</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="party_bank_branch" name="party_bank_branch" placeholder="Bank Branch" value="<?php echo $party_bank_branch; ?>" disabled="disabled">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="party_ifsc_code" class="col-sm-2 control-label">IFSC Code</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="party_ifsc_code" name="party_ifsc_code" placeholder="Bank IFSC Code" value="<?php echo $party_ifsc_code; ?>" disabled="disabled">
                                    </div>
                                    <label for="party_bank_account_no" class="col-sm-2 control-label">Bank A/C No</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="party_bank_account_no" name="party_bank_account_no" placeholder="Bank A/C no" value="<?php echo $party_bank_account_no; ?>" disabled="disabled">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="party_pan" class="col-sm-2 control-label" id="pan_label">PAN</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="party_pan" name="party_pan" placeholder="PAN" value="<?php echo $party_pan; ?>" disabled="disabled">
                                        <span id="pan_help_block" class="help-block"></span>
                                    </div>
                                    <label for="party_gst_state_code_id" class="col-sm-2 control-label" id="state_label">State</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="party_gst_state_code_id" name="party_gst_state_code_id" disabled="disabled">
                                            <option value="0">Select State</option>
                                            <?php
                                            if (isset($gst_states)) {
                                                foreach ($gst_states as $gst_state) {
                                                    if ($party_gst_state_code_id == $gst_state['state_code']) {
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
                                        <select class="form-control" id="party_gst_type_id" name="party_gst_type_id" disabled="disabled">
                                            <?php
                                            if (isset($gst_types)) {
                                                foreach ($gst_types as $gst_type) {
                                                    if ($party_gst_type_id == $gst_type['id']) {
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
                                        <input type="text" class="form-control" id="party_gstin" name="party_gstin" placeholder="GSTIN" value="<?php echo $party_gstin; ?>" maxlength="15" minlength="15" oncopy="return false;" onpaste="return false;" autocomplete="off" disabled="disabled">
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
                                                    <?php
                                                    $products_data = $purchase_voucher['products_data'];
                                                    $products_data_arr = explode(',', $products_data);

                                                    foreach ($products_data_arr as $product) {
                                                        $product_arr = explode('_', $product);
                                                        $product_id = $product_arr[0];
                                                        $target_account_id = $product_arr[1];

                                                        if (isset($target_accounts)) {
                                                            foreach ($target_accounts as $target_account) {
                                                                if ($target_account_id == $target_account['id']) {
                                                                    $target_account_name = $target_account['name'];
                                                                }
                                                            }
                                                        }

                                                        $product_name = $product_arr[2];
                                                        $hsn_code = $product_arr[3];
                                                        $mrp = $product_arr[4];
                                                        $qty = $product_arr[5];
                                                        $final_updated_qty = $product_arr[6];
                                                        $price = $product_arr[7];
                                                        $discount_percentage = $product_arr[8];
                                                        $discount_rs = $product_arr[9];
                                                        $cgst_percentage = $product_arr[10];
                                                        $cgst_rs = $product_arr[11];
                                                        $sgst_percentage = $product_arr[12];
                                                        $sgst_rs = $product_arr[13];
                                                        $igst_percentage = $product_arr[14];
                                                        $igst_rs = $product_arr[15];
                                                        $total_amount = $product_arr[16];
                                                        ?>
                                                        <tr id="tr_<?php echo $product_id; ?>" data-id="<?php echo $product_id; ?>" data-tid="<?php echo $target_account_id; ?>" data-name="<?php echo $product_name; ?>" data-hcode="<?php echo $hsn_code; ?>" data-mrp="<?php echo $mrp; ?>" data-qty="<?php echo $qty; ?>" data-finalQty="<?php echo $final_updated_qty; ?>" data-price="<?php echo $price; ?>" data-dper="<?php echo $discount_percentage; ?>" data-drs="<?php echo $discount_rs; ?>" data-cgstper="<?php echo $cgst_percentage; ?>" data-cgstrs="<?php echo $cgst_rs; ?>" data-sgstper="<?php echo $sgst_percentage; ?>" data-sgstrs="<?php echo $sgst_rs; ?>" data-igstper="<?php echo $igst_percentage; ?>" data-igstrs="<?php echo $igst_rs; ?>" data-total="<?php echo $total_amount; ?>" class="products">
                                                            <td><?php echo $product_id; ?></td>
                                                            <td><?php echo ucwords($target_account_name); ?></td>
                                                            <td><?php echo $product_name; ?></td>
                                                            <td><?php echo $hsn_code; ?></td>
                                                            <td><?php echo $mrp; ?></td>
                                                            <td><?php echo $qty; ?></td>
                                                            <td><?php echo $price; ?></td>
                                                            <td><?php echo $discount_percentage; ?></td>
                                                            <td><?php echo $discount_rs; ?></td>
                                                            <td><?php echo $cgst_percentage; ?></td>
                                                            <td><?php echo $cgst_rs; ?></td>
                                                            <td><?php echo $sgst_percentage; ?></td>
                                                            <td><?php echo $sgst_rs; ?></td>
                                                            <td><?php echo $igst_percentage; ?></td>
                                                            <td><?php echo $igst_rs; ?></td>
                                                            <td><?php echo $total_amount; ?></td>
                                                            <td><a href="" class="delete_product" data-id="<?php echo $product_id; ?>"> <i class="fa fa-fw fa-trash"></i></a></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
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
                        <a type="button" class="btn btn-danger" href="?controller=purchase&action=getbills">
                            <i class="fa fa-fw fa-arrow-circle-left"></i> Cancel
                        </a>
                        <button type="submit" id="save" class="btn btn-success pull-right">
                            <i class="fa fa-credit-card"></i> Save
                        </button>
                    </div>
                </div>
            </form>
            <?php
        }
    }
}
?>