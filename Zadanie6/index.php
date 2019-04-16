<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="xfrankof">


    <title>2018| Domov Z6</title>

    <link rel="stylesheet"  type="text/css"  href="style.css">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script  src="js/bootstrap.min.js"></script>

</head>

<body >

<header>
    <h1>Vitajte na stránke so zadaním č.6 z WEBTECH 2</h1>
</header>
<div class="col-md-3 offset-5">

    <div class="starter-template">

        <br>

        <form class="form-template" role="form" method="post" action="client.php">
            <h2>Zisti meniny z dátumu:</h2>
            <input type="date" name="meniny" class="form-control">
            <br>
            <button class="btn btn-lg btn-primary btn-block offset-4 col-md-4" name="meninyButton" type="submit">Zisti</button>
        </form>
        <br>

        <form class="form-template" role="form" method="post" action="client.php">
            <h2>Zisti meniny z mena pre štát:</h2>
            <input type="text" name="menoAstat" class="form-control" placeholder="napr. Jožko">
            <select name="stat" class="form-control">
                <option value="SK" selected>Slovensko</option>
                <option value="CZ">Česko</option>
                <option value="HU">Maďarsko</option>
                <option value="PL">Poľsko</option>
                <option value="AT">Rakúsko</option>
            </select>
            <br>
            <button class="btn btn-lg btn-primary btn-block offset-4 col-md-4" name="menoAstatButton" type="submit">Zisti</button>
        </form>
        <br>


        <form class="form-template" role="form" method="post" action="client.php">
            <h2>Zobraz všetky sviatky pre Slovensko:</h2>
            <button class="btn btn-lg btn-primary btn-block offset-4 col-md-4" name="AllSK" type="submit">Zobraz</button>
        </form>
        <br>
        <form class="form-template" role="form" method="post" action="client.php">
            <h2>Zobraz všetky sviatky pre Česko:</h2>
            <button class="btn btn-lg btn-primary btn-block offset-4 col-md-4" name="AllCZ" type="submit">Zobraz</button>
        </form>
        <br>
        <form class="form-template" role="form" method="post" action="client.php">
            <h2>Zobraz všetky pamätné dni pre Slovensko:</h2>
            <button class="btn btn-lg btn-primary btn-block offset-4 col-md-4" name="pamatneDniAllSK" type="submit">Zobraz</button>
        </form>
        <br>
        <form class="form-template" role="form" method="post" action="add_new.php">
            <h2>Pridaj meno podľa datumu:</h2>
            <input type="date" name="pridajmeno" class="form-control">
            <input type="text" name="novemeno" class="form-control" placeholder="napr. Jožko">
            <button class="btn btn-lg btn-primary btn-block offset-4 col-md-4" name="" type="submit">Pridaj</button>
        </form>
    </div>
    <?php
    if (isset($_GET['zapisane'])){
        echo "Meno bolo pridane";
    }

    ?>
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
