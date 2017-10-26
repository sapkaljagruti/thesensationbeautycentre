<?php
@session_start();

$admin_id = (isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id'])) ? $_SESSION['admin_id'] : '';
if (!empty($admin_id)) {
    header('location: index.php');
}

if (isset($_POST['username']) && !empty($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = md5($password);
    require_once 'config/Database.php';
    $db = new Database();
    $conn = $db->connect();
    $admins = $conn->query('SELECT * FROM admins WHERE username="' . $username . '" AND password="' . $hashed_password . '"');
    if ($admins->num_rows > 0) {
        while ($admin = $admins->fetch_assoc()) {
            $_SESSION['admin'] = $admin['fname'] . ' ' . $admin['lname'];
            $_SESSION['admin_id'] = $admin['id'];
        }
        $_SESSION['timestamp'] = time();
        header('location: index.php');
    } else {
        $error = 'These credentials do not match our records.';
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Sensation Beauty Center | Log in</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link href="public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="public/css/font-awesome.min.css" rel="stylesheet">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link href="public/css/admin.min.css" rel="stylesheet">
        <link href="public/css/skin-black-light.min.css" rel="stylesheet">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="javascript:void(0)"><b>Admin</b></a>
            </div>
            <?php
            if (isset($error) && !empty($error)) {
                $error_class = ' has-error';
                ?>
                <div class="callout callout-danger">
                    <h4>Login Failed!</h4>
                    <p><?php echo $error; ?></p>
                </div>
                <?php
            } else {
                $error_class = '';
            }
            ?>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form method="post">
                    <div class="form-group has-feedback<?php echo $error_class; ?>">
                        <input type="text" class="form-control" placeholder="Username" name="username" id="username" required="required" value="<?php echo!empty($username) ? $username : ''; ?>">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback<?php echo $error_class; ?>">
                        <input type="password" class="form-control" placeholder="Password" name="password" id="password" required="required" value="<?php echo!empty($password) ? $password : ''; ?>">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <br/>
                <a href="#">I forgot my password</a>
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <!-- jQuery 2.2.3 -->
        <script src="public/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="public/plugins/bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>
