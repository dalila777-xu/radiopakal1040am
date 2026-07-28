<?php
// Incluir conexión a base de datos
require_once 'db.php';

session_start();

// Configuración de Zona Horaria Oficial para Chiapas
date_default_timezone_set('America/Mexico_City');

function obtenerIndicadorTransmision($diaPrograma, $horaPrograma, $nombrePrograma) {
    $diasSemana = [
        1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 
        4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo'
    ];
    
    $diaActualNum = (int)date('N');
    $diaActualNombre = $diasSemana[$diaActualNum];
    $horaActual = date('H:i');
    
    $diaCoincide = false;
    $diaProgramaNorm = mb_strtolower(trim($diaPrograma), 'UTF-8');

    if ($diaProgramaNorm == 'lunes a viernes' && $diaActualNum >= 1 && $diaActualNum <= 5) {
        $diaCoincide = true;
    } elseif ($diaProgramaNorm == 'miércoles a viernes' && $diaActualNum >= 3 && $diaActualNum <= 5) {
        $diaCoincide = true;
    } elseif ($diaProgramaNorm == 'lunes a martes' && $diaActualNum >= 1 && $diaActualNum <= 2) {
        $diaCoincide = true;
    } elseif ($diaProgramaNorm == 'lunes a domingo' && $diaActualNum >= 1 && $diaActualNum <= 7) {
        $diaCoincide = true;
    } elseif (strpos($diaProgramaNorm, mb_strtolower($diaActualNombre, 'UTF-8')) !== false) {
        $diaCoincide = true;
    }

    if (!$diaCoincide) return ''; 

    $partesHora = explode('-', $horaPrograma);
    if (count($partesHora) == 2) {
        $horaInicio = trim($partesHora[0]);
        $horaFin = trim($partesHora[1]);
        
        if ($horaActual >= $horaInicio && $horaActual < $horaFin) {
            if (stripos($nombrePrograma, 'Noticias') !== false) {
                return '<span class="lucesita luz-noticias" title="Noticiero Al Aire"></span>';
            } else {
                return '<span class="lucesita luz-envivo" title="Al Aire"></span>';
            }
        }
    }
    return ''; 
}

// Manejo de inicio de sesión
$login_error = "";
if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['login_action'])) {
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($usuario) && !empty($password)) {
        $query = "SELECT * FROM usuarios WHERE usuario = '$usuario' LIMIT 1";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            if ($password === $user_data['password']) {
                $_SESSION['usuario'] = $user_data['usuario'];
                $_SESSION['nombre'] = $user_data['nombre'] ?? $user_data['usuario'];
                $_SESSION['rol'] = $user_data['rol'] ?? 'colaborador';
                header('Location: admin.php');
                exit();
            } else {
                $login_error = 'Contraseña incorrecta.';
            }
        } else {
            $login_error = 'El usuario no existe.';
        }
    } else {
        $login_error = 'Por favor, llena todos los campos.';
    }
}

