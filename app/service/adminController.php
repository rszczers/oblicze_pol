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
        if (isset($_SESSION['valid']) && $_SESSION['valid'] == true) {
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
                    $this->admindao->removeUser($_POST["usersToRemove"]);
                }
                $data = new removeUserForm($this->admindao->getUsers());                
            } else if ($request == "addLecture") {
                if (isset($_POST["newLectureTitle"],
                        $_POST["newLectureAbstract"],
                        $_POST["newLectureTime"],
                        $_POST["newLectureAuthors"],
                        $_POST["newLectureTags"])) {
                    $this->admindao->addLecture(
                            $_POST["newLectureTitle"],
                            $_POST["newLectureAbstract"],
                            $_POST["newLectureTime"],
                            $_POST["newLectureAuthors"],
                            $_POST["newLectureTags"]
                            );
                }
                $data = new newLectureForm(
                    $this->admindao->getNonLectureUsers(),
                    $this->admindao->getNonUsedSchedules()); 
            } else if ($request == "addPoster") {
                if (isset($_POST["newPosterTitle"],
                        $_POST["newPosterAbstract"],
                        $_POST["newPosterTime"],
                        $_POST["newPosterAuthors"],
                        $_POST["newPosterTags"])) {
                    $this->admindao->addPoster(
                            $_POST["newPosterTitle"],
                            $_POST["newPosterAbstract"],
                            $_POST["newPosterTime"],
                            $_POST["newPosterAuthors"],
                            $_POST["newPosterTags"]
                            );
                }
                $data = new newPosterForm(
                    $this->admindao->getNonPosterUsers(),
                    $this->admindao->getSchedules());
            } else if ($request == "rmEvent") {
                if (isset($_POST["lecturesToRemove"])) {
                    $this->admindao->removeLecture($_POST["lecturesToRemove"]);                    
                }
                if (isset($_POST["postersToRemove"])) {
                    $this->admindao->removePoster($_POST["postersToRemove"]);
                }
                $data = new removeForm(
                    $this->admindao->getLectures(),
                    $this->admindao->getPosters());
            } else if ($request == "addBreak") {
                //TODO
                $data = new newBreakForm($this->admindao->getSchedules());
            } else if ($request == "rmBreak") {
                //TODO
                $data = new removeBreakForm($this->admindao->getBreaks());
            } else if ($request == "addTerm") {
                if (isset($_POST["newDay"])) {
                    $this->admindao->addDay($_POST["newDay"]);
                }
                if (isset($_POST["newScheduleDay"],
                        $_POST["newScheduleStart"],
                        $_POST["newScheduleEnd"],
                        $_POST["newSchedulePlace"])) {
                    $this->admindao->addSchedule(
                            $_POST["newScheduleDay"],
                            $_POST["newScheduleStart"],
                            $_POST["newScheduleEnd"],
                            $_POST["newSchedulePlace"]);
                }
                $data = new newScheduleForm($this->admindao->getDays());
            } else if ($request == "rmTerm") {
                if (isset($_POST["removeSchedulesSelect"])) {
                    $this->admindao->removeSchedule($_POST["removeSchedulesSelect"]);
                }
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
                } else if ($request == "error") {
                    http_response_code(404);
                    include(dirname(__DIR__) . '/view/error/404.php');
                    die();
                } else {
                    header("Location: " . ADMIN_PANEL_REQUESTCODE . "/error");
                    exit();
                }                
            }
        }
        
        ob_start(); 
        require(dirname(__DIR__) . '/view/adminPanel/adminViewLayout.php'); 
        ob_end_flush();
    }
}