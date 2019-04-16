<?php
/**
 * Created by PhpStorm.
 * User: frantisek.ff
 * Date: 9. 3. 2018
 * Time: 23:45
 */
include 'config.php';
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
<body >
<div id="body" style="text-align:center;">


    <?php
    session_start();
    if ((isset($_SESSION["id"]))) {
        echo "Ste prihlaseny: ". $_SESSION["id"] . "<br>";

        echo "<a href=\"logout.php\" class=\"btn btn-primary btn-rounded btn-sm \" >Log out</a>";

        echo "<h2>Vitajte, ste prihlaseny " . $_SESSION["meno"] ."</h2>";

        echo "<br>";


        ?>
           <h2>Posledných 5 prihlásení: </h2>
    <br>


         <table class="table table-striped w-auto table-bordered table-hover table2"  >
        <thead class="thead-inverse">
        <tr>

            <th>
                Username
            </th>
            <th>
                Time
            </th>
            <th>
                Type
            </th>

        </tr>
        </thead>

        <?php
        $id =  $_SESSION["id"];

     trim($id);
    //    SELECT * FROM `history_login`  WHERE type_login = 'Local' ORDER BY `time_login` DESC
        $data = $pdo->query("SELECT * FROM history_login WHERE username = '".$id."'" . " ORDER BY time_login DESC LIMIT 5");
        $ldap = $pdo->query("SELECT COUNT(*) AS num FROM history_login WHERE type_login = 'LDAP'")->fetchColumn();
        $google = $pdo->query("SELECT COUNT(*) AS num FROM history_login WHERE type_login = 'Google'")->fetchColumn();
        $local = $pdo->query("SELECT COUNT(*) AS num FROM history_login WHERE type_login = 'Local'")->fetchColumn();




foreach ($data as $row) {

    echo "<tr>" .

        "<td>" . $row["username"] . "</td>" .
        "<td>" . $row["time_login"] . "</td>" .
        "<td>" . $row["type_login"] . "</td>" .
        "</tr>";
    }



?>
    </table>


        <table class="table table-striped w-auto table-bordered table-hover table2"  >
            <thead class="thead-inverse">
            <tr>

                <th>
                    LDAP
                </th>
                <th>
                    Google
                </th>
                <th>
                    Local
                </th>

            </tr>
            </thead>

            <tr>
                <td><?php echo $ldap; ?></td>
                <td><?php echo $google; ?></td>
                <td><?php echo $local; ?></td>
            </tr>
        </table>
<?php
    } else {
        echo "<h2>Vitajte, NIE ste prihlaseny  </h2>";
    }
    ?>

    <a href="index.php" class="btn btn-primary btn-rounded btn-sm" >Späť</a>

</div>
</body>
</html>