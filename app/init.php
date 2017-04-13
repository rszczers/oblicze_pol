<?php
include 'config.php';
require 'Medoo.php';
require_once 'model/Author.php';
require_once 'model/Lecture.php';
require_once 'model/Poster.php';
require_once 'model/Breaktime.php';

require_once 'controller/userViewController.php';
require_once 'controller/mobileAppController.php';
require_once 'view/userView/lecturesList.php';

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
if (count($userData) > 0) {
    $userRequest = $request[1];    
    $rawDataRequest = $request[2];
    $isAdmin = $userData[0]["isAdmin"];
    
    //check if its mobile app json request
    if ($userRequest == JSON_REQUEST) {
        $mac = new mobileAppController($database);
        if ($rawDataRequest == JSON_REQUEST_LECTURES) {
            $lectures = $mac->getLectures();
            $json = array();
            foreach ($lectures as $lecture) {
                array_push($json, $lecture->jsonSerialize());            
            }
            print_r(json_encode($json, JSON_PRETTY_PRINT));
        }
        if ($rawDataRequest == JSON_REQUEST_POSTERS) {
            $posters = $mac->getPosters();
            $json = array();
            foreach ($posters as $poster) {
                array_push($json, $poster->jsonSerialize());            
            }
            print_r(json_encode($json, JSON_PRETTY_PRINT));
        }
        if ($rawDataRequest == JSON_REQUEST_BREAKS) {
            $breaks = $mac->getBreaks();
            $json = array();
            foreach ($breaks as $break) {
                array_push($json, $break->jsonSerialize());
            }
            print_r(json_encode($json, JSON_PRETTY_PRINT));
        }
    } else if ($userRequest == ADMIN_PANEL_REQUESTCODE &&
            $isAdmin) {
        ob_start(); 
        require("view/adminPanel/adminViewLayout.php"); 
        ob_end_flush();
    } else if (is_null($userRequest)) { 
        $uvc = new userViewController($database);
        $lectureList = new lecturesList($uvc->getLectures());
        ob_start(); 
        require("view/userView/userViewLayout.php"); 
        ob_end_flush();
    }
} else { //else, print 'check your code' error
    echo "Error";
}
?>
