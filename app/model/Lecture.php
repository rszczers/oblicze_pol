<?php
class Lecture {
    private $title;
    private $abstract;
    private $authors;
    private $date;
    private $startTime;
    private $endTime;
    
    function __construct($title, $abstract, $authors, $date, $startTime, $endTime) {
        $this->title = $title;
        $this->abstract = $abstract;
        $this->authors = $authors;
        $this->date = $date;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }
}
