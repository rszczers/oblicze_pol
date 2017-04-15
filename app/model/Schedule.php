<?php

class Schedule {
    private $schedule_id;
    private $start;
    private $end;
    private $date;
    private $type;
    
    function __construct($schedule_id, $start, $end, $date, $type) {
        $this->schedule_id = $schedule_id;
        try {
            $this->start = new DateTime($date . ' ' . $start);
            $this->end = new DateTime($date . ' ' . $end);
            $this->date = new DateTime($date);
        } catch (Exception $e) {
            echo "test";
            $e->getMessage();
            exit(1);
        }
        $this->type = $type;
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

    public function getType() {
        return $this->type;
    }
}
