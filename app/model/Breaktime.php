<?php
class Breaktime implements \JsonSerializable {
    private $title;
    private $date;
    private $startTime;
    private $endTime;
    
    function __construct($title, $date, $startTime, $endTime) {
        $this->title = $title;
        $this->date = $date;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    public function jsonSerialize() {
        $vars = get_object_vars($this);
        return $vars;
    }

}
