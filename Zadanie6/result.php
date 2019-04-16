<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>2018 | Result Z6</title>

    <link rel="stylesheet"  type="text/css"  href="style.css">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script  src="js/bootstrap.min.js"></script>

</head>

<body>


<div class="container">

    <div class="starter-template">
        <h1>Výsledok dopytu</h1>
        <br>

        <p class="lead">
            <?php

            session_start();

            if (isset($_SESSION["meniny"])){
                $vysledok = $_SESSION["meniny"];
                echo implode(',',$vysledok);
            }

            else if (isset($_SESSION['menoAstat'])){
                $tmp = $_SESSION["menoAstat"];
                $datum=$tmp[2].$tmp[3].".".$tmp[0].$tmp[1];
                echo $datum;
            }

            else if (isset($_SESSION['meno'])){
                $vysledok = $_SESSION["meno"];
                print_r($vysledok);
            }

            else if (isset($_SESSION['AllSK'])){
                $vysledok = $_SESSION["AllSK"];
                for ($i = 0; $i < count($vysledok); $i+=2) {
                    $tmp=$vysledok[$i];
                    $datum=$tmp[2].$tmp[3].".".$tmp[0].$tmp[1];
                    echo $datum;
                    echo "<br/>";
                    echo $vysledok[$i+1];
                    echo "<br/><br/>";
                }
            }

            else if (isset($_SESSION['AllCZ'])){
                $vysledok = $_SESSION["AllCZ"];
                for ($i = 0; $i < count($vysledok); $i+=2) {
                    $tmp=$vysledok[$i];
                    $datum=$tmp[2].$tmp[3].".".$tmp[0].$tmp[1];
                    echo $datum;
                    echo "<br/>";
                    echo $vysledok[$i+1];
                    echo "<br/><br/>";
                }
            }

            else if (isset($_SESSION['pamatneDniSK'])){
                $vysledok = $_SESSION["pamatneDniSK"];
                for ($i = 0; $i < count($vysledok); $i+=2) {
                    $tmp=$vysledok[$i];
                    $datum=$tmp[2].$tmp[3].".".$tmp[0].$tmp[1];
                    echo $datum;
                    echo "<br/>";
                    echo $vysledok[$i+1];
                    echo "<br/><br/>";
                }
            }


            ?>
        </p>

        <form class="form-template" role="form" method="post" action="clear.php">
            <button class="btn btn-danger" type="submit">Späť</button>
        </form>

    </div>

</div>
<!-- /.container -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="../../dist/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

<footer>
    <div class="footer">
        <div class="col-md-12">
            &copy; Created by: xfrankof, 2018. Bootstrap.
        </div>
    </div>
</footer>
</body>
</html>
