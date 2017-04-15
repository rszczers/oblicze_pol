<?php
class userViewDAO {
    protected $database;
    private $lecturesData;
    private $postersData;
    private $relatedAuthors;
    private $lectureAuthors;
    private $posterAuthors;
    
    function __construct($databaseHandler) {
        $this->lectureAuthors = array();
        $this->posterAuthors = array();  
        
        $this->database = $databaseHandler;
        $this->lecturesData = $this->setLecturesData();
        $this->postersData = $this->setPostersData();
        $this->relatedAuthors = $this->setRelatedAuthors();
        $this->setAuthorsRight();
    }
    
    private function setLecturesData() {
        return $this->database->select("Lectures", ["[>]Schedule" => ["schedule" => "schedule_id"]], [
            "Lectures.lecture_id",
            "Lectures.title",
            "Lectures.abstract",
            "Schedule.start",
            "Schedule.end",
            "Schedule.date",
            "Lectures.place"]);
    }
    
    private function setPostersData() {
        return $this->database->select("Posters", ["[>]Schedule" => ["schedule" => "schedule_id"]], [
            "Posters.poster_id",
            "Posters.title",
            "Posters.abstract",
            "Schedule.start",
            "Schedule.end",
            "Schedule.date",
            "Posters.place"]);
    }
    
    private function setAuthorsRight() {
        foreach ($this->relatedAuthors as $author) {
            $newAuthor = new Author($author["author_id"],
                    $author["fname"], $author["sname"], $author["email"]);

            if (!is_null($author["lecture_id"])) { // author has lecture
                if (array_key_exists($author["lecture_id"], $this->lectureAuthors)) {
                    array_push($this->lectureAuthors[$author["lecture_id"]], $newAuthor);
                } else {
                    $this->lectureAuthors[$author["lecture_id"]] = array($newAuthor);
                }
            }
            
            if (!is_null($author["poster_id"])) {
                if (array_key_exists($author["poster_id"], $this->posterAuthors)) {
                    array_push($this->posterAuthors[$author["poster_id"]], $newAuthor);
                } else {
                    $this->posterAuthors[$author["poster_id"]] = array($newAuthor);
                }
            }
        };
    }
    
    private function setRelatedAuthors() {
        return $this->database->select("Authors", [
            "[>]Lectures" => ["lecture_id" => "lecture_id"],
            "[>]Posters" => ["poster_id" => "poster_id"]], [
            "Authors.author_id",
            "Authors.fname",
            "Authors.sname",
            "Authors.email",
            "Lectures.lecture_id",
            "Posters.poster_id"
        ]);        
    }
    
    public function getLectures() {
        $lectures = array();
        foreach ($this->lecturesData as $lecture) {
            $lectures[$lecture["lecture_id"]] = new Lecture(
                $lecture["title"],
                $lecture["abstract"],
                $this->lectureAuthors[$lecture["lecture_id"]],
                $lecture["date"],
                $lecture["start"],
                $lecture["end"],
                $lecture["place"]);
        }
        return $lectures;
    }
    
    public function getPosters() {
        $posters = array();
        foreach ($this->postersData as $poster) {
            $posters[$poster["poster_id"]] = new Poster(
                $poster["title"],
                $poster["abstract"],
                $this->posterAuthors[$poster["poster_id"]],
                $poster["date"],
                $poster["start"],
                $poster["end"],
                $poster["place"]);
        }
        return $posters;
    }
}
