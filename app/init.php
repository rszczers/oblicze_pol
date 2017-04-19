<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    
include 'config.php';
require 'Medoo.php';
require_once 'model/User.php';
require_once 'model/Author.php';
require_once 'model/Lecture.php';
require_once 'model/Poster.php';
require_once 'model/Breaktime.php';
require_once 'model/Schedule.php';

require_once 'service/userViewDAO.php';
require_once 'service/adminViewDAO.php';
require_once 'service/mobileAppDAO.php';
require_once 'service/adminController.php';

require_once 'view/JSONView/JSONView.php';
require_once 'view/userView/lecturesList.php';
require_once 'view/userView/posterList.php';
require_once 'view/adminPanel/Forms/newLectureForm.php';
require_once 'view/adminPanel/Forms/newPosterForm.php';
require_once 'view/adminPanel/Forms/newBreakForm.php';
require_once 'view/adminPanel/Forms/newUserForm.php';
require_once 'view/adminPanel/Forms/newScheduleForm.php';
require_once 'view/adminPanel/Forms/removeForm.php';
require_once 'view/adminPanel/Forms/removeBreakForm.php';
require_once 'view/adminPanel/Forms/removeScheduleForm.php';
require_once 'view/adminPanel/Forms/removeUserForm.php';
require_once 'view/adminPanel/Forms/loginForm.php';
require_once 'view/adminPanel/adminWelcome.php';

use Medoo\Medoo;
$database = new Medoo([
	// required
	'database_type' => DB_TYPE,
	'database_name' => DB_NAME,
	'server' => DB_HOST,
	'username' => DB_USER,
	'password' => DB_PASSWORD,
	'charset' => DB_CHARSET]
    );

$request = (isset($_GET['request']) ? explode('/', $_GET['request']) : null);
$userCode = isset($request[0]) ? $request[0] : NULL;
$userRequest = isset($request[1]) ? $request[1] : NULL;    
$methodRequest = isset($request[2]) ? $request[2] : NULL;

//Check if user with such code exists
$userData = $database->select("Users", [
    "user_id",
    "fname",
    "code",
    "didVote"], [
    "code" => $userCode]);

$userID = isset($userData[0]["user_id"]) ? $userData[0]["user_id"] : NULL;

if (count($userData) == 1) {
    //check if its mobile app json request
    if ($userRequest == 'poll') {
        $insert = array();
        foreach ($_POST["lectures"] as $lecture_id => $value) {
            array_push($insert, array(
               "user_id" => $userID,
               "lecture_id" => $lecture_id,
               "rate" => $value));
        }
        $database->insert("LectureRatings", $insert);
        
        $insert = array();
        foreach ($_POST["posters"] as $poster_id => $value) {
            array_push($insert, array(
               "user_id" => $userID,
               "poster_id" => $poster_id,
               "rate" => $value));
        }
        $database->insert("PosterRatings", $insert);
        ob_start(); 
            require("view/userView/thanksView.php"); 
        ob_end_flush();
    } else if (is_null($userRequest)) { 
        ob_start(); 
        require("view/userView/userViewLayout.php"); 
        ob_end_flush();
    }
} else if ($userCode == JSON_REQUEST) {
    $json = new JSONView(new mobileAppDAO($database));
    if ($userRequest == JSON_REQUEST_LECTURES) {
        $json->showLectures();
    } else if ($userRequest == JSON_REQUEST_POSTERS) {
        $json->showPosters();
    } else if ($userRequest == JSON_REQUEST_BREAKS) {
        $json->showBreaks();
    } else {
        //404
    }
} else if (empty($userCode)) { // insert code page
    ob_start(); 
    require("view/userView/insertCodePage.php"); 
    ob_end_flush();
} else if ($userCode == ADMIN_PANEL_REQUESTCODE) {
    $admindao = new adminViewDAO($database);
    $adminController = new adminController($database, $admindao);
    $adminController->view($userRequest);
} else { //code invalid
    http_response_code(404);
    include('view/error/404.php');
    die();
}
?>
