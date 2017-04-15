<?php
class lecturesList {
    private $lectures;
 
    function __construct($lectures) {
        $this->lectures = $lectures;
    }
    
    public function show() {
        $output =
          '<table class="table table-bordered">
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
                <td rowspan=2 style="text-align:center">';
            
            $output = $output .                  
            '<div class="radio">
                <label><input type="radio" name="optradio">1</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="optradio">2</label>
            </div>
            <div class="radio disabled">
                <label><input type="radio" name="optradio">3</label>
            </div>';
                                    
            $output = $output . '</td>
                </tr><tr><td>';
            
            if (count($authors) > 1) { // Jeśli jest więcej niż jeden autor:
                foreach ($authors as $author) {
                    $output = $output . $author->getFullName() . ', '; 
                }
                $output = substr($output, 0, -2); // Wywal odstęp po ostatnim autorze
            } else if (count($authors) == 1) {                
                $output = $output . $authors[0]->getFullName();
            } else {
                $output = $output . 'Brak autora';
            }
            $output = $output . '</td></tr>';
            $i++;
        }
        $output = $output . '</tbody></table>';
        echo $output;
    }
}