// Vista del Login integrado
if (isset($_GET['page']) && $_GET['page'] === 'login') {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Iniciar Sesión | Radio Pakal</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <style>
            *{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif}
            body{background:#f8f5f0;display:flex;justify-content:center;align-items:center;height:100vh;color:#1a1a2e}
            .login-container{background:white;padding:2.5rem;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,0.05);width:100%;max-width:400px;border-top:4px solid #8B2C2D}
            .login-logo{display:block;margin:0 auto 1rem;width:120px;height:auto}
            .text-center{text-align:center;margin-bottom:1.5rem}
            .text-center h2{color:#0d47a1;font-size:1.6rem;margin-bottom:.3rem}
            .form-group{margin-bottom:1.2rem;position:relative}
            .form-group i{position:absolute;left:12px;top:38px;color:#8B2C2D}
            label{display:block;margin-bottom:.4rem;font-weight:600;font-size:.85rem;color:#444}
            input[type=text],input[type=password]{width:100%;padding:.75rem .75rem .75rem 2.2rem;border:1px solid #ddd;border-radius:6px;font-size:.95rem}
            .btn-submit{background:#8B2C2D;color:white;border:none;width:100%;padding:.75rem;border-radius:6px;font-size:1rem;font-weight:600;cursor:pointer;margin-top:.5rem}
            .error-msg{background:#fde8e8;color:#e53e3e;padding:.75rem;border-radius:6px;font-size:.85rem;margin-bottom:1rem;text-align:center;border:1px solid #f8b4b4}
            .back-link{display:block;text-align:center;margin-top:1.2rem;color:#8B2C2D;text-decoration:none;font-size:.85rem;font-weight:500}
        </style>
    </head>
    <body>
    <div class="login-container">
        <img src="pm.png" alt="Logo Radio Pakal" class="login-logo" onerror="this.src='https://placehold.co/80x80?text=Logo'">
        <div class="text-center"><h2>Panel de Control</h2><p>Radio Pakal 1040 AM</p></div>
        <?php if(!empty($login_error)): ?>
            <div class="error-msg"><?php echo htmlspecialchars($login_error); ?></div>
        <?php endif; ?>
        <form action="?page=login" method="POST">
            <input type="hidden" name="login_action" value="1">
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <i class="fas fa-user"></i>
                <input type="text" id="usuario" name="usuario" required placeholder="Ingresa tu usuario">
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>
            <button type="submit" class="btn-submit">Ingresar al Sistema</button>
        </form>
        <a href="index.php" class="back-link"><i class="fas fa-arrow-left"></i> Volver a la página web</a>
    </div>
    </body>
    </html>
    <?php
    exit();
}

// Página principal
$query_programacion = "SELECT programa, dia, hora FROM programacion";
$result_programacion = mysqli_query($conn, $query_programacion);

$query_redes = "SELECT nombre, url, icono FROM redes_sociales WHERE activo = 1";
$result_redes = mysqli_query($conn, $query_redes);

$query_carrusel = "SELECT ruta_imagen, titulo FROM carrusel WHERE activo = 1 ORDER BY orden ASC";
$result_carrusel = mysqli_query($conn, $query_carrusel);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radio Pakal 1040 AM - Oficial</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Inter',sans-serif;background:#ffffff;color:#1a1a2e;line-height:1.6;scroll-behavior:smooth}
        @keyframes parpadeo{0%{opacity:0.3}50%{opacity:1}100%{opacity:0.3}}
        .lucesita{display:inline-block;width:12px;height:12px;border-radius:50%;margin-right:8px;vertical-align:middle}
        .luz-envivo{background-color:#22c55e;box-shadow:0 0 8px #22c55e;animation:parpadeo 1s infinite ease-in-out}
        .luz-noticias{background-color:#ef4444;box-shadow:0 0 8px #ef4444;animation:parpadeo 1s infinite ease-in-out}
        header{background:#ffffff;text-align:center;padding:2rem 1.5rem;border-bottom:1px solid #f0f0f0;position:relative}
        header::before{content:'';position:absolute;top:0;left:0;right:0;bottom:0;background-image:url('bb.png');background-size:cover;background-position:center;background-repeat:no-repeat;opacity:0.75;pointer-events:none}
        header>*{position:relative;z-index:1}
        .logo{width:200px;height:auto;margin-bottom:1rem}
        header h1{color:#144ea5;font-size:1.8rem;margin-bottom:0.5rem}
        nav{background:white;display:flex;justify-content:center;flex-wrap:wrap;gap:0.5rem;padding:0.8rem 1rem;position:sticky;top:0;z-index:100;box-shadow:0 2px 10px rgba(0,0,0,0.05);border-bottom:2px solid #D4AF37}
        nav a{color:#1a1a2e;text-decoration:none;font-weight:600;padding:0.5rem 1.2rem;border-radius:40px;transition:all 0.3s ease;font-size:0.85rem;display:flex;align-items:center;gap:6px}
        nav a i{color:#8B2C2D}
        nav a:hover{background:#8B2C2D;color:white}
        nav a:hover i{color:white}
        .container{max-width:1200px;margin:2.5rem auto;padding:0 1.5rem}
        section{background:white;border:1px solid #f0f0f0;border-radius:12px;padding:2rem;margin-bottom:2rem;scroll-margin-top:85px}
        section h2{font-size:1.5rem;font-weight:700;margin-bottom:1.2rem;display:flex;align-items:center;gap:12px;border-left:3px solid #D4AF37;padding-left:1rem;color:#000000}
        section h2 i{color:#D4AF37;font-size:1.5rem}
        .table-responsive{overflow-x:auto}
        table{width:100%;border-collapse:collapse;border-radius:10px;overflow:hidden}
        th{background:#2C5F2D;color:white;padding:12px 16px;text-align:left;font-weight:600}
        td{padding:12px 16px;border-bottom:1px solid #f0f0f0;background:white}
        tr:hover td{background:#FDF9F0}
        .grid-buttons{display:flex;flex-wrap:wrap;gap:1rem;margin-top:1rem}
        .btn-card{display:inline-flex;align-items:center;gap:10px;padding:0.8rem 1.5rem;border-radius:50px;text-decoration:none;font-weight:600;transition:all 0.3s ease;font-size:0.9rem}
        .facebook-btn{background:#1877F2;color:white}
        .whatsapp-btn{background:#25D366;color:white}
        .app-btn{background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:white}
        .btn-card:hover{transform:translateY(-3px);box-shadow:0 8px 20px rgba(0,0,0,0.15)}
        #ubicacion p{background:#faf8f5;padding:1rem;border-radius:10px;margin-bottom:1rem;border-left:3px solid #D4AF37}
        iframe{width:100%;height:350px;border-radius:12px;border:1px solid #e8e8e8;margin-top:0.5rem}
        footer{background:#1a1a2e;color:#cbd5e0;text-align:center;padding:2rem;margin-top:2rem}
        footer p{margin:5px 0}
        footer p:first-child{font-weight:600;color:white}
        .carrusel-container{position:relative;width:100%;max-width:900px;margin:0 auto;border-radius:16px;overflow:hidden;background:#f8f5f0;border:1px solid #e8e8e8}
        .carrusel-track{display:flex;transition:transform 0.5s ease-in-out;list-style:none;padding:0;margin:0}
        .carrusel-slide{min-width:100%;flex-shrink:0;position:relative}
        .carrusel-slide img{width:100%;height:400px;object-fit:cover;display:block}
        .carrusel-btn{position:absolute;top:50%;transform:translateY(-50%);background:rgba(139,44,45,0.7);color:white;border:none;width:45px;height:45px;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;z-index:10;transition:all 0.3s ease;font-size:1.2rem}
        .carrusel-btn:hover{background:#8b2c2d;transform:translateY(-50%) scale(1.05)}
        .carrusel-btn-prev{left:15px}
        .carrusel-btn-next{right:15px}
        .carrusel-dots{display:flex;justify-content:center;gap:10px;padding:1rem;background:#f8f5f0}
        .carrusel-dot{width:10px;height:10px;border-radius:50%;background:#ccc;border:none;cursor:pointer;transition:all 0.3s ease}
        .carrusel-dot.active{background:#8B2C2D;transform:scale(1.2)}
        @media (max-width:768px){header h1{font-size:1.4rem}nav a{padding:0.4rem 0.9rem;font-size:0.75rem}section{padding:1.3rem}section h2{font-size:1.2rem}.carrusel-slide img{height:280px}}
        @media (max-width:480px){.grid-buttons{flex-direction:column}.btn-card{justify-content:center}th,td{padding:8px 12px;font-size:0.85rem}.carrusel-sl