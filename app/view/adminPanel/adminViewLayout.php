<?php
    ob_start();
    session_start();
    
    include('adminViewHeader.php');
    
    if (!empty($_POST['password'])) {
        if ($_POST['password'] == ADMIN_PANEL_PASSWD) {
            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time();                       
        }
    }
    
    if ($_SESSION['valid'] == true) {
        include('adminViewNavbar.php'); 
        $apc = new adminViewDAO($database);
?>
    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-6">
            <?php
            $nlf = new newLectureForm(
                    $apc->getNonLectureAuthors(),
                    $apc->getNonUsedSchedules());        
            $nlf->show();
            ?>
        </div>
        <div class="col-md-6">
            <?php
            $npf = new newPosterForm(
                    $apc->getNonPosterAuthors(),
                    $apc->getNonUsedSchedules());
            $npf->show();
            ?>
       </div>        
      </div>
      <div class="row">
        <div class="col-md-6">
            <?php include('newUserForm.php'); ?>
        </div>
        <div class="col-md-6">
            <?php
            $rf = new removeForm(
                    $apc->getLectures(),
                    $apc->getPosters());
            $rf->show();
            ?>
       </div>        
      </div>
      <div class="row">
        <div class="col-md-6">
            <?php include('newBreakForm.php'); ?>
        </div>
        <div class="col-md-6">
            <?php
            $rbf = new removeBreakForm($apc->getBreaks());
            $rbf->show();
            ?>
       </div>        
      </div>
      <div class="row">
        <div class="col-md-6">
            <?php include('newScheduleForm.php'); ?>
        </div>
        <div class="col-md-6">
            <?php include('removeScheduleForm.php'); ?>
        </div>
      </div>
<?php 
    } else {
        include('loginForm.php');
    }
    include('adminViewFooter.php'); 
?>
