<link rel="stylesheet" href="public/plugins/select2/select2.min.css">
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
?>
<form class="form-horizontal" method="post">
    <input type="hidden" id="save_type" name="save_type" value="add"/>
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
                        <label for="name" class="col-sm-2 control-label" id="name_label">Name</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>"  required="required">
                            <span id="name_help_block" class="help-block"></span>
                        </div>
                        <input type="hidden" id="is_valid_name" name="is_valid_name" value="<?php echo isset($_POST['is_valid_name']) ? $_POST['is_valid_name'] : '0'; ?>"/>
                        <label for="parent_id" class="col-sm-2 control-label">Under Group</label>
                        <div class="col-sm-2">
                            <select id="parent_id" name="parent_id" class="form-control" required="required">
                                <?php
                                if (isset($_POST['parent_id'])) {
                                    $parent_id = $_POST['parent_id'];
                                } else {
                                    $parent_id = '';
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
                            <input type="text" class="form-control decimal" id="opening_balance" name="opening_balance" placeholder="0.00" onkeypress="return allowOnlyNumberWithDecimal(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['opening_balance']) ? $_POST['opening_balance'] : ''; ?>">
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
                            <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Contact Person" value="<?php echo isset($_POST['contact_person']) ? $_POST['contact_person'] : ''; ?>">
                        </div>
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-4">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="area" class="col-sm-2 control-label">Area</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="area" name="area" placeholder="Area" value="<?php echo isset($_POST['area']) ? $_POST['area'] : ''; ?>">
                        </div>
                        <label for="city" class="col-sm-2 control-label">City</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="city" name="city" placeholder="City" value="<?php echo isset($_POST['city']) ? $_POST['city'] : ''; ?>">
                        </div>
                        <label for="pincode" class="col-sm-2 control-label">Pincode</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode" value="<?php echo isset($_POST['pincode']) ? $_POST['pincode'] : ''; ?>">
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
                                        if (isset($_POST['gst_state_code_id'])) {
                                            $gst_state_code_id = $_POST['gst_state_code_id'];
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
                        <label for="mobile1" class="col-sm-2 control-label">Mobile 1</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="mobile1" name="mobile1" placeholder="Enter Mobile No" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['mobile1']) ? $_POST['mobile1'] : ''; ?>">
                        </div>
                        <label for="mobile2" class="col-sm-2 control-label">Mobile 2</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="mobile2" name="mobile2" placeholder="Enter Mobile No" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['mobile2']) ? $_POST['mobile2'] : ''; ?>">
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
                            <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name" value="<?php echo isset($_POST['bank_name']) ? $_POST['bank_name'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bank_branch" class="col-sm-2 control-label">Bank Branch</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="bank_branch" name="bank_branch" placeholder="Bank Branch" value="<?php echo isset($_POST['bank_branch']) ? $_POST['bank_branch'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ifsc_code" class="col-sm-2 control-label">IFSC Code</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" placeholder="IFSC Code" value="<?php echo isset($_POST['ifsc_code']) ? $_POST['ifsc_code'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bank_account_no" class="col-sm-2 control-label">Bank Account No</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="bank_account_no" name="bank_account_no" placeholder="Bank Account No" value="<?php echo isset($_POST['bank_account_no']) ? $_POST['bank_account_no'] : ''; ?>">
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
                            <input type="text" class="form-control" id="pan" name="pan" placeholder="PAN" value="<?php echo isset($_POST['pan']) ? $_POST['pan'] : ''; ?>">
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
                                        if (isset($_POST['gst_type_id'])) {
                                            $gst_type_id = $_POST['gst_type_id'];
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
                    </div>
                    <div class="form-group">
                        <label for="gstin" class="col-sm-2 control-label">GSTIN</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="gstin" name="gstin" placeholder="GSTIN" value="<?php echo isset($_POST['gstin']) ? $_POST['gstin'] : ''; ?>" maxlength="15" minlength="15" oncopy="return false;" onpaste="return false;" autocomplete="off">
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
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Brand Details</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="form-group">
                        <label for="brand_ids[]" class="col-sm-2 control-label">Serving Brands</label>
                        <?php
                        if (isset($brands)) {
                            ?>
                            <div class="col-sm-4">
                                <select class="form-control select2" multiple="multiple" data-placeholder="Select brands" id="brand_ids" name="brand_ids[]">
                                    <?php
                                    foreach ($brands as $brand) {
                                        $brand_selected = '';
                                        if (isset($_POST['brand_ids'])) {
                                            foreach ($_POST['brand_ids'] as $post_brand_id) {
                                                if ($post_brand_id == $brand['id']) {
                                                    $brand_selected = ' selected="selected"';
                                                }
                                            }
                                        }
                                        ?>
                                        <option name="brand_ids[]" value="<?php echo $brand['id']; ?>"<?php echo $brand_selected; ?>><?php echo $brand['name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <?php
                        }
                        ?>
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