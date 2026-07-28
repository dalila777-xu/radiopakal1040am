<?php 
include("db.php"); 
session_start();

// ==========================================
// CONFIGURACIÓN DE ZONA HORARIA
// ==========================================
date_default_timezone_set('America/Mexico_City');

// ==========================================
// FUNCIÓN: OBTENER INDICADOR DE TRANSMISIÓN
// ==========================================
function obtenerIndicadorTransmision($diaPrograma, $horaPrograma, $nombrePrograma) {
    $diasSemana = [
        1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 
        4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo'
    ];
    
    $diaActualNum = (int)date('N');
    $diaActualNombre = $diasSemana[$diaActualNum];
    $horaActual = date('H:i');
    
    // ==========================================
    // 1. VERIFICAR DÍA
    // ==========================================
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
    } elseif ($diaProgramaNorm == 'lunes y miércoles' && ($diaActualNum == 1 || $diaActualNum == 3)) {
        $diaCoincide = true;
    } elseif ($diaProgramaNorm == 'lunes y jueves' && ($diaActualNum == 1 || $diaActualNum == 4)) {
        $diaCoincide = true;
    } elseif (strpos($diaProgramaNorm, mb_strtolower($diaActualNombre, 'UTF-8')) !== false) {
        $diaCoincide = true;
    }

    // Si NO coincide el día → SIN LUZ (gris estático)
    if (!$diaCoincide) return ''; 

    // ==========================================
    // 2. VERIFICAR HORA
    // ==========================================
    $partesHora = explode('-', $horaPrograma);
    if (count($partesHora) == 2) {
        $horaInicio = trim($partesHora[0]);
        $horaFin = trim($partesHora[1]);
        
        $horaInicioMin = strtotime($horaInicio);
        $horaFinMin = strtotime($horaFin);
        $horaActualMin = strtotime($horaActual);
        
        $minutosRestantesInicio = ($horaInicioMin - $horaActualMin) / 60;
        $minutosRestantesFin = ($horaFinMin - $horaActualMin) / 60;
        
        // 🔴 ROJO: Si falta 1 minuto o menos para COMENZAR
        if ($minutosRestantesInicio >= -1 && $minutosRestantesInicio < 0) {
            return '<span class="lucesita luz-rojo" data-estado="rojo" title="Comienza en 1 minuto"></span>';
        }
        
        // 🟢 VERDE: Si está transmitiendo AHORA
        if ($horaActualMin >= $horaInicioMin && $horaActualMin < $horaFinMin) {
            return '<span class="lucesita luz-envivo" data-estado="verde" title="Al Aire"></span>';
        }
    }
    
    // Fuera del aire (gris estático)
    return ''; 
}

// ==========================================
// MANEJO DE LOGIN
// ==========================================
if (isset($_SESSION['usuario'])) {
  if (isset($_GET['page']) && $_GET['page'] === 'login') {
    header('Location: admin.php'); exit();
  }
}

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
        header('Location: admin.php'); exit();
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

// Vista del Login
if (isset($_GET['page']) && $_GET['page'] === 'login') {
  ?>
  <!DOCTYPE html>
  <html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Radio Pakal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    *{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif}
    body{background:#f8f5f0;display:flex;justify-content:center;align-items:center;height:100vh;color:#1a1a2e}
    .login-container{background:white;padding:2.5rem;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,0.05);width:100%;max-width:400px;border-top:4px solid #3a8ee8}
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
    <div class="text-center"><h2>Panel de Control</h2><p></p></div>
    <?php if(!empty($login_error)): ?>
      <div class="error-msg"><?php echo htmlspecialchars($login_error); ?></div>
    <?php endif; ?>
    <form action="?page=login" method="POST">
      <input type="hidden" name="login_action" value="1">
      <div class="form-group"><label for="usuario">Usuario</label><i class="fas fa-user"></i><input type="text" id="usuario" name="usuario" required placeholder="Ingresa tu usuario"></div>
      <div class="form-group"><label for="password">Contraseña</label><i class="fas fa-lock"></i><input type="password" id="password" name="password" required placeholder=""></div>
      <button type="submit" class="btn-submit">Ingresar al Sistema</button>
    </form>
    <a href="index.php" class="back-link"><i class="fas fa-arrow-left"></i> Volver a la página web</a>
  </div>
  </body>
  </html>
  <?php
  exit();
}

// ==========================================
// CONSULTAS A LA BASE DE DATOS
// ==========================================

// Obtener todos los programas
$query = "SELECT * FROM programacion ORDER BY id";
$result = mysqli_query($conn, $query);
$programas = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $programas[] = $row;
    }
}

