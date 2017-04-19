<?php

class removeDayForm {
    private $days;
    
    function __construct($days) {
        $this->days = $days;
    }

    
    public function show() {
?>
<form class="form-horizontal" method="post">
<fieldset>

<!-- Form Name -->
<legend>Usuń cały dzień</legend>

<!-- Select Multiple -->
<div class="form-group">
  <label class="col-md-2 control-label" for="removeDaySelect">Dzień</label>
  <div class="col-md-9">
    <select id="removeDaySelect" name="removeDaySelect[]" size=15 class="form-control" multiple="multiple">
      <?php
      foreach ($this->days as $day) {
          echo '<option value="' . $day . '">' . $day . '</option>';
      }
      ?>
    </select>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-2 control-label" for="removeDayButton"></label>
  <div class="col-md-9">
    <button id="removeDayButton" class="btn btn-danger">Usuń</button>
  </div>
</div>

</fieldset>
</form>

<?php
    }        
}
