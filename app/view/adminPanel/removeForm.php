<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Usuwanie referatów lub plakatów</legend>

<!-- Select Multiple -->
<div class="form-group">
  <label class="col-md-2 control-label" for="lecturesToRemove">Referaty</label>
  <div class="col-md-9">
    <select id="lecturesToRemove" name="lecturesToRemove" class="form-control" multiple="multiple">
      <option value="Lectures">Opcje</option>
    </select>
  </div>
</div>

<!-- Select Multiple -->
<div class="form-group">
  <label class="col-md-2 control-label" for="postersToRemove">Plakaty</label>
  <div class="col-md-9">
    <select id="postersToRemove" name="postersToRemove" class="form-control" multiple="multiple">
      <option value="1">Option one</option>
      <option value="2">Option two</option>
    </select>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-2 control-label" for="removeButton"></label>
  <div class="col-md-9">
    <button id="removeButton" name="removeButton" class="btn btn-danger">Usuń</button>
  </div>
</div>

</fieldset>
</form>
