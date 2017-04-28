<?php
class lecturesList {
    private $lectures;
 
    function __construct($lectures) {
        $this->lectures = $lectures;
    }
    
    public function show() {
?>  
    <div class="container">
        <div class="row" style="margin-bottom: 5px">
            <div class="col-xs-9 col-md-9">
                <h3>Referaty:</h3>
            </div>
            <div class="col-xs-3 col-md-3">
                <button type="button" class="btn btn-danger btn-lg pull-right" onclick="resetLectures();">Reset</button>
            </div>
        </div>
<!--        <div class="row">
            <div class="col-xs-1 col-md-1"><h4>#</h4></div>
            <div class="col-xs-8 col-md-8"><h4>Tytuł</h4></div>
            <div class="col-xs-3 col-md-3 text-center"><h4>Ocena</h4></div>
        </div>-->
        <hr>
<?php                
        $i = 1;
        foreach ($this->lectures as $lecture) { 
            $authors = $lecture->getAuthors();
            $title = $lecture->getTitle();
            $tags = $lecture->getTags();     
?>
            <div class="row bg-success">
                <div class="col-xs-1 col-md-1 lead" style="padding-top: 1em"><?php echo $i; ?>.</div>
                <div class="col-xs-11 col-md-11 lead"  style="padding-top: 1em">
                    <?php echo $title ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-12 text-center" style="margin-top: 1.5em; margin-bottom: 1.5em; padding-top: 0.25em; padding-bottom: 0.25em; min-height: 2em;">
                    <label class="radio-inline"><input 
                            id="<?php echo 'r'. ($i*3+2);?>"
                            type="radio" 
                            name="lectures[<?php echo $lecture->getID(); ?>]" 
                            onclick="hideLecture(<?php echo $i*3+2;?>);"
                            value="3">3 pkt</label>
                    <label class="radio-inline"><input 
                            id="<?php echo 'r'. ($i*3+1);?>" 
                            type="radio" 
                            name="lectures[<?php echo $lecture->getID(); ?>]" 
                            onclick="hideLecture(<?php echo $i*3+1;?>);"
                            value="2">2 pkt</label>
                    <label class="radio-inline"><input 
                            id="<?php echo 'r'. ($i*3);?>" 
                            type="radio" 
                            name="lectures[<?php echo $lecture->getID(); ?>]" 
                            onclick="hideLecture(<?php echo $i*3;?>);"
                            value="1">1 pkt</label>
                </div>
            </div>
<?php       
            $form = 'Autor:';
            $authOutput = 'Brak autora';
            if (count($authors) > 1) { // Jeśli jest więcej niż jeden autor:
                $form = 'Autorzy:';
                $authOutput = '';
                foreach ($authors as $author) {
                    $authOutput = $authOutput . $author->getFullName() . ', '; 
                }
                $authOutput = substr($authOutput, 0, -2); // Wywal odstęp po ostatnim autorze                
            } else if (count($authors) == 1) {                
                $authOutput = $authors[0]->getFullName();
            }
?>
            <div class="row" style="margin-bottom: 0.5em">
                <div class="col-xs-11 col-md-2"><?php echo $form;?></div>
                <div class="col-xs-11 col-md-10"><?php echo $authOutput; ?></div>
            </div>
<?php       
            $tagsOutput = '<code>Brak tagów</code>';
            if (count($tags) > 0) {
                $tagsOutput = '';
                foreach ($tags as $tag) {
                    $tagsOutput = $tagsOutput . '<code>'. $tag . '</code>, ';
                }
                $tagsOutput = substr($tagsOutput, 0, -2);
            }
            $i++;
?>
            <div class="row small" style="margin-bottom: 2em;">
                <div class="col-xs-12 col-md-2">Tagi:</div>
                <div class=" col-xs-12 col-md-10"><?php echo $tagsOutput; ?></div>
            </div>
            <hr>
<?php
        }
?>
    </div>
<?php
    }
}