<?php
include('simple_html_dom.php');
/**
 * Created by PhpStorm.
 * User: frantisek.ff
 * Date: 4. 4. 2018
 * Time: 7:14
 */
$volne = 0;
$obsadene = 0;

if ((($_POST['typ_prace'] == 1)) || $_POST['typ_prace'] == 3) {
    $get_typ_prace = 1;
    if ($_POST['typ_prace'] == 1) {
        $volne = 1;
    } else {
        $obsadene = 1;
    }

} else if (($_POST['typ_prace'] == 2) || $_POST['typ_prace'] == 4) {
    $get_typ_prace = 2;
    if ($_POST['typ_prace'] == 2) {
        $volne = 1;
    } else {
        $obsadene = 1;
    }
}

if (isset($_POST['pracovisko'])) {
    $aktualny_kod_prac = $_POST['pracovisko'];


} else {

    $aktualny_kod_prac = 642;
}

if ($_POST['program']) {
    $aktualny_program = $_POST['program'];

}

if ($_POST['veduci']) {
    $aktualny_veduci = $_POST['veduci'];

}



$input_semester = 0;
$input_rok = 0;
if ($_POST['semester']) {
    $input_semester = $_POST['semester'];

}

if ($_POST['rok']) {
    $input_rok = $_POST['rok'];

}





$curl = curl_init("http://is.stuba.sk/pracoviste/prehled_temat.pl?lang=sk&pracoviste=" . $aktualny_kod_prac . "&filtr_typtemata2=" . $get_typ_prace . "&filtr_programtemata2=" . $aktualny_program . "&filtr_vedtemata2=" . $aktualny_veduci . "&omezit_temata2=Obmedzi%C5%A5&ke_schvaleni=1&alias=ke_schvaleni");

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$page = curl_exec($curl);
//$information = curl_getinfo($curl);
//var_dump($information);
curl_close($curl);

//echo $page;


$html = new simple_html_dom();
$html->load($page);

$first_table = $html->find('table', 0);
$second_table = $html->find('table', 1);


$nazov_pracoviska = array("Ústav automobilovej mechatroniky", "Ústav elektroenergetiky a aplikovanej elektrotechniky", "Ústav elektroniky a fotoniky", "Ústav elektrotechniky", "Ústav informatiky a matematiky", "Ústav jadrového a fyzikálneho inžinierstva", "Ústav multimediálnych informačných a komunikačných technológií", "Ústav robotiky a kybernetiky");
$kod_pracoviska = array(642, 548, 549, 550, 816, 817, 818, 356);


//$mapNazovKod = array_map(null, $nazov_pracoviska, $kod_pracoviska);
//var_dump($mapNazovKod);
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
            integrity=""
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
<header>
    <h1>Zadanie 5 </h1>
</header>

<div id="body">
<form action="index.php" method="post">
    <label>Vyber pracovisko:</label>
    <select name="pracovisko">
        <?php

        for ($x = 0; $x <= count($kod_pracoviska) - 1; $x++) {
            echo "<option value=\"" . $kod_pracoviska[$x] . "\"" . ">" . $nazov_pracoviska[$x] . "</option>";
        }
        ?>

    </select>
    <br>
    Typ prace:
    <select name="typ_prace">
        <option value="1"> Bakalarska praca - volne</option>
        <option value="2"> Diplomova praca - volne</option>
        <option value="3"> Bakalarska praca - obsadene</option>
        <option value="4"> Diplomova praca - obsadene</option>
    </select>
    <br>
    <label>Vyber studijny program:</label>
    <select name="program">
        <?php
        $vsetky_programy = $first_table->find('tr', 1);
        foreach ($vsetky_programy->find('option') as $element) {
            echo $element;
        }
        ?>

    </select>
    <br>
    <label>Vyber veduceho:</label>

    <select name="veduci">
        <?php
        $vsetci_veduci = $first_table->find('tr', 2);
        foreach ($vsetci_veduci->find('option') as $element) {
            echo $element;
        }
        ?>

    </select>
    <br>
    Semester:
    <select name="semester">
        <option value="0"> Vsetky</option>
        <option value="1"> 1</option>
        <option value="2"> 2</option>
        <option value="3"> 3</option>
        <option value="4"> 4</option>
        <option value="5"> 5</option>
        <option value="6"> 6</option>
    </select>
    <br>
    Rocnik:
    <select name="rok">
        <option value="0"> Vsetky</option>
        <option value="1"> 1</option>
        <option value="2"> 2</option>
        <option value="3"> 3</option>
    </select>
    <br>

    <input type="submit" value="Vybrat" name="vytvorit">
