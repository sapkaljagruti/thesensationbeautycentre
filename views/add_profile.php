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
if (isset($profiles)) {
    if (!empty($profiles)) {
        foreach ($profiles as $profile) {
            $id = $profile['id'];
            $fname = !empty($_POST['fname']) ? $_POST['fname'] : $profile['fname'];
            $lname = !empty($_POST['lname']) ? $_POST['lname'] : $profile['lname'];
            $email = !empty($_POST['email']) ? $_POST['email'] : $profile['email'];
            $mobile = !empty($_POST['mobile']) ? $_POST['mobile'] : $profile['mobile'];
            $username = !empty($_POST['username']) ? $_POST['username'] : $profile['username'];
            $profile_picture = !empty($_FILES['profile_picture']['name']) ? $_FILES['profile_picture']['name'] : $profile['profile_picture'];
            
            ?>

            <form class="form-horizontal" method="post">
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
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>">
                                    </div>

                                    <label for="mobile" class="col-sm-2 control-label">Mobile</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo $mobile; ?>">
                                    </div>

                                    <label for="username" class="col-sm-2 control-label">Username</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $username; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="profile_picture" class="col-sm-2 control-label">Profile_picture</label>
                                    <div class="col-sm-4">
                                        <input type="file"  id="profile_picture" name="profile_picture">
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
                    </div>
                    <!-- /.box -->
                </div>
            </form>
            <?php
        }
    }
}
?>