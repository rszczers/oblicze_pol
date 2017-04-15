<?php
class newLectureForm {
    private $authors;
    private $schedules;
    
    function __construct($authors, $schedules) {
        $this->authors = $authors;
        $this->schedules = $schedules;
    }
    
    public function show() {
?> 
<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Dodawanie referatów</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="newLectureTitle">Tytuł</label>  
  <div class="col-md-9">
  <input id="newLectureTitle" name="newLectureTitle" placeholder="tytuł nowego referatu" class="form-control input-md" type="text">
    
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-2 control-label" for="newLectureAbstract">Abstrakt</label>
  <div class="col-md-9">
    <textarea class="form-control" id="newLectureAbstract" name="newLectureAbstract"></textarea>
  </div>
</div>

<!-- Select Multiple -->
<div class="form-group">
  <label class="col-md-2 control-label" for="newLectureAuthors">Autorzy</label>
  <div class="col-md-9">
    <select id="newLectureAuthors" name="newLectureAuthors" class="form-control" multiple="multiple">
    <?php 
    foreach ($this->authors as $author) {
        $id = $author->getID();
        $fullname = $author->getFullName();        
        echo '<option value="' . $id . '">' . $fullname . "</option>";
    }
    ?>
    </select>
    <span class="help-block">Aby jednocześnie zaznaczyć kilku autorów, trzymaj przycisk Ctrl</span>  
  </div>
</div>


<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-2 control-label" for="newLectureTime">Termin</label>
  <div class="col-md-9">
    <select id="newLectureTime" name="newLectureTime" class="form-control">
    <?php 
    foreach ($this->schedules as $schedule) {
        $id = $schedule->getID();
        $start = $schedule->getStart("H:i");
        $end = $schedule->getEnd("H:i");
        $date = $schedule->getDate("d/m");
        $full = $start . '-' . $end . ' ' .  $date;
        echo '<option value="' . $id . '">' . $full . "</option>";
    }
    ?>
    </select>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="newLecturePlace">Miejsce</label>  
  <div class="col-md-9">
  <input id="newLecturePlace" name="newLecturePlace" placeholder="" class="form-control input-md" type="text">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="newLectureTags">Tagi</label>  
  <div class="col-md-9">
  <input id="newLectureTags" name="newLectureTags" placeholder="" class="form-control input-md" type="text">
  <span class="help-block">Przykład: #teoria_liczb #topologia</span>  
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-2 control-label" for="newLectureButton"></label>
  <div class="col-md-9">
    <button id="newLectureButton" name="newLectureButton" class="btn btn-primary">Dodaj</button>
  </div>
</div>

</fieldset>
</form>        
<?php
    }
}