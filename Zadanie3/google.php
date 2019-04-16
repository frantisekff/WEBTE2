<?php
/**
 * Created by PhpStorm.
 * User: frantisek.ff
 * Date: 10. 3. 2018
 * Time: 17:32
 */

include 'config.php';
require_once 'google-api-php-client-2.2.1/vendor/autoload.php';

$client = new Google_Client();
$client->setClientId("");
$client->setClientSecret("");
$client->setRedirectUri("http://xfrankof.147.175.98.137.nip.io/zadanie__33/google.php");
$client->setScopes(array('https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile',));



//Send Client Request
$objOAuthService = new Google_Service_Oauth2($client);

//
//LOGOUT je vo vlastnom subore


//Authenticate code from Google OAuth Flow
//Add Access Token to Session
if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

//Set Access Token to make Request
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
}

//Get User Data from Google Plus
if ($client->getAccessToken()) {

    $userData = $objOAuthService->userinfo->get();

    if(!empty($userData)) {
        //print_r($userData);
        session_start();
        $_SESSION['id']=$userData["email"];
        $_SESSION['meno']=$userData["givenName"];
        $_SESSION['priezvisko']=$userData["familyName"];
        $_SESSION['GoogleSS']="true";



        $id=$userData["email"];
        $typUctu = "google";
        $_SESSION["typ_uctu"]=$typUctu;
        $time_login = getDatetimeNow();
        $type_login = "Google";
        $sql = "INSERT INTO history_login ( username, time_login, type_login)
  VALUES (?, ?, ? )";

        $pdo->prepare($sql)->execute([$id, $time_login, $type_login]);

        header('Location: welcome.php');
    }

    $_SESSION['access_token'] = $client->getAccessToken();
}
else {
    $authUrl = $client->createAuthUrl();
    header('Location: '.$authUrl);
   // print "<button class=\"btn btn-lg btn-primary btn-block\" style=\"width: 300px; margin:0 auto;\" name=\"prihlasit\" onClick=\"location.href='$authUrl'\" type=\"submit\">Prihlásiť sa pomocou Google účtu</button>";
}




function getDatetimeNow()
{
    $tz_object = new DateTimeZone('Europe/Bratislava');
    $datetime = new DateTime();
    $datetime->setTimezone($tz_object);
    return $datetime->format('Y\-m\-d\ H:i:s');
}


?>
