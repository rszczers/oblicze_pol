<?php

class adminViewDAO {
    private $database;
    
    function __construct($database) {
        $this->database = $database;
    }
    
    public function turnVotingOn() {
        $this->database->update("Config", ["isPollOver" => 0],
                ["isPollOver" => 1]);
    }
    
    public function turnVotingOff() {
        $this->database->update("Config", ["isPollOver" => 1],
                ["isPollOver" => 0]);
    }
    
    public function countLectures() {
        $dboutput = $this->database->select("Lectures",
                ["lecture_id"]);
        return count($dboutput);
    }
    
    public function countPosters() {
        $dboutput = $this->database->select("Poster",
                ["poster_id"]);
        return count($dboutput);
    }
    
    public function getLectureResults($n) {
        return $this->database->query(
            "SELECT E.lecture_id, SUM(E.rate) AS `score`, F.title, F.fullname
            FROM LectureRatings E
            LEFT JOIN (
                SELECT A.lecture_id, GROUP_CONCAT(`name` ORDER BY `name` ASC SEPARATOR ', ') AS `fullname`, A.title
                FROM `Lectures` A
                LEFT JOIN (
                    SELECT *
                    FROM `Authors` C
                    LEFT JOIN (
                        SELECT `user_id`, CONCAT(`fname`, ' ', `sname`) as `name`
                        FROM  `Users`
                        ) D
                        ON C.user = D.user_id
                    ) B
                ON A.lecture_id = B.lecture_id
                GROUP BY A.lecture_id
                ) F
            ON E.lecture_id = F.lecture_id
            GROUP BY E.lecture_id
            ORDER BY `score` DESC
            LIMIT ". $n)->fetchAll(PDO::FETCH_ASSOC);;        
    }
    
    public function getPosterResults($n) {
        return $this->database->query(
            "SELECT E.poster_id, SUM(E.rate) AS `score`, F.title, F.fullname
            FROM PosterRatings E
            LEFT JOIN (
                SELECT A.poster_id, GROUP_CONCAT(`name` ORDER BY `name` ASC SEPARATOR ', ') AS `fullname`, A.title
                FROM `Posters` A
                LEFT JOIN (
                    SELECT *
                    FROM `Authors` C
                    LEFT JOIN (
                        SELECT `user_id`, CONCAT(`fname`, ' ', `sname`) as `name`
                        FROM  `Users`
                        ) D
                        ON C.user = D.user_id
                    ) B
                ON A.poster_id = B.poster_id
                GROUP BY A.poster_id
                ) F
            ON E.poster_id = F.poster_id
            GROUP BY E.poster_id
            ORDER BY `score` DESC
            LIMIT ". $n)->fetchAll(PDO::FETCH_ASSOC);;        
    }
    
    public function getQRs($idArr) {
        $paths = array();
        foreach ($idArr as $id) {            
            $dboutput = $this->database->select("Users", [
                "code",
                "fname",
                "sname",
                "email"
                ], ["user_id" => $id]);
            $code = $dboutput[0]["code"];
            $content = 'http://' . PAGE_ADDRESS . $code;
            $path = dirname(dirname(__DIR__)) . '/public/' . QRCODE_CACHE_FOLDER . '/' . $code . '.png';
            $pathMin = dirname(dirname(__DIR__)) . '/public/' . QRCODE_CACHE_FOLDER . '/' . $code . '_min.png';
            if (!file_exists($path)) {
                QRcode::png($content, $path, QR_ECLEVEL_L, 25); 
                QRcode::png($content, $pathMin, QR_ECLEVEL_L, 5); 
                chmod($path, 0755); 
                chmod($pathMin, 0755); 
            }
            $path = 'http://' . PAGE_ADDRESS . 'public/' . QRCODE_CACHE_FOLDER . '/' . $code . '.png';
            $pathMin = 'http://' . PAGE_ADDRESS . 'public/' . QRCODE_CACHE_FOLDER . '/' . $code . '_min.png';
            $paths[$code] = array(
                $path,
                $pathMin,
                $dboutput[0]["fname"] . ' ' . $dboutput[0]["sname"],
                $dboutput[0]["email"]);
        }
        return $paths;
    }
    
    public function getCodes($idArr) {
        $codes = array();
        foreach ($idArr as $id) {
            $dboutput = $this->database->select("Users", ["code"], ["user_id" => $id]);
            array_push($codes, array($id => $dboutput[0]["code"]));
        }
        return $codes;
    }
    
    public function addBreak($title, $schedule_id) {
        if (!is_null($this->getScheduleById($schedule_id))) {
            $this->database->insert("Breaks", [
                "title" => $title,
                "schedule" => $schedule_id
            ]);
        }
    }
    
    public function removeBreaks($ids) {
        foreach ($ids as $id) {
            $this->database->delete("Breaks", [
                "break_id" => $id
            ]);
        }
    }
    
    public function getDays() {
        $dboutput = $this->database->select("Date", [
            "day"
        ]);
        
       $days = array();
       
       foreach ($dboutput as $day) {
           array_push($days, $day["day"]);
       }
       
       return $days;
    }
    
    public function addDay($day) {       
        $isNotThere = count($this->database->select("Date", ["day"],
                ["day" => $day])) == 0;
        if ($isNotThere) {
            $this->database->insert("Date", ["day" => $day]);
        }
    }
    
    public function removeDay($day) {
        $this->database->delete("Date", [
            "day" => $day
        ]);
    }
    
    public function removeDays($dayArr) {
        foreach ($dayArr as $day) {
            $this->database->delete("Date", [
                "day" => $day
            ]);
        }
    }
    
    public function removeSchedule($idArr) {
        foreach ($idArr as $id) {
            $this->database->delete("Schedule", [
                "schedule_id" => $id
            ]);
        }
    }
    
    public function getNonUsedSchedules() {
        $dboutput = $this->database->query(
               "SELECT * FROM `Schedule` 
                WHERE `schedule_id` 
                NOT IN (
                    SELECT DISTINCT `schedule` FROM `Lectures`
                    UNION
                    SELECT DISTINCT `schedule` FROM `Posters`
                    UNION
                    SELECT DISTINCT `schedule` FROM `Breaks`
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
    
    public function addSchedule($day, $start, $end, $place) {
        $this->database->insert("Schedule", [
            "start" => $start,
            "end" => $end,
            "date" => $day,
            "place" => $place
        ]);
    }
    
    public function getScheduleById($id) {
        $dboutput = $this->database->select("Schedule", [
            "schedule_id",
            "start",
            "end",
            "date",
            "place"
        ], [
            "schedule_id" => $id
        ]);
        
        $output = NULL;
        if (count($dboutput)==1) {
            $output = new Schedule($id,
                    $dboutput[0]["start"],
                    $dboutput[0]["end"],
                    $dboutput[0]["date"],
                    $dboutput[0]["place"]);
        }
        return $output;
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
            array_push($users, new User(
                    $user["user_id"],
                    $user["fname"], 
                    $user["sname"],
                    $user["email"]));
        }
        
        return $users;
    }

    public function getLectures() {
        $dboutput = $this->database->select("Lectures", 
                ["[>]Schedule" => ["schedule" => "schedule_id"]], [
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
            $authors = array();
            $relAuth = $this->database->query("SELECT * 
                    FROM `Authors` A
                    LEFT JOIN `Users` B
                    ON A.user = B.user_id
                    WHERE lecture_id = " . 
                    $lecture["lecture_id"])->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($relAuth as $author) {
                array_push($authors, new Author(
                        $author["author_id"],
                        $author["fname"],
                        $author["sname"],
                        $author["user_id"],
                        $author["email"]));
            }
            
            $tags = $this->database->select("LectureTags", [
                "tag"
            ], [
                "lecture" => $lecture["lecture_id"]
                ]);   
                    
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
                        $lecture["place"]),
                    $tags));
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
            $authors = array();
            $relAuth = $this->database->query("SELECT * 
                    FROM `Authors` A
                    LEFT JOIN `Users` B
                    ON A.user = B.user_id
                    WHERE poster_id = " . 
                    $poster["poster_id"])->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($relAuth as $author) {
                array_push($authors, new Author(
                        $author["author_id"],
                        $author["fname"],
                        $author["sname"],
                        $author["user_id"],
                        $author["email"]));
            }
            
            $tags = $this->database->select("PosterTags", [
                "tag"
            ], [
                "poster" => $poster["poster_id"]
                ]);                        
            
            array_push($posters, new Poster(
                    $poster["poster_id"],
                    $poster["title"],
                    $poster["abstract"],
                    $authors,
                    new Schedule(
                        $poster["schedule_id"],
                        $poster["start"],
                        $poster["end"],
                        $poster["date"],
                        $poster["place"]),
                    $tags));
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
      
    public function addPoster($title, $abstract, $schedule_id, $user_id, $tags) {        
        $this->database->insert("Posters", [
            "title" => $title,
            "abstract" => $abstract,
            "schedule" => $schedule_id
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
    
    public function removePoster($idArr) {
        foreach ($idArr as $id) {
            $this->database->delete("Posters", [
                'poster_id' => $id
            ]);
        }
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
    
    public function removeLecture($idArr) {
        foreach ($idArr as $id) {
            $this->database->delete("Lectures", [
                'lecture_id' => $id
            ]);        
        }
    }
    
    public function getUsers() {
        return $this->database->select("Users", [
            "user_id",
            "fname",
            "sname",
            "code",
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
    
    public function removeUser($idArr) {
        foreach ($idArr as $id) {
            $this->database->delete("Users", [
                'user_id' => $id
            ]);
        }
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