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
                    <h3 class="box-title">Debit Note Details</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <label for="debit_note_no" class="col-sm-2 control-label" id="debit_note_no_label">Debit Note No</label>
                        <div class="col-sm-4" id="debit_note_no_label">
                            <input type="text" class="form-control" id="debit_note_no" name="debit_note_no" placeholder="Debit Note No" value="<?php echo isset($_POST['debit_note_no']) ? $_POST['debit_note_no'] : ''; ?>" required="required">
                            <span id="debit_note_no_help_block" class="help-block"></span>
                        </div>
                        <input type="hidden" id="valid_debit_note_no" name="valid_debit_note_no" value="0"/>
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
                        <label for="party_name" class="col-sm-2 control-label">Party Name</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="party_id" name="party_id" required="party_id">
                                <option value="">Select Party</option>
                                <?php
                                if (isset($parties)) {
                                    foreach ($parties as $party) {
                                        if (isset($_POST['party_id'])) {
                                            $party_id = $_POST['party_id'];
                                        } else {
                                            $party_id = '0';
                                        }
                                        if ($party_id == $party['party_id']) {
                                            $party_selected = ' selected="selected"';
                                        } else {
                                            $party_selected = '';
                                        }
                                        ?>
                                        <option value="<?php echo $party['id']; ?>"<?php echo $party_selected; ?>><?php echo $party['name']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <label for="party_contact_person" class="col-sm-2 control-label">Contact Person</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="party_contact_person" name="party_contact_person" placeholder="Contact Person" value="<?php echo isset($_POST['party_contact_person']) ? $_POST['party_contact_person'] : ''; ?>" disabled="disabled">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="party_address" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" rows="3" placeholder="Address" id="party_address" name="party_address" disabled="disabled"><?php echo isset($_POST['party_address']) ? $_POST['party_address'] : ''; ?></textarea>
                        </div>
                        <label for="party_email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-4">
                            <input type="party_email" class="form-control" id="party_email" name="party_email" placeholder="Email" value="<?php echo isset($_POST['party_email']) ? $_POST['party_email'] : ''; ?>" disabled="disabled">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="party_mobile1" class="col-sm-2 control-label">Mobile 1</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="party_mobile1" name="party_mobile1" placeholder="Enter Mobile No" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['party_mobile1']) ? $_POST['party_mobile1'] : ''; ?>" disabled="disabled">
                        </div>
                        <label for="party_mobile2" class="col-sm-2 control-label">Mobile 2</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="party_mobile2" name="party_mobile2" placeholder="Enter Mobile No" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['party_mobile2']) ? $_POST['party_mobile2'] : ''; ?>" disabled="disabled">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="party_residence_no" class="col-sm-2 control-label">Residence No</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="party_residence_no" name="party_residence_no" placeholder="Enter Residence No" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['party_residence_no']) ? $_POST['party_residence_no'] : ''; ?>" disabled="disabled">
                        </div>
                        <label for="party_office_no" class="col-sm-2 control-label">Office No</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="party_office_no" name="party_office_no" placeholder="Enter Office Contact No" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" value="<?php echo isset($_POST['party_office_no']) ? $_POST['party_office_no'] : ''; ?>" disabled="disabled">
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
                            <input type="hidden" name="purchase_voucher_id" id="purchase_voucher_id">
                            <input type="hidden" name="purchase_party_id" id="purchase_party_id">
                            <label for="ledger_name" class="col-sm-2 control-label" id="ledger_name_label"> Particular</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="ledger_name" name="ledger_name" placeholder="Purchase Ledger Name" value="<?php echo isset($_POST['ledger_name']) ? $_POST['ledger_name'] : ''; ?>" onkeypress="return enterKeyEvent(event)">
                                <span id="ledger_name_help_block" class="help-block"></span>
                            </div>
                            <label for="amount" class="col-sm-2 control-label" id="amount_label">Amount</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount" value="<?php echo isset($_POST['amount']) ? $_POST['amount'] : ''; ?>" onkeypress="return allowOnlyNumberWithDecimal(event)" oncopy="return false;" onpaste="return false;" autocomplete="off">
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
        <textarea style="display: none;" name="purchase_invoice_data" id="purchase_invoice_data"></textarea>
        <a type="button" class="btn btn-danger" href="?controller=debitnotes&action=getall">
            <i class="fa fa-fw fa-arrow-circle-left"></i> Cancel
        </a>
        <button type="submit" id="save" class="btn btn-success pull-right">
            <i class="fa fa-credit-card"></i> Save
        </button>
    </div>
</div>
</form>