<?php
/**
 * Created by PhpStorm.
 * User: frantisek.ff
 * Date: 4. 4. 2018
 * Time: 18:03
 */
include('simple_html_dom.php');
if(isset($_GET['odkaz'])){
    $odkaz = $_GET['odkaz'];
}

$curl = curl_init("http://is.stuba.sk/pracoviste/prehled_temat.pl". $odkaz );

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$page = curl_exec($curl);
curl_close($curl);




$html = new simple_html_dom();
$html->load($page);

$first_table = $html->find('table', 0);
$second_table = $html->find('table', 1);



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>


    <link rel="stylesheet"  type="text/css"  href="style.css">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script  src="js/bootstrap.min.js"></script>
    <script
        src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="="
        crossorigin="anonymous">
    </script>
    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity=""
        crossorigin="anonymous">
    </script>
    <script src="script.js"></script>


</head>
<body>
<div id="body">

<h1>Zakladne informacie</h1>

<?php echo $first_table;
?>

    <a href="index.php" class="btn btn-primary btn-rounded btn-sm" >Späť</a>
</div>
</body>
</html>
