<?php
class Breaktime implements \JsonSerializable {
    private $id;
    private $title;
    private $schedule;
    
    function __construct($id, $title, $schedule) {
        $this->id = $id;
        $this->title = $title;
        $this->schedule = $schedule;
    }

    function getId() {
        return $this->id;
    }

    function getTitle() {
        return $this->title;
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

    function getType() {
        return $this->schedule->getType();
    }

    public function jsonSerialize() {
        $vars = get_object_vars($this);
        return $vars;
    }

}
