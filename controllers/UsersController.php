<?php

class UsersController {

    public $usersobj;
    public $extra_js_files;

    public function __construct() {

        require_once 'models/Users.php';
        $this->usersobj = new Users();

        $this->extra_js_files = array('plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables/dataTables.bootstrap.min.js', 'plugins/input-mask/jquery.inputmask.js', 'plugins/input-mask/jquery.inputmask.date.extensions.js', 'plugins/input-mask/jquery.inputmask.extensions.js', 'js/users.js');
    }

    public function getUsers() {
        $page_header = 'Users';
        $extra_js_files = $this->extra_js_files;
        $users = $this->usersobj->getUsers();
        $view_file = '/views/users.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function getUser() {
        $id = trim($_POST['id']);
        $user = $this->usersobj->getUser($id);
        if ($user->num_rows == 1) {
            while ($u = mysqli_fetch_assoc($user)) {
                $u['fname'] = ucwords($u['fname']);
                $u['lname'] = ucwords($u['lname']);
                $u['email'] = ($u['email']);
                $u['mobile'] = ($u['mobile']);
                $u['username'] = ($u['username']);
                $u['password'] = ($u['password']);
                $u['can_view'] = ($u['can_view']);
                $u['can_add'] = ($u['can_add']);
                $u['can_update'] = ($u['can_update']);
                $u['can_delete'] = ($u['can_delete']);
                $rows[] = $u;
            }
            echo json_encode($rows);
        } else {
            echo '0';
        }
    }

    public function addUsers() {
        $page_header = 'Add New User';
        $extra_js_files = $this->extra_js_files;
        
//         $folder = "public/images/";
//         $uploadfile=$folder.basename($_FILES['$profile_picture']['name']);
//         $ftmp=$_FILES['$profile_picture']['tmp_name'];

        if (!empty($_POST)) {
            $errors = array();

            if (empty($errors)) {
                $fname = trim($_POST['fname']);
                $lname = $_POST['lname'];
                $email = !empty($_POST['email']) ? trim($_POST['email']) : NULL;
                $mobile = !empty($_POST['mobile']) ? trim($_POST['mobile']) : NULL;
                $username = !empty($_POST['username']) ? $_POST['username'] : NULL;
                $password = !empty($_POST['password']) ? $_POST['password'] : NULL;
//                $ftmp = !empty($_FILES['profile_picture']['name']) ? $_FILES['profile_picture']['name'] : NULL;
                $can_view = isset($_POST['can_view']) ? $_POST['can_view'] : '0';
                $can_add = isset($_POST['can_add']) ? $_POST['can_add'] : '0';
                $can_update = isset($_POST['can_update']) ? $_POST['can_update'] : '0';
                $can_delete = isset($_POST['can_delete']) ? $_POST['can_delete'] : '0';
                
                if(move_uploaded_file($ftmp, $uploadfile))
                {   
                $users_add = $this->usersobj->addUsers($fname, $lname, $email, $mobile, $username, $password, $profile_picture, $can_view, $can_add, $can_update, $can_delete);
                if ($users_add) {
                    header('location: home.php?controller=users&action=getUsers');
                } else {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
            }
            }
        }

        $view_file = '/views/add_users.php';
        require_once APP_DIR . '/views/layout.php';
    }

    public function updateUsers() {
        $page_header = 'Update User Details';
        $extra_js_files = $this->extra_js_files;

        $id = trim($_GET['id']);
        if (!empty($_POST)) {
            $errors = array();

            $fname = strtolower(trim($_POST['fname']));

            if (empty($errors)) {
                $id = trim($_POST['id']);
                $fname = !empty($_POST['fname']) ? $_POST['fname'] : NULL;
                $lname = !empty($_POST['lname']) ? $_POST['lname'] : NULL;
                $email = !empty($_POST['email']) ? trim($_POST['email']) : NULL;
                $mobile = !empty($_POST['mobile']) ? trim($_POST['mobile']) : NULL;
                $username = !empty($_POST['username']) ? $_POST['username'] : NULL;
                $password = !empty($_POST['password']) ? $_POST['password'] : NULL;
                $can_view = isset($_POST['can_view']) ? $_POST['can_view'] : '0';
                $can_add = isset($_POST['can_add']) ? $_POST['can_add'] : '0';
                $can_update = isset($_POST['can_update']) ? $_POST['can_update'] : '0';
                $can_delete = isset($_POST['can_delete']) ? $_POST['can_delete'] : '0';

                $users_upd = $this->usersobj->updateUsers($id, $fname, $lname, $email, $mobile, $username, $password, $can_view, $can_add, $can_update, $can_delete);


                if ($users_upd) {
                    header('location: home.php?controller=users&action=getUsers');
                } else {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
            }
        }

        $users = array();

        $users_res = $this->usersobj->getUser($id);
        if ($users_res->num_rows == 1) {
            while ($user = mysqli_fetch_assoc($users_res)) {
                $users[] = $user;
            }
            $view_file = '/views/update_users.php';
            require_once APP_DIR . '/views/layout.php';
        } else {
            header('location: home.php?controller=error&action=index');
        }
    }

    public function deleteUsers() {
        if (is_array($_POST['id'])) {
            $ids = $_POST['id'];
            $deleted = array();
            foreach ($ids as $id) {
                $user = $this->usersobj->deleteUsers($id);
                if ($user) {
                    array_push($deleted, $id);
                }
            }
            echo json_encode($deleted);
        } else {
            $id = $_POST['id'];
            $user = $this->usersobj->deleteUsers($id);
            if ($user) {
                echo 'deleted';
            }
        }
    }

}

?>