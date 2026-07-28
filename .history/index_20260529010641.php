<?php
// admin.php - Panel de administración
session_start();
include 'conexion.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Procesar acciones - AGREGAR PROGRAMA
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar_programa'])) {
    $horario = $conn->real_escape_string($_POST['horario']);
    $programa = $conn->real_escape_string($_POST['programa']);
    $conductor = $conn->real_escape_string($_POST['conductor']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $orden = intval($_POST['orden']);
    
    $sql = "INSERT INTO programacion (horario, programa, conductor, descripcion, orden) 
            VALUES ('$horario', '$programa', '$conductor', '$descripcion', $orden)";
    $conn->query($sql);
    header('Location: admin.php');
    exit();
}

// ELIMINAR PROGRAMA
if (isset($_GET['eliminar_programa'])) {
    $id = intval($_GET['eliminar_programa']);
    $conn->query("DELETE FROM programacion WHERE id = $id");
    header('Location: admin.php');
    exit();
}

// EDITAR PROGRAMA
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar_programa'])) {
    $id = intval($_POST['id']);
    $horario = $conn->real_escape_string($_POST['horario']);
    $programa = $conn->real_escape_string($_POST['programa']);
    $conductor = $conn->real_escape_string($_POST['conductor']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    
    $sql = "UPDATE programacion SET horario='$horario', programa='$programa', conductor='$conductor', descripcion='$descripcion' WHERE id=$id";
    $conn->query($sql);
    header('Location: admin.php');
    exit();
}

// AGREGAR NOTICIA
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar_noticia'])) {
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $resumen = $conn->real_escape_string($_POST['resumen']);
    $contenido = $conn->real_escape_string($_POST['contenido']);
    $imagen_url = $conn->real_escape_string($_POST['imagen_url']);
    $destacado = isset($_POST['destacado']) ? 1 : 0;
    
    $sql = "INSERT INTO noticias (titulo, resumen, contenido, imagen_url, destacado) 
            VALUES ('$titulo', '$resumen', '$contenido', '$imagen_url', $destacado)";
    $conn->query($sql);
    header('Location: admin.php');
    exit();
}

// ELIMINAR NOTICIA
if (isset($_GET['eliminar_noticia'])) {
    $id = intval($_GET['eliminar_noticia']);
    $conn->query("DELETE FROM noticias WHERE id = $id");
    header('Location: admin.php');
    exit();
}

// MARCAR MENSAJE COMO LEÍDO
if (isset($_GET['leer_mensaje'])) {
    $id = intval($_GET['leer_mensaje']);
    $conn->query("UPDATE mensajes SET leido = 1 WHERE id = $id");
    header('Location: admin.php');
    exit();
}

// ELIMINAR MENSAJE
if (isset($_GET['eliminar_mensaje'])) {
    $id = intval($_GET['eliminar_mensaje']);
    $conn->query("DELETE FROM mensajes WHERE id = $id");
    header('Location: admin.php');
    exit();
}

// Obtener datos
$programas = $conn->query("SELECT * FROM programacion ORDER BY orden ASC");
$noticias = $conn->query("SELECT * FROM noticias ORDER BY fecha_publicacion DESC");
$mensajes = $conn->query("SELECT * FROM mensajes ORDER BY fecha DESC");

