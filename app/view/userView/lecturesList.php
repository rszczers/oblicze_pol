<?php
class lecturesList {
    private $lectures;
 
    function __construct($lectures) {
        $this->lectures = $lectures;
    }
    
    public function show() {
        $output = "<ul class=\"list-group\">";
        foreach ($this->lectures as $lecture) {
            $output = $output . "<li class=\"list-group-item\">";
            $output = $output . $lecture->getTitle();
            $output = $output . "</li>";
        }
        $output = $output . "</ul>";
        echo $output;
    }
}
