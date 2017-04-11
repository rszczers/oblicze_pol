<?php
include 'config.php';
require 'vendor/autoload.php';

require_once 'model/Lecture.php';
require_once 'model/Poster.php';
require_once 'model/Timebreak.php';

use Medoo\Medoo;
//Establish database connection
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
//else, print no such code error


if (count($userData) > 0) {
    echo "dziala2";
} else {
    echo "nie dziala2";
}
?>