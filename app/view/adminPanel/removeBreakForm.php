<?php
class removeBreakForm {
    private $breaks;
    
    function __construct($breaks) {
        $this->breaks = $breaks;
    }

    public function show() {
?>
<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Usuwanie przerw</legend>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-2 control-label" for="selectbasic">Przerwy</label>
  <div class="col-md-6">
    <select id="removeBreakSelection" name="removeBreakSelection" class="form-control">
      <?php                
        foreach ($this->breaks as $break) {
            $id = $break->getID();
            $start = $break->getStart("H:i");
            $end = $break->getEnd("H:i");
            $date = $break->getDate("d/m");
            $full = $start . '-' . $end . ' ' .  $date;
            echo '<option value="' . $id . '">' . $full . "</option>";
        }
      ?>
    </select>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-2 control-label" for="removeBreakButton"></label>
  <div class="col-md-9">
    <button id="removeBreakButton" name="removeBreakButton" class="btn btn-warning">Usuń</button>
  </div>
</div>

</fieldset>
</form>
<?php
    }
}
?>