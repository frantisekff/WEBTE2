<?php
/**
 * Created by PhpStorm.
 * User: frantisek.ff
 * Date: 3. 3. 2018
 * Time: 12:01
 */
$host = 'localhost';
$db = 'zadanie7';
$user = '';
$pass = '';
$charset = 'utf8mb4';


$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, $options);
