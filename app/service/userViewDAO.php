<?php
class userViewDAO {
    protected $database;
    
    function __construct($databaseHandler) {      
        $this->database = $databaseHandler;
    }       
    
    public function isVotingOver() {
        $dboutput = $this->database->select("Config", ["isPollOver"]);    
        return intval($dboutput[0]["isPollOver"]) == 1;
    }        
    
    private function getLecturesData() {
        return $this->database->select("Lectures", 
                ["[>]Schedule" => ["schedule" => "schedule_id"]], [
            "Lectures.lecture_id",
            "Lectures.title"]);
    }
    
    private function getPostersData() {
        return $this->database->select("Posters", 
                ["[>]Schedule" => ["schedule" => "schedule_id"]], [
            "Posters.poster_id",
            "Posters.title"]);
    }
    
    private function getLectureTagsData() {
        return $this->database->select("LectureTags", [
            "tag_id",
            "lecture",
            "tag"
        ]);
    }
    
    private function getPosterTagsData() {
        return $this->database->select("PosterTags", [
            "tag_id",
            "poster",
            "tag"
        ]);
    }
    
    private function matchPosterTags($tagsData, $id) {
        $output = array();
        foreach ($tagsData as $row) {
            if ($row["poster"] == $id) {
                array_push($output, $row["tag"]);
            }
        }
        return $output;        
    }
    
    private function matchLectureTags($tagsData, $id) {
        $output = array();
        foreach ($tagsData as $row) {
            if ($row["lecture"] == $id) {
                array_push($output, $row["tag"]);
            }
        }
        return $output;        
    }
    
    private function matchLectureAuthors($relAuthData, $id) {
        $output = array();
        foreach ($relAuthData as $row) {
            if($row["lecture_id"] == $id) {
                array_push($output, new Author(
                        $row["author_id"],
                        $row["fname"],
                        $row["sname"],
                        NULL,
                        NULL));
            }
        }
        return $output;
    }
    
    private function matchPosterAuthors($relAuthData, $id) {
        $output = array();
        foreach ($relAuthData as $row) {
            if($row["poster_id"] == $id) {
                array_push($output, new Author(
                        $row["author_id"],
                        $row["fname"],
                        $row["sname"],
                        NULL, 
                        NULL));
            }
        }
        return $output;
    }
    
    private function getRelatedAuthors() {
        return $this->database->select("Authors", [
            "[>]Users" => ["user" => "user_id"],
            "[>]Lectures" => ["lecture_id" => "lecture_id"],
            "[>]Posters" => ["poster_id" => "poster_id"]], [
                "Authors.author_id",
                "Users.user_id",
                "Users.fname",
                "Users.sname",
                "Lectures.lecture_id",
                "Posters.poster_id"
            ]);
    }
    
    public function getLectures() {
        $data = $this->getLecturesData();
        $tags = $this->getLectureTagsData();
        $authors = $this->getRelatedAuthors();
                
        $lectures = array();
        foreach ($data as $lecture) {
            $lectures[$lecture["lecture_id"]] = new Lecture(
                $lecture["lecture_id"],
                $lecture["title"],
                NULL,
                $this->matchLectureAuthors($authors, $lecture["lecture_id"]),
                NULL,
                $this->matchLectureTags($tags, $lecture["lecture_id"]));
        }
        return $lectures;
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
       
    public function getPosters() {
        $data = $this->getPostersData();
        $tags = $this->getPosterTagsData();
        $authors = $this->getRelatedAuthors();
        
        $posters = array();
        foreach ($data as $poster) {
            $posters[$poster["poster_id"]] = new Poster(
                $poster['poster_id'],
                $poster["title"],
                NULL,
                $this->matchPosterAuthors($authors, $poster["poster_id"]),
                NULL,
                $this->matchPosterTags($tags, $poster["poster_id"]));
        }        
        return $posters;
    }
}