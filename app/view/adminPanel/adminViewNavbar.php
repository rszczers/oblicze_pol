      
      <!-- Static navbar -->
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            <a class="navbar-brand" href=".">θβℓιcℤε</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle"
                 data-toggle="dropdown"
                 role="button"
                 aria-haspopup="true"
                 aria-expanded="false">Dodaj <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo ADMIN_PANEL_REQUESTCODE; ?>/addUser">Uczestnika</a></li>
                <li><a href="<?php echo ADMIN_PANEL_REQUESTCODE; ?>/addTerm">Termin</a></li>
                <li><a href="<?php echo ADMIN_PANEL_REQUESTCODE; ?>/addLecture">Referat</a></li>
                <li><a href="<?php echo ADMIN_PANEL_REQUESTCODE; ?>/addPoster">Plakat</a></li>
                <li><a href="<?php echo ADMIN_PANEL_REQUESTCODE; ?>/addBreak">Przerwę</a></li>
              </ul>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle"
                 data-toggle="dropdown"
                 role="button"
                 aria-haspopup="true"
                 aria-expanded="false">Usuń <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo ADMIN_PANEL_REQUESTCODE; ?>/rmUser">Uczestnika</a></li>
                <li><a href="<?php echo ADMIN_PANEL_REQUESTCODE; ?>/rmTerm">Termin</a></li>
                <li><a href="<?php echo ADMIN_PANEL_REQUESTCODE; ?>/rmLecture">Referat</a></li>
                <li><a href="<?php echo ADMIN_PANEL_REQUESTCODE; ?>/rmPoster">Plakat</a></li>
                <li><a href="<?php echo ADMIN_PANEL_REQUESTCODE; ?>/rmBreak">Przerwę</a></li>
              </ul>
            </li>
            <li><a href="pollResults">Zobacz głosy</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="signoff">Wyloguj</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
  <div class="container">