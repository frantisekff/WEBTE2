<?php
/**
 * Created by PhpStorm.
 * User: frantisek.ff
 * Date: 19. 4. 2018
 * Time: 18:43
 */
require_once('config.php');
$clicked_coutry = $_GET['country'];
$nelokal = "Mesto nelokalizovane";
$data = $pdo->query("SELECT null_city, COUNT(null_city) AS counted  FROM (SELECT country, IFNULL(city, \"Mesto nelokalizovane\") AS null_city, Date(time_stamp)AS filt_date FROM `visitors_logs` WHERE country = '".$clicked_coutry."' GROUP BY DATE(time_stamp), null_city)AS table1 GROUP BY null_city  
")->fetchAll();
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
<div class="col-md-6 offset-3">

    <table class="table table-striped table-responsive w-auto table-bordered table-hover ">
        <thead class="thead-inverse">
        <tr>



            <th class="th-sm">Štát</th>
            <th>
                <a href="index.php?sort=rok">Počet návštev</a>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($data as $row) {
            echo "<tr>" .

                 "<td>" . $row["null_city"] . "</td>" .
                "<td>" . $row["counted"] . "</td>" .
                "</tr>";
        }
        ?>

        </tbody>
    </table>








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

