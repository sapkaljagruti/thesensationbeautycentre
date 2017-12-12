<?php

class ProfileController {

    public $profileobj;

    public function __construct() {

        require_once 'models/Profile.php';
        $this->profileobj = new Profile();


        $this->extra_js_files = array('plugins/datatables/jquery.dataTables.min.js', 'plugins/datatables/dataTables.bootstrap.min.js', 'plugins/select2/select2.full.js', 'js/account_groups.js');
    }

    public function update() {
        $page_header = 'Profile';
        $extra_js_files = $this->extra_js_files;

//        **Code starts**
//        $id = trim($_GET['id']);
        if (!empty($_POST)) {
            $errors = array();

//            $folder = "uploads/";
//            $uploadfile=$folder.basename($_FILES['$profile_picture']['name']);
//            $ftmp=$_FILES['$profile_picture']['tmp_name'];
//            
            $fname = strtolower(trim($_POST['fname']));

            if (empty($errors)) {
                $id = trim($_POST['id']);
                $fname = !empty($_POST['fname']) ? $_POST['fname'] : NULL;
                $lname = !empty($_POST['lname']) ? $_POST['lname'] : NULL;
                $email = !empty($_POST['email']) ? $_POST['email'] : NULL;
                $mobile = !empty($_POST['mobile']) ? $_POST['mobile'] : NULL;
                $username = !empty($_POST['username']) ? $_POST['username'] : NULL;
//                $profile_picture = !empty($_FILES['$profile_picture']) ? $_FILES['profile_picture'] : NULL;

//                if(move_uploaded_file($ftmp, $uploadfile))
//                {
                $profile_upd = $this->profileobj->update($id, $fname, $lname, $email, $mobile, $username, $profile_picture);

//                    $image=$_FILES['$profile_picture']['name'];
//                    $img="uploads/".$image;
//                    
//                }

                if ($profile_upd) {
                    header('location: home.php?controller=profile&action=update');
                } else {
                    array_push($errors, 'Something went wrong. Please try again later.');
                }
            }
        }

        $profiles = array();

        $profiles_res = $this->profileobj->getProfile($id);
        if ($profiles_res->num_rows == 1) {
            while ($profile = mysqli_fetch_assoc($profiles_res)) {
                $profiles[] = $profile;
            }
            $view_file = '/views/add_profile.php';
            require_once APP_DIR . '/views/layout.php';
        } else {
            header('location: home.php?controller=error&action=index');
        }
    }

//        **Code ends**
}

?>