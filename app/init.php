<?php
include 'config.php';
require 'vendor/autoload.php';

require_once 'model/Author.php';
require_once 'model/Lecture.php';
require_once 'model/Poster.php';
require_once 'model/Timebreak.php';

require_once 'controller/userViewController.php';

//require_once 'view/userView.php';
//require_once 'view/adminView.php';

use Medoo\Medoo;
//Establish database connection
//$lectureAuthors = array();
//$posterAuthors = array();
//$lectures = array();
//$posters = array();

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
    $uvc = new userViewController($database);
    $test = $uvc->getPosters();
    echo "<pre>";
    var_dump($test);
    echo "</pre>";
    
//    $lecturesData = $database->select("Lectures", 
//        ["[>]Schedule" => ["schedule" => "schedule_id"]],
//        [
//            "Lectures.lecture_id",
//            "Lectures.title",
//            "Lectures.abstract",
//            "Schedule.start",
//            "Schedule.end",
//            "Schedule.date",    
//            "Lectures.place"]);
//    
//    $postersData = $database->select("Posters", 
//        ["[>]Schedule" => ["schedule" => "schedule_id"]],
//        [
//            "Posters.poster_id",
//            "Posters.title",
//            "Posters.abstract",
//            "Schedule.start",
//            "Schedule.end",
//            "Schedule.date",    
//            "Posters.place"]);
//    
//    $relatedAuthors = $database->select("Authors",
//        [
//            "[>]Lectures" => ["lecture_id" => "lecture_id"],
//            "[>]Posters" => ["poster_id" => "poster_id"]],
//        [
//            "Authors.fname",
//            "Authors.sname",
//            "Authors.email",
//            "Lectures.lecture_id",
//            "Posters.poster_id"
//            ]);
//    
//    //construct array of days
//    //construct array of Lectures for each day
//    //construct array of Posters for each day
////    new userView();
//    
//    foreach ($relatedAuthors as $author) {
//        $newAuthor = new Author(
//                    $author["fname"],
//                    $author["sname"],
//                    $author["email"]); 
//        
//        if (!is_null($author["lecture_id"])) {
//            if (array_key_exists($author["lecture_id"], $lectureAuthors)) {
//                array_push($lectureAuthors[$author["lecture_id"]], $newAuthor);               
//            } else {
//                $lectureAuthors[$author["lecture_id"]] = array($newAuthor);
//            }
//        }       
//        if (!is_null($author["poster_id"])) {
//            if (array_key_exists($author["poster_id"], $posterAuthors)) {
//                array_push($posterAuthors[$author["poster_id"]], $newAuthor);
//            } else {
//                $posterAuthors[$author["poster_id"]] = array($newAuthor);
//            }
//        }    
//    };
//       
//    foreach ($lecturesData as $lecture) {
//        $lectures[$lecture["lecture_id"]] = new Lecture(
//            $lecture["title"],
//            $lecture["abstract"],
//            $lectureAuthors[$lecture["lecture_id"]],
//            $lecture["date"],
//            $lecture["start"],
//            $lecture["end"],
//            $lecture["place"]);
//    }
//    
//    foreach ($postersData as $poster) {
//        $posters[$poster["poster_id"]] = new Poster(
//            $poster["title"],
//            $poster["abstract"],
//            $posterAuthors[$poster["poster_id"]],
//            $poster["date"],
//            $poster["start"],
//            $poster["end"],
//            $poster["place"]);
//    }
//    
//    
} else {
    echo "Error";
}
?>