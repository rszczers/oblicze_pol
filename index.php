<?php
include 'app/config.php';
require 'app/vendor/autoload.php';
use Medoo\Medoo;

$database = new Medoo([
	// required
	'database_type' => DB_TYPE,
	'database_name' => DB_NAME,
	'server' => DB_HOST,
	'username' => DB_USER,
	'password' => DB_PASSWORD,
	'charset' => DB_CHARSET]
    );

$request = (isset($_GET['request']) ? explode('/', $_GET['request']) : null);
$userCode = $request[0];

$userData = $database->select("Users", [
    "fname",
    "code",
    "didVote",
    "email"], [
    "code" => $userCode]);

if (count($userData) > 0) {
    echo "dziala";
} else {
    echo "nie dziala";
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
<?php
   // echo "coś dziala\n";
   // $datas = $database->select("Type", "name");
   // var_dump($datas);
   // var_dump($request);
?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    </body>
</html>
