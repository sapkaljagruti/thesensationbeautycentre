<?php

class ProfileController {

    public $profileobj;
    public $extra_js_files;

    public function __construct() {

        require_once 'models/Profile.php';
        $this->profileobj = new Profile();

        $this->extra_js_files = array('js/profile.js', 'js/jquery.cropit.js');
    }

    public function update() {
        $page_header = 'Update Profile Details';
        $extra_js_files = $this->extra_js_files;

        $id = $_SESSION['admin_id'];

        if (!empty($_POST)) {
            $id = trim($_POST['id']);
            $fname = !empty($_POST['fname']) ? $_POST['fname'] : NULL;
            $lname = !empty($_POST['lname']) ? $_POST['lname'] : NULL;
            $email = !empty($_POST['email']) ? $_POST['email'] : NULL;
            $mobile = !empty($_POST['mobile']) ? $_POST['mobile'] : NULL;
            $username = !empty($_POST['username']) ? $_POST['username'] : NULL;
            $previous_image_name = !empty($_POST['previous_image_name']) ? $_POST['previous_image_name'] : NULL;
            $image_data = !empty($_POST['image-data']) ? $_POST['image-data'] : NULL;

            $errors = array();

            if (!empty($_FILES['profile_picture']['name'])) {
                $allowed_file_types = array('jpg', 'png', 'jpeg');
                $upload_dir = APP_DIR . '/public/images/';
                $file_actual_name = $_FILES['profile_picture']['name'];
                $file = "product_" . $id . "_" . rand(100, 5000) . "_" . $file_actual_name;
                $file_size = 200000;
                $allowed_file_types_string = implode("/", $allowed_file_types);
                $file_size_in_kb = $file_size / 1000;

                if (!in_array(strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION)), $allowed_file_types)) {
                    array_push($errors, 'Only ' . $allowed_file_types_string . ' files are allowed.');
                } elseif ($_FILES['profile_picture']['size'] > $file_size) {
                    array_push($errors, 'Photo size should be less than ' . $file_size_in_kb . 'KB');
                } elseif ($_FILES['profile_picture']['error'] > 0) {
                    array_push($errors, 'Something went wrong. Please try again later.');
                } else {
                    list($type, $image_data) = explode(';', $image_data);
                    list(, $image_data) = explode(',', $image_data);
                    $image_data = base64_decode($image_data);
                    if (file_put_contents($upload_dir . $file, $image_data)) {
                        $image_name = $file;
                    } else {
                        array_push($errors, 'Something went wrong. Please try again later.');
                    }
                }
            } else {
                $image_name = $previous_image_name;
            }

            if (empty($errors)) {

                $profile_upd = $this->profileobj->update($id, $fname, $lname, $email, $mobile, $username, $image_name);

                if ($profile_upd) {
                    $_SESSION['admin'] = $fname . ' ' . $lname;
                    $_SESSION['admin_profile_picture'] = $image_name;

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