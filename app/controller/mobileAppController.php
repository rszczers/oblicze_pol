<?php
class mobileAppController extends userViewController {
    function __construct($databaseHandler) {
        parent::__construct($databaseHandler);
    }
    
    public function getBreaks() {
        $breaksData = $this->database->select("Breaks", ["[>]Schedule" => ["schedule" => "schedule_id"]], [
            "Breaks.break_id",
            "Breaks.title",
            "Schedule.start",
            "Schedule.end",
            "Schedule.date"]);
        
        $breaks = array();
        foreach ($breaksData as $b) {
            $newBreak = new Breaktime($b["title"], $b["date"], $b["start"], $b["end"]);
            array_push($breaks, $newBreak);
        }
        return $breaks;
    }
    
}