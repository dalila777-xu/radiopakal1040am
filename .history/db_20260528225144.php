<?php
$host = "sql101.infinityfree.com";   
$user = "if0_42043988";              
$pass = "gbGX70PP2BmhQux";           
$db   = "if0_42043988_radio_pakal";  

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
