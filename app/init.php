<?php
include 'config.php';
require 'Medoo.php';
require_once 'model/Author.php';
require_once 'model/Lecture.php';
require_once 'model/Poster.php';
require_once 'model/Breaktime.php';
require_once 'model/Schedule.php';

require_once 'service/userViewDAO.php';
require_once 'service/adminViewDAO.php';
require_once 'service/mobileAppDAO.php';

require_once 'view/JSONView/JSONView.php';
require_once 'view/userView/lecturesList.php';
require_once 'view/adminPanel/newLectureForm.php';
require_once 'view/adminPanel/newPosterForm.php';
require_once 'view/adminPanel/removeForm.php';

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
$userCode = $request[0];

//Check if user with such code exists
$userData = $database->select("Users", [
    "fname",
    "code",
    "didVote",
    "isAdmin",
    "email"], [
    "code" => $userCode]);

//If so, then construct page
if (count($userData) == 1) {
    $userRequest = $request[1];    
    $rawDataRequest = $request[2];
    $isAdmin = ($userData[0]["isAdmin"] == 1);
    //check if its mobile app json request
    if ($userRequest == JSON_REQUEST) {
        $json = new JSONView(new mobileAppDAO($database));
        if ($rawDataRequest == JSON_REQUEST_LECTURES) {
            $json->showLectures();
        }
        if ($rawDataRequest == JSON_REQUEST_POSTERS) {
            $json->showPosters();
        }
        if ($rawDataRequest == JSON_REQUEST_BREAKS) {
            $json->showBreaks();
        } 
    } else if ($isAdmin && $userRequest == ADMIN_PANEL_REQUESTCODE) {               
        ob_start(); 
        require("view/adminPanel/adminViewLayout.php"); 
        ob_end_flush();
    } else if ($isAdmin && $userRequest == 'signoff') {
        ob_start(); 
        require("view/adminPanel/logout.php"); 
        ob_end_flush();
    } else if (is_null($userRequest)) { 
        $uvc = new userViewDAO($database);
        $ll = new lecturesList($uvc->getLectures());
        ob_start(); 
        require("view/userView/userViewLayout.php"); 
        ob_end_flush();
    }
} else if (empty($userCode)) { // insert code page
    ob_start(); 
    require("view/userView/insertCodePage.php"); 
    ob_end_flush();
} else { //code invalid
    http_response_code(404);
    include('view/error/404.php');
    die();
}
?>
