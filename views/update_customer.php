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
if (isset($customer_detail)) {
    if (!empty($customer_detail)) {
        foreach ($customer_detail as $customer) {
            $id = $customer['id'];
            $name = isset($_POST['name']) ? $_POST['name'] : $customer['name'];
            $area = isset($_POST['area']) ? $_POST['area'] : $customer['area'];
            $city = isset($_POST['city']) ? $_POST['city'] : $customer['city'];
            $pincode = isset($_POST['pincode']) ? $_POST['pincode'] : $customer['pincode'];

            $male_checked = ' checked="checked"';
            $female_checked = '';
            if (isset($_POST['gender'])) {
                $gender = $_POST['gender'];
            } else {
                $gender = $customer['gender'];
            }
            if ($gender == 'male') {
                $male_checked = ' checked="checked"';
                $female_checked = '';
            } else if ($gender == 'female') {
                $female_checked = ' checked="checked"';
                $male_checked = '';
            }

            $email = isset($_POST['email']) ? $_POST['email'] : $customer['email'];
            $mobile1 = isset($_POST['mobile1']) ? $_POST['mobile1'] : $customer['mobile1'];
            $mobile2 = isset($_POST['mobile2']) ? $_POST['mobile2'] : $customer['mobile2'];
            $residence_no = isset($_POST['residence_no']) ? $_POST['residence_no'] : $customer['residence_no'];
            $office_no = isset($_POST['office_no']) ? $_POST['office_no'] : $customer['office_no'];
            $dob = isset($_POST['dob']) ? $_POST['dob'] : $customer['dob'];
            $doa = isset($_POST['doa']) ? $_POST['doa'] : $customer['doa'];
            ?>
            <div class="row">
                <div class="col-md-12">
                    <!-- Horizontal Form -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Detail Form</h3>
                            <!--<a href="?controller=customer&action=getCustomers" class="btn btn-danger pull-right">&times;</a>-->
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal" method="post">
                            <input type="hidden" id="id" name="id" value=""<?php echo $id; ?>/>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo $name; ?>" required="required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">Address</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="area" name="area" placeholder="Area" value="<?php echo $area; ?>">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="city" name="city" placeholder="City" value="<?php echo $city; ?>">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode" value="<?php echo $pincode; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="gender" class="col-sm-2 control-label">Gender</label>
                                    <div class="col-sm-2">
                                        <div class="radio">
                                            <?php
                                            ?>
                                            <label><input type="radio" name="gender" value="male"<?php echo $male_checked; ?>> Male </label>
                                            <label><input type="radio" name="gender" value="female"<?php echo $female_checked; ?>> Female </label>
                                        </div>
                                    </div>
                                    <label for="email" class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-6">
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
                                    <label for="dob" class="col-sm-2 control-label" id="dob_label">Date Of Birth</label>
                                    <div class="col-sm-4">
                                        <div class="input-group date">
                                            <input type="text" class="form-control" id="dob" name="dob" placeholder="Enter Date Of Birth" oncopy="return false;" onpaste="return false;" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask="" autocomplete="off" value="<?php echo $dob; ?>" maxlength="20">
                                            <div class="input-group-addon" id="dob_addon">
                                                <i class="fa fa-calendar" id="dob_cal"></i>
                                            </div>
                                        </div>
                                        <span id="dob_help_block" class="help-block"></span>
                                    </div>
                                    <label for="doa" class="col-sm-2 control-label" id="doa_label">Date Of Anniversary</label>
                                    <div class="col-sm-4">
                                        <div class="input-group date">
                                            <input type="text" class="form-control" id="doa" name="doa" placeholder="Enter Date Of Anniversary" oncopy="return false;" onpaste="return false;" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask="" autocomplete="off" value="<?php echo $doa; ?>" maxlength="20">
                                            <div class="input-group-addon" id="doa_addon">
                                                <i class="fa fa-calendar" id="doa_cal"></i>
                                            </div>
                                        </div>
                                        <span id="doa_help_block" class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="form-group">
                                    <div class="col-sm-10 pull-right">
                                        <button type="submit" class="btn btn-success">Save</button>
                                        <a href="?controller=customer&action=getCustomers" type="button" class="btn btn-default">Cancel</a>
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