<?php
// Conexión local con XAMPP
$host = "localhost";
$user = "root";
$pass = "";
$db   = "radio_pakal"; // nombre de la base creada en MySQL Workbench o phpMyAdmin

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
