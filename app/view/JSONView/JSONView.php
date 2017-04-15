<?php
class JSONView {
    private $mac;
    
    function __construct($mobileAppController) {
        $this->mac = $mobileAppController;
    }
    
    public function showBreaks() {
        $breaks = $this->mac->getBreaks();
        $json = array();
        foreach ($breaks as $break) {
            array_push($json, $break->jsonSerialize());
        }
        print_r(json_encode($json, JSON_PRETTY_PRINT));
    }
    
    public function showLectures() {
        $lectures = $this->mac->getLectures();
        $json = array();
        foreach ($lectures as $lecture) {
            array_push($json, $lecture->jsonSerialize());            
        }
        print_r(json_encode($json, JSON_PRETTY_PRINT));
    }
    
    public function showPosters() {
        $posters = $this->mac->getPosters();
        $json = array();
        foreach ($posters as $poster) {
            array_push($json, $poster->jsonSerialize());            
        }
        print_r(json_encode($json, JSON_PRETTY_PRINT));
    }
}