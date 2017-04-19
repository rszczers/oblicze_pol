<?php
class newScheduleForm {
    private $days;
    
    function __construct($days) {
        $this->days = $days;
    }

    public function show() {
?>
<form class="form-horizontal" method="post">
<fieldset>

<!-- Form Name -->
<legend>Dodawanie terminów</legend>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-2 control-label" for="selectbasic">Dzień</label>
  <div class="col-md-9">
    <select id="selectbasic" name="newScheduleDay" class="form-control">
      <?php
      foreach ($this->days as $day) {
          echo '<option value="' . $day . '">' . $day . '</option>';
      }
      ?>
    </select>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="newScheduleStart">Początek</label>  
  <div class="col-md-9">
  <input id="newScheduleStart" name="newScheduleStart" type="text" placeholder="czas rozpoczęcia" class="form-control input-md" required="">
  <span class="help-block">Przykład: 12:00:00</span>  
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="newScheduleEnd">Koniec</label>  
  <div class="col-md-9">
  <input id="newScheduleEnd" name="newScheduleEnd" type="text" placeholder="" class="form-control input-md" required="">
  <span class="help-block">Przykład: 13:00:00</span>  
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label" for="newSchedulePlace">Sala</label>  
  <div class="col-md-9">
  <input id="newSchedulePlace" name="newSchedulePlace" type="text" placeholder="" class="form-control input-md" required="">
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-2 control-label" for="newScheduleButton"></label>
  <div class="col-md-9">
    <button id="newScheduleButton" class="btn btn-info">Dodaj</button>
  </div>
</div>

</fieldset>
</form>

<?php
    }
}
?>