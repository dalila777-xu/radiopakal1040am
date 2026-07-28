<?php
// Configuración de la base de datos
$db_host = "localhost";
$db_user = "root";
$db_pass = "12345678"; // Cambiar por tu contraseña de MySQL
$db_name = "radio_pakal";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Validar si la conexión falló
if (!$conn) {
    die("<div style='color:red; font-family:sans-serif; text-align:center; margin-top:20px;'>
            <h3>❌ Error de conexión a la base de datos</h3>" . mysqli_connect_error() . "
         </div>");
}

// Forzar codificación UTF-8 para evitar problemas con acentos o eñes
mysqli_set_charset($conn, "utf8mb4");
?>