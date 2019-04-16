<?php
/**
 * Created by PhpStorm.
 * User: frantisek.ff
 * Date: 10. 3. 2018
 * Time: 10:15
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
<body>
<div id="body">
    <form action="register.php" method="post">
        <label for="name">Meno: * </label>
        <input type="text" name="name" required><br>
        <label for="surname">Priezvisko: *</label>
        <input type="text" name="surname" required><br>
        <label for="email">Email: *</label>
        <input type="text" name="email" required><br>
        <label for="username">Uživat. meno: *</label>
        <input type="text" name="username" required><br>
        <label for="">Heslo: *</label>
        <input type="password" id="passwd" required name="passwd"><br>
        <input type="text" hidden value="1" name="register">

        <input type="submit" class="btn btn-primary btn-rounded btn-sm" value="Registrovať">
        <a href="index.php" class="btn btn-primary btn-rounded btn-sm" >Späť</a>


    </form>

</div>

</body>
</html>


<?php
if ($_POST['register'] == 1){

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $passwd = hash('sha256', $_POST['passwd']);


    $sql = "INSERT INTO users (name, surname, email, username, passwd) 
                      VALUES (?, ?, ?, ?, ?)";

    $pdo->prepare($sql)->execute([$name, $surname, $email, $username, $passwd]);

    echo "Udaje vlozene do DB";


}


?>
