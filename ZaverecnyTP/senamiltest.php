<?php
$to = "frantisek.ff@gmail.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: webmaster@example.com" . "\r\n" .
    "CC: frantisek.ff.ff@gmail.com";

mail($to,$subject,$txt,$headers);
?>