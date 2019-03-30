<?php
//$db_host =  'mysql71.unoeuro.com';
//$db_user = 'michellerenee_dk';
//$db_pass = '';
//$db_name = 'michellerenee_dk_db';

$db_host = 'localhost'; //'mysql71.unoeuro.com';
$db_user = 'root'; //'michellerenee_dk';
$db_pass = ''; //'';
$db_name = 'plantorama'; //'michellerenee_dk_db_2';

// Opretter forbindelse til databasen med oplysningerne oppe over
$link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
mysqli_set_charset($link, 'utf8'); // Sætter tegnsætningen til utf8
mysqli_query($link, 'SET lc_time_names ) "da_DK'); // Sætter navn på måneder og dage til dansk

if(!$link){
  die('Connection error: ' . mysqli_connect_error());
}

session_start(); // Starter en session, så vi kan gemme session variabler
ob_start(); // Starter output buffer for at kunne ændre i header, uden risiko for advarsler
