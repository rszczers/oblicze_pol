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

function __construct($title, $abstract, $authors, $date, $start, $end, $place) {
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
}
