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

<?php
if (isset($users)) {
    if (!empty($users)) {
        foreach ($users as $user) {
            $id = $user['id'];
            $fname = !empty($_POST['fname']) ? $_POST['fname'] : $user['fname'];
            $lname = !empty($_POST['lname']) ? $_POST['lname'] : $user['lname'];
            $email = !empty($_POST['email']) ? $_POST['email'] : $user['email'];
            $mobile = !empty($_POST['mobile']) ? $_POST['mobile'] : $user['mobile'];
            $username = !empty($_POST['username']) ? $_POST['username'] : $user['username'];
            $password = !empty($_POST['password']) ? $_POST['password'] : $user['password'];
            $can_view = isset($_POST['can_view']) ? $_POST['can_view'] : $user['can_view'];
            $can_add = isset($_POST['can_add']) ? $_POST['can_add'] : $user['can_add'];
            $can_update = isset($_POST['can_update']) ? $_POST['can_update'] : $user['can_update'];
            $can_delete = isset($_POST['can_delete']) ? $_POST['can_delete'] : $user['can_delete'];
            ?>

            <form class="form-horizontal" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">User Details</h3>
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
                                    <label for="fname" class="col-sm-2 control-label">First Name</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="name" name="fname" placeholder="First Name" value="<?php echo $fname; ?>" required="required">
                                    </div>
                                    <label for="lname" class="col-sm-2 control-label">Last Name</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" value="<?php echo $lname; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>">
                                    </div>

                                    <label for="mobile" class="col-sm-2 control-label">Mobile</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo $mobile; ?>">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="username" class="col-sm-2 control-label">Username</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $username; ?>">
                                    </div>
                                    
                                    <label for="password" class="col-sm-2 control-label">Password</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="password" name="password" placeholder="Password" value="<?php echo $password; ?>">
                                    </div>
                                </div>

                                <!--                                <div class="form-group">
                                                                    <label for="profile_picture" class="col-sm-2 control-label">Profile_picture</label>
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
                                        <input type="checkbox"  id="can_update" name="can_update" value="1">Update Permission
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

            </form>
            <?php
        }
    }
}
?>