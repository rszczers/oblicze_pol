<?php
class adminViewController {
    private $database;
    
    function __construct($database) {
        $this->database = $database;
    }
    
    public function getUsedSchedules() {
        return $this->database->query(
               "SELECT * FROM `Schedule` 
                WHERE `schedule_id` 
                IN (
                    SELECT DISTINCT `schedule_id` 
                    FROM (
                        SELECT `schedule` FROM `Lectures`
                        UNION
                        SELECT `schedule` FROM `Posters`
                    )  AS sid
                )")->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getNonLectureAuthors() {
        return $this->database->select("Authors", [
            "author_id",
            "fname",
            "sname",
            "email"
        ], [ 
            "lecture_id" => null
        ]);       
    }
    
    public function getNonPosterAuthors() {
        return $this->database->select("Authors", [
            "author_id",
            "fname",
            "sname",
            "email"
        ], [ 
            "poster_id" => null
        ]);       
    }

    public function getLectures() {
        return $this->database->select("Lectures", ["[>]Schedule" => ["schedule" => "schedule_id"]], [
            "Lectures.lecture_id",
            "Lectures.title",
            "Lectures.abstract",
            "Lectures.place",
            "Schedule.schedule_id",
            "Schedule.start",
            "Schedule.end",
            "Schedule.date"]);
    }        
      
    public function addPoster($title, $abstract, $schedule_id, $place, $auhors_id, $tags) {        
        $this->database->insert("Posters", [
            "title" => $title,
            "abstract" => $abstract,
            "schedule" => $schedule_id,
            "place" => $place
        ]);
        
        //update Authors table with recent data
        $newPosterID = $this->database->id();
        foreach ($authors_id as $id) {
            $this->database->update("Authors", [
                "poster_id" => $newPosterID
            ], [
                "author_id" => $id
            ]);
        }
        
        if (is_string($tags)) {
            $tags = explode(' ', $tags);
            foreach ($tags as $tag) {
                $this->database->insert("PosterTags", [
                    "poster" => $newPosterID,
                    "tag" => $tag
                ]);
            }
        }
    }
    
    public function removePoster($id) {
        return $this->database->delete("Posters", [
            'poster_id' => $id
        ]);
    }

    public function addLecture($title, $abstract, $schedule_id, $place, $auhors_id, $tags) {
        $this->database->insert("Lectures", [
            "title" => $title,
            "abstract" => $abstract,
            "schedule" => $schedule_id,
            "place" => $place
        ]);
        
        //update Authors table with recent data
        $newLectureID = $this->database->id();
        foreach ($authors_id as $id) {
            $this->database->update("Authors", [
                "lecture_id" => $newPosterID
            ], [
                "author_id" => $id
            ]);
        }
        
        if (is_string($tags)) {
            $tags = explode(' ', $tags);
            foreach ($tags as $tag) {
                $this->database->insert("LectureTags", [
                    "poster" => $newLectureID,
                    "tag" => $tag
                ]);
            }
        }
    }
    
    public function removeLecture($id) {
        return $this->database->delete("Lectures", [
            'lecture_id' => $id
        ]);        
    }
    
    public function addUser($fname, $sname, $code, $didVote, $isAdmin, $email) {
        return $this->database->insert("Users", [
            "fname" => $fname,
            "sname" => $sname,
            "code" => $code,
            "didVote" => $didVote,
            "isAdmin" => $isAdmin,
            "email" => $email
        ]);
    }
    
    public function removeUser($id) {
        return $this->database->delete("Users", [
            'user_id' => $id
        ]);
    }

    public function generateCode() {
        $newCode = $this->readableRandomString();
        $userData = $database->select("Users", [
            "user_id"], [
            "code" => $newCode]);
        if (is_null($userData)) {
            $this->generateCode();
        } else {
            return $newCode;
        }
    }
    
    private function readableRandomString($length = 6) {
        $string     = '';
        $vowels     = array("a","e","i","o","u");  
        $consonants = array(
            'b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 
            'n', 'p', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z'
        );  
        // Seed it
        srand((double) microtime() * 1000000);
        $max = $length/2;
        for ($i = 1; $i <= $max; $i++)
        {
            $string .= $consonants[rand(0,19)];
            $string .= $vowels[rand(0,4)];
        }
        return $string;
    }
}