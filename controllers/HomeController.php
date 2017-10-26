<?php

class HomeController {

    public $ex_ins_staff_members_nots;

    public function __construct() {

        require_once 'models/Staff.php';
        $this->staffobj = new Staff();

        $this->ex_ins_staff_members_nots = array();

        $ex_ins_staff_members_res = $this->staffobj->getInsuranceExStaff();
        if ($ex_ins_staff_members_res->num_rows > 0) {
            while ($ex_ins_staff_members = mysqli_fetch_assoc($ex_ins_staff_members_res)) {
                $this->ex_ins_staff_members_nots[] = $ex_ins_staff_members;
            }
        }
    }

    public function index() {
        $page_header = 'Welcome To Sensation Beauty Center';
        
        $ex_ins_staff_members_nots = $this->ex_ins_staff_members_nots;
        $view_file = '/views/home.php';
        require_once APP_DIR . '/views/layout.php';
    }

}

?>