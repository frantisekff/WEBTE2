<?php

header('Content-type: text/html; charset=utf-8');
session_start();

$context = stream_context_create([
    'ssl' => [
        // set some SSL/TLS specific options
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    ]
]);
//WSDL (Web Services Description Language) je jazyk, ktorý opisuje, aké funkcie ponúka webová služba a spôsob, ako sa jej to opýtať. Zapisuje sa vo formáte XML. Spravidla teda opisuje SOAP komunikáciu.
$client = new SoapClient(null, array(
        'location' => "......./server.php",
        'uri'      => "urn://xfrankof/req",
        'trace'    => 1,
        'stream_context' => $context)
);

if (isset($_POST['meniny'])){
    $ziskane = $_POST['meniny'];

    $return = $client->__soapCall("datum",array($ziskane));
    //print_r($return);
    $_SESSION["meniny"] = $return;
    header("Location: result.php");
}

else if (isset($_POST['menoAstat'])){
    $meno = $_POST['menoAstat'];
    $stat = $_POST['stat'];

    $return = $client->__soapCall("menoAstat",array($meno,$stat));
    //print_r($return);
    $_SESSION["menoAstat"] = $return;
    header("Location: result.php");
}



else if (isset($_POST['AllSK'])){
    $return = $client->__soapCall("SK_sviatky",array(""));
    //print_r($return);
    $_SESSION["AllSK"] = $return;
    header("Location: result.php");
}

else if (isset($_POST['AllCZ'])){
    $return = $client->__soapCall("CZ_sviatky",array(""));
    //print_r($return);
    $_SESSION["AllCZ"] = $return;
    header("Location: result.php");
}

else if (isset($_POST['pamatneDniAllSK'])){
    $return = $client->__soapCall("pamatneDni",array(""));
    //print_r($return);
    $_SESSION["pamatneDniSK"] = $return;
    header("Location: result.php");
}

?>
