<?php
class newBreakForm {
    private $schedules;
    
    function __construct($schedules) {
        $this->schedules = $schedules;
    }

    public function show() {
?>
<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Dodawanie przerw</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="newBreakTitle">Tytuł</label>  
  <div class="col-md-9">
  <input id="newBreakTitle" name="newBreakTitle" placeholder="tytuł przerwy" class="form-control input-md" type="text">
  <span class="help-block">Przykład: przerwa kawowa</span>  
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-2 control-label" for="newBreakTime">Termin</label>
  <div class="col-md-9">
    <select id="newBreakTime" name="newBreakTime" class="form-control">
    <?php
    foreach ($this->schedules as $schedule) {
        $id = $schedule->getID();
        $start = $schedule->getStart("H:i");
        $end = $schedule->getEnd("H:i");
        $date = $schedule->getDate("d/m");
        $place = $schedule->getPlace();
        $full = 'godzina ' . $start . ' - ' . $end . ', miejsce: ' . $place . ', dzień: ' . $date;
        echo '<option value="' . $id . '">' . $full . "</option>";
    }
    ?>
    </select>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-2 control-label" for="newBreakButton"></label>
  <div class="col-md-9">
    <button id="newBreakButton" name="newBreakButton" class="btn btn-primary">Dodaj</button>
  </div>
</div>

</fieldset>
</form>
<?php
    }
}
?>