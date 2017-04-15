<?php
class lecturesList {
    private $lectures;
 
    function __construct($lectures) {
        $this->lectures = $lectures;
    }
    
    public function show() {
?>        
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>#</th>
                <th>Tytuł</th>
                <th>Ocena</th>
              </tr>
            </thead>
            <tbody>
<?php                
        $i = 1;
        foreach ($this->lectures as $lecture) { 
            $authors = $lecture->getAuthors();            
            $title = $lecture->getTitle();
            $tags = $lecture->getTags();
//            var_dump($tags);
            echo
               '<tr>
                <td rowspan=3>' . $i . '</td>
                <td>' . $title . '</td>
                <td rowspan=3 style="text-align:center">';
?>          
            <div class="radio">
                <label><input type="radio" name="optradio">1</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="optradio">2</label>
            </div>
            <div class="radio disabled">
                <label><input type="radio" name="optradio">3</label>
            </div>
            </td></tr>
            <tr><td>
<?php       
            if (count($authors) > 1) { // Jeśli jest więcej niż jeden autor:
                $output = '';
                foreach ($authors as $author) {
                    $output = $output . $author->getFullName() . ', '; 
                }
                echo substr($output, 0, -2); // Wywal odstęp po ostatnim autorze                
            } else if (count($authors) == 1) {                
                echo $authors[0]->getFullName();
            } else {
                echo 'Brak autora';
            }
            
            echo '</td></tr>'
                    . '<tr><td>';
            
            if (count($tags) > 0) {
                $output = '';
                foreach ($tags as $tag) {
                    $output = $output . $tag . ', ';
                }
                $tagString = substr($tags, 0, -2);
                echo $output;
            } else {
                echo 'Brak tagów';
            }
            echo '</td></tr>';
            $i++;
        }
        echo '</tbody></table>';
    }
}