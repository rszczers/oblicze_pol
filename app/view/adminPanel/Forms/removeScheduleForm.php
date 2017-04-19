<?php
class removeScheduleForm {
    private $schedules;
    
    function __construct($schedules) {
        $this->schedules = $schedules;
    }
    
    public function show() {
?>
<form class="form-horizontal" method="post">
<fieldset>

<!-- Form Name -->
<legend>Usuwanie terminów</legend>

<!-- Select Multiple -->
<div class="form-group">
  <label class="col-md-2 control-label" for="removeSchedulesSelect">Terminy</label>
  <div class="col-md-9">
    <select id="removeSchedulesSelect" name="removeSchedulesSelect[]" size="15" class="form-control" multiple="multiple">
        <?php        
        foreach ($this->schedules as $schedule) {
            $id = $schedule->getID();
            $start = $schedule->getStart("H:i");
            $end = $schedule->getEnd("H:i");
            $date = $schedule->getDate("d/m");
            $place = $schedule->getPlace();
            $full = "sala " .  $place . ', '. $start . '-' . $end . ' ' .  $date;
            echo '<option value="' . $id . '">' . $full . "</option>";
        }
        ?>
    </select>
      <span class="help-block">Aby jednocześnie zaznaczyć kilka terminów, przytrzymaj <kbd>Ctrl</kbd></span>  
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-2 control-label" for="removeScheduleButton"></label>
  <div class="col-md-9">
    <button id="removeScheduleButton" class="btn btn-danger">Usuń</button>
  </div>
</div>

</fieldset>
</form>
<?php
    }
}
?>