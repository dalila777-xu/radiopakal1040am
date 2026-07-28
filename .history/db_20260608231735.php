<?php
$servername = "localhost";
$username = "root";   // usuario por defecto en XAMPP
$password = "";       // normalmente vacío
$database = "radio_pakal"; // tu base de datos

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