// Obtener horarios únicos
$query_horarios = "SELECT DISTINCT hora FROM programacion ORDER BY hora";
$result_horarios = mysqli_query($conn, $query_horarios);
$horarios = [];
if ($result_horarios && mysqli_num_rows($result_horarios) > 0) {
    while ($row = mysqli_fetch_assoc($result_horarios)) {
        $horarios[] = $row['hora'];
    }
}

// Días de la semana
$dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

// Función para obtener el programa en un día y hora específicos
function obtenerProgramaEnCelda($programas, $dia, $hora) {
    foreach ($programas as $p) {
        $diaPrograma = trim($p['dia']);
        $horaPrograma = trim($p['hora']);
        if ($horaPrograma === $hora) {
            $diaProgramaNorm = mb_strtolower($diaPrograma, 'UTF-8');
            $diaNorm = mb_strtolower($dia, 'UTF-8');
            
            if ($diaProgramaNorm == 'lunes a viernes' && in_array($dia, ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'])) {
                return $p;
            } elseif ($diaProgramaNorm == 'lunes a domingo') {
                return $p;
            } elseif ($diaProgramaNorm == 'miércoles a viernes' && in_array($dia, ['Miércoles', 'Jueves', 'Viernes'])) {
                return $p;
            } elseif ($diaProgramaNorm == 'lunes a martes' && in_array($dia, ['Lunes', 'Martes'])) {
                return $p;
            } elseif ($diaProgramaNorm == 'lunes y miércoles' && in_array($dia, ['Lunes', 'Miércoles'])) {
                return $p;
            } elseif ($diaProgramaNorm == 'lunes y jueves' && in_array($dia, ['Lunes', 'Jueves'])) {
                return $p;
            } elseif (strpos($diaProgramaNorm, $diaNorm) !== false) {
                return $p;
            }
        }
    }
    return null;
}

// Obtener día actual
$diaActualNum = (int)date('N');
$diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
$diaActualNombre = $diasSemana[$diaActualNum - 1];
$horaServidor = date('H:i:s');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <meta name="description" content="Radio Pakal 1040 AM - La voz oficial de Palenque, Chiapas. Música, cultura y noticias comunitarias.">
  <title>RADIO PAKAL 1040 AM | Oficial - Palenque, Chiapas</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    /* ========================================
       RESET Y BASE
    ======================================== */
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Inter', sans-serif;
      background: #ffffff;
      color: #1a1a2e;
      line-height: 1.6;
      scroll-behavior: smooth;
    }

    /* ========================================
       LUCES LED
    ======================================== */
    @keyframes parpadeo-verde {
      0% { opacity: 0.3; box-shadow: 0 0 5px #22c55e; }
      50% { opacity: 1; box-shadow: 0 0 20px #22c55e, 0 0 40px #22c55e; }
      100% { opacity: 0.3; box-shadow: 0 0 5px #22c55e; }
    }

    @keyframes parpadeo-rojo {
      0% { opacity: 0.3; box-shadow: 0 0 5px #ef4444; }
      50% { opacity: 1; box-shadow: 0 0 20px #ef4444, 0 0 40px #ef4444; }
      100% { opacity: 0.3; box-shadow: 0 0 5px #ef4444; }
    }

    .lucesita {
      display: inline-block;
      width: 12px;
      height: 12px;
      border-radius: 50%;
      margin-right: 6px;
      vertical-align: middle;
    }

    .luz-envivo {
      background-color: #22c55e;
      animation: parpadeo-verde 1s infinite ease-in-out;
      box-shadow: 0 0 8px #22c55e;
    }

    .luz-rojo {
      background-color: #ef4444;
      animation: parpadeo-rojo 0.5s infinite ease-in-out;
      box-shadow: 0 0 8px #ef4444;
    }

    .luz-apagada {
      background-color: #d1d5db;
      opacity: 0.4;
    }

    /* ========================================
       HEADER
    ======================================== */
    header {
      background: #ffffff;
      text-align: center;
      padding: 2rem 1.5rem;
      position: relative;
      border-bottom: 1px solid #f0f0f0;
    }

    header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image: url('aaa.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      opacity: 7.75;
      pointer-events: none;
    }

    header > * { position: relative; z-index: 1; }

    .logo { width: 270px; height: auto; margin-bottom: 1rem; }
    header h1 { color: #144ea5; font-size: 1.8rem; margin-bottom: 0.5rem; }
    header p { color: #000000; font-size: 1rem; }

    /* ==============
    ==========================
       NAVEGACIÓN
    ======================================== */
    nav {
      background: white;
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 0.5rem;
      padding: 0.8rem 1rem;
      position: sticky;
      top: 0;
      z-index: 100;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      border-bottom: 2px solid #000000;
    }

    nav a {
      color: #1a1a2e;
      text-decoration: none;
      font-weight: 600;
      padding: 0.5rem 1.2rem;
      border-radius: 40px;
      transition: all 0.3s ease;
      font-size: 0.85rem;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    nav a i { font-size: 0.9rem; color: #000000; }
    nav a:hover { background: #5ca6f6; color: white; }
    nav a:hover i { color: white; }

    /* ========================================
       CONTENEDOR
    ======================================== */
    .container { max-width: 1200px; margin: 2.5rem auto; padding: 0 1.5rem; }

    /* ========================================
       SECCIONES
    ======================================== */
    section {
      background: white;
      border: 1px solid #f0f0f0;
      border-radius: 12px;
      padding: 2rem;
      margin-bottom: 2rem;
      scroll-margin-top: 85px;
    }

    section h2 {
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 1.2rem;
      display: flex;
      align-items: center;
      gap: 12px;
      border-left: 3px solid #D4AF37;
      padding-left: 1rem;
      color: #000000;
    }

    section h2 i { color: #0e0b01; font-size: 1.5rem; }

    .mision-vision-container {
      display: grid;
      grid-template-columns: repeat(2, minmax(250px, 1fr));
      gap: 1.5rem;
      margin-top: 1.5rem;
    }

    .mv-block {
      background: #faf8f5;
      border: 1px solid #f0f0f0;
      border-radius: 14px;
      padding: 1.4rem 1.5rem;
    }

    .mv-block h3 { margin-bottom: 0.8rem; color: #000000; }
    .mv-block p { line-height: 1.75; color: #333; }

    /* ========================================
       CARRUSEL
    ======================================== */
    .carousel-container {
      position: relative;
      width: 100%;
      max-width: 900px;
      margin: 1.5rem auto 0;
      border-radius: 16px;
      overflow: hidden;
      background: #f8f5f0;
      border: 1px solid #e8e8e8;
    }

    .carousel-track {
      display: flex;
      transition: transform 0.5s ease-in-out;
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .carousel-slide {
      min-width: 100%;
      flex-shrink: 0;
    }

    .carousel-slide img {
      width: 100%;
      height: 400px;
      object-fit: cover;
      display: block;
    }

    .carousel-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(139, 44, 45, 0.7);
      color: white;
      border: none;
      width: 45px;
      height: 45px;
      border-radius: 50%;
      cursor: pointer;
      z-index: 10;
      transition: all 0.3s ease;
      font-size: 1.2rem;
    }

    .carousel-btn:hover { background: #2efe62; transform: translateY(-50%) scale(1.05); }
    .carousel-btn-prev { left: 15px; }
    .carousel-btn-next { right: 15px; }

    .carousel-dots {
      display: flex;
      justify-content: center;
      gap: 10px;
      padding: 1rem;
      background: #f8f5f0;
    }

    .carousel-dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: #ccc;
      border: none;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .carousel-dot.active { background: #8B2C2D; transform: scale(1.2); }

    /* ========================================
       BARRA PROGRAMÁTICA
    ======================================== */
    .programacion-container {
      overflow-x: auto;
      margin-top: 1rem;
    }

    .programacion-tabla {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.8rem;
      min-width: 800px;
    }

    .programacion-tabla th {
      background: #28acdc;
      color: white;
      padding: 10px 8px;
      text-align: center;
      font-weight: 700;
      font-size: 0.85rem;
      border: 1px solid #6e2122;
    }

    .programacion-tabla td {
      padding: 8px 6px;
      text-align: center;
      border: 1px solid #e5e7eb;
      vertical-align: middle;
      font-size: 0.75rem;
      min-height: 40px;
    }

    .programacion-tabla .hora-col {
      background: #f3f4f6;
      font-weight: 600;
      color: #1f2937;
      white-space: nowrap;
      min-width: 70px;
    }

    .programacion-tabla .celda-programa {
      background: #fafafa;
      transition: background 0.3s ease;
    }

    .programacion-tabla .celda-programa:hover {
      background: #f0f0f0;
    }

    .programacion-tabla .celda-programa .nombre-programa {
      display: block;
      font-weight: 500;
      font-size: 0.7rem;
      line-height: 1.3;
      color: #1f2937;
    }

    .programacion-tabla .celda-programa .nombre-programa.destacado {
      font-weight: 700;
      color: #8B2C2D;
    }

    /* Filas alternas */
    .programacion-tabla tbody tr:nth-child(even) .hora-col {
      background: #e5e7eb;
    }

    .programacion-tabla tbody tr:nth-child(even) .celda-programa {
      background: #f8f8f8;
    }

    .programacion-tabla tbody tr:nth-child(even) .celda-programa:hover {
      background: #f0f0f0;
    }

    /* Celda vacía */
    .programacion-tabla .celda-vacia {
      background: #f9fafb;
      color: #9ca3af;
      font-size: 0.65rem;
    }

    /* ========================================
       DESTACADO: DÍA ACTUAL
    ======================================== */
    .dia-actual th {
      background: #1a5a2a !important;
      border-color: #0d3d1a !important;
      box-shadow: inset 0 -3px 0 #D4AF37;
    }

    .dia-actual th::after {
      content: '⬅ HOY';
      display: block;
      font-size: 0.55rem;
      font-weight: 400;
      color: #D4AF37;
      margin-top: 2px;
    }

    /* ========================================
       BOTONES
    ======================================== */
    .grid-buttons {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      margin-top: 1rem;
    }

    .btn-card {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 0.8rem 1.5rem;
      border-radius: 50px;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
      font-size: 0.9rem;
    }

    .facebook-btn { background: #1877F2; color: white; }
    .whatsapp-btn { background: #25D366; color: white; }
    .app-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }

    .btn-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    /* ========================================
       UBICACIÓN
    ======================================== */
    #ubicacion p {
      background: #faf8f5;
      padding: 1rem;
      border-radius: 10px;
      margin-bottom: 1rem;
      border-left: 3px solid #D4AF37;
    }

    iframe {
      width: 100%;
      height: 350px;
      border-radius: 12px;
      border: 1px solid #e8e8e8;
      margin-top: 0.5rem;
    }

    /* ========================================
       FOOTER
    ======================================== */
    footer {
      background: #1a1a2e;
      color: #cbd5e0;
      text-align: center;
      padding: 2rem;
      margin-top: 2rem;
    }

    footer p { margin: 5px 0; }
    footer p:first-child { font-weight: 600; color: white; }

    /* ========================================
       LEYENDA
    ======================================== */
    .leyenda {
      display: flex;
      flex-wrap: wrap;
      gap: 1.5rem;
      margin-bottom: 1rem;
      padding: 0.8rem 1.2rem;
      background: #f8f5f0;
      border-radius: 10px;
      font-size: 0.8rem;
      align-items: center;
    }

    .leyenda-item {
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .leyenda-item .circulo {
      display: inline-block;
      width: 12px;
      height: 12px;
      border-radius: 50%;
    }

    .circulo-verde {
      background: #22c55e;
      animation: parpadeo-verde 1s infinite ease-in-out;
      box-shadow: 0 0 8px #22c55e;
    }

    .circulo-rojo {
      background: #ef4444;
      animation: parpadeo-rojo 0.5s infinite ease-in-out;
      box-shadow: 0 0 8px #ef4444;
    }

    .circulo-gris {
      background: #d1d5db;
      opacity: 0.4;
    }

    /* ========================================
       RESPONSIVE
    ======================================== */
    @media (max-width: 768px) {
      header h1 { font-size: 1.4rem; }
      nav a { padding: 0.4rem 0.9rem; font-size: 0.75rem; }
      section { padding: 1.3rem; }
      section h2 { font-size: 1.2rem; }
      .carousel-slide img { height: 280px; }
      .programacion-tabla { font-size: 0.6rem; min-width: 600px; }
      .programacion-tabla th { font-size: 0.65rem; padding: 6px 4px; }
      .programacion-tabla td { padding: 4px 3px; font-size: 0.6rem; }
      .programacion-tabla .celda-programa .nombre-programa { font-size: 0.6rem; }
      .mision-vision-container { grid-template-columns: 1fr; }
      .dia-actual th::after { font-size: 0.45rem; }
    }

    @media (max-width: 480px) {
      .grid-buttons { flex-direction: column; }
      .btn-card { justify-content: center; }
      .carousel-slide img { height: 200px; }
      .programacion-tabla { font-size: 0.5rem; min-width: 500px; }
      .programacion-tabla th { font-size: 0.55rem; padding: 4px 3px; }
      .programacion-tabla td { padding: 3px 2px; font-size: 0.5rem; }
      .programacion-tabla .celda-programa .nombre-programa { font-size: 0.5rem; }
      .leyenda { font-size: 0.65rem; gap: 0.8rem; }
      .dia-actual th::after { font-size: 0.4rem; }
    }

    /* ========================================
       RELOJ EN TIEMPO REAL
    ======================================== */
    .reloj-tiempo-real {
      font-size: 0.8rem;
      font-weight: 600;
      color: #1f2937;
      background: #f3f4f6;
      padding: 4px 12px;
      border-radius: 20px;
      display: inline-block;
      font-variant-numeric: tabular-nums;
    }
  </style>
</head>
<body>

  <header>
    <img src="pm.png" alt="Logo Radio Pakal" class="logo" onerror="this.src='https://placehold.co/85x85?text=RP'">
  </header>

  <nav>
    <a href="#quienes"><i class="fas fa-users"></i> Quiénes Somos</a>
    <a href="#ubicacion"><i class="fas fa-map-marker-alt"></i> Ubicación</a>
    <a href="#programacion"><i class="fas fa-calendar-alt"></i> Programación</a>
    <a href="#redes"><i class="fas fa-share-alt"></i> Redes Sociales</a>
    <a href="#app"><i class="fas fa-mobile-alt"></i> App Móvil</a>
    <?php if (isset($_SESSION['usuario'])): ?>
      <a href="admin.php"><i class="fas fa-user-cog"></i> Panel</a>
    <?php else: ?>
      <a href="?page=login"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</a>
    <?php endif; ?>
  </nav>

  <div class="container">
    
    <!-- ===== QUIÉNES SOMOS ===== -->
    <section id="quienes">
      <h2><i class="fas fa-users"></i> Quiénes Somos</h2>
      <p><strong>Radio Pakal 1040 AM</strong> es una emisora comunitaria profundamente arraigada en Palenque, Chiapas. 
         Promovemos la riqueza cultural, la música de nuestra región y la identidad de nuestra gente, 
         transmitiendo con orgullo tanto en español como en nuestras valiosas lenguas originarias (Ch'ol y Tzeltal).</p>
      <p style="margin-top: 0.8rem;">Somos parte del compromiso del Gobierno del Estado de Chiapas por llevar información, educación y entretenimiento a cada rincón de nuestra tierra.</p>
      
      <div class="mision-vision-container">
        <div class="mv-block">
          <h3>Misión</h3>
          <p>Ser un Organismo descentralizado del Gobierno del Estado, que tiene la meta de producir, coproducir y transmitir programas informativos, culturales y educativos y atraer empresas que realicen filmaciones audiovisuales, para la población de habla hispana y lenguas indígenas, desarrollando contenidos que impulsen el desarrollo humano de los Chiapanecos, a través de la Radio, Televisión y la difusión de las factibles locaciones cinematográficas.</p>
        </div>
        <div class="mv-block">
          <h3>Visión</h3>
          <p>Ser el Sistema de Comunicación Audiovisual reconocido a nivel nacional e internacional, que promueva la calidad de nuestros programas radiofónicos y televisivos y la diversidad de locaciones factibles para el mercado cinematográfico, que sirva para contribuir al desarrollo social y económico del Estado de Chiapas.</p>
        </div>
      </div>

      <!-- CARRUSEL -->
      <div class="carousel-section">
        <div class="carousel-container">
          <div class="carousel">
            <div class="carousel-track-container">
              <ul class="carousel-track">
                <li class="carousel-slide"><img src="B.png" alt="Equipo de Radio Pakal 1" onerror="this.src='https://placehold.co/900x400?text=Radio+Pakal+1'"></li>
                <li class="carousel-slide"><img src="D.png" alt="Transmisión en vivo" onerror="this.src='https://placehold.co/900x400?text=Radio+Pakal+2'"></li>
                <li class="carousel-slide"><img src=".png" alt="Comunidades conectadas" onerror="this.src='https://placehold.co/900x400?text=Radio+Pakal+3'"></li>
                <li class="carousel-slide"><img src="g.png" alt="Actividad comunitaria" onerror="this.src='https://placehold.co/900x400?text=Radio+Pakal+4'"></li>
                <li class="carousel-slide"><img src="l.png" alt="Radio y cultura" onerror="this.src='https://placehold.co/900x400?text=Radio+Pakal+5'"></li>
              </ul>
            </div>
            <button class="carousel-btn carousel-btn-prev" id="prevBtn">❮</button>
            <button class="carousel-btn carousel-btn-next" id="nextBtn">❯</button>
          </div>
          <div class="carousel-dots" id="dotsContainer"></div>
        </div>
      </div>
    </section>

    <!-- ===== PROGRAMACIÓN ===== -->
    <section id="programacion">
      <h2><i class="fas fa-calendar-alt"></i> Programación Radio Pakal</h2>
      
      <!-- LEYENDA CON RELOJ EN TIEMPO REAL -->
      <div class="leyenda">
                <span class="leyenda-item"><span class="circulo circulo-rojo"></span> <strong>Rojo:</strong> Comienza en 1 minuto</span>
        <span class="leyenda-item"><span class="circulo circulo-verde"></span> <strong>Verde:</strong> Transmitiendo AHORA</span>
        <span class="leyenda-item"><span class="circulo circulo-gris"></span> <strong>Gris:</strong> Fuera del aire</span>
        <span style="font-size:0.7rem;color:#6b7280;margin-left:auto;display:flex;align-items:center;gap:10px;">
          <span>📅 Hoy es <?php echo $diaActualNombre; ?></span>
          <span class="reloj-tiempo-real" id="relojTiempoReal"><?php echo date('H:i:s'); ?></span>
          <span style="font-size:0.6rem;color:#22c55e;"> </span>
        </span>
      </div>

      <!-- BARRA PROGRAMÁTICA -->
      <div class="programacion-container" id="programacionContainer">
        <table class="programacion-tabla" id="tablaProgramacion">
          <thead>
            <tr>
              <th>HORARIO</th>
              <?php foreach ($dias as $index => $dia): 
                $es_hoy = ($dia === $diaActualNombre);
              ?>
                <th class="<?php echo $es_hoy ? 'dia-actual' : ''; ?>">
                  <?php echo $dia; ?>
                </th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody id="tablaBody">
            <?php foreach ($horarios as $hora): ?>
              <tr>
                <td class="hora-col"><?php echo htmlspecialchars($hora); ?></td>
                <?php foreach ($dias as $dia): ?>
                  <?php 
                    $programa = obtenerProgramaEnCelda($programas, $dia, $hora);
                    $luz = '';
                    $nombre = '';
                    $clase_adicional = '';
                    if ($programa) {
                      $nombre = $programa['programa'];
                      $luz = obtenerIndicadorTransmision($programa['dia'], $programa['hora'], $programa['programa']);
                      if (stripos($nombre, 'noticias') !== false || stripos($nombre, 'diez noticias') !== false) {
                        $clase_adicional = 'destacado';
                      }
                    }
                  ?>
                  <td class="celda-programa <?php echo $programa ? '' : 'celda-vacia'; ?>" data-dia="<?php echo htmlspecialchars($dia); ?>" data-hora="<?php echo htmlspecialchars($hora); ?>" data-programa="<?php echo htmlspecialchars($nombre); ?>">
                    <?php if ($programa): ?>
                      <?php echo $luz; ?>
                      <span class="nombre-programa <?php echo $clase_adicional; ?>">
                        <?php echo htmlspecialchars($nombre); ?>
                      </span>
                    <?php else: ?>
                      <span class="nombre-programa" style="color:#9ca3af;font-size:0.6rem;">—</span>
                    <?php endif; ?>
                  </td>
                <?php endforeach; ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>

    <!-- ===== REDES SOCIALES ===== -->
    <section id="redes">
      <h2><i class="fab fa-facebook"></i> Síguenos en Redes Sociales</h2>
      <div class="grid-buttons">
        <a href="https://www.facebook.com/RadioPakalCapitalMaya" target="_blank" class="btn-card facebook-btn">
          <i class="fab fa-facebook-f"></i> Facebook: XEPLE Radio Palenque
        </a>
        <a href="https://wa.me/529935990830" target="_blank" class="btn-card whatsapp-btn">
          <i class="fab fa-whatsapp"></i> WhatsApp Cabina
        </a>
      </div>
    </section>

    <!-- ==========================================
    APP MÓVIL CON CÓDIGO QR FUNCIONAL
    ========================================== -->
    <section id="app">
      <h2><i class="fas fa-download"></i> Lleva la Radio en tu Bolsillo</h2>
      
      <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 2rem; margin-top: 0.5rem;">
          
          <!-- CÓDIGO QR -->
          <div style="text-align: center; flex-shrink: 0;">
                  <img src="pp.png" 
                       alt="Código QR para descargar la app" 
                       style="width: 180px; height: 180px; border-radius: 12px; border: 3px solid #D4AF37; padding: 8px; background: white; transition: transform 0.3s ease;"
                       onerror="this.src='https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=https://radio-pakal.net/app'"
                       onmouseover="this.style.transform='scale(1.05)'"
                       onmouseout="this.style.transform='scale(1)'">
              </a>
              <p style="font-size: 0.7rem; color: #6b7280; margin-top: 6px;">
                  <i class="fas fa-qrcode"></i> Escanea el código QR con tu celular
              </p>
          </div>

          <!-- INFORMACIÓN Y BOTONES -->
          <div style="flex: 1; min-width: 200px;">
              <p style="font-size: 0.95rem; font-weight: 600; color: #1f2937;">
                 
                      <p style="font-size: 0.75rem; color: #6b7280; margin-top: 0.8rem;">
              </p>
          </div>
      </div>
    </section>

    <!-- ===== UBICACIÓN ===== -->
    <section id="ubicacion">
      <h2><i class="fas fa-location-dot"></i> Nuestra Ubicación</h2>
      <p><i class="fas fa-map-pin"></i> <strong>Dirección:</strong> AV. Corregidora S/N entre la calle Javier Mina y Chiapas, Palenque Chiapas </p>
            <h2><i class="fas fa-phone-alt"></i> Nuestros Teléfonos </h2>
      <p><i class=""></i> <strong>Oficina:</strong> (916)6880170</p>
            <p><i class=""></i> <strong>Cabina:</strong> (916)3453692 </p>
      <iframe 
        src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3809.916853245455!2d-91.98151892394017!3d17.50769400000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTfCsDMwJzI3LjciTiA5McKwNTgnNDQuMiJX!5e0!3m2!1ses-419!2smx!4v1718742000000!5m2!1ses-419!2smx" 
        allowfullscreen="" 
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </section>
  </div>

  <footer>
    <p>© <?php echo date('Y'); ?> Radio Pakal 1040 AM — Palenque, Chiapas</p>
    <p>Conectando culturas, uniendo comunidades.</p>
    <p style="font-size: 0.75rem; margin-top: 0.5rem;">Sistema Chiapaneco de Radio, Televisión y Cinematografía | Humanismo que transforma</p>
  </footer>

  <!-- ========================================
  JAVASCRIPT - ACTUALIZACIÓN EN TIEMPO REAL
  ======================================== -->
  <script>
    // ==========================================
    // RELOJ EN TIEMPO REAL
    // ==========================================
    function actualizarReloj() {
        const ahora = new Date();
        const horas = String(ahora.getHours()).padStart(2, '0');
        const minutos = String(ahora.getMinutes()).padStart(2, '0');
        const segundos = String(ahora.getSeconds()).padStart(2, '0');
        const horaActual = horas + ':' + minutos + ':' + segundos;
        
        const reloj = document.getElementById('relojTiempoReal');
        if (reloj) {
            reloj.textContent = horaActual;
        }
    }

    // ==========================================
    // ACTUALIZAR LUCES LED EN TIEMPO REAL
    // ==========================================
    function actualizarLuces() {
        const ahora = new Date();
        const diaActualNum = ahora.getDay(); // 0=domingo, 1=lunes...
        const horaActual = ahora.getHours().toString().padStart(2, '0') + ':' + ahora.getMinutes().toString().padStart(2, '0');
        
        // Mapear días: 1=Lunes, 2=Martes, ...
        const diasMap = {1:'Lunes', 2:'Martes', 3:'Miércoles', 4:'Jueves', 5:'Viernes', 6:'Sábado', 0:'Domingo'};
        const diaActualNombre = diasMap[diaActualNum];
        
        // Obtener todas las celdas que tienen programa
        const celdas = document.querySelectorAll('.celda-programa:not(.celda-vacia)');
        
        celdas.forEach(celda => {
            const diaCelda = celda.dataset.dia;
            const horaPrograma = celda.dataset.hora;
            const nombrePrograma = celda.dataset.programa;
            
            // Verificar si el día coincide
            let diaCoincide = false;
            // Verificar días complejos (Lunes a Viernes, etc.)
            const diaNorm = diaCelda.toLowerCase().trim();
            const diaActualNorm = diaActualNombre.toLowerCase();
            
            if (diaNorm === 'lunes a viernes' && diaActualNum >= 1 && diaActualNum <= 5) diaCoincide = true;
            else if (diaNorm === 'lunes a domingo' && diaActualNum >= 0 && diaActualNum <= 6) diaCoincide = true;
            else if (diaNorm === 'miércoles a viernes' && diaActualNum >= 3 && diaActualNum <= 5) diaCoincide = true;
            else if (diaNorm === 'lunes a martes' && diaActualNum >= 1 && diaActualNum <= 2) diaCoincide = true;
            else if (diaNorm === 'lunes y miércoles' && (diaActualNum === 1 || diaActualNum === 3)) diaCoincide = true;
            else if (diaNorm === 'lunes y jueves' && (diaActualNum === 1 || diaActualNum === 4)) diaCoincide = true;
            else if (diaNorm.includes(diaActualNorm)) diaCoincide = true;
            
            // Buscar el span de la luz dentro de la celda
            const luzSpan = celda.querySelector('.lucesita');
            
            if (!diaCoincide) {
                // Día no coincide → sin luz
                if (luzSpan) {
                    luzSpan.className = 'lucesita';
                    luzSpan.style.background = '#d1d5db';
                    luzSpan.style.opacity = '0.4';
                    luzSpan.style.animation = 'none';
                    luzSpan.style.boxShadow = 'none';
                    luzSpan.title = 'Fuera del aire';
                }
                return;
            }
            
            // Verificar hora
            const partes = horaPrograma.split('-');
            if (partes.length === 2) {
                const inicio = partes[0].trim();
                const fin = partes[1].trim();
                
                // Convertir a minutos para comparación
                const inicioMin = inicio.split(':').map(Number);
                const finMin = fin.split(':').map(Number);
                const ahoraMin = horaActual.split(':').map(Number);
                
                const inicioTotal = inicioMin[0] * 60 + inicioMin[1];
                const finTotal = finMin[0] * 60 + finMin[1];
                const ahoraTotal = ahoraMin[0] * 60 + ahoraMin[1];
                
                const minutosRestantesInicio = inicioTotal - ahoraTotal;
                const minutosRestantesFin = finTotal - ahoraTotal;
                
                if (!luzSpan) {
                    // Si no hay span de luz, crearlo
                    const nuevoSpan = document.createElement('span');
                    nuevoSpan.className = 'lucesita';
                    celda.prepend(nuevoSpan);
                }
                
                const span = celda.querySelector('.lucesita');
                
                // 🔴 ROJO: falta 1 minuto para comenzar
                if (minutosRestantesInicio >= -1 && minutosRestantesInicio < 0) {
                    span.className = 'lucesita luz-rojo';
                    span.style.background = '#ef4444';
                    span.style.opacity = '1';
                    span.style.animation = 'parpadeo-rojo 0.5s infinite ease-in-out';
                    span.style.boxShadow = '0 0 8px #ef4444';
                    span.title = 'Comienza en 1 minuto';
                }
                // 🟢 VERDE: transmitiendo actualmente
                else if (ahoraTotal >= inicioTotal && ahoraTotal < finTotal) {
                    span.className = 'lucesita luz-envivo';
                    span.style.background = '#22c55e';
                    span.style.opacity = '1';
                    span.style.animation = 'parpadeo-verde 1s infinite ease-in-out';
                    span.style.boxShadow = '0 0 8px #22c55e';
                    span.title = 'Al Aire';
                }
                // ⚪ GRIS: fuera del aire
                else {
                    span.className = 'lucesita';
                    span.style.background = '#d1d5db';
                    span.style.opacity = '0.4';
                    span.style.animation = 'none';
                    span.style.boxShadow = 'none';
                    span.title = 'Fuera del aire';
                }
            }
        });
    }

    // ==========================================
    // INICIALIZAR
    // ==========================================
    document.addEventListener('DOMContentLoaded', function() {
        // Actualizar cada segundo
        setInterval(function() {
            actualizarReloj();
            actualizarLuces();
        }, 1000);
        
        // Ejecutar una vez al cargar
        actualizarReloj();
        actualizarLuces();
        
        // ==========================================
        // CARRUSEL
        // ==========================================
        const track = document.querySelector('.carousel-track');
        const slides = Array.from(document.querySelectorAll('.carousel-slide'));
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const dotsContainer = document.getElementById('dotsContainer');
        
        if (track && slides.length > 0) {
            let currentIndex = 0;
            
            function createDots() {
                dotsContainer.innerHTML = '';
                slides.forEach((_, index) => {
                    const dot = document.createElement('button');
                    dot.classList.add('carousel-dot');
                    if (index === currentIndex) dot.classList.add('active');
                    dot.addEventListener('click', () => goToSlide(index));
                    dotsContainer.appendChild(dot);
                });
            }
            
            function updateDots() {
                const dots = document.querySelectorAll('.carousel-dot');
                dots.forEach((dot, index) => {
                    dot.classList.toggle('active', index === currentIndex);
                });
            }
            
            function goToSlide(index) {
                currentIndex = index;
                track.style.transform = `translateX(${-currentIndex * 100}%)`;
                updateDots();
            }
            
            function nextSlide() {
                currentIndex = (currentIndex + 1) % slides.length;
                goToSlide(currentIndex);
            }
            
            function prevSlide() {
                currentIndex = (currentIndex - 1 + slides.length) % slides.length;
                goToSlide(currentIndex);
            }
            
            nextBtn.addEventListener('click', nextSlide);
            prevBtn.addEventListener('click', prevSlide);
            
            let autoPlay = setInterval(nextSlide, 5000);
            const carouselContainer = document.querySelector('.carousel-container');
            if (carouselContainer) {
                carouselContainer.addEventListener('mouseenter', () => clearInterval(autoPlay));
                carouselContainer.addEventListener('mouseleave', () => {
                    autoPlay = setInterval(nextSlide, 5000);
                });
            }
            
            createDots();
        }
    });

    // ========================================
    // NAVEGACIÓN ACTIVA
    // ========================================
    const sections = document.querySelectorAll('section');
    const navLinks = document.querySelectorAll('nav a');

    window.addEventListener('scroll', () => {
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 90;
            const sectionBottom = sectionTop + section.offsetHeight;
            if (window.scrollY >= sectionTop && window.scrollY < sectionBottom) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.style.background = '';
            link.style.color = '';
            const icon = link.querySelector('i');
            if (link.getAttribute('href') === `#${current}`) {
                link.style.background = '#8B2C2D';
                link.style.color = 'white';
                if (icon) icon.style.color = 'white';
            } else {
                if (icon) icon.style.color = '#8B2C2D';
            }
        });
    });
  </script>
</body>
</html>