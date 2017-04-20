<?php
   session_start();  
   session_unset();
   session_destroy();
?>

<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="refresh" content="2; url=<?php echo 'http://'. PAGE_ADDRESS ?>" />
    <link rel="icon" href="../public/assets/favicon.ico">

    <title>Oblicze</title>
    <link href="../public/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../public/assets/css/cover.css" rel="stylesheet">

    
  <body>
  
  <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="inner cover">
            <h1 class="cover-heading">Wylogowano</h1>
            <p class="lead"></p>
            <p class="lead">
              <a href="<?php echo 'http://'. PAGE_ADDRESS; ?>" class="btn btn-lg btn-secondary">Strona głosowania</a>
            </p>
          </div>

          <div class="mastfoot">
            <div class="inner">
              <p>Za chwilę zostaniesz przeniesion(y|a) na stronę głosowania.</p>
            </div>
          </div>

        </div>

      </div>

    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../public/assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="../public/dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../public/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>