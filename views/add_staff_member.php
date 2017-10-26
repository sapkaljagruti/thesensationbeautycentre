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

<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Staff Member Details</h3>
                <!--<a href="?controller=customer&action=getCustomers" class="btn btn-danger pull-right">&times;</a>-->
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="staff_code" class="col-sm-2 control-label">Staff Code</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="staff_code" name="staff_code" placeholder="Staff Code" value="<?php echo isset($_POST['staff_code']) ? $_POST['staff_code'] : ''; ?>">
                        </div>
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="designation" class="col-sm-2 control-label">Designation</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="designation" name="designation" placeholder="Designation" value="<?php echo isset($_POST['designation']) ? $_POST['designation'] : ''; ?>">
                        </div>
                        <label for="gender" class="col-sm-2 control-label">Gender</label>
                        <div class="col-sm-4">
                            <div class="radio">
                                <?php
                                $male_checked = ' checked="checked"';
                                $female_checked = '';
                                if (isset($_POST['gender'])) {
                                    $gender = $_POST['gender'];
                                    if ($gender == 'male') {
                                        $male_checked = ' checked="checked"';
                                        $female_checked = '';
                                    } else if ($gender == 'female') {
                                        $female_checked = ' checked="checked"';
                                        $male_checked = '';
                                    }
                                }
                                ?>
                                <label><input type="radio" name="gender" value="male"<?php echo $male_checked; ?>> Male </label>
                                <label><input type="radio" name="gender" value="female"<?php echo $female_checked; ?>> Female </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" rows="3" placeholder="Address" id="address" name="address"><?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?></textarea>
                        </div>
                        <label for="permanent_address" class="col-sm-2 control-label">Permanent Address</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" rows="3" placeholder="Permanent Address" id="permanent_address" name="permanent_address"><?php echo isset($_POST['permanent_address']) ? $_POST['permanent_address'] : ''; ?></textarea>
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
                    <div class="form-group">
                        <label for="residence_no" class="col-sm-2 control-label">Residence No</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="residence_no" name="residence_no" placeholder="Enter Residence No" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['residence_no']) ? $_POST['residence_no'] : ''; ?>">
                        </div>
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-4">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dob" class="col-sm-2 control-label" id="dob_label">Date Of Birth</label>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                <input type="text" class="form-control" id="dob" name="dob" placeholder="Enter Date Of Birth" oncopy="return false;" onpaste="return false;" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask="" autocomplete="off" value="<?php echo isset($_POST['dob']) ? $_POST['dob'] : ''; ?>" maxlength="20">
                                <div class="input-group-addon" id="dob_addon">
                                    <i class="fa fa-calendar" id="dob_cal"></i>
                                </div>
                            </div>
                            <span id="dob_help_block" class="help-block"></span>
                        </div>
                        <label for="doa" class="col-sm-2 control-label" id="doa_label">Date Of Anniversary</label>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                <input type="text" class="form-control" id="doa" name="doa" placeholder="Enter Date Of Anniversary" oncopy="return false;" onpaste="return false;" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask="" autocomplete="off" value="<?php echo isset($_POST['doa']) ? $_POST['doa'] : ''; ?>" maxlength="20">
                                <div class="input-group-addon" id="doa_addon">
                                    <i class="fa fa-calendar" id="doa_cal"></i>
                                </div>
                            </div>
                            <span id="doa_help_block" class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="insurance_type" class="col-sm-2 control-label">Insurance Type</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="insurance_type" name="insurance_type" placeholder="Insurance Type" value="<?php echo isset($_POST['insurance_type']) ? $_POST['insurance_type'] : ''; ?>">
                        </div>
                        <label for="insurance_name" class="col-sm-2 control-label">Insurance Name</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="insurance_name" name="insurance_name" placeholder="Insurance Name" value="<?php echo isset($_POST['insurance_name']) ? $_POST['insurance_name'] : ''; ?>">
                        </div>
                        <label for="insurance_amount" class="col-sm-1 control-label">Amount</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="insurance_amount" name="insurance_amount" placeholder="Insurance Amount" value="<?php echo isset($_POST['insurance_amount']) ? $_POST['insurance_amount'] : ''; ?>" onkeypress="return allowOnlyNumberWithDecimal(event)" oncopy="return false;" onpaste="return false;" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group" id="insurance_validity_div">
                        <label for="insurance_from" class="col-sm-2 control-label" id="insurance_from_label">Insurance From</label>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                <input type="text" class="form-control" id="insurance_from" name="insurance_from" placeholder="Enter Insurance From Date" oncopy="return false;" onpaste="return false;" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask="" autocomplete="off" value="<?php echo isset($_POST['insurance_from']) ? $_POST['insurance_from'] : ''; ?>" maxlength="20">
                                <div class="input-group-addon" id="insurance_from_addon">
                                    <i class="fa fa-calendar" id="insurance_from_cal"></i>
                                </div>
                            </div>
                            <span id="insurance_from_help_block" class="help-block"></span>
                        </div>
                        <label for="insurance_to" class="col-sm-2 control-label" id="insurance_to_label">Insurance To</label>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                <input type="text" class="form-control" id="insurance_to" name="insurance_to" placeholder="Enter Insurance To Date" oncopy="return false;" onpaste="return false;" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask="" autocomplete="off" value="<?php echo isset($_POST['insurance_to']) ? $_POST['insurance_to'] : ''; ?>" maxlength="20">
                                <div class="input-group-addon" id="insurance_to_addon">
                                    <i class="fa fa-calendar" id="insurance_to_cal"></i>
                                </div>
                            </div>
                            <span id="insurance_to_help_block" class="help-block"></span>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-sm-10 pull-right">
                            <button type="submit" class="btn btn-success">Save</button>
                            <a href="?controller=staff&action=getstaffmembers" type="button" class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->
    </div>
</div>