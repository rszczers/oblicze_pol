<?php
class getUserQRForm {
    private $users;
    
    function __construct($users) {
        $this->users = $users;
    }

    public function show() {
?>
<form class="form-horizontal" method="post">
<fieldset>

<!-- Form Name -->
<legend>Kody QR</legend>

<!-- Select Multiple -->
<div class="form-group">
  <label class="col-md-2 control-label" for="userQRSelect">Uczestnicy</label>
  <div class="col-md-9">
    <select id="userQRSelect" size=15 name="userQRSelect[]" class="form-control" multiple="multiple">
      <?php
      foreach ($this->users as $user) {
          $text = $user["fname"] . ' ' . $user["sname"] . ' ' . $user["code"] . ' ' . $user["email"];
          $value = $user["user_id"];
          echo '<option value="' . $value . '">' . $text . '</option>';
      }
      ?>
    </select>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="qrSelectButton"></label>
  <div class="col-md-4">
    <button id="qrSelectButton" name="qrCodeButton" class="btn btn-primary">Pokaż QR</button>
  </div>
</div>

</fieldset>
</form>

<?php
    }
}
