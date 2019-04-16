<?php

header('Content-type: text/html; charset=utf-8');
date_default_timezone_set('Europe/Bratislava');

function hello($someone) {
    return "Hello " . $someone . "!";
}

function menoAstat($selected, $stat){
    $xmlDoc = new DOMDocument();
    $xmlDoc->load("data.xml");

    if (empty($selected)){
        die;
    }

    $zaznamy = $xmlDoc->getElementsByTagName("zaznam");
    foreach ($zaznamy as $zaznam) {
        if ($stat == "SK") {
            if ($zaznam->getElementsByTagName("SKd")->length > 0) {

                $tmp = $zaznam->getElementsByTagName("SKd")->item(0)->nodeValue;
                $TMParray = explode(",", $tmp);

                foreach ($TMParray as $tmpArray) {
                    $tmpArray = ltrim($tmpArray, " ");
                    if (strcmp($tmpArray, $selected) == 0) {
                        $tmp2 = $zaznam->getElementsByTagName("den");
                        $datum = $tmp2->item(0)->nodeValue;
                        return $datum;
                    }
                }

            }
        } else if ($stat == "CZ") {
            if ($zaznam->getElementsByTagName("CZ")->length > 0) {

                $tmp = $zaznam->getElementsByTagName("CZ")->item(0)->nodeValue;

                if (strcmp($tmp, $selected) == 0) {
                    $tmp2 = $zaznam->getElementsByTagName("den");
                    $datum = $tmp2->item(0)->nodeValue;
                    return $datum;
                }
            }
        } else if ($stat == "HU") {
            if ($zaznam->getElementsByTagName("HU")->length > 0) {

                $tmp = $zaznam->getElementsByTagName("HU")->item(0)->nodeValue;

                if (strcmp($tmp, $selected) == 0) {
                    $tmp2 = $zaznam->getElementsByTagName("den");
                    $datum = $tmp2->item(0)->nodeValue;
                    return $datum;
                }
            }
        } else if ($stat == "PL") {
            if ($zaznam->getElementsByTagName("PL")->length > 0) {

                $tmp = $zaznam->getElementsByTagName("PL")->item(0)->nodeValue;

                if (strcmp($tmp, $selected) == 0) {
                    $tmp2 = $zaznam->getElementsByTagName("den");
                    $datum = $tmp2->item(0)->nodeValue;
                    return $datum;
                }
            }
        } else if ($stat == "AT") {
            if ($zaznam->getElementsByTagName("AT")->length > 0) {

                $tmp = $zaznam->getElementsByTagName("AT")->item(0)->nodeValue;

                if (strcmp($tmp, $selected) == 0) {
                    $tmp2 = $zaznam->getElementsByTagName("den");
                    $datum = $tmp2->item(0)->nodeValue;
                    return $datum;
                }
            }
        }
    }
}

function datum($selected){
    $xmlDoc = new DOMDocument();
    $xmlDoc->load("data.xml");

    if (empty($selected)){
        die;
    }

    $zadanyDatum = date ('md', strtotime($selected));

    $vysledokArray = array();

    $zaznamy = $xmlDoc->getElementsByTagName("zaznam");
    foreach ($zaznamy as $zaznam) {
        if ( $zaznam->getElementsByTagName("den")->item(0)->nodeValue == $zadanyDatum){

            if ($zaznam->getElementsByTagName("SKd")->length > 0){
                array_push($vysledokArray, $zaznam->getElementsByTagName("SKd")->item(0)->nodeValue);
            }

            else if ($zaznam->getElementsByTagName("SK")->length > 0){
                array_push($vysledokArray, $zaznam->getElementsByTagName("SK")->item(0)->nodeValue);
            }

            if ($zaznam->getElementsByTagName("CZ")->length > 0){
                array_push($vysledokArray, $zaznam->getElementsByTagName("CZ")->item(0)->nodeValue);
            }

            if ($zaznam->getElementsByTagName("HU")->length > 0){
                array_push($vysledokArray, $zaznam->getElementsByTagName("HU")->item(0)->nodeValue);
            }

            if ($zaznam->getElementsByTagName("PL")->length > 0){
                array_push($vysledokArray, $zaznam->getElementsByTagName("PL")->item(0)->nodeValue);
            }

            if ($zaznam->getElementsByTagName("AT")->length > 0){
                array_push($vysledokArray, $zaznam->getElementsByTagName("AT")->item(0)->nodeValue);
            }
        }
    }
    return $vysledokArray;
}


function pamatneDni($selected)
{

    $xmlDoc = new DOMDocument();
    $xmlDoc->load("data.xml");

    $pamatneDni = array();

    $zaznamy = $xmlDoc->getElementsByTagName("zaznam");
    foreach ($zaznamy as $zaznam) {
        if ($zaznam->getElementsByTagName("SKdni")->length > 0) {
            $tmp1 = $zaznam->getElementsByTagName("den");
            $datum = $tmp1->item(0)->nodeValue;

            $tmp2 = $zaznam->getElementsByTagName("SKdni");
            $najdenySviatok = $tmp2->item(0)->nodeValue;
            array_push($pamatneDni, $datum);
            array_push($pamatneDni, $najdenySviatok);
        }
    }

    return $pamatneDni;
}

function SK_sviatky($selected){

    $xmlDoc = new DOMDocument();
    $xmlDoc->load("data.xml");

    $SKsviatkyStack = array();

    $zaznamy = $xmlDoc->getElementsByTagName("zaznam");
    foreach( $zaznamy as $zaznam ) {
        if ($zaznam->getElementsByTagName("SKsviatky")->length > 0) {
            $tmp1 = $zaznam->getElementsByTagName("den");
            $datum = $tmp1->item(0)->nodeValue;

            $tmp2 = $zaznam->getElementsByTagName("SKsviatky");
            $najdenySviatok = $tmp2->item(0)->nodeValue;
            array_push($SKsviatkyStack, $datum);
            array_push($SKsviatkyStack, $najdenySviatok);
        }
    }

    return $SKsviatkyStack;
}

function CZ_sviatky($selected){

    $xmlDoc = new DOMDocument();
    $xmlDoc->load("data.xml");

    $CZsviatkyStack = array();

    $zaznamy = $xmlDoc->getElementsByTagName("zaznam");
    foreach( $zaznamy as $zaznam ) {
        if ($zaznam->getElementsByTagName("CZsviatky")->length > 0) {
            $tmp1 = $zaznam->getElementsByTagName("den");
            $datum = $tmp1->item(0)->nodeValue;

            $tmp2 = $zaznam->getElementsByTagName("CZsviatky");
            $najdenySviatok = $tmp2->item(0)->nodeValue;
            array_push($CZsviatkyStack, $datum);
            array_push($CZsviatkyStack, $najdenySviatok);
        }
    }

    return $CZsviatkyStack;
}

$context = stream_context_create([
    'ssl' => [
        // set some SSL/TLS specific options
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    ]
]);

//vytvorenie servera
$server = new SoapServer(null, array('uri' => "urn://xfrankof/res"));

//registrovanie funkcii pre API
//$server->addFunction("hello");
$server->addFunction("SK_sviatky");
$server->addFunction("CZ_sviatky");
$server->addFunction("pamatneDni");
$server->addFunction("menoAstat");
$server->addFunction("datum");

//handle na server
$server->handle();

?>