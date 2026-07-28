<?php
$host = "localhost";
$user = "root";
$pass = "12345678";
$db   = "radio_pakal";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
