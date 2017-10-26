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
                <h3 class="box-title">Account Details</h3>
                <!--<a href="?controller=customer&action=getCustomers" class="btn btn-danger pull-right">&times;</a>-->
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Account Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" required="required">
                        </div>
                        <label for="account_no" class="col-sm-2 control-label">Account No</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="account_no" name="account_no" placeholder="Account No" value="<?php echo isset($_POST['account_no']) ? $_POST['account_no'] : ''; ?>" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="account_group_id" class="col-sm-2 control-label">Account Group</label>
                        <div class="col-sm-2">
                            <select class="form-control" id="account_group_id" name="account_group_id">
                                <option value='0'>Select Group</option>
                                <?php
                                if (isset($account_groups)) {
                                    $ac_group_selected = '';
                                    if (count($account_groups) > 0) {
                                        foreach ($account_groups as $account_group) {
                                            if (isset($_POST['account_group_id'])) {
                                                $account_group_id = $_POST['account_group_id'];
                                                if ($account_group_id == $account_group['id']) {
                                                    $ac_group_selected = ' selected="selected"';
                                                } else {
                                                    $ac_group_selected = '';
                                                }
                                            }
                                            ?>
                                            <option value="<?php echo $account_group['id']; ?>"<?php echo $ac_group_selected; ?>><?php echo ucwords($account_group['name']); ?></option>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <label for="opening_type" class="col-sm-2 control-label">Opening Type</label>
                        <div class="col-sm-2">
                            <select class="form-control" id="opening_type" name="opening_type">
                                <?php
                                if (isset($_POST['opening_type'])) {
                                    $opening_type = $_POST['opening_type'];
                                    if ($opening_type == 'dr') {
                                        $dr_checked = ' selected="selected"';
                                        $cr_checked = '';
                                    } else if ($opening_type == 'cr') {
                                        $cr_checked = ' selected="selected"';
                                        $dr_checked = '';
                                    }
                                } else {
                                    $dr_checked = ' selected="selected"';
                                    $cr_checked = '';
                                }
                                ?>
                                <option value='dr'<?php echo $dr_checked; ?>>DR</option>
                                <option value='cr'<?php echo $cr_checked; ?>>CR</option>
                            </select>
                        </div>
                        <label for="opening_amount" class="col-sm-2 control-label">Opening Amount</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="opening_amount" name="opening_amount" placeholder="0.00" onkeypress="return allowOnlyNumberWithDecimal(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['opening_amount']) ? $_POST['opening_amount'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contact_person" class="col-sm-2 control-label">Contact Person</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Contact Person" value="<?php echo isset($_POST['contact_person']) ? $_POST['contact_person'] : ''; ?>">
                        </div>
                        <label for="address" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-2">
                            <textarea class="form-control" rows="3" placeholder="Address" id="address" name="address"><?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?></textarea>
                        </div>
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-2">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mobile1" class="col-sm-2 control-label">Mobile 1</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="mobile1" name="mobile1" placeholder="Enter Mobile No 1" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['mobile1']) ? $_POST['mobile1'] : ''; ?>">
                        </div>
                        <label for="mobile2" class="col-sm-2 control-label">Mobile 2</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="mobile2" name="mobile2" placeholder="Enter Mobile No 2" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['mobile2']) ? $_POST['mobile2'] : ''; ?>">
                        </div>
                        <label for="office_no" class="col-sm-2 control-label">Office No</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="office_no" name="office_no" placeholder="Enter Office No" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" value="<?php echo isset($_POST['office_no']) ? $_POST['office_no'] : ''; ?>">
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="form-group">
                        <div class="col-sm-10 pull-right">
                            <button type="submit" class="btn btn-success">Save</button>
                            <a href="?controller=account&action=getacs" type="button" class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->
    </div>
</div>