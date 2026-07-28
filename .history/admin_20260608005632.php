<?php
include("db.php");
session_start();

// Validar que el administrador esté logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$msg = "";
$error = "";

// 1. PROCESAR ACCIONES DE PROGRAMACIÓN (Añadir / Eliminar)
if (isset($_POST['add_programa'])) {
    $hora = mysqli_real_escape_string($conn, $_POST['hora']);
    $programa = mysqli_real_escape_string($conn, $_POST['programa']);

    if (!empty($hora) && !empty($programa)) {
        $query = "INSERT INTO programacion (hora, programa) VALUES ('$hora', '$programa')";
        if (mysqli_query($conn, $query)) {
            $msg = "Programa añadido correctamente de forma cronológica.";
        } else {
            $error = "Error al guardar el programa.";
        }
    }
}

if (isset($_GET['del_programa'])) {
    $id_del = (int)$_GET['del_programa'];
    if (mysqli_query($conn, "DELETE FROM programacion WHERE id = $id_del")) {
        $msg = "Programa eliminado del horario del día.";
    }
}

// 2. PROCESAR ACCIONES DE PUBLICACIONES (Añadir / Eliminar)
if (isset($_POST['add_publicacion'])) {
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $contenido = mysqli_real_escape_string($conn, $_POST['contenido']);
    $autor = $_SESSION['nombre'];

    if (!empty($titulo) && !empty($contenido)) {
        $query = "INSERT INTO publicaciones (titulo, contenido, autor) VALUES ('$titulo', '$contenido', '$autor')";
        if (mysqli_query($conn, $query)) {
            $msg = "Aviso publicado exitosamente en la web.";
        } else {
            $error = "Error al publicar el comunicado.";
        }
    }
}

