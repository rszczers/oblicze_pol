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
                if (isset($_POST["newUserEmail"]) &&
                        isset($_POST["newUserFirstName"]) &&
                                isset($_POST["newUserSurname"])) {
                    $this->admindao->addUser($_POST["newUserFirstName"],
                            $_POST["newUserSurname"],
                            $_POST["newUserEmail"]);
                } 
                $data = new newUserForm();
            } else if ($request == "rmUser") {                
                if (isset($_POST["usersToRemove"])) {
                    foreach ($_POST["usersToRemove"] as $id) {
                            $this->admindao->removeUser($id);
                    }
                }
                $data = new removeUserForm($this->admindao->getUsers());                
            } else if ($request == "addLecture") {
                var_dump($_POST);
                $data = new newLectureForm(
                    $this->admindao->getNonLectureAuthors(),
                    $this->admindao->getNonUsedSchedules()); 
            } else if ($request == "addPoster") {
                $data = new newPosterForm(
                    $this->admindao->getNonPosterAuthors(),
                    $this->admindao->getSchedules());
            } else if ($request == "rmEvent") {
                $data = new removeForm(
                    $this->admindao->getLectures(),
                    $this->admindao->getPosters());
            } else if ($request == "addBreak") {
                $data = new newBreakForm($this->admindao->getSchedules());
            } else if ($request == "rmBreak") {
                $data = new removeBreakForm($this->admindao->getBreaks());
            } else if ($request == "addTerm") {
                $data = new newScheduleForm();
            } else if ($request == "rmTerm") {            
                $data = new removeScheduleForm($this->admindao->getSchedules());
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

