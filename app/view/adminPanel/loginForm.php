    <div class="container">
    <div class="col-md-6 col-md-offset-3">
    <img src="http://<?php echo PAGE_ADDRESS;?>assets/img/oblicze.jpg" class="img-responsive">
        <form class="form-signin"
            action = "<?php echo 'https://' . PAGE_ADDRESS . $userCode . '/' . ADMIN_PANEL_REQUESTCODE; ?>"
            method = "post">
        <h2 class="form-signin-heading">Podaj hasło</h2>
        <label for="inputPassword" class="sr-only">Hasło</label>
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Twoje hasło" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Zapamiętaj mnie
          </label>
        </div>
        <button class="btn btn-md btn-primary btn-block" type="submit">Zaloguj</button>
      </form>
    </div>
    </div> <!-- /container -->
  
