<?php
session_start();
// Si no hay sesión iniciada, regresarlo al index
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
include("db.php");

// Manejar cierre de sesión desde este mismo archivo (logout)
if (isset($_GET['logout'])) {
    // Destruir toda la sesión y redirigir al index
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración | Radio Pakal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: sans-serif; background: #f4f6f9; margin: 0; padding: 20px; color: #333; }
        
        /* ========================================
           BARRA DE BIENVENIDA MODERNA Y ESTÉTICA
        ======================================== */
        .nav-admin { 
            background: linear-gradient(135deg, #8B2C2D 0%, #5A1C1D 100%); 
            color: white; 
            padding: 20px 25px; 
            border-radius: 12px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 30px; 
            box-shadow: 0 4px 15px rgba(139, 44, 45, 0.2);
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .avatar-icon {
            background: rgba(255, 255, 255, 0.15);
            width: 50px;
            height: 50px;
            border-radius: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.4rem;
            color: #D4AF37; /* Toque dorado de Radio Pakal */
            border: 2px solid rgba(212, 175, 55, 0.4);
        }
        .welcome-text {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #e0e0e0;
            display: block;
            margin-bottom: 2px;
        }
        .user-name {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .user-role {
            display: inline-block;
            background: rgba(0, 0, 0, 0.25);
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            margin-top: 5px;
            color: #D4AF37;
            font-weight: bold;
            border: 1px solid rgba(212, 175, 55, 0.2);
        }
        .btn-logout { 
            color: white; 
            text-decoration: none; 
            font-weight: bold; 
            background: #8B2C2D; 
            padding: 10px 20px; 
            border-radius: 8px; 
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-logout:hover {
            background: #D4AF37;
            color: #1a1a2e;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }

        /* ========================================
           ESTILOS DE MÓDULOS Y CONTENIDO
        ======================================== */
        .grid-modulos { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .card-modulo { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-top: 4px solid #D4AF37; }
        .card-modulo h3 { margin-top: 0; color: #6B1E1F; }
        .btn-action { display: inline-block; background: #2C5F2D; color: white; padding: 8px 12px; text-decoration: none; border-radius: 4px; font-size: 0.9rem; margin-top: 10px; }
    </style>
</head>
<body>

    <div class="nav-admin">
        <div class="user-info">
            <div class="avatar-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <div>
                <span class="welcome-text">¡Bienvenido!</span>
                <h3 class="user-name">
                    <?php echo htmlspecialchars($_SESSION['nombre'] ?? 'Usuario'); ?>
                </h3>
                <span class="user-role">
                    <i class="fas fa-id-badge"></i> <?php echo htmlspecialchars($_SESSION['rol'] ?? 'Administrador'); ?>
                </span>
            </div>
        </div>
        <a href="?logout=1" class="btn-logout">
            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
        </a>
    </div>

    <h2 style="color: #6ab8ed; margin-bottom: 10px;"><i class="fas fa-tools"></i> Gestor de Contenidos de la Emisora</h2>
    <p style="color: #555; font-size: 0.95rem;">Selecciona el módulo que deseas modificar, actualizar o eliminar:</p>
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