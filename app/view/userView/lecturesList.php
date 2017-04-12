<?php
class lecturesList {
    private $lectures;
 
    function __construct($lectures) {
        $this->lectures = $lectures;
    }
    
    public function show() {
        $output =
        '<div class="container">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>#</th>
                <th>Tytuł</th>
                <th>Ocena</th>
              </tr>
            </thead>
            <tbody>';
        $i = 1;
        foreach ($this->lectures as $lecture) {        
            $authors = $lecture->getAuthors();
            $title = $lecture->getTitle();
           
            $output = $output . 
               '<tr>
                <td rowspan=2>' . $i . '</td>
                <td>' . $title . '</td>
                <td rowspan=2> Miejsce na ocenę </td>
                </tr><tr><td>';
            if (count($authors) > 1) {
                foreach ($authors as $author) {
                    $output = $output . $author->getFullName() . ', '; 
                }
                $output = substr($output, 0, -2); 
            } else {
                 $output = $output . $authors[0]->getFullName();
            }
            $output = $output . '</td></tr>';
            $i++;
        }
        $output = $output . '</tbody></table></div>';
        echo $output;
    }
}