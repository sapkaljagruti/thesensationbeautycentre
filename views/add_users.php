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
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Users</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>               <!-- /.box-header -->
                <!-- form start -->

                <div class="box-body">
                    <div class="form-group">
                        <label for="fname" class="col-sm-2 control-label">First Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" value="<?php echo isset($_POST['fname']) ? $_POST['fname'] : ''; ?>" required="required">
                        </div>
                        <label for="lname" class="col-sm-2 control-label">Last Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" value="<?php echo isset($_POST['lname']) ? $_POST['lname'] : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-4">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                        </div>

                        <label for="mobile" class="col-sm-2 control-label">Mobile</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['mobile']) ? $_POST['mobile'] : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username" class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
                        </div>

                        <label for="password" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control" id="password" name="password" placeholder="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>">
                        </div>
                    </div>

<!--                    <div class="form-group">
                        <label for="profile_picture" class="col-sm-2 control-label">Profile Picture</label>
                        <div class="col-sm-4">
                            <input type="file"  id="profile_picture" name="profile_picture">
                        </div>

                    </div>-->
                </div>

            </div>
            <!-- /.box-body -->

        </div>
        <!-- /.box -->
    </div>


    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Permissions</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"  id="can_view" name="can_view" value="1">View Permission
                        </label>
                        <label>
                            <input type="checkbox"  id="can_add" name="can_add" value="1">Add Permission
                        </label>
                        <label>
                            <input type="checkbox"  id="can_update" name="can_update" placeholder="Can_Update" value="1">Update Permission
                        </label>
                        <label>
                            <input type="checkbox"  id="can_delete" name="can_delete" value="1">Delete Permission
                        </label>
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
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-success btn-block">Save Changes</button>
                </div>
                <div class="col-sm-2">
                    <a href="?controller=users&action=getUsers" type="button" class="btn btn-default btn-block">Cancel</a>
                </div>
            </div>
        </div>
    </div>

</form>