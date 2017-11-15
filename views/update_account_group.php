<style>
    #pan, #gstin {
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
if (isset($account_group_details)) {
    if (!empty($account_group_details)) {
        foreach ($account_group_details as $account_group_detail) {
            $id = $account_group_detail['id'];
            $name = isset($_POST['name']) ? $_POST['name'] : $account_group_detail['name'];
            $parent_id = isset($_POST['parent_id']) ? $_POST['parent_id'] : $account_group_detail['parent_id'];
            $opening_balance = isset($_POST['opening_balance']) ? $_POST['opening_balance'] : $account_group_detail['opening_balance'];
            $contact_person = isset($_POST['contact_person']) ? $_POST['contact_person'] : $account_group_detail['contact_person'];
            $area = isset($_POST['area']) ? $_POST['area'] : $account_group_detail['area'];
            $city = isset($_POST['city']) ? $_POST['city'] : $account_group_detail['city'];
            $pincode = isset($_POST['pincode']) ? $_POST['pincode'] : $account_group_detail['pincode'];
            $gst_state_code_id = isset($_POST['gst_state_code_id']) ? $_POST['gst_state_code_id'] : $account_group_detail['gst_state_code_id'];
            $email = isset($_POST['email']) ? $_POST['email'] : $account_group_detail['email'];
            $mobile1 = isset($_POST['mobile1']) ? $_POST['mobile1'] : $account_group_detail['mobile1'];
            $mobile2 = isset($_POST['mobile2']) ? $_POST['mobile2'] : $account_group_detail['mobile2'];
            $bank_name = isset($_POST['bank_name']) ? $_POST['bank_name'] : $account_group_detail['bank_name'];
            $bank_branch = isset($_POST['bank_branch']) ? $_POST['bank_branch'] : $account_group_detail['bank_branch'];
            $ifsc_code = isset($_POST['ifsc_code']) ? $_POST['ifsc_code'] : $account_group_detail['ifsc_code'];
            $bank_account_no = isset($_POST['bank_account_no']) ? $_POST['bank_account_no'] : $account_group_detail['bank_account_no'];
            $pan = isset($_POST['pan']) ? $_POST['pan'] : $account_group_detail['pan'];
            $gst_type_id = isset($_POST['gst_type_id']) ? $_POST['gst_type_id'] : $account_group_detail['gst_type_id'];
            $gstin = isset($_POST['gstin']) ? $_POST['gstin'] : $account_group_detail['gstin'];
            ?>
            <form class="form-horizontal" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Account Details</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <div class="box-body">
                                <div class="form-group">
                                    <input type="hidden" id="save_type" name="save_type" value="edit"/>
                                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>"/>
                                    <label for="name" class="col-sm-2 control-label" id="name_label">Name</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo $name; ?>"  required="required">
                                        <span id="name_help_block" class="help-block"></span>
                                    </div>
                                    <input type="hidden" id="is_valid_name" name="is_valid_name" value="<?php echo isset($_POST['is_valid_name']) ? $_POST['is_valid_name'] : '1'; ?>"/>
                                    <label for="parent_id" class="col-sm-2 control-label">Under Group</label>
                                    <div class="col-sm-2">
                                        <select id="parent_id" name="parent_id" class="form-control" required="required">
                                            <option value="" data-parent-id="0">Select group</option>
                                            <?php
                                            if (isset($account_groups)) {
                                                foreach ($account_groups as $account_group) {
                                                    if ($parent_id == $account_group['id']) {
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
                                        <input type="text" class="form-control" id="opening_balance" name="opening_balance" placeholder="0.00" onkeypress="return allowOnlyNumberWithDecimal(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo $opening_balance; ?>">
                                    </div>
                                </div>
                                <div class="overlay" style="display: none;">
                                    <i class="fa fa-refresh fa-spin"></i>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Mailing Details</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="contact_person" class="col-sm-2 control-label">Contact Person</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Contact Person" value="<?php echo $contact_person; ?>">
                                    </div>
                                    <label for="email" class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-4">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="area" class="col-sm-2 control-label">Area</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="area" name="area" placeholder="Area" value="<?php echo $area; ?>">
                                    </div>
                                    <label for="city" class="col-sm-2 control-label">City</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="city" name="city" placeholder="City" value="<?php echo $city; ?>">
                                    </div>
                                    <label for="pincode" class="col-sm-2 control-label">Pincode</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode" value="<?php echo $pincode; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="gst_state_code_id" class="col-sm-2 control-label">State</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="gst_state_code_id" name="gst_state_code_id">
                                            <option value="0">Select State</option>
                                            <?php
                                            if (isset($gst_states)) {
                                                foreach ($gst_states as $gst_state) {
                                                    if ($gst_state_code_id == $gst_state['id']) {
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
                                    <label for="mobile1" class="col-sm-2 control-label">Mobile 1</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="mobile1" name="mobile1" placeholder="Enter Mobile No" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo $mobile1; ?>">
                                    </div>
                                    <label for="mobile2" class="col-sm-2 control-label">Mobile 2</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="mobile2" name="mobile2" placeholder="Enter Mobile No" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo $mobile2; ?>">
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="overlay" style="display: none;">
                                <i class="fa fa-refresh fa-spin"></i>
                            </div>
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Bank Details</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="bank_name" class="col-sm-2 control-label">Bank Name</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name" value="<?php echo $bank_name; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bank_branch" class="col-sm-2 control-label">Bank Branch</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="bank_branch" name="bank_branch" placeholder="Bank Branch" value="<?php echo $bank_branch; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ifsc_code" class="col-sm-2 control-label">IFSC Code</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" placeholder="IFSC Code" value="<?php echo $ifsc_code; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bank_account_no" class="col-sm-2 control-label">Bank Account No</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="bank_account_no" name="bank_account_no" placeholder="Bank Account No" value="<?php echo $bank_account_no; ?>">
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="overlay" style="display: none;">
                                <i class="fa fa-refresh fa-spin"></i>
                            </div>
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Tax Registration Details</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="pan" class="col-sm-2 control-label">PAN</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="pan" name="pan" placeholder="PAN" value="<?php echo $pan; ?>">
                                        <span id="pan_help_block" class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="gst_type_id" class="col-sm-2 control-label">GST Type</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="gst_type_id" name="gst_type_id">
                                            <?php
                                            if (isset($gst_types)) {
                                                foreach ($gst_types as $gst_type) {
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
                                </div>
                                <div class="form-group">
                                    <label for="gstin" class="col-sm-2 control-label">GSTIN</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="gstin" name="gstin" placeholder="GSTIN" value="<?php echo $gstin; ?>" maxlength="15" minlength="15" oncopy="return false;" onpaste="return false;" autocomplete="off">
                                        <span id="gstin_help_block" class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="overlay" style="display: none;">
                                <i class="fa fa-refresh fa-spin"></i>
                            </div>
                        </div>
                        <!-- /.box -->
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-success btn-block">Save Changes</button>
                            </div>
                            <div class="col-sm-2">
                                <a href="?controller=accountgroup&action=getall" type="button" class="btn btn-default btn-block">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <?php
        }
    }
}
?>