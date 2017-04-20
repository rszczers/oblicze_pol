<?php
include dirname(__DIR__) . '/vendor/phpqrcode/qrlib.php';
require_once dirname(__DIR__) . '/view/adminPanel/Forms/newLectureForm.php';
require_once dirname(__DIR__) . '/view/adminPanel/Forms/newPosterForm.php';
require_once dirname(__DIR__) . '/view/adminPanel/Forms/newBreakForm.php';
require_once dirname(__DIR__) . '/view/adminPanel/Forms/newUserForm.php';
require_once dirname(__DIR__) . '/view/adminPanel/Forms/newScheduleForm.php';
require_once dirname(__DIR__) . '/view/adminPanel/Forms/newDayForm.php';
require_once dirname(__DIR__) . '/view/adminPanel/Forms/removeForm.php';
require_once dirname(__DIR__) . '/view/adminPanel/Forms/removeBreakForm.php';
require_once dirname(__DIR__) . '/view/adminPanel/Forms/removeScheduleForm.php';
require_once dirname(__DIR__) . '/view/adminPanel/Forms/removeUserForm.php';
require_once dirname(__DIR__) . '/view/adminPanel/Forms/removeDayForm.php';
require_once dirname(__DIR__) . '/view/adminPanel/Forms/loginForm.php';
require_once dirname(__DIR__) . '/view/adminPanel/Forms/getUserQRForm.php';
require_once dirname(__DIR__) . '/view/adminPanel/adminWelcome.php';
require_once dirname(__DIR__) . '/view/adminPanel/qrImages.php';


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
        
        $content = array();
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
                array_push($content, new newUserForm());
            } else if ($request == "rmUser") {                
                if (isset($_POST["usersToRemove"])) {
                    $this->admindao->removeUser($_POST["usersToRemove"]);
                }
                array_push($content, 
                        new removeUserForm($this->admindao->getUsers()));
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
                array_push($content, new newLectureForm(
                    $this->admindao->getNonLectureUsers(),
                    $this->admindao->getNonUsedSchedules()));
                array_push($content,
                    new newScheduleForm($this->admindao->getDays()));
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
                array_push($content, new newPosterForm(
                    $this->admindao->getNonPosterUsers(),
                    $this->admindao->getSchedules()));
                array_push($content,
                    new newScheduleForm($this->admindao->getDays()));
            } else if ($request == "rmEvent") {
                if (isset($_POST["lecturesToRemove"])) {
                    $this->admindao->removeLecture($_POST["lecturesToRemove"]);                    
                }
                if (isset($_POST["postersToRemove"])) {
                    $this->admindao->removePoster($_POST["postersToRemove"]);
                }
                
                array_push($content, new removeForm(
                    $this->admindao->getLectures(),
                    $this->admindao->getPosters()));
            } else if ($request == "addBreak") {
                if (isset($_POST["newBreakTitle"],
                        $_POST["newBreakTime"])) {
                    $this->admindao->addBreak(
                            $_POST["newBreakTitle"],
                            $_POST["newBreakTime"]);
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
                
                array_push($content, 
                        new newBreakForm($this->admindao->getNonUsedSchedules()));
                array_push($content,
                        new newScheduleForm($this->admindao->getDays()));
            } else if ($request == "rmBreak") {
                if (isset($_POST["removeBreakSelection"])) {
                    $this->database->removeBreak($_POST["removeBreakSelection"]);
                }
                array_push($content,
                        new removeBreakForm($this->admindao->getBreaks()));
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
                array_push($content,
                        new newScheduleForm($this->admindao->getDays()));
                array_push($content,
                        new newDayForm($this->admindao->getDays()));
            } else if ($request == "rmTerm") {
                if (isset($_POST["removeSchedulesSelect"])) {
                    $this->admindao->removeSchedule($_POST["removeSchedulesSelect"]);
                }
                if (isset($_POST["removeDaySelect"])) {
                    $this->admindao->removeDays($_POST["removeDaySelect"]);
                }
                array_push($content,
                        new removeScheduleForm($this->admindao->getSchedules()));
                array_push($content, new removeDayForm($this->admindao->getDays()));
            } else if ($request == 'showQR') {
                
                $users = $this->admindao->getUsers();
                $idsToGet = array();
                foreach ($users as $user) {
                    array_push($idsToGet, $user["user_id"]);
                }

                array_push($content, new getUserQRForm($users));
                
                if (isset($_POST["qrCodeButton"], $_POST["userQRSelect"])) {
                        $paths = $this->admindao->getQRs($_POST["userQRSelect"]);
                        array_push($content, new qrImages($paths));
                }
                
            } else if ($request == 'logout') {
                ob_start(); 
                require(dirname(__DIR__) . "/view/adminPanel/logout.php"); 
                ob_end_flush();
            } else if ($request == 'main') {
                array_push($content, new adminWelcome());
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
                    array_push($content, new loginForm()); 
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