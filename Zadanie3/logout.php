<?php
/**
 * Created by PhpStorm.
 * User: frantisek.ff
 * Date: 10. 3. 2018
 * Time: 8:31
 */


session_start();
 $_SESSION = array();
 session_destroy();

header("location: index.php");
?>


