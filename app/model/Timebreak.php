<?php
class Timebreak {
    private $title;
    private $date;
    private $start;
    private $end;
    
    function __construct($title, $date, $startTime, $endTime) {
        $this->title = $title;
        $this->date = $date;
        $this->start = $start;
        $this->end = $end;
    }
}
