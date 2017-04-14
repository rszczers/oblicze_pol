<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/favicon.ico">

    <title>Oblicze</title>
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error-template {padding: 40px 15px;text-align: center;}
        .error-actions {margin-top:15px;margin-bottom:15px;}
        .error-actions .btn { margin-right:10px; }
    </style>
    
  <body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="error-template">
                    <h1>To nie jest strona, której szukasz.</h1>
                    <h2>404</h2>
                    <div class="error-details">
                        Podany adres prowadzi do nikąd.
                    </div>
                    <div class="error-actions">
                        <a href="" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
                            Wprowadź kod głosowania </a><a href="<?php PAGE_ADDRESS ?>" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> Skontaktuj się z nami</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>