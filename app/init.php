<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    
include 'config.php';
require 'vendor/Medoo.php';

require_once 'model/User.php';
require_once 'model/Author.php';
require_once 'model/Lecture.php';
require_once 'model/Poster.php';
require_once 'model/Breaktime.php';
require_once 'model/Schedule.php';

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

if (count($userData) == 1) {
    $userID = isset($userData[0]["user_id"]) ? $userData[0]["user_id"] : NULL;
    $didVote = $userData[0]["didVote"] != 0;
    if ($didVote) {        
        ob_start(); 
        require("view/userView/alreadyVoted.php"); 
        ob_end_flush();
    } else if (!$didVote && $userRequest == 'poll') {
        if (isset($_POST["lectures"], $_POST["posters"])) {
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
        } 
        $database->update("Users", ["didVote" => 1], [
            "user_id" => $userID
        ]);
        ob_start(); 
        require("view/userView/thanksView.php"); 
        ob_end_flush();
    } else if (is_null($userRequest)) {
        require_once 'view/userView/lecturesList.php';
        require_once 'view/userView/posterList.php';
        require_once 'service/userViewDAO.php';
        ob_start(); 
        require("view/userView/userViewLayout.php"); 
        ob_end_flush();
    }
} else if ($userCode == JSON_REQUEST) {
    require_once 'service/mobileAppDAO.php';
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
} else if ($userCode == QRCODE_REQUEST) {
    include 'vendor/phpqrcode/qrlib.php';
    if (!is_null($userRequest)) {
        $dboutput = $database->select("Users", 
                ["code"],
                ["code" => $userRequest]);        
        if (count($dboutput) == 1) {
            QRcode::png($userRequest);
        } else {
            echo "Nie ma takiego kodu.";
        }
    }
} else if (empty($userCode)) { // insert code page
    ob_start(); 
    require("view/userView/insertCodePage.php"); 
    ob_end_flush();
} else if ($userCode == ADMIN_PANEL_REQUESTCODE) {
    require_once 'service/adminController.php';
    require_once 'service/adminViewDAO.php';
    $admindao = new adminViewDAO($database);
    $adminController = new adminController($database, $admindao);
    $adminController->view($userRequest);
} else if ($userCode == POLL_RESULTS) {
    require_once 'service/userViewDAO.php';   
    $udao = new userViewDAO($database);
    if ($udao->isVotingOver() == true) {
        ob_start(); 
        require("view/userView/pollResults.php"); 
        ob_end_flush();
    } else {
        http_response_code(404);
        include('view/error/404.php');
        die();
    }
} else { //code invalid
    http_response_code(404);
    include('view/error/404.php');
    die();
}
?>