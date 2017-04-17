<?php

class Schedule {
    private $schedule_id;
    private $start;
    private $end;
    private $date;
    private $place;
    
    function __construct($schedule_id, $start, $end, $date, $place) {
        $this->schedule_id = $schedule_id;
        try {
            $this->start = new DateTime($date . ' ' . $start);
            $this->end = new DateTime($date . ' ' . $end);
            $this->date = new DateTime($date);
        } catch (Exception $e) {
            $e->getMessage();
            exit(1);
        }
        $this->place = $place;
    }
    
    public function getID() {
        return $this->schedule_id;
    }

    public function getStart($format) {
        return $this->start->format($format);
    }

    public function getEnd($format) {
        return $this->end->format($format);
    }

    public function getDate($format) {
        return $this->date->format($format);
    }

    public function getPlace() {
        return $this->place;
    }
    
    public function jsonSerialize() {
        $vars = get_object_vars($this);
        return $vars;
    }
}
