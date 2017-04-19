<?php

class adminViewDAO {
    private $database;
    
    function __construct($database) {
        $this->database = $database;
    }
    
    public function getNonUsedSchedules() {
        $dboutput = $this->database->query(
               "SELECT * FROM `Schedule` 
                WHERE `schedule_id` 
                NOT IN (
                    SELECT DISTINCT `schedule` FROM `Lectures`
                    UNION
                    SELECT DISTINCT `schedule` FROM `Posters`
                )")->fetchAll(PDO::FETCH_ASSOC);
        
        $schedules = array();
        
        foreach ($dboutput as $schedule) {
            array_push($schedules, new Schedule(
                    $schedule["schedule_id"],
                    $schedule["start"],
                    $schedule["end"],
                    $schedule["date"],
                    $schedule["place"]));
        }
        
        return $schedules;
    }
    
    public function getSchedules() {
        $dboutput = $this->database->select("Schedule", [
            "schedule_id",
            "start",
            "end",
            "date",
            "place"
        ]);
        
        $schedules = array();
        
        foreach ($dboutput as $schedule) {
            array_push($schedules, new Schedule(
                    $schedule["schedule_id"],
                    $schedule["start"],
                    $schedule["end"],
                    $schedule["date"],
                    $schedule["place"]));
        }
        
        return $schedules;
    }
    
    public function getUsedSchedules() {
        $dboutput = $this->database->query(
               "SELECT * FROM `Schedule` 
                WHERE `schedule_id` 
                IN (
                    SELECT DISTINCT `schedule` FROM `Lectures`
                    UNION
                    SELECT DISTINCT `schedule` FROM `Posters`
                )")->fetchAll(PDO::FETCH_ASSOC);
        
                $schedules = array();
        
        foreach ($dboutput as $schedule) {
            array_push($schedules, new Schedule(
                    $schedule["schedule_id"],
                    $schedule["start"],
                    $schedule["end"],
                    $schedule["date"],
                    $schedule["place"]));
        }
        
        return $schedules;
    }
    
    public function getNonLectureUsers() {
        $dboutput = $this->database->select("Authors", [
            "[<]Users" => ["user" => "user_id"]
        ], [
            "Users.user_id",
            "Users.fname",
            "Users.sname",
            "Users.email"
        ], [ 
            "Authors.lecture_id" => null
        ]);
        
        $users = array();
        
        foreach ($dboutput as $user) {
            array_push($users, new User(
                    $user["user_id"],
                    $user["fname"], 
                    $user["sname"],
                    $user["email"]));
        }
        
        return $users;
    }   
    
    public function getNonPosterUsers() {
        $dboutput = $this->database->select("Authors", [
            "[<]Users" => ["user" => "user_id"]
        ], [
            "Users.user_id",
            "Users.fname",
            "Users.sname",
            "Users.email"
        ], [ 
            "Authors.poster_id" => null
        ]);
        
        $users = array();
        
        foreach ($dboutput as $user) {
            array_push($authors, new Users(
                    $user["user_id"],
                    $user["fname"], 
                    $user["sname"],
                    $user["email"]));
        }
        
        return $users;
    }

    public function getLectures() {
        $dboutput = $this->database->select("Lectures", ["[>]Schedule" => ["schedule" => "schedule_id"]], [
            "Lectures.lecture_id",
            "Lectures.title",
            "Lectures.abstract",
            "Schedule.schedule_id",
            "Schedule.start",
            "Schedule.end",
            "Schedule.date",
            "Schedule.place"]);                
        
        $lectures = array();
        
        foreach ($dboutput as $lecture) {
            $relAuth = $this->database->select("Authors", [
                        "author_id",
                        "fname",
                        "sname",
                        "user",
                        "email"], [
                            "lecture_id" => $lecture["lecture_id"]
                            ]);
            
            $authors = array();
            
            foreach ($relAuth as $author) {
                array_push($authors, new Author(
                        $author["author_id"],
                        $author["fname"],
                        $author["sname"],
                        $author["user"],
                        $author["email"]));
            }
                    
            array_push($lectures, new Lecture(
                    $lecture["lecture_id"],
                    $lecture["title"],
                    $lecture["abstract"],
                    $authors,
                    new Schedule(
                        $lecture["schedule_id"],
                        $lecture["start"],
                        $lecture["end"],
                        $lecture["date"],
                        $lecture["place"])));
        }
        
        return $lectures;
    }

    public function getPosters() {
        $dboutput = $this->database->select("Posters",
                ["[>]Schedule" => ["schedule" => "schedule_id"]],
                [
                    "Posters.poster_id",
                    "Posters.title",
                    "Posters.abstract",
                    "Schedule.schedule_id",
                    "Schedule.start",
                    "Schedule.end",
                    "Schedule.date",
                    "Schedule.place"
                    ]);
        
        $posters = array();
        
        foreach ($dboutput as $poster) {
            $relAuth = $this->database->select("Authors", [
                    "author_id",
                    "fname",
                    "sname",
                    "user",
                    "email"], [
                        "poster_id" => $poster["poster_id"]
                        ]);
            
            $authors = array();
            
            foreach ($relAuth as $author) {
                array_push($authors, new Author(
                        $author["author_id"],
                        $author["fname"],
                        $author["sname"],
                        $author["user"],
                        $author["email"]));
            }
            
            array_push($posters, new Poster(
                    $poster["poster_id"],
                    $poster["title"],
                    $poster["abstract"],
                    $authors,
                    new Schedule(
                        $lecture["schedule_id"],
                        $lecture["start"],
                        $lecture["end"],
                        $lecture["date"],
                        $lecture["place"])));
        }
        return $posters;        
    }
    
    public function getBreaks() {
        $dboutput = $this->database->select("Breaks", 
            ["[>]Schedule" => ["schedule" => "schedule_id"]],
            [
                "Breaks.break_id",
                "Breaks.title",
                "Schedule.schedule_id",
                "Schedule.date",
                "Schedule.start",
                "Schedule.end",
                "Schedule.place"
            ]);
        
        
        $breaks = array();
        
        foreach ($dboutput as $break) {
            array_push($breaks, new Breaktime(
                    $break["break_id"], 
                    $break["title"], 
                    new Schedule(
                            $break["schedule_id"],
                            $break["start"],
                            $break["end"],
                            $break["date"],
                            $break["place"])));
        }

        return $breaks;
    }
      
    public function addPoster($title, $abstract, $schedule_id, $users_id, $tags) {        
        $this->database->insert("Posters", [
            "title" => $title,
            "abstract" => $abstract,
            "schedule" => $schedule_id,
        ]);
        
        //update Authors table with recent data
        $newPosterID = $this->database->id();
        foreach ($user_id as $id) {
            $isThereAlready = count($this->database->select("Authors",
                    ["user"],
                    ["user" => $id])) > 0;
            if ($isThereAlready) {
                $this->database->update("Authors", [
                    "poster_id" => $newPosterID
                ], [
                    "user" => $id
                ]);
            } else {
                $this->database->insert("Authors", [
                    "user" => $id,
                    "poster_id" => $newPosterID
                ]);
            }
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

    public function addLecture($title, $abstract, $schedule_id, $user_id, $tags) {
        $this->database->insert("Lectures", [
            "title" => $title,
            "abstract" => $abstract,
            "schedule" => $schedule_id,
        ]);
        
        //update Authors table with recent data
        $newLectureID = $this->database->id();
        foreach ($user_id as $id) {
            $isThereAlready = count($this->database->select("Authors",
                    ["user"],
                    ["user" => $id])) > 0;
            if ($isThereAlready) {
                $this->database->update("Authors", [
                    "lecture_id" => $newLectureID
                ], [
                    "user" => $id
                ]);
            } else {
                $this->database->insert("Authors", [
                    "user" => $id,
                    "lecture_id" => $newLectureID
                ]);
            }
        }
        
        if (is_string($tags)) {
            $tags = explode(' ', $tags);
            foreach ($tags as $tag) {
                $this->database->insert("LectureTags", [
                    "lecture" => $newLectureID,
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
    
    public function getUsers() {
        return $this->database->select("Users", [
            "user_id",
            "fname",
            "sname",
            "email"
        ]);
    }
    
    public function addUser($fname, $sname, $email) {
        return $this->database->insert("Users", [
            "fname" => $fname,
            "sname" => $sname,
            "code" => $this->generateCode($this->readableRandomString(9)),
            "email" => $email
        ]);
    }
    
    public function removeUser($id) {
        return $this->database->delete("Users", [
            'user_id' => $id
        ]);
    }
    
    private function generateCode($code) {
        $userData = $this->database->select("Users", [
            "user_id"], [
            "code" => $code]);
        if (count($userData)>0) {
            $code = generateCode($this->readableRandomString(9));
        }
        return $code;
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