<?php
/**
 * Created by PhpStorm.
 * User: frantisek.ff
 * Date: 19. 4. 2018
 * Time: 18:42
 */

require_once('config.php');
$ip = $_SERVER['REMOTE_ADDR'];
session_start();


$nameOfFile = basename(__FILE__, ".php");

$num_visits = $pdo->query("SELECT num_visit FROM `web_pages_logs` WHERE name = \""  . $nameOfFile . "\"")->fetchAll();
$num_visits = $num_visits[0]["num_visit"];
$num_visits++;

$insert_query = "UPDATE web_pages_logs SET  num_visit=?  WHERE name=\""  . $nameOfFile . "\"";

$pdo->prepare($insert_query)->execute([$num_visits ]);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title>2018| Domov Z7</title>

    <link rel="stylesheet"  type="text/css"  href="style.css">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script  src="js/bootstrap.min.js"></script>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light ">
        <a class="navbar-brand" href="index.php">Zadanie 7</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="visitor.php">O návštevníkoví <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="statistic.php">Štatistky</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="col-md-4 offset-4">

    <h1>Informácie o uživateľovi</h1>
    <h3>IP adresa: <?php echo $ip; ?></h3>
    <h3>GPS súradnice: <?php echo $_SESSION['lat'] . ' lat a ' . $_SESSION['lng'] ." lng"; ?></h3>
    <h3>Mesto vzhľadom k súradniciam: <?php echo $_SESSION['near_city']; ?> </h3>
    <h3>Hlavné mesto: <?php echo $_SESSION['country'] ; ?> </h3>
    <h3>Štát: <?php echo $_SESSION['capital_city']; ?></h3>

</div>
<!-- /.container -->


<footer>
    <div class="footer">
        <div class="col-md-12">
            &copy; Created by: xfrankof, 2018. Bootstrap.
        </div>
    </div>
</footer>

</body>
</html>
