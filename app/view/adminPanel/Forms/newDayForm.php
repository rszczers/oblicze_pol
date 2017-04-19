<?php

class newDayForm {
    private $days;
    
    function __construct($days) {
        $this->days = $days;
    }

    public function show() {
?>

<form class="form-horizontal" method="post">
<fieldset>

<!-- Form Name -->
<legend>Dodaj dzień</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="textinput">Nowy dzień</label>  
  <div class="col-md-9">
  <input id="textinput" name="newDay" 
         type="text" class="form-control input-md" required="">
  <span class="help-block">Przykład: 2017-05-23</span>  
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-2 control-label" for="newDayButton"></label>
  <div class="col-md-9">
    <button id="newDayButton" class="btn btn-primary">Dodaj</button>
  </div>
</div>

</fieldset>
</form>

<?php
    }
}