</form>


<table class="table table-striped w-auto table-bordered table-hover table2" id="myTable">
    <thead class="thead-inverse">
    <tr>
        <th>
            Typ prace
        </th>
        <th>
            Nazov prace
        </th>
        <th>
            Meno skolitela
        </th>
        <th>
            Obsadene/Max
        </th>
        <th>
            Studijny program
        </th>
        <th>
            Riesitel
        </th>
        <th>
            Rocnik
        </th>
        <th>
            Semester
        </th>
    </tr>
    </thead>


    <tbody>
    <?php
    foreach ($second_table->find('tr') as $element) {
        $typ_prace = $element->find('td', 1)->plaintext;
        $nazov = $element->find('td', 2)->plaintext;
        $meno_skolitela = $element->find('td', 3)->plaintext;
        $stud_program = $element->find('td', 5)->plaintext;
        $obsadenost = $element->find('td', 8)->plaintext;

        $odkaz = $element->find('a', 1);
        if (is_object($odkaz)) {
            $praca_odkaz = $odkaz->getAttribute('href');
        }

        $meno_riesitela = $element->find('td', 9)->plaintext;

        $riesitel_odkaz = $element->find('a', 2);


        if (is_object($riesitel_odkaz)) {
            $riesitel_odkaz = $riesitel_odkaz->getAttribute('href');
            $riesitel_odkaz = substr($riesitel_odkaz, 5, 24);

            $curl = curl_init("http://is.stuba.sk" . $riesitel_odkaz . "&lang=sk;");

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $about = curl_exec($curl);
            curl_close($curl);


            $about_html = new simple_html_dom();
            $about_html->load($about);

            $first_table = $about_html->find('table', 1);


            if (is_object($first_table)) {
                $first_table = $first_table->find('td', 5)->plaintext;
                //$first_table = $first_table->find('td')->plaintext;

                $pos_sem = strpos($first_table, "sem");
                $pos_rok = strpos($first_table, "roč");
                $sem_cislo = substr($first_table, $pos_sem + 4, 1);
                $rok_cislo = substr($first_table, $pos_rok + 5, 1);

            } else {
                $first_table = "";
            }


        } else {
            $riesitel_odkaz = "--";
            $first_table = "--";
            $sem_cislo = "--";
            $rok_cislo = "--";
        }

        $aktualne_obsadene = substr($obsadenost,0,1);
        $ci_je_volne = 0;
        $max = substr($obsadenost,4,1);
        if(($max == "-") ){
            $ci_je_volne = 1;
        }else if(is_numeric($max)){
            $rozdiel = (int) $max - $aktualne_obsadene;
            if($rozdiel >= 1){
                $ci_je_volne = 1;

            }

        }
        if($obsadene){
            if($ci_je_volne)
                $ci_je_volne = 0;
            else{
                $ci_je_volne = 1;
            }
        }
        if($input_semester > 0) {
            if ($input_semester == $sem_cislo ){
                    $ci_sem = 1;
            }else{
                $ci_sem = 0;
            }
        }else{
            $ci_sem = 1;

        }

        if($input_rok > 0) {
            if ($input_rok == $rok_cislo ){
                $ci_rok = 1;
            }else{
                $ci_rok = 0;
            }
        }else{
            $ci_rok = 1;

        }

        if($ci_je_volne && $ci_sem && $ci_rok){
            echo "<tr>" .
                "<td>" . $typ_prace . "</td>" .
                "<td><a href=\"podrobnosti.php?odkaz=" . $praca_odkaz . "\">" . $nazov . "</a></td>" .
                "<td>" . $meno_skolitela . "</td>" .
                "<td>" . $obsadenost . "</td>" .
                "<td>" . $stud_program . "</td>" .
                "<td>" . $meno_riesitela . "</td>" .
                "<td>" . $rok_cislo . "</td>" .
                "<td>" . $sem_cislo . "</td>" .

                "</tr>";
       }
       else {
            //echo "Ziadne volne prace <br>";

       }




    }

    ?>
    </tbody>
</table>
</div>
</body>
</html>