if (isset($_GET['del_pub'])) {
    $id_pub_del = (int)$_GET['del_pub'];
    if (mysqli_query($conn, "DELETE FROM publicaciones WHERE id = $id_pub_del")) {
        $msg = "Publicación retirada de la sección pública.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración | Radio Pakal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #f4f6f9; color: #333; padding-bottom: 3rem; }
        
        /* Navbar */
        .navbar { background: #8B2C2D; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .navbar h2 { font-size: 1.3rem; }
        .navbar a { color: white; text-decoration: none; font-weight: 600; background: rgba(255,255,255,0.15); padding: 0.5rem 1rem; border-radius: 20px; transition: 0.2s; font-size: 0.85rem; }
        .navbar a:hover { background: rgba(255,255,255,0.3); }

        .container { max-width: 1100px; margin: 2rem auto; padding: 0 1.5rem; }
        
        /* Alertas */
        .alert { padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 500; font-size: 0.9rem; }
        .alert-success { background: #def7ec; color: #03543f; border: 1px solid #84e1bc; }
        .alert-error { background: #fde8e8; color: #9b1c1c; border: 1px solid #f8b4b4; }

        /* Módulos de edición */
        .grid-admin { display: grid; grid-template-columns: 1fr; gap: 2rem; }
        @media (min-width: 768px) { .grid-admin { grid-template-columns: 1fr 1fr; } }
        
        .card { background: white; padding: 1.8rem; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.02); border-top: 3px solid #D4AF37; }
        .card h3 { color: #6B1E1F; font-size: 1.2rem; margin-bottom: 1.2rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem; display: flex; align-items: center; gap: 8px; }
        
        label { display: block; margin-bottom: 0.4rem; font-weight: 600; font-size: 0.85rem; color: #555; }
        input[type="text"], input[type="time"], textarea { width: 100%; padding: 0.65rem; border: 1px solid #ccc; border-radius: 6px; font-size: 0.9rem; outline: none; margin-bottom: 1rem; }
        input:focus, textarea:focus { border-color: #8B2C2D; }
        textarea { height: 100px; resize: none; }
        
        .btn-primary { background: #8B2C2D; color: white; border: none; padding: 0.65rem 1.2rem; border-radius: 6px; font-weight: 600; cursor: pointer; transition: 0.2s; font-size: 0.9rem; }
        .btn-primary:hover { background: #6B1E1F; }

        /* Tablas y listas internas */
        .list-items { margin-top: 1.5rem; max-height: 300px; overflow-y: auto; border: 1px solid #eee; border-radius: 6px; }
        .item-row { display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 1rem; border-bottom: 1px solid #eee; background: #fafafa; }
        .item-row:last-child { border-bottom: none; }
        .item-row:hover { background: #fffdf9; }
        .item-title { font-size: 0.9rem; }
        .btn-delete { color: #e53e3e; text-decoration: none; font-size: 0.9rem; padding: 0.2rem 0.5rem; border-radius: 4px; transition: 0.2s; }
        .btn-delete:hover { background: #fde8e8; }
    </style>
</head>
<body>

<div class="navbar">
    <h2><i class="fas fa-sliders-h"></i> Panel de Administración - Radio Pakal</h2>
    <div>
        <span style="margin-right: 15px; font-size: 0.9rem; opacity: 0.9;">Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
    </div>
</div>

<div class="container">
    
    <?php if(!empty($msg)): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo $msg; ?></div>
    <?php endif; ?>
    <?php if(!empty($error)): ?>
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
    <?php endif; ?>

    <div class="grid-admin">
        
        <div class="card">
            <h3><i class="fas fa-calendar-plus"></i> Gestionar Horarios y Programas</h3>
            <form action="" method="POST">
                <label for="hora">Hora de Inicio</label>
                <input type="time" id="hora" name="hora" required>
                
                <label for="programa">Nombre del Programa / Locutor</label>
                <input type="text" id="programa" name="programa" placeholder="Ej: Mañanas Alegres con Juan López" required>
                
                <button type="submit" name="add_programa" class="btn-primary">Añadir al Horario</button>
            </form>

            <div class="list-items">
                <?php
                $res = mysqli_query($conn, "SELECT * FROM programacion ORDER BY hora ASC");
                if(mysqli_num_rows($res) > 0){
                    while($row = mysqli_fetch_assoc($res)){
                        echo "<div class='item-row'>";
                        echo "<span class='item-title'><strong>{$row['hora']}</strong> - " . htmlspecialchars($row['programa']) . "</span>";
                        echo "<a href='?del_programa={$row['id']}' class='btn-delete' onclick=\"return confirm('¿Remover este programa?')\"><i class='fas fa-trash-alt'></i></a>";
                        echo "</div>";
                    }
                } else {
                    echo "<p style='padding:1rem; text-align:center; color:#888; font-size:0.85rem;'>No hay programas asignados hoy.</p>";
                }
                ?>
            </div>
        </div>

        <div class="card">
            <h3><i class="fas fa-file-medical"></i> Publicar Noticias o Avisos</h3>
            <form action="" method="POST">
                <label for="titulo">Título del Comunicado</label>
                <input type="text" id="titulo" name="titulo" placeholder="Ej: Aviso Importante a la Comunidad de Palenque" required>
                
                <label for="contenido">Contenido Completo</label>
                <textarea id="contenido" name="contenido" placeholder="Escribe aquí los detalles del mensaje..." required></textarea>
                
                <button type="submit" name="add_publicacion" class="btn-primary">Publicar Ahora</button>
            </form>

            <div class="list-items">
                <?php
                $res_p = mysqli_query($conn, "SELECT id, titulo FROM publicaciones ORDER BY id DESC");
                if(mysqli_num_rows($res_p) > 0){
                    while($row_p = mysqli_fetch_assoc($res_p)){
                        echo "<div class='item-row'>";
                        echo "<span class='item-title' style='white-space:nowrap; text-overflow:ellipsis; overflow:hidden; max-width:250px;'>" . htmlspecialchars($row_p['titulo']) . "</span>";
                        echo "<a href='?del_pub={$row_p['id']}' class='btn-delete' onclick=\"return confirm('¿Eliminar esta publicación permanente de la web?')\"><i class='fas fa-trash-alt'></i></a>";
                        echo "</div>";
                    }
                } else {
                    echo "<p style='padding:1rem; text-align:center; color:#888; font-size:0.85rem;'>No hay circulares activas en el portal.</p>";
                }
                ?>
            </div>
        </div>

    </div>
</div>

</body>
</html>