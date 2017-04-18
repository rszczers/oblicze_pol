<?php
class adminController {
    private $database;
    private $admindao;
    
    function __construct($database, $admindao) {
        $this->database = $database;
        $this->admindao = $admindao;
    }
    
    public function view($request) {
        ob_start();
        session_start();

        if (!empty($_POST['password'])) {
            if ($_POST['password'] == ADMIN_PANEL_PASSWD) {
                $_SESSION['valid'] = true;
                $_SESSION['timeout'] = time();                       
            }
        } 
        
        include(dirname(__DIR__) . '/view/adminPanel/adminViewHeader.php');
        if ($_SESSION['valid'] == true) {
            include(dirname(__DIR__) . '/view/adminPanel/adminViewNavbar.php');                 
            if ($request == "addUser") {
                $data = new newUserForm();
            } else if ($request == "rmUser") {
                //TODO
            } else if ($request == "addLecture") {
                $data = new newLectureForm(
                    $admindao->getNonLectureAuthors(),
                    $admindao->getNonUsedSchedules()); 
            } else if ($request == "addPoster") {
                $data = new newPosterForm(
                    $admindao->getNonPosterAuthors(),
                    $admindao->getSchedules());
            } else if ($request == "rmEvent") {
                $data = new removeForm(
                    $admindao->getLectures(),
                    $admindao->getPosters());
            } else if ($request == "addBreak") {
                $data = new newBreakForm($admindao->getSchedules());
            } else if ($request == "rmBreak") {
                $data = new removeBreakForm($admindao->getBreaks());
            } else if ($request == "addTerm") {
                $data = new newScheduleForm();
            } else if ($request == "rmTerm") {            
                $data = new removeScheduleForm($admindao->getSchedules());
            } else if ($request == 'logout') {
                ob_start(); 
                require(dirname(__DIR__) . "/view/adminPanel/logout.php"); 
                ob_end_flush();
            } else if ($request == 'main') {
                $data = new adminWelcome();
            } else {
                header("Location: http://" . PAGE_ADDRESS . ADMIN_PANEL_REQUESTCODE . "/main");
                exit();
            }
        } else {
            if (is_null($request)) {
                header("Location: " . ADMIN_PANEL_REQUESTCODE . "/login");
                exit();
            } else {
                if ($request == "login") {
                    $data = new loginForm();
                } else {
                    http_response_code(404);
                    include('view/error/404.php');
                    die();
                }                
            }
        }
        
        ob_start(); 
        require(dirname(__DIR__) . '/view/adminPanel/adminViewLayout.php'); 
        ob_end_flush();
    }
}

