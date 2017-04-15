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
?>
    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-6">
            <?php new newLectureForm($apc->getNonLectureAuthors(), $apc->getNonUsedSchedules()) ?>
        </div>
        <div class="col-md-6">
            <?php include('newPosterForm.php'); ?>
       </div>        
      </div>
      <div class="row">
        <div class="col-md-6">
            <?php include('newUserForm.php'); ?>
        </div>
        <div class="col-md-6">
            <?php include('removeForm.php'); ?>
       </div>        
      </div>
      <div class="row">
        <div class="col-md-6">
            <?php include('newBreakForm.php'); ?>
        </div>
        <div class="col-md-6">
            <?php include('removeBreakForm.php'); ?>
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
