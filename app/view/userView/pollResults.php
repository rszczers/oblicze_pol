<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="public/assets/favicon.ico">

    <title>Oblicze</title>

    <!-- Bootstrap core CSS -->
    <link href="public/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="public/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="public/assets/style.css" rel="stylesheet">
  </head>
    <body>
 <!-- Begin page content -->
    <div class="container">
        <div class="row"><h1>Referaty:</h1>
            <?php         
            $lectureResults = $udao->getLectureResults(3);
            $i = 1;
            foreach ($lectureResults as $result) {
                $fullname = $result["fullname"];
                $title = $result["title"];
                $score = $result["score"];
            ?>
            <hr>
            <div class="row" style="margin-bottom: 2em">
                <div class="col-lg-2"><h1><?php echo $i; ?>. </h1></div>
                <div class="col-lg-2"> <?php echo $score; ?>pkt. </div>
                <div class="col-lg-8">
                    <div class="row">
                        <h3><?php echo $title; ?></h3>
                    </div>
                    <div class="row">
                        <?php echo $fullname; ?>
                    </div>
                </div>
            </div>
            <?php   
                $i++;
            }
            ?>
        </div>
        <hr>
        <div class="row" style="margin-top: 2em"><h1>Plakaty:</h1>
            <?php         
            $posterResults = $udao->getPosterResults(3);
            $i = 1;
            foreach ($posterResults as $result) {
                $fullname = $result["fullname"];
                $title = $result["title"];
                $score = $result["score"];
            ?>
            <hr>
            <div class="row" style="margin-bottom: 2em">
                <div class="col-lg-2"><h1><?php echo $i; ?>. </h1></div>
                <div class="col-lg-2"> <?php echo $score; ?>pkt. </div>
                <div class="col-lg-8">
                    <div class="row">
                        <h3><?php echo $title; ?></h3>
                    </div>
                    <div class="row">
                        <?php echo $fullname; ?>
                    </div>
                </div>
            </div>
            <?php   
                $i++;
            }
            ?>
        </div>
        
    </div>
    <footer class="footer">
      <div class="container">
        <p class="text-muted">θβℓιcℤε 2017</p>
      </div>
    </footer>
 
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!--<script src="assets/js/ie10-viewport-bug-workaround.js"></script>-->
    <script src="public/dist/js/jquery-3.2.1.min"></script>    
    <script src="public/dist/js/button.js"></script>    
  </body>
</html>
