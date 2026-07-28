<?php
session_start();
// Si no hay sesión iniciada, regresarlo al index
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
include("db.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración | Radio Pakal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: sans-serif; background: #f4f6f9; margin: 0; padding: 20px; color: #333; }
        .nav-admin { background: #8B2C2D; color: white; padding: 15px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .nav-admin a { color: white; text-decoration: none; font-weight: bold; background: rgba(0,0,0,0.2); padding: 8px 15px; border-radius: 5px; }
        .grid-modulos { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .card-modulo { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-top: 4px solid #D4AF37; }
        .card-modulo h3 { margin-top: 0; color: #6B1E1F; }
        .btn-action { display: inline-block; background: #2C5F2D; color: white; padding: 8px 12px; text-decoration: none; border-radius: 4px; font-size: 0.9rem; margin-top: 10px; }
    </style>
</head>
<body>

    <div class="nav-admin">
        <div>
            <i class="fas fa-user-cog"></i> ¡Bienvenido, <strong><?php echo $_SESSION['nombre']; ?></strong>! (Rol: <?php echo $_SESSION['rol']; ?>)
        </div>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
    </div>

    <h2><i class="fas fa-tools"></i> Gestor de Contenidos de la Emisora</h2>
    <p>Selecciona el módulo que deseas modificar, actualizar o eliminar:</p>
    <br>

    <div class="grid-modulos">
        <div class="card-modulo">
            <h3><i class="fas fa-calendar-alt"></i> Tabla Programación</h3>
            <p>Controla los horarios de transmisión y locutores en vivo.</p>
            <a href="admin_programacion.php" class="btn-action">Administrar Horarios</a>
        </div>

        <div class="card-modulo">
            <h3><i class="fas fa-newspaper"></i> Noticias y Publicaciones</h3>
            <p>Sube avisos comunitarios, edita o elimina noticias actuales.</p>
            <a href="admin_publicaciones.php" class="btn-action" style="background:#8B2C2D;">Administrar Posts</a>
        </div>

        <div class="card-modulo">
            <h3><i class="fas fa-images"></i> Imágenes del Carrusel</h3>
            <p>Cambia las fotos de la marquesina principal del sitio.</p>
            <a href="admin_carrusel.php" class="btn-action" style="background:#1a1a2e;">Administrar Fotos</a>
        </div>
    </div>

</body>
</html>