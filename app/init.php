<?php
include 'config.php';
require 'Medoo.php';
require_once 'model/Author.php';
require_once 'model/Lecture.php';
require_once 'model/Poster.php';
require_once 'model/Timebreak.php';

require_once 'controller/userViewController.php';
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
    "email"], [
    "code" => $userCode]);
//If so, then construct poll page
if (count($userData) > 0) {
    $uvc = new userViewController($database);
    $lectureList = new lecturesList($uvc->getLectures());
    ob_start(); 
    require("view/userView/userViewLayout.php"); 
    ob_end_flush();
} else { //else, print 'check your code' error
    echo "Error";
}
?>
