<?php
// The file test.xml contains an XML document with a root element
// and at least an element /[root]/title.
if (isset($_POST['pridajmeno'])) {
    $datum = $_POST['pridajmeno'];
}
if (isset($_POST['novemeno'])) {
    $novemeno = $_POST['novemeno'];
}
if (file_exists('data.xml')) {
    $xml = simplexml_load_file('data.xml');
    /*if ((string) $xml->movie->title == 'PHP: Behind the Parser') {
        print 'My favorite movie.';
    }*/

    $zadanyDatum = date('md', strtotime($datum));
    var_dump($zadanyDatum);
    echo PHP_EOL;
    $zaznamy = $xml->meniny;
    foreach ($xml as $zaznam) {
        if ($zaznam->den == $zadanyDatum) {
            $upr = $zaznam->SKd . ", " . $novemeno;
            $zaznam->SKd = $upr;
        }
    }
    file_put_contents('data.xml', $xml->asXML());
    header("Location: index.php?zapisane");



} else {
    exit('Failed to open test.xml.');
}
?>