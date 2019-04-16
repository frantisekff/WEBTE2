<?php
require_once('config.php');



/**
 * Created by PhpStorm.
 * User: frantisek.ff
 * Date: 18. 4. 2018
 * Time: 14:03
 */
// set IP address and API access key

$ip = $_SERVER['REMOTE_ADDR'];
$access_key = '';


// Initialize CURL:
$ch = curl_init('http://api.ipstack.com/'.$ip.'?access_key='.$access_key.'');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Store the data:
$json = curl_exec($ch);
curl_close($ch);

// Decode JSON response:
$api_result = json_decode($json, true);

// Output the "capital" object inside "location"

$lat = $api_result['latitude'];
$lng = $api_result['longitude'];
session_start();
$_SESSION['lat'] = $lat;
$_SESSION['lng'] = $lng;


$city = $api_result['city'];
$country = $api_result['country_name'];
$capital_city = $api_result['location']['capital'];
$flag = $api_result['location']['country_flag'];
$_SESSION['flag'] = $flag;
$tag_flag = $api_result['location']['country_flag'];

$date = date("Y-m-d H:i:s", time());

$sql = "INSERT INTO visitors_logs (ip_adress, country, city, time_stamp, capital_city, lat, lng, tag_flag)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$pdo->prepare($sql)->execute([$ip, $country, $city, $date, $capital_city, $lat, $lng, $tag_flag ]);


$weather = curl_init('http://api.openweathermap.org/data/2.5/weather?lat='.$lat.'&lon='.$lng.'&units=metric&appid=');
curl_setopt($weather, CURLOPT_RETURNTRANSFER, true);

$res_weather = curl_exec($weather);
curl_close($weather);

$json_weather= json_decode($res_weather, JSON_PRETTY_PRINT);
//$wind = $json_weather['wind']['speed'];
  //  print_r($json_weather);
//header('Content-Type: application/json');
//print_r($api_result);
//print_r($wind);

$description = $json_weather['weather']['0']['description'];

$temperature = $json_weather['main']['temp'];

$wind = $json_weather['wind']['speed'];
$city_weather = $json_weather['name'];

$_SESSION['near_city'] = $city_weather;
$_SESSION['country'] = $country;
$_SESSION['capital_city'] = $capital_city;



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
<div class="col-md-3 offset-5">

<h1>Predpoveď počasia</h1>
<h3>Mesto: <?php echo $city_weather; ?></h3>
    <h3>Aktuálne počasie: <?php echo $description; ?></h3>
    <h3>Rychlosť vetra: <?php echo $wind; ?> km/h</h3>
    <h3>Aktuálna teplota: <?php echo $temperature; ?> °C</h3>


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
