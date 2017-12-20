<?php

class ProfileController {

    public $profileobj;

    public function __construct() {

        require_once 'models/Profile.php';
        $this->profileobj = new Profile();
    }

    public function update() {
        $page_header = 'Update Profile Details';

        $id = $_SESSION['admin_id'];
        if (!empty($_POST)) {
            $errors = array();

            if (empty($errors)) {
                $id = trim($_POST['id']);
                $fname = !empty($_POST['fname']) ? $_POST['fname'] : NULL;
                $lname = !empty($_POST['lname']) ? $_POST['lname'] : NULL;
                $email = !empty($_POST['email']) ? $_POST['email'] : NULL;
                $mobile = !empty($_POST['mobile']) ? $_POST['mobile'] : NULL;
                $username = !empty($_POST['username']) ? $_POST['username'] : NULL;

                $profile_upd = $this->profileobj->update($id, $fname, $lname, $email, $mobile, $username, $profile_picture);

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
            $view_file = '/views/update_profile.php';
            require_once APP_DIR . '/views/layout.php';
        } else {
            header('location: home.php?controller=error&action=index');
        }
    }

}

?>