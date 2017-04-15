<?php
class Poster implements \JsonSerializable {
    private $id;
    private $title;
    private $abstract;
    private $authors;
    private $date;
    private $startTime;
    private $endTime;
    private $place;

function __construct($id, $title, $abstract, $authors, $date, $start, $end, $place) {
        $this->id = $id;
	$this->title = $title;
	$this->abstract = $abstract;
        $this->authors = $authors;
        $this->startTime = $start;
        $this->endTime = $end;
        $this->date = $date;
        $this->place = $place;
    }
    
    public function jsonSerialize() {
        $vars = get_object_vars($this);
        return $vars;
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


}
