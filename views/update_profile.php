<style>
    .cropit-preview {
        background-color: #f8f8f8;
        background-size: cover;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin-top: 7px;
        width: 250px;
        height: 250px;
    }

    .cropit-preview-image-container {
        cursor: move;
    }

    .image-size-label {
        margin-top: 10px;
    }

    input {
        display: block;
    }

    #result {
        margin-top: 10px;
        width: 900px;
    }

    #result-data {
        display: block;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        word-wrap: break-word;
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

<div class="row">
    <div class="col-md-12">

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
                    $profile_picture = $_SESSION['admin_profile_picture'];
                    ?>
                    <!-- form start -->
                    <form class="form-horizontal" method="post" enctype = "multipart/form-data">
                        <div class="image-editor">
                            <input type="hidden" id="result-data" name="result-data" value=""/>
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Profile Details</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                    <!-- /.box-tools -->
                                </div>
                                <!-- /.box-header -->
                                <input type="hidden" id="save_type" name="save_type" value="add"/>
                                <div class="box-body">
                                    <div class="form-group">
                                        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>"/>
                                        <label for="fname" class="col-sm-2 control-label">First Name</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="name" name="fname" placeholder="First Name" value="<?php echo $fname; ?>" required="required">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="lname" class="col-sm-2 control-label">Last Name</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" value="<?php echo $lname; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-4">
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
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
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-4">
                                            <img class="img-responsive" style="width: 250px; height: 250px;" src="/public/images/<?php echo $profile_picture; ?>" alt="User Image">
                                        </div>
                                    </div>
                                    <input type="hidden" name="previous_image_name" value="<?php echo $profile_picture; ?>"/>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"></label>
                                        <div class="col-sm-10">
                                            <div class="cropit-preview"></div>
                                            <div class="image-size-label">
                                                Resize image
                                            </div>
                                            <input type="range" class="cropit-image-zoom-input" style="width: 50% !important;">
                                            <input type="hidden" name="image-data" class="hidden-image-data"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="image" class="col-sm-2 control-label"> Set another photo</label>
                                        <div class="col-sm-10">
                                            <input type="file" name="profile_picture" class="cropit-image-input">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="overlay" style="display: none;">
                                    <i class="fa fa-refresh fa-spin"></i>
                                </div>
                                <div class="box-footer">
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-4">
                                            <button type="submit" class="btn btn-success">Save</button>
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

    </div>
</div>