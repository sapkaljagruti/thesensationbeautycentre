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
if (isset($party_detail)) {
    if (!empty($party_detail)) {
        foreach ($party_detail as $party) {
            $id = $party['id'];
            $name = isset($_POST['name']) ? $_POST['name'] : $party['name'];
            $address = isset($_POST['address']) ? $_POST['address'] : $party['address'];
            $contact_person = isset($_POST['contact_person']) ? $_POST['contact_person'] : $party['contact_person'];
            $email = isset($_POST['email']) ? $_POST['email'] : $party['email'];
            $mobile1 = isset($_POST['mobile1']) ? $_POST['mobile1'] : $party['mobile1'];
            $mobile2 = isset($_POST['mobile2']) ? $_POST['mobile2'] : $party['mobile2'];
            $residence_no = isset($_POST['residence_no']) ? $_POST['residence_no'] : $party['residence_no'];
            $office_no = isset($_POST['office_no']) ? $_POST['office_no'] : $party['office_no'];
            $bank_name = isset($_POST['bank_name']) ? $_POST['bank_name'] : $party['bank_name'];
            $bank_branch = isset($_POST['bank_branch']) ? $_POST['bank_branch'] : $party['bank_branch'];
            $ifsc_code = isset($_POST['ifsc_code']) ? $_POST['ifsc_code'] : $party['ifsc_code'];
            $bank_account_no = isset($_POST['bank_account_no']) ? $_POST['bank_account_no'] : $party['bank_account_no'];
            $pan = isset($_POST['pan']) ? $_POST['pan'] : $party['pan'];
            $gst_state_code_id = isset($_POST['gst_state_code_id']) ? $_POST['gst_state_code_id'] : $party['gst_state_code_id'];
            $gst_type_id = isset($_POST['gst_type_id']) ? $_POST['gst_type_id'] : $party['gst_type_id'];
            $gstin = isset($_POST['gstin']) ? $_POST['gstin'] : $party['gstin'];
            $brand_ids = isset($_POST['brand_ids']) ? $_POST['brand_ids'] : (!empty($party['brand_ids']) ? explode(',', $party['brand_ids']) : []);
            ?>
            <div class="row">
                <div class="col-md-12">
                    <!-- Horizontal Form -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Detail Form</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                            <!--<a href="?controller=customer&action=getCustomers" class="btn btn-danger pull-right">&times;</a>-->
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal" method="post">
                            <input type="hidden" id="save_type" name="save_type" value="edit"/>
                            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>"/>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label" id="name_label">Party Name</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo $name; ?>" required="required">
                                        <span id="name_help_block" class="help-block"></span>
                                    </div>
                                    <input type="hidden" id="is_valid_name" name="is_valid_name" value="<?php echo isset($_POST['is_valid_name']) ? $_POST['is_valid_name'] : '1'; ?>"/>
                                    <label for="contact_person" class="col-sm-2 control-label">Contact Person</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Contact Person" value="<?php echo $contact_person; ?>" required="required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address" class="col-sm-2 control-label">Address</label>
                                    <div class="col-sm-4">
                                        <textarea class="form-control" rows="3" placeholder="Address" id="address" name="address"><?php echo $address; ?></textarea>
                                    </div>
                                    <label for="email" class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-4">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>">
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
                                <div class="form-group">
                                    <label for="residence_no" class="col-sm-2 control-label">Residence No</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="residence_no" name="residence_no" placeholder="Enter Residence No" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo $residence_no; ?>">
                                    </div>
                                    <label for="office_no" class="col-sm-2 control-label">Office No</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="office_no" name="office_no" placeholder="Enter Office Contact No" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" value="<?php echo $office_no; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bank_name" class="col-sm-2 control-label">Bank Name</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name" value="<?php echo $bank_name; ?>">
                                    </div>
                                    <label for="bank_branch" class="col-sm-2 control-label">Bank Branch</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="bank_branch" name="bank_branch" placeholder="Bank Branch" value="<?php echo $bank_branch; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ifsc_code" class="col-sm-2 control-label">IFSC Code</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" placeholder="Bank IFSC Code" value="<?php echo $ifsc_code; ?>">
                                    </div>
                                    <label for="bank_account_no" class="col-sm-2 control-label">Bank A/C No</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="bank_account_no" name="bank_account_no" placeholder="Bank A/C no" value="<?php echo isset($_POST['bank_account_no']) ? $_POST['bank_account_no'] : ''; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pan" class="col-sm-2 control-label" id="pan_label">PAN</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="pan" name="pan" placeholder="PAN" value="<?php echo $pan; ?>">
                                        <span id="pan_help_block" class="help-block"></span>
                                    </div>
                                    <label for="state" class="col-sm-2 control-label" id="state_label">State</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="gst_state_code_id" name="gst_state_code_id">
                                            <option value="0">Select State</option>
                                            <?php
                                            if (isset($gst_states)) {
                                                foreach ($gst_states as $gst_state) {
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
                                    <label for="gst_type_id" class="col-sm-2 control-label">GST Type</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="gst_type_id" name="gst_type_id">
                                            <?php
                                            if (isset($gst_types)) {
                                                $gst_type_selected = '';
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
                                    <label for="gstin" class="col-sm-2 control-label" id="gstin_label">GSTIN</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="gstin" name="gstin" placeholder="GSTIN" value="<?php echo $gstin; ?>" maxlength="15" minlength="15" oncopy="return false;" onpaste="return false;" autocomplete="off">
                                        <span id="gstin_help_block" class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="brand_ids[]" class="col-sm-2 control-label">Party Brands</label>
                                    <?php
                                    if (isset($brands)) {
                                        ?>
                                        <div class="col-sm-4">
                                            <select class="form-control select2" multiple="multiple" data-placeholder="Select brands" id="brand_ids" name="brand_ids[]">
                                                <?php
                                                foreach ($brands as $brand) {
                                                    $brand_selected = '';
                                                    foreach ($brand_ids as $brand_id) {
                                                        if ($brand_id == $brand['id']) {
                                                            $brand_selected = ' selected="selected"';
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
                            <div class="box-footer">
                                <div class="form-group">
                                    <div class="col-sm-10 pull-right">
                                        <button type="submit" class="btn btn-success">Save</button>
                                        <a href="?controller=party&action=getall" type="button" class="btn btn-default">Cancel</a>
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