<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>The Sensation Beauty Centre | Admin</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link href="public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="public/css/font-awesome.min.css" rel="stylesheet">
        <!-- Ionicons -->
        <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">-->
        <!-- Theme style -->
        <link href="public/css/admin.min.css" rel="stylesheet">
        <link href="public/css/skin-black-light.min.css" rel="stylesheet">
        <style>
            .dropdown-submenu {
                position: relative;
            }

            .dropdown-submenu .dropdown-menu {
                top: 0;
                left: 100%;
                margin-top: -1px;
            }
        </style>
    </head>
    <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
    <body class="hold-transition skin-black-light layout-top-nav">
        <div class="wrapper">

            <header class="main-header">
                <nav class="navbar navbar-static-top">
                    <div class="container">
                        <div class="navbar-header">
                            <a href="home.php" class="navbar-brand"><b>Admin</b></a>
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                                <i class="fa fa-bars"></i>
                            </button>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li class="dropdown active">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Masters <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <!--<li><a href="?controller=manager&action=getManagers">Manager Master</a></li>-->
                                        <!--<li><a href="?controller=branch&action=getBranches">Branch Master</a></li>-->
                                        <li><a href="?controller=customer&action=getCustomers">Customer Master</a></li>
                                        <li><a href="?controller=staff&action=getstaffmembers">Staff Master</a></li>
                                        <li><a href="?controller=party&action=getall">Party Master</a></li>
                                        <li><a href="?controller=brand&action=getBrands">Brand Master</a></li>
                                        <li><a href="?controller=accountgroup&action=getacgroups">Account Group Master</a></li>
                                        <li><a href="?controller=account&action=getacs">Account Master</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Products <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="?controller=productcategory&action=getcategories">Product Categories</a></li>
                                        <li><a href="?controller=product&action=getproducts">Product Master</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Transactions <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="?controller=purchasebill&action=getbills">Purchase Bill</a></li>
                                        <li><a href="?controller=product&action=getproducts">Sales Bill</a></li>
                                        <li><a href="?controller=product&action=getproducts">Debit Note</a></li>
                                        <li><a href="?controller=product&action=getproducts">Credit Note</a></li>
                                        <li><a href="?controller=product&action=getproducts">Journal Voucher</a></li>
                                        <li><a href="?controller=product&action=getproducts">Cash Book</a></li>
                                        <li><a href="?controller=product&action=getproducts">Bank Book</a></li>
                                    </ul>
                                    <!--                                    <ul class="dropdown-menu">
                                                                            <li class="dropdown-submenu">
                                                                                <a class="dropdown_submenu_anchor" href="#">Cash Book <i class="fa fa-fw fa-caret-right"></i></a>
                                                                                <ul class="dropdown-menu">
                                                                                    <li><a href="#">Receipt</a></li>
                                                                                    <li><a href="#">Payment</a></li>
                                                                                </ul>
                                                                            </li>
                                                                            <li class="dropdown-submenu">
                                                                                <a class="dropdown_submenu_anchor" href="#">Bank Book <i class="fa fa-fw fa-caret-right"></i></a>
                                                                                <ul class="dropdown-menu">
                                                                                    <li><a href="#">Receipt</a></li>
                                                                                    <li><a href="#">Payment</a></li>
                                                                                </ul>
                                                                            </li>
                                                                        </ul>-->
                                </li>
                                <li>
                                    <a href="#">Reports</a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings<span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">User Roles</a></li>
                                        <li><a href="#">Users</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <form class="navbar-form navbar-left" role="search">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
                                </div>
                            </form>
                        </div>
                        <!-- /.navbar-collapse -->
                        <!-- Navbar Right Menu -->
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                <?php
                                if (isset($ex_ins_staff_members_nots)) {
                                    if (empty($ex_ins_staff_members_nots)) {
                                        $notification_count = '';
                                    } else {
                                        $notification_count = count($ex_ins_staff_members_nots);
                                    }
                                    ?>
                                    <!-- Notifications: style can be found in dropdown.less -->
                                    <li class="dropdown notifications-menu">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-bell-o"></i>
                                            <span class="label label-warning"><?php echo $notification_count; ?></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li> 
                                                <ul class="menu">
                                                    <?php
                                                    if (!empty($ex_ins_staff_members_nots)) {
                                                        foreach ($ex_ins_staff_members_nots as $ex_ins_staff_members_not) {
                                                            ?>
                                                            <li>
                                                                <a href="?controller=staff&action=updatestaff&id=<?php echo $ex_ins_staff_members_not['id']; ?>">
                                                                    <i class="fa fa-warning text-yellow"></i> Insurance Expiring Today
                                                                    <p><?php echo $ex_ins_staff_members_not['name']; ?></p>
                                                                </a>
                                                            </li>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                            </li>
                                            <!--<li class="footer"><a href="#">View all</a></li>-->
                                        </ul>
                                    </li>
                                    <?php
                                }
                                ?>
                                <!-- User Account Menu -->
                                <li class="dropdown user user-menu">
                                    <!-- Menu Toggle Button -->
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <!-- The user image in the navbar-->
                                        <img src="public/images/user2-160x160.jpg" class="user-image" alt="User Image">
                                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                        <span class="hidden-xs"><?php echo ucwords($_SESSION['admin']); ?></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <!-- The user image in the menu -->
                                        <li class="user-header">
                                            <img src="public/images/user2-160x160.jpg" class="img-circle" alt="User Image">

                                            <p><?php echo ucwords($_SESSION['admin']); ?>
                                            </p>
                                        </li>
                                        <!-- Menu Footer-->
                                        <li class="user-footer">
                                            <div class="pull-left">
                                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                                            </div>
                                            <div class="pull-right">
                                                <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!-- /.navbar-custom-menu -->
                    </div>
                    <!-- /.container-fluid -->
                </nav>
            </header>
            <!-- Full Width Column -->
            <div class="content-wrapper">
                <div class="container">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <h1><?php echo $page_header; ?></h1>
                    </section>

                    <!-- Main content -->
                    <section class="content">
                        <?php
                        if (!isset($view_file)) {
                            $view_file = '';
                        }
                        include_once APP_DIR . $view_file;
                        ?>
                    </section>
                    <!-- /.content -->
                </div>
                <!-- /.container -->
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="container">
                    <strong>Copyright &copy; 2017 <a href="http://www.sensationsalon.in/">The Sensation Salon</a>.</strong> All rights
                    reserved.
                </div>
                <!-- /.container -->
            </footer>
        </div>
        <!-- ./wrapper -->

        <!-- jQuery 2.2.3 -->
        <script src="public/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="public/plugins/bootstrap/js/bootstrap.min.js"></script>
        <!-- SlimScroll -->
        <script src="public/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="public/plugins/fastclick/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="public/js/app.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.dropdown-submenu a.dropdown_submenu_anchor').on("click", function (e) {
                    $(this).next('ul').toggle();
                    e.stopPropagation();
                    e.preventDefault();
                });
            });
        </script>
        <?php
        if (isset($extra_js_files) && is_array($extra_js_files)) {
            foreach ($extra_js_files as $extra_js_file) {
                ?>
                <script src="<?php echo 'public/' . $extra_js_file; ?>"></script>
                <?php
            }
        }
        ?>
    </body>
</html>
