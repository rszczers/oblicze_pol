<?php
class Poster {
    private $title;
    private $abstract;
    private $authors;
    private $date;
    private $startTime;
    private $endTime;

function __construct($title, $abstract, $authors, $date, $start, $end) {
	$this->title = $title;
	$this->abstract = $abstract;
        $this->authors = $authors;
        $this->startTime = $start;
        $this->endTime = $end;
        $this->date = $date;
    }
}
