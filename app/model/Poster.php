<?php
class Poster implements \JsonSerializable {
    private $id;
    private $title;
    private $abstract;
    private $authors;
    private $schedule;
    private $tags;

function __construct($id, $title, $abstract, $authors, $schedule, $tags) {
        $this->id = $id;
	$this->title = $title;
	$this->abstract = $abstract;
        $this->authors = $authors;
        $this->schedule = $schedule;
        $this->tags = $tags;
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

    function getDate($format) {
        return $this->schedule->getDate($format);
    }

    function getStart($format) {
        return $this->schedule->getStart($format);
    }

    function getEnd($format) {
        return $this->schedule->getEnd($format);
    }

    function getPlace() {
        return $this->schedule->getPlace();
    }
}
