<?php
// ============================================
// CONFIGURACIÓN DE BASE DE DATOS
// ============================================
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "radio_pakal";

// Crear conexión
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar conexión
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Establecer charset
mysqli_set_charset($conn, "utf8mb4");

// Iniciar sesión para el panel de admin
session_start();
?>