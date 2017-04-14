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
      <option value="1">Option one</option>
      <option value="2">Option two</option>
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
