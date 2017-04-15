<?php
class Lecture implements \JsonSerializable {
    private $id;
    private $title;
    private $abstract;
    private $authors;
    private $date;
    private $startTime;
    private $endTime;
    private $place;
    
    function __construct($id, $title, $abstract, $authors, $date, $startTime, $endTime, $place) {
        $this->id = $id;
        $this->title = $title;
        $this->abstract = $abstract;
        $this->authors = $authors;
        $this->date = $date;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->place = $place;
    }
    
    function getID() {
        return $this->id;
    }
    
    function getTitle() {
        return $this->title;
    }

    function getAbstract() {
        return $this->abstract;
    }

    function getAuthors() {
        return $this->authors;
    }

    function getDate() {
        return $this->date;
    }

    function getStartTime() {
        return $this->startTime;
    }

    function getEndTime() {
        return $this->endTime;
    }

    function getPlace() {
        return $this->place;
    }

    public function jsonSerialize() {
        $vars = get_object_vars($this);
        return $vars;
    }

}
