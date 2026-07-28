<?php
$host = "localhost";   // Host local
$user = "root";        // Usuario por defecto en XAMPP
$pass = "";            // Contraseña vacía en XAMPP
$db   = "radio_pakal"; // Nombre de tu base de datos local

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
