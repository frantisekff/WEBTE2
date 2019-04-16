<?php
/**
 * Created by PhpStorm.
 * User: frantisek.ff
 * Date: 9. 3. 2018
 * Time: 22:34
 */


function getDatetimeNow()
{
    $tz_object = new DateTimeZone('Europe/Bratislava');
    $datetime = new DateTime();
    $datetime->setTimezone($tz_object);
    return $datetime->format('Y\-m\-d\ H:i:s');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<header>
    <h1>Zadanie 3</h1>
</header>
<body>
<div id="body">
    <?php
    session_start();
    if ((isset($_SESSION["id"]))) {
        echo "Ste prihlaseny: " . $_SESSION["id"] . "<br>";

        echo "<a href=\"logout.php\" class=\"btn btn-primary btn-rounded btn-sm \" >Log out</a>";
    }
    ?>
    <br>
    <br>

    <h2 class="col-4 offset-4"> Zadajte prihlasovacie údaje</h2>

    <?php


    if (isset($_GET['signin']) && $_GET['signin'] == 0) {
        echo "Zle prihlasovacie udaje";
        echo "<br>";

    }
    ?>

    <br>

    <form action="login.php" type="post" class="col-4 offset-4">
        <div class="form-group row ">
                <label for="username" class="col-3  col-form-label">Uživ. meno: </label>
                <div class="col-8">
                    <input type="text" name="username" id="username" autofocus required class="form-control" placeholder="Meno">
                </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="passwd" class="col-3  col-form-label">Heslo: </label>
            <div class="col-8">
            <input type="password" name="passwd" id="passwd" required class="form-control" placeholder="Heslo">
            </div>
        </div>


        <br>

        <input type="submit" value="Prihlasiť">
        <br>
        <br>

        <fieldset id="choode_account_type" class="form-check">
            <input type="radio" name="type" autofocus value="ldap"  id="radio1" class="form-check-input">
            <label class="form-check-label" for="radio1">LDAP účet</label>
            <br>
            <input type="radio" name="type" value="local" id="radio2"  class="form-check-input" checked>
            <label class="form-check-label" for="radio2">Lokálny účet</label>
        </fieldset>
        <br>
        <div class="offset-3">
            <a href="google.php" class="btn btn-secondary btn-rounded btn-sm">Google účet</a>
            <a href="register.php" class="btn btn-secondary btn-rounded btn-sm">Registrácia (Lokálny účet)</a>
        </div>


    </form>




</div>

</body>
</html>