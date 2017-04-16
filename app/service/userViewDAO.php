<?php
class userViewDAO {
    protected $database;
    
    function __construct($databaseHandler) {      
        $this->database = $databaseHandler;
    }       
    
    private function getLecturesData() {
        return $this->database->select("Lectures", 
                ["[>]Schedule" => ["schedule" => "schedule_id"]], [
            "Lectures.lecture_id",
            "Lectures.title",
            "Lectures.abstract",
            "Schedule.schedule_id",
            "Schedule.start",
            "Schedule.end",
            "Schedule.date",
            "Schedule.place"]);
    }
    
    private function getPostersData() {
        return $this->database->select("Posters", 
                ["[>]Schedule" => ["schedule" => "schedule_id"]], [
            "Posters.poster_id",
            "Posters.title",
            "Posters.abstract",
            "Schedule.schedule_id",
            "Schedule.start",
            "Schedule.end",
            "Schedule.date",
            "Schedule.place"]);
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
                        $row["email"]));
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
                        $row["email"]));
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
                "Users.fname",
                "Users.sname",
                "Users.email",
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
                $lecture["abstract"],
                $this->matchLectureAuthors($authors, $lecture["lecture_id"]),
                new Schedule(
                    $lecture["schedule_id"],
                    $lecture["start"],
                    $lecture["end"],
                    $lecture["date"],
                    $lecture["place"]),
                $this->matchLectureTags($tags, $lecture["lecture_id"]));
        }
        return $lectures;
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
                $poster["abstract"],
                $this->matchPosterAuthors($authors, $poster["poster_id"]),
                new Schedule(
                        $poster["schedule_id"],
                        $poster["start"],
                        $poster["end"],
                        $poster["date"],
                        $poster["place"]),
                $this->matchPosterTags($tags, $poster["poster_id"]));
        }        
        return $posters;
    }
    
    public function vote($user_id, $lectureIdArray, $posterIdArray,
            $lectureVoteValuesArray, $posterVoteValuesArray) {
        
    }
}