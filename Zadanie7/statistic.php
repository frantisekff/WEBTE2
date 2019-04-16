<?php
/**
 * Created by PhpStorm.
 * User: frantisek.ff
 * Date: 19. 4. 2018
 * Time: 18:43
 */
require_once('config.php');

$data = $pdo->query("SELECT tag_flag, country, COUNT(filt_date) AS counted FROM ( SELECT tag_flag, ip_adress, country, Date(time_stamp)AS filt_date FROM `visitors_logs` GROUP BY DATE(time_stamp),ip_adress, country, tag_flag) AS table1 GROUP BY country, tag_flag
")->fetchAll();

$data_map = $pdo->query("SELECT DISTINCT(city)AS \"unique_city\", lng, lng FROM visitors_logs WHERE city IS NOT NULL
")->fetchAll();

$counted_6_14 = $pdo->query("SELECT COUNT(filtered_time) AS counted FROM (SELECT (DATE_FORMAT(time_stamp, \"%H:%i:%s\")) AS filtered_time FROM `visitors_logs`) AS table1 WHERE filtered_time BETWEEN '06:00:00' AND '13:59:59'")->fetchAll();
$counted_14_20 = $pdo->query("SELECT COUNT(filtered_time) AS counted FROM (SELECT (DATE_FORMAT(time_stamp, \"%H:%i:%s\")) AS filtered_time FROM `visitors_logs`) AS table1 WHERE filtered_time BETWEEN '14:00:00' AND '19:59:59'")->fetchAll();
$counted_20_24 = $pdo->query("SELECT COUNT(filtered_time) AS counted FROM (SELECT (DATE_FORMAT(time_stamp, \"%H:%i:%s\")) AS filtered_time FROM `visitors_logs`) AS table1 WHERE filtered_time BETWEEN '20:00:00' AND '23:59:59'")->fetchAll();
$counted_24_6 = $pdo->query("SELECT COUNT(filtered_time) AS counted FROM (SELECT (DATE_FORMAT(time_stamp, \"%H:%i:%s\")) AS filtered_time FROM `visitors_logs`) AS table1 WHERE filtered_time BETWEEN '00:00:00' AND '05:59:59'")->fetchAll();


session_start();

$nameOfFile = basename(__FILE__, ".php");

$num_visits = $pdo->query("SELECT num_visit FROM `web_pages_logs` WHERE name = \"" . $nameOfFile . "\"")->fetchAll();

$num_visits = $num_visits[0]["num_visit"];
$num_visits++;

$insert_query = "UPDATE web_pages_logs SET  num_visit=?  WHERE name=\"" . $nameOfFile . "\"";

$pdo->prepare($insert_query)->execute([$num_visits]);


$web_pages_logs = $pdo->query("SELECT * FROM `web_pages_logs`")->fetchAll();


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>

    <title>2018| Domov Z7</title>

    <link rel="stylesheet" type="text/css" href="style.css">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 400px;
            width: 100%;
        }

        /* Optional: Makes the sample page fill the window. */

    </style>
    <script src="script_mapa.js"></script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap">
    </script>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light ">
        <a class="navbar-brand" href="index.php">Zadanie 7</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
<div class="col-md-10 offset-1 ">
    <div class="row">
        <div class="col-md-3">
            <table class="table table-striped table-responsive w-auto table-bordered table-hover ">
                <thead class="thead-inverse">
                <tr>


                    <th class="th-sm">Vlajka</th>
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

                        "<td>" . "<img src=" . $row['tag_flag'] . " height=\"40\" alt=\"Nie je dostupná\"/>
"
                        . "</td>" .
                        "<td> <a href='description_country.php?country=" . $row["country"] . "'> " . $row["country"] . "</a></td>" .
                        "<td>" . $row["counted"] . "</td>" .
                        "</tr>";
                }
                ?>

                </tbody>
            </table>
        </div>
        <div class="col-md-3">
            <table class="table table-striped table-responsive w-auto table-bordered table-hover ">
                <thead class="thead-inverse">
                <tr>


                    <th class="th-sm">Názov</th>
                    <th class="th-sm">Počet návštev</th>

                </tr>
                </thead>
                <tbody>
                <?php

                foreach ($web_pages_logs as $row) {
                    echo "<tr>" .


                        "<td>" . $row["name"] . "</td>" .
                        "<td>" . $row["num_visit"] . "</td>" .
                        "</tr>";
                }
                ?>

                </tbody>
            </table>
        </div>
        <div class="col-md-3">
        <table class="table table-striped table-responsive w-auto table-bordered table-hover ">
            <thead class="thead-inverse">
            <tr>


                <th class="th-sm">Časy</th>
                <th class="th-sm">Počet návštev</th>

            </tr>
            </thead>
            <tbody>
            <?php


            echo "<tr>" .
                "<td>" . "6:00-14:00" . "</td>" .
                "<td>" . $counted_6_14[0]['counted'] . "</td>" .
                "</tr>" .
                "<tr>" .
                "<td>" . "14:00-20:00" . "</td>" .
                "<td>" . $counted_14_20[0]['counted'] . "</td>" .
                "</tr>" .
                "<tr>" .
                "<td>" . "20:00-24:00" . "</td>" .
                "<td>" . $counted_20_24[0]['counted'] . "</td>" .
                "</tr>" .
                "<td>" . "24:00-6:00" . "</td>" .
                "<td>" . $counted_24_6[0]['counted'] . "</td>" .
                "</tr>";

            ?>

            </tbody>
        </table>
        </div>
    </div>


</div>

<div id="map"></div>
<!-- /.container -->


</body>
</html>