// Obtener estadísticas
$total_programas = $programas->num_rows;
$total_noticias = $noticias->num_rows;
$total_mensajes = $mensajes->num_rows;
$mensajes_nuevos = $conn->query("SELECT COUNT(*) as total FROM mensajes WHERE leido = 0")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administración - Radio Palenque</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #1a1a2e;
            padding: 20px;
        }

        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .admin-header {
            background: #16213e;
            color: white;
            padding: 1rem 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #16213e;
            color: white;
            padding: 1rem;
            border-radius: 10px;
            text-align: center;
        }

        .stat-card h3 {
            font-size: 2rem;
            margin: 0.5rem 0;
        }

        .card {
            background: #16213e;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .card h2 {
            color: #e67e22;
            margin-bottom: 1rem;
            border-left: 4px solid #e67e22;
            padding-left: 1rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            background: #0f3460;
            border: 1px solid #e67e22;
            border-radius: 8px;
            color: white;
        }

        input::placeholder, textarea::placeholder {
            color: #aaa;
        }

        button {
            background: #e67e22;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #f39c12;
        }

        .btn-danger {
            background: #c0392b;
        }

        .btn-danger:hover {
            background: #e74c3c;
        }

        .btn-success {
            background: #27ae60;
        }

        .btn-success:hover {
            background: #2ecc71;
        }

        .btn-warning {
            background: #f39c12;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            color: white;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #0f3460;
        }

        th {
            background: #0f3460;
            color: #e67e22;
        }

        .badge {
            background: #e67e22;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 0.7rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .leido {
            opacity: 0.6;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: #16213e;
            padding: 2rem;
            border-radius: 15px;
            width: 90%;
            max-width: 500px;
        }

        @media (max-width: 768px) {
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<div class="admin-container">
    <div class="admin-header">
        <h2>🔐 RADIO PALENQUE - PANEL DE ADMINISTRACIÓN</h2>
        <div>
            <span class="badge">👤 <?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Admin'); ?></span>
            <a href="logout.php" style="background:#c0392b; color:white; text-decoration:none; padding:5px 15px; border-radius:8px; margin-left:1rem;">🚪 Cerrar Sesión</a>
            <a href="index.php" style="background:#27ae60; color:white; text-decoration:none; padding:5px 15px; border-radius:8px; margin-left:1rem;">🌍 Ver sitio</a>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="stats">
        <div class="stat-card">
            📅 <h3><?php echo $total_programas; ?></h3>
            <p>Programas</p>
        </div>
        <div class="stat-card">
            📰 <h3><?php echo $total_noticias; ?></h3>
            <p>Noticias</p>
        </div>
        <div class="stat-card">
            ✉️ <h3><?php echo $total_mensajes; ?></h3>
            <p>Mensajes</p>
        </div>
        <div class="stat-card">
            🆕 <h3><?php echo $mensajes_nuevos; ?></h3>
            <p>Mensajes nuevos</p>
        </div>
    </div>

    <!-- Agregar Programa -->
    <div class="card">
        <h2>➕ Agregar Nuevo Programa</h2>
        <form method="POST" class="form-grid">
            <input type="text" name="horario" placeholder="Horario (ej: 06:00 - 08:00 AM)" required>
            <input type="text" name="programa" placeholder="Nombre del programa" required>
            <input type="text" name="conductor" placeholder="Conductor">
            <input type="number" name="orden" placeholder="Orden (1,2,3...)" value="0">
            <textarea name="descripcion" rows="2" placeholder="Descripción del programa" style="grid-column: span 2;"></textarea>
            <button type="submit" name="agregar_programa" style="grid-column: span 2;">💾 Guardar Programa</button>
        </form>
    </div>

    <!-- Agregar Noticia -->
    <div class="card">
        <h2>📰 Agregar Nueva Noticia</h2>
        <form method="POST" class="form-grid">
            <input type="text" name="titulo" placeholder="Título de la noticia" required>
            <input type="text" name="imagen_url" placeholder="URL de la imagen (opcional)">
            <textarea name="resumen" rows="2" placeholder="Resumen breve" required style="grid-column: span 2;"></textarea>
            <textarea name="contenido" rows="3" placeholder="Contenido completo" style="grid-column: span 2;"></textarea>
            <div style="grid-column: span 2;">
                <label style="color:white;">
                    <input type="checkbox" name="destacado"> Destacar esta noticia
                </label>
            </div>
            <button type="submit" name="agregar_noticia" style="grid-column: span 2;">📢 Publicar Noticia</button>
        </form>
    </div>

    <!-- Lista de Programas -->
    <div class="card">
        <h2>📋 Lista de Programas</h2>
        <table>
            <thead>
                <tr><th>Horario</th><th>Programa</th><th>Conductor</th><th>Descripción</th><th>Acciones</th></tr>
            </thead>
            <tbody>
                <?php 
                $programas->data_seek(0);
                while($prog = $programas->fetch_assoc()): 
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($prog['horario']); ?></td>
                    <td><?php echo htmlspecialchars($prog['programa']); ?></td>
                    <td><?php echo htmlspecialchars($prog['conductor']); ?></td>
                    <td><?php echo htmlspecialchars($prog['descripcion']); ?></td>
                    <td class="action-buttons">
                        <button onclick="editarPrograma(<?php echo $prog['id']; ?>, '<?php echo htmlspecialchars($prog['horario']); ?>', '<?php echo htmlspecialchars($prog['programa']); ?>', '<?php echo htmlspecialchars($prog['conductor']); ?>', '<?php echo htmlspecialchars($prog['descripcion']); ?>')" style="background:#f39c12;">✏️ Editar</button>
                        <a href="?eliminar_programa=<?php echo $prog['id']; ?>" class="