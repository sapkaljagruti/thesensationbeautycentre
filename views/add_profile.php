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
                <h3 class="box-title">Profile Details</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
                <!--<a href="?controller=customer&action=getCustomers" class="btn btn-danger pull-right">&times;</a>-->
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="fname" class="col-sm-2 control-label">First Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="name" name="fname" placeholder="First Name" value="<?php echo isset($_POST['fname']) ? $_POST['fname'] : ''; ?>" required="required">
                        </div>
                        <label for="lname" class="col-sm-2 control-label">Last Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" value="<?php echo isset($_POST['lname']) ? $_POST['lname'] : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                        </div>
                        
                        <label for="mobile" class="col-sm-2 control-label">Mobile</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['mobile']) ? $_POST['mobile'] : ''; ?>">
                        </div>

                        <label for="username" class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="residence_no" class="col-sm-2 control-label">Profile_picture</label>
                        <div class="col-sm-4">
                            <input type="file" class="form-control" id="profile_picture" name="profile_picture" >
                        </div>

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