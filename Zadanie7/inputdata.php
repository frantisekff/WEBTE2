<?php

Header('Content-type: text/xml');

require_once('config.php');

$data_map = $pdo->query("SELECT DISTINCT(city)AS \"unique_city\", lng, lat FROM visitors_logs WHERE city IS NOT NULL 
")->fetchAll();

    $xml = new SimpleXMLElement('<markers/>');
    $i = 0;
    foreach ($data_map as $row) {
        $i++;
        $track = $xml->addChild('marker');
        $track->addAttribute('id', $i);
        $track->addAttribute("lat", $row['lat']);
        $track->addAttribute(   "lng", $row['lng']);
}

print($xml->asXML());

?>
