<?php
class removeScheduleForm {
    private $schedules;
    
    function __construct($schedules) {
        $this->schedules = $schedules;
    }
    
    public function show() {
?>
<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Usuwanie terminów</legend>

<!-- Select Multiple -->
<div class="form-group">
  <label class="col-md-2 control-label" for="removeSchedulesSelect">Terminy</label>
  <div class="col-md-9">
    <select id="removeSchedulesSelect" name="removeSchedulesSelect" class="form-control" multiple="multiple">
        <?php
        foreach ($schedules as $schedule) {
            $start = $schedule->getStart("H:i");
            $end = $schedule->getEnd("H:i");
            $date = $schedule->getDate("d/m");
            $type = $schedule->getType();
            $full = $type. ': ' . $start . '-' . $end . ' ' .  $date;
            echo '<option value="' . $id . '">' . $full . "</option>";
        }
        ?>
    </select>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-2 control-label" for="removeScheduleButton"></label>
  <div class="col-md-9">
    <button id="removeScheduleButton" name="removeScheduleButton" class="btn btn-danger">Usuń</button>
  </div>
</div>

</fieldset>
</form>
<?php
    }
}
?>