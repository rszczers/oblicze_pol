<?php
class posterList {
    private $posters;
 
    function __construct($poster) {
        $this->posters = $poster;        
    }
    
    public function show() {
?>      
        <div class="row">
            <div class="col-md-10">
                <h3>Plakaty:</h3>
            </div>
            <div class="col-md-2 text-center">
                <button type="button" class="btn btn-danger btn-lg" onclick="resetPosters();">Reset</button>
            </div>
        </div>
          <table class="table table-responsive">
            <thead>
              <tr>
                <th class="col-md-1">#</th>
                <th>Tytuł</th>
                <th class="text-center col-md-2">Ocena</th>
              </tr>
            </thead>
            <tbody>
<?php                
        $i = 1;
        foreach ($this->posters as $poster) { 
            $authors = $poster->getAuthors();
            $title = $poster->getTitle();
            $tags = $poster->getTags();            
            echo
               '<tr>
                <td rowspan=3 class="col-md-1">' . $i . '</td>
                <td class="lead">' .
                $title .
                '</td><td rowspan=3 style="text-align:center" class="col-md-2">';
?>          
            <div class="radio">
                <label><input id="<?php echo 'p'. ($i*3+2);?>"
                              type="radio" 
                              name="posters[<?php echo $poster->getID(); ?>]" 
                              onclick="hidePoster(<?php echo $i*3+2;?>);"
                              value="3">3 pkt</label>
            </div>
            <div class="radio">
                <label><input id="<?php echo 'p'. ($i*3+1);?>" 
                              type="radio" 
                              name="posters[<?php echo $poster->getID(); ?>]" 
                              onclick="hidePoster(<?php echo $i*3+1;?>);"
                              value="2">2 pkt</label>
            </div>
            <div class="radio">
                <label><input 
                        id="<?php echo 'p'. ($i*3);?>" 
                        type="radio" 
                        name="posters[<?php echo $poster->getID(); ?>]" 
                        onclick="hidePoster(<?php echo $i*3;?>);"
                        value="1">1 pkt</label>
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
                    . '<tr><td class="small"><p>';
            
            if (count($tags) > 0) {
                $output = '';
                foreach ($tags as $tag) {
                    $output = $output . '<code>'. $tag . '</code>, ';
                }
                $output = substr($output, 0, -2);
                echo $output;
            } else {
                echo 'Brak tagów';
            }
            echo '</p></td></tr>';
            $i++;
        }
        echo '</tbody></table>';                                    
    }
}