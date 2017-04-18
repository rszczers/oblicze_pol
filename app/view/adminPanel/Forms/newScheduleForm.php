<?php
class newScheduleForm {
    function __construct() {
        
    }

    public function show() {
?>
<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Dodawanie terminów</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="newScheduleDate">Data</label>  
  <div class="col-md-9">
  <input id="newScheduleDate" name="newScheduleDate" type="text" placeholder="data nowego wydarzenia" class="form-control input-md">
  <span class="help-block">Przykład: 2017/05/23</span>  
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

<!-- Button -->
<div class="form-group">
  <label class="col-md-2 control-label" for="newScheduleButton"></label>
  <div class="col-md-9">
    <button id="newScheduleButton" name="newScheduleButton" class="btn btn-info">Dodaj</button>
  </div>
</div>

</fieldset>
</form>
<?php
    }
}
?>