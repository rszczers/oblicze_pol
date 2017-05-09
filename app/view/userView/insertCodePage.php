<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Oblicze</title>
        <link href="public/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="public/assets/style.css" rel="stylesheet">
        <link rel="icon" href="public/assets/favicon.ico">
        <script src="public/dist/js/jquery-3.2.1.min.js"></script>
    </head>
    <body>
    <div class="container">        
        <img src="public/assets/img/oblicze.jpg" class="img-responsive">
        <h2 class="form-signin-heading">Podaj swój kod</h2>
        <label class="sr-only">Hasło</label>
        <input type="password" id="userCodeField" class="form-control input-lg" placeholder="Twój kod" required>        
        <button id="codeButton" class="btn btn-lg btn-primary btn-block" onclick="redir()">Wprowadź</button>
    </div> 
        
    <footer class="footer">
    <div class="container">
        <p class="text-muted">θβℓιcℤε 2017</p>
    </div>
    </footer>
        
    <script>
        var go = document.getElementById("codeButton");
        var txt = document.getElementById("userCodeField");

        txt.addEventListener("keypress", function(event) {
            if (event.keyCode == 13) {
                go.click();
            }
        });
        function redir() {
            var code = $('#userCodeField').val();
            var redirectTo = 'http://<?php echo PAGE_ADDRESS; ?>' + code;
            window.location = redirectTo;
        }
    </script>
  </body>
</html>
