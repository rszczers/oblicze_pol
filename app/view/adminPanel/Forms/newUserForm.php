<?php
class newUserForm {    
    function __construct() {
        
    }

    function show() {            
?>
<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Dodawanie uczestników</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="newUserFirstName">Imię</label>  
  <div class="col-md-9">
  <input id="newUserFirstName" name="newUserFirstName" type="text" placeholder="imię nowego uczestnika" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="newUserSurname">Nazwisko</label>  
  <div class="col-md-9">
  <input id="newUserSurname" name="newUserSurname" type="text" placeholder="nazwisko nowego użytkownika" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-2 control-label" for="newUserEmail">Email</label>  
  <div class="col-md-9">
  <input id="newUserEmail" name="newUserEmail" type="text" placeholder="email" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-2 control-label" for="sendNewUserData"></label>
  <div class="col-md-9">
    <button id="sendNewUserData" name="sendNewUserData" class="btn btn-success">Dodaj</button>
  </div>
</div>

</fieldset>
</form>
<?php
    }
}
?>