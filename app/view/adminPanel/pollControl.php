<form class="form-horizontal" method="post">
<fieldset>
<legend>Aplikacja mobila</legend>

<?php
    $currentMobiStatus = '';
    switch($mobileStatus) {
    case "0":
        $currentMobiStatus = '<span class="bg-danger">wyłączona</span>';
        break;
    case "1":
        $currentMobiStatus = '<span class="bg-success">włączona</span>';
        break;
    case "2":
        $currentMobiStatus = '<span class="bg-warning">tymczasowo wyłączona</span>';
        break;
    }
?>
<p>Aplikacja mobila jest <?php echo $currentMobiStatus ?>.</p>
<!-- Button (Double) -->
<div class="form-group">
  <div class="col-md-8">
    <button id="mobileOff" name="mobileOff" class="btn btn-danger">Wyłącz</button>
    <button id="mobileOn" name="mobileOn" class="btn btn-success">Włącz</button>
    <button id="mobileTemporaryOff" name="mobileTemporaryOff" class="btn btn-warning">Przerwa techniczna</button>
  </div>
</div>

    
<!-- Form Name -->
<?php
    $currentPollStatus = '';
    switch($pollStatus) { //isPollOver?
        case "1":
            $currentPollStatus = '<span class="bg-danger">wyłączone</span>';
            break;
        case "0":
            $currentPollStatus = '<span class="bg-success">włączone</span>';
            break;
    }
?>
<legend>Głosowanie</legend>

<p>Głosowanie jest <?php echo $currentPollStatus ?>.</p>
<!-- Button (Double) -->
<div class="form-group">
  <div class="col-md-8">
    <button id="pollTurnOnButton" name="pollTurnOnButton" class="btn btn-success">Włącz</button>
    <button id="pollTurnOffButton" name="pollTurnOffButton" class="btn btn-danger">Wyłącz</button>
  </div>
</div>

</fieldset>
</form>
