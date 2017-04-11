<?php
class Lecture {
    private $title;
    private $abstract;
    private $authors;
    private $date;
    private $startTime;
    private $endTime;
    private $place;
    
    function __construct($title, $abstract, $authors, $date, $startTime, $endTime, $place) {
        $this->title = $title;
        $this->abstract = $abstract;
        $this->authors = $authors;
        $this->date = $date;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->place = $place;
    }
}
