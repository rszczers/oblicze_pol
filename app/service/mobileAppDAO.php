<?php
class mobileAppDAO extends userViewDAO {
    function __construct($databaseHandler) {
        parent::__construct($databaseHandler);
    }
    
    public function getBreaks() {
        $breaksData = $this->database->select("Breaks", 
                ["[>]Schedule" => ["schedule" => "schedule_id"]], [
            "Breaks.break_id",
            "Breaks.title",
            "Schedule.schedule_id",
            "Schedule.start",
            "Schedule.end",
            "Schedule.date",
            "Schedule.place"]);
        
        $breaks = array();
        foreach ($breaksData as $b) {
            $newBreak = new Breaktime(
                    $b["id"],
                    $b["title"],
                    new Schedule(
                            $b["schedule_id"],
                            $b["start"],
                            $b["end"],
                            $b["date"],
                            $b["place"]));
            array_push($breaks, $newBreak);
        }       
        return $breaks;
    }
}