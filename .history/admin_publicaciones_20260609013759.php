<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
include("db.php");

$mensaje = "";

// --- ACCIÓN 1: SUBIR NUEVA PUBLICACIÓN ---
if (isset($_POST['agregar_post'])) {
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $contenido = mysqli_real_escape_string($conn, $_POST['contenido']);
    $autor = mysqli_real_escape_string($conn, $_SESSION['nombre']); // Nombre de quien inició sesión

    if (!empty($titulo) && !empty($contenido)) {
        $query = "INSERT INTO publicaciones (titulo, contenido, autor) VALUES ('$titulo', '$contenido', '$autor')";
        if (mysqli_query($conn, $query)) {
            $mensaje = "<div class='alert success'>✨ Publicación subida con éxito al Index.</div>";
        } else {
            $mensaje = "<div class='alert error'>❌ Error al publicar: " . mysqli_error($conn) . "</div>";
        }
    }
}

// --- ACCIÓN 2: ELIMINAR PUBLICACIÓN ---
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $query = "DELETE FROM publicaciones WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        $mensaje = "<div class='alert success'>🗑️ Post eliminado correctamente.</div>";
    } else {
        $mensaje = "<div class='alert error'>❌ Error al eliminar el registro.</div>";
    }
}

// --- ACCIÓN 3: ACTUALIZAR PUBLICACIÓN ---
if (isset($_POST['actualizar_post'])) {
    $id = intval($_POST['id']);
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $contenido = mysqli_real_escape_string($conn, $_POST['contenido']);

    $query = "UPDATE publicaciones SET titulo = '$titulo', contenido = '$contenido' WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        $mensaje = "<div class='alert success'>🔄 Post actualizado correctamente en la web.</div>";
    } else {
        $mensaje = "<div class='alert error'>❌ Error al actualizar.</div>";
    }
}

// --- PASO PREVIO PARA EDITAR ---
$edit_mode = false;
$edit_id = "";
$edit_titulo = "";
$edit_contenido = "";

if (isset($_GET['editar'])) {
    $edit_mode = true;
    $id_editar = intval($_GET['editar']);
    $res_edit = mysqli_query($conn, "SELECT * FROM publicaciones WHERE id = $id_editar");
    if ($res_edit && mysqli_num_rows($res_edit) > 0) {
        $row_edit = mysqli_fetch_assoc($res_edit);
        $edit_id = $row_edit['id'];
        $edit_titulo = $row_edit['titulo'];
        $edit_contenido = $row_edit['contenido'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Publicaciones | Radio Pakal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: sans-serif; background: #f4f6f9; margin: 0; padding: 20px; color: #333; }
        .header-modulo { background: #8B2C2D; color: white; padding: 15px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .header-modulo a { color: white; text-decoration: none; font-weight: bold; background: rgba(0,0,0,0.2); padding: 8px 15px; border-radius: 5px; }
        .form-container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 25px; border-top: 4px solid #D4AF37; }
        .form-group { margin-bottom: 15px; display: flex; flex-direction: column; }
        .form-group label { font-weight: bold; margin-bottom: 5px; }
        .form-group input, .form-group textarea { padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem; font-family: sans-serif; }
        .btn-submit { background: #8B2C2D; color: white; border: none; padding: 12px 25px; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 1rem; display: inline-block; }
        .btn-update { background: #D4AF37; color: #1a1a2e; }
        .btn-cancel { background: #666; color: white; text-decoration: none; padding: 12px 25px; border-radius: 4px; font-weight: bold; font-size: 1rem; display: inline-block; margin-left: 10px; }
        .post-item { background: white; padding: 18px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 15px; border-left: 5px solid #1a1a2e; position: relative; }
        .post-item h4 { margin: 0 0 5px 0; color: #6B1E1F; font-size: 1.2rem; }
        .post-item small { color: #777; display: block; margin-bottom: 10px; }
        .post-item p { margin: 0; color: #444; white-space: pre-line; }
        .post-actions { margin-top: 15px; text-align: right; }
        .post-actions a { text-decoration: none; padding: 6px 14px; border-radius: 4px; font-size: 0.85rem; font-weight: bold; margin-left: 8px; display: inline-block; }
        .btn-edit { background: #D4AF37; color: #1a1a2e; }
        .btn-delete { background: #8B2C2D; color: white; }
        .alert { padding: 12px; border-radius: 5px; margin-bottom: 15px; font-weight: bold; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

    <div class="header-modulo">
        <h2><i class="fas fa-newspaper"></i> Panel de Noticias, Avisos y Publicaciones</h2>
        <a href="admin.php"><i class="fas fa-arrow-left"></i> Volver al Menú</a>
    </div>

    <?php echo $mensaje; ?>

    <div class="form-container">
        <h3><?php echo $edit_mode ? "📝 Editar Publicación Actual" : "📢 Redactar Nuevo Comunicado para la Web"; ?></h3>
        <br>
        <form action="admin_publicaciones.php" method="POST">
            <?php if ($edit_mode): ?>
                <input type="hidden" name="id" value="<?php echo $edit_id; ?>">
            <?php endif; ?>

            <div class="form-group">
                <label>Título del Aviso / Noticia:</label>
                <input type="text" name="titulo" placeholder="Ej: Gran Evento Cultural en Palenque" required value="<?php echo htmlspecialchars($edit_titulo); ?>">
            </div>

            <div class="form-group">
                <label>Contenido / Cuerpo de la Publicación:</label>
                <textarea name="contenido" rows="5" placeholder="Escribe aquí toda la información detallada que verá el público..." required><?php echo htmlspecialchars($edit_contenido); ?></textarea>
            </div>

            <div>
                <?php if ($edit_mode): ?>
                    <button type="submit" name="actualizar_post" class="btn-submit btn-update"><i class="fas fa-save"></i> Publicar Cambios Actualizados</button>
                    <a href="admin_publicaciones.php" class="btn-cancel">Cancelar</a>
                <?php else: ?>
                    <button type="submit" name="agregar_post" class="btn-submit"><i class="fas fa-paper-plane"></i> Lanzar Publicación al Index</button>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <h3><i class="fas fa-history"></i> Historial de Publicaciones Emitidas</h3>
    <br>
    <div class="posts-list">
        <?php
        $res = mysqli_query($conn, "SELECT * FROM publicaciones ORDER BY id DESC");
        if ($res && mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                echo "<div class='post-item'>";
                echo "<h4>" . htmlspecialchars($row['titulo']) . "</h4>";
                echo "<small><i class='far fa-calendar-alt'></i> " . date('d/m/Y H:i', strtotime($row['fecha_creacion'])) . " | <i class='far fa-user'></i> Autor: " . htmlspecialchars($row['autor']) . "</small>";
                echo "<p>" . htmlspecialchars($row['contenido']) . "</p>";
                echo "<div class='post-actions'>";
                echo "<a href='admin_publicaciones.php?editar=" . $row['id'] . "' class='btn-edit'><i class='fas fa-edit'></i> Editar</a>";
                echo "<a href='admin_publicaciones.php?eliminar=" . $row['id'] . "' class='btn-delete' onclick='return confirm(\"¿Deseas eliminar permanentemente esta publicación del index?\");'><i class='fas fa-trash-alt'></i> Eliminar</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p style='color:#777; font-style:italic;'>No hay comunicados registrados aún en tu base de datos.</p>";
        }
        ?>
    </div>

</body>
</html>