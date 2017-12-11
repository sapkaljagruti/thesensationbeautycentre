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
                    <h3 class="box-title">Credit Note Details</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <label for="credit_note_no" class="col-sm-2 control-label" id="credit_note_no_label">Credit Note No</label>
                        <div class="col-sm-4" id="credit_note_no_label">
                            <input type="text" class="form-control" id="credit_note_no" name="credit_note_no" placeholder="Credit Note No" value="<?php echo isset($_POST['credit_note_no']) ? $_POST['credit_note_no'] : ''; ?>" required="required">
                            <span id="credit_note_no_help_block" class="help-block"></span>
                        </div>
                        <input type="hidden" id="valid_credit_note_no" name="valid_credit_note_no" value="0"/>
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
                        <label for="narration" class="col-sm-2 control-label">Narration</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" rows="3" placeholder="Narration" id="narration" name="narration"><?php echo isset($_POST['narration']) ? $_POST['narration'] : ''; ?></textarea>
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
                            <select class="form-control" id="party_id" name="party_id" required="required">
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
                        <label for="party_name" class="col-sm-2 control-label" id="party_name_label">Party A/C Name</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="party_name" name="party_name" placeholder="Party A/C Name" value="<?php echo isset($_POST['party_name']) ? $_POST['party_name'] : ''; ?>"  disabled="disabled">
                            <span id="party_name_help_block" class="help-block"></span>
                        </div>
                        <input type="hidden" id="is_valid_party_name" name="is_valid_party_name" value="<?php echo isset($_POST['is_valid_party_name']) ? $_POST['is_valid_party_name'] : '0'; ?>"/>
                        <label for="party_parent_id" class="col-sm-2 control-label">Under Group</label>
                        <div class="col-sm-2">
                            <select id="party_parent_id" name="party_parent_id" class="form-control" disabled="disabled">
                                <?php
                                if (isset($_POST['party_parent_id'])) {
                                    $parent_id = $_POST['party_parent_id'];
                                } else {
                                    $parent_id = '40';
                                }
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
                            <span id="group_parent"></span>
                        </div>
                        <label for="opening_balance" class="col-sm-2 control-label">Opening Balance</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control decimal" id="opening_balance" name="opening_balance" placeholder="0.00" onkeypress="return allowOnlyNumberWithDecimal(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['opening_balance']) ? $_POST['opening_balance'] : ''; ?>" disabled="disabled">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contact_person" class="col-sm-2 control-label">Contact Person</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Contact Person" value="<?php echo isset($_POST['contact_person']) ? $_POST['contact_person'] : ''; ?>" disabled="disabled">
                        </div>
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-4">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" disabled="disabled">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="area" class="col-sm-2 control-label">Area</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="area" name="area" placeholder="Area" value="<?php echo isset($_POST['area']) ? $_POST['area'] : ''; ?>" disabled="disabled">
                        </div>
                        <label for="city" class="col-sm-2 control-label">City</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="city" name="city" placeholder="City" value="<?php echo isset($_POST['city']) ? $_POST['city'] : ''; ?>" disabled="disabled">
                        </div>
                        <label for="pincode" class="col-sm-2 control-label">Pincode</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode" value="<?php echo isset($_POST['pincode']) ? $_POST['pincode'] : ''; ?>" disabled="disabled">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mobile1" class="col-sm-2 control-label">Mobile 1</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="mobile1" name="mobile1" placeholder="Enter Mobile No" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['mobile1']) ? $_POST['mobile1'] : ''; ?>" disabled="disabled">
                        </div>
                        <label for="mobile2" class="col-sm-2 control-label">Mobile 2</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="mobile2" name="mobile2" placeholder="Enter Mobile No" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['mobile2']) ? $_POST['mobile2'] : ''; ?>" disabled="disabled">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="party_bank_name" class="col-sm-2 control-label">Bank Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="party_bank_name" name="party_bank_name" placeholder="Bank Name" value="<?php echo isset($_POST['party_bank_name']) ? $_POST['party_bank_name'] : ''; ?>" disabled="disabled">
                        </div>
                        <label for="party_bank_branch" class="col-sm-2 control-label">Bank Branch</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="party_bank_branch" name="party_bank_branch" placeholder="Bank Branch" value="<?php echo isset($_POST['party_bank_branch']) ? $_POST['party_bank_branch'] : ''; ?>" disabled="disabled">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="party_ifsc_code" class="col-sm-2 control-label">IFSC Code</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="party_ifsc_code" name="party_ifsc_code" placeholder="Bank IFSC Code" value="<?php echo isset($_POST['party_ifsc_code']) ? $_POST['party_ifsc_code'] : ''; ?>" disabled="disabled">
                        </div>
                        <label for="party_bank_account_no" class="col-sm-2 control-label">Bank A/C No</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="party_bank_account_no" name="party_bank_account_no" placeholder="Bank A/C no" value="<?php echo isset($_POST['party_bank_account_no']) ? $_POST['party_bank_account_no'] : ''; ?>" disabled="disabled">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="party_pan" class="col-sm-2 control-label" id="pan_label">PAN</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="party_pan" name="party_pan" placeholder="PAN" value="<?php echo isset($_POST['party_pan']) ? $_POST['party_pan'] : ''; ?>" disabled="disabled">
                            <span id="pan_help_block" class="help-block"></span>
                        </div>
                        <label for="party_gst_state_code_id" class="col-sm-2 control-label" id="state_label">State</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="party_gst_state_code_id" name="party_gst_state_code_id" disabled="disabled">
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
                            <select class="form-control" id="party_gst_type_id" name="party_gst_type_id" disabled="disabled">
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
                            <input type="text" class="form-control" id="party_gstin" name="party_gstin" placeholder="GSTIN" value="<?php echo isset($_POST['party_gstin']) ? $_POST['party_gstin'] : ''; ?>" maxlength="15" minlength="15" oncopy="return false;" onpaste="return false;" autocomplete="off" disabled="disabled">
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
                    <h3 class="box-title">Particulars</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="form-group">
                            <input type="hidden" name="sales_ledger_id" id="sales_ledger_id">
                            <label for="ledger_name" class="col-sm-2 control-label" id="ledger_name_label"> Particular</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="ledger_name" name="ledger_name" placeholder="Sales Ledger Name" value="<?php echo isset($_POST['ledger_name']) ? $_POST['ledger_name'] : ''; ?>" onkeypress="return enterKeyEvent(event)">
                                <span id="ledger_name_help_block" class="help-block"></span>
                            </div>
                            <label for="amount" class="col-sm-2 control-label" id="amount_label">Amount</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control decimal" id="amount" name="amount" placeholder="Amount" value="<?php echo isset($_POST['amount']) ? $_POST['amount'] : ''; ?>" onkeypress="return allowOnlyNumberWithDecimal(event)" oncopy="return false;" onpaste="return false;" autocomplete="off">
                                <span id="amount_help_block" class="help-block"></span>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-block btn-info" id="proceed_particular"><i class="fa fa-plus"></i> Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="particulars_table_div">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="particulars_table" class="table table-bordered table-hover" role="grid" aria-describedby="particulars_table_info">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Particular</th>
                                            <th>Amount</th>
                                            <th data-orderable="false">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" style="text-align:right">Total:</th>
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
            <div id="overlay_particular" class="overlay" style="display: none;">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <textarea style="display: none;" name="sales_invoice_data" id="sales_invoice_data"></textarea>
        <a type="button" class="btn btn-danger" href="?controller=creditnotes&action=getall">
            <i class="fa fa-fw fa-arrow-circle-left"></i> Cancel
        </a>
        <button type="submit" id="save" class="btn btn-success pull-right">
            <i class="fa fa-credit-card"></i> Save
        </button>
    </div>
</div>
</form>