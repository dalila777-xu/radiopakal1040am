<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
include("db.php");

$mensaje = "";
$upload_dir = 'uploads/noticias/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// --- ACCIÓN 1: SUBIR NUEVA PUBLICACIÓN ---
if (isset($_POST['agregar_post'])) {
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $contenido = mysqli_real_escape_string($conn, $_POST['contenido']);
    
    // Respaldo por si 'nombre' no está definido en la sesión
    $session_autor = $_SESSION['nombre'] ?? $_SESSION['usuario'] ?? 'Administrador';
    $autor = mysqli_real_escape_string($conn, $session_autor); 
    $imagen_path = '';

    if (!empty($titulo) && !empty($contenido)) {
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['imagen']['tmp_name'];
            $original_name = basename($_FILES['imagen']['name']);
            $extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

            if (in_array($extension, $allowed_extensions)) {
                $filename = time() . '_' . bin2hex(random_bytes(5)) . '.' . $extension;
                $destino = $upload_dir . $filename;

                if (move_uploaded_file($tmp_name, $destino)) {
                    if (!empty($imagen_actual) && file_exists($imagen_actual)) {
                        @unlink($imagen_actual);
                    }
                    $imagen_path = mysqli_real_escape_string($conn, $destino);
                } else {
                    $mensaje = "<div class='alert error'>❌ No se pudo subir la imagen.</div>";
                }
            } else {
                $mensaje = "<div class='alert error'>❌ Formato de imagen no admitido. Usa JPG, PNG, WEBP o GIF.</div>";
            }
        }

        if (empty($mensaje)) {
            $query = "INSERT INTO publicaciones (titulo, contenido, autor, imagen, fecha_creacion) VALUES ('$titulo', '$contenido', '$autor', '$imagen_path', NOW())";
            if (mysqli_query($conn, $query)) {
                $mensaje = "<div class='alert success'>✨ Publicación subida con éxito al Index.</div>";
            } else {
                $mensaje = "<div class='alert error'>❌ Error al publicar: " . mysqli_error($conn) . "</div>";
            }
        }
    } else {
        $mensaje = "<div class='alert error'>❌ Completa todos los campos requeridos.</div>";
    }
}

// --- ACCIÓN 2: ELIMINAR PUBLICACIÓN ---
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $res_img = mysqli_query($conn, "SELECT imagen FROM publicaciones WHERE id = $id");
    if ($res_img && mysqli_num_rows($res_img) > 0) {
        $row_img = mysqli_fetch_assoc($res_img);
        if (!empty($row_img['imagen']) && file_exists($row_img['imagen'])) {
            @unlink($row_img['imagen']);
        }
    }

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
    $imagen_actual = $_POST['imagen_actual'] ?? '';
    $imagen_path = mysqli_real_escape_string($conn, $imagen_actual);

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['imagen']['tmp_name'];
        $original_name = basename($_FILES['imagen']['name']);
        $extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

        if (in_array($extension, $allowed_extensions)) {
            $filename = time() . '_' . bin2hex(random_bytes(5)) . '.' . $extension;
            $destino = $upload_dir . $filename;

            if (move_uploaded_file($tmp_name, $destino)) {
                $imagen_path = mysqli_real_escape_string($conn, $destino);
            } else {
                $mensaje = "<div class='alert error'>❌ No se pudo subir la imagen.</div>";
            }
        } else {
            $mensaje = "<div class='alert error'>❌ Formato de imagen no admitido. Usa JPG, PNG, WEBP o GIF.</div>";
        }
    }

    if (empty($mensaje)) {
        $query = "UPDATE publicaciones SET titulo = '$titulo', contenido = '$contenido'";
        if (!empty($imagen_path)) {
            $query .= ", imagen = '$imagen_path'";
        }
        $query .= " WHERE id = $id";

        if (mysqli_query($conn, $query)) {
            $mensaje = "<div class='alert success'>🔄 Post actualizado correctamente en la web.</div>";
        } else {
            $mensaje = "<div class='alert error'>❌ Error al actualizar.</div>";
        }
    }
}

// --- PASO PREVIO PARA EDITAR ---
$edit_mode = false;
$edit_id = "";
$edit_titulo = "";
$edit_contenido = "";
$edit_imagen = "";

if (isset($_GET['editar'])) {
    $edit_mode = true;
    $id_editar = intval($_GET['editar']);
    $res_edit = mysqli_query($conn, "SELECT * FROM publicaciones WHERE id = $id_editar");
    if ($res_edit && mysqli_num_rows($res_edit) > 0) {
        $row_edit = mysqli_fetch_assoc($res_edit);
        $edit_id = $row_edit['id'];
        $edit_titulo = $row_edit['titulo'];
        $edit_contenido = $row_edit['contenido'];
        $edit_imagen = $row_edit['imagen'] ?? '';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Publicaciones | Radio Pakal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #f8f5f0; padding: 30px; color: #1a1a2e; }
        
        .header-modulo { background: #0099FF; color: white; padding: 20px; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .header-modulo h2 { font-size: 1.4rem; font-weight: 700; }
        .header-modulo a { color: white; text-decoration: none; font-weight: 600; background: rgba(255,255,255,0.1); padding: 10px 18px; border-radius: 8px; transition: background 0.2s; font-size: 0.9rem; }
        .header-modulo a:hover { background: rgba(255,255,255,0.2); }
        
        .form-container { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 30px; border-top: 4px solid #D4AF37; }
        .form-container h3 { color: #6B1E1F; font-size: 1.25rem; margin-bottom: 20px; }
        
        .form-group { margin-bottom: 18px; display: flex; flex-direction: column; }
        .form-group label { font-weight: 600; margin-bottom: 8px; font-size: 0.9rem; color: #444; }
        .form-group input, .form-group textarea { padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 0.95rem; outline: none; transition: border-color 0.2s; color: #333; }
        .form-group input:focus, .form-group textarea:focus { border-color: #8B2C2D; }
        
        .btn-submit { background: #0099FF; color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 0.95rem; display: inline-block; transition: background 0.2s; }
        .btn-submit:hover { background: #0099FF; }
        .btn-update { background: #D4AF37; color: #0099FF; }
        .btn-update:hover { background: #bfa032; }
        .btn-cancel { background: #e2e8f0; color: #4a5568; text-decoration: none; padding: 12px 25px; border-radius: 8px; font-weight: 600; font-size: 0.95rem; display: inline-block; margin-left: 10px; transition: background 0.2s; }
        .btn-cancel:hover { background: #cbd5e1; }
        
        h3.section-title { color: #1a1a2e; font-size: 1.3rem; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        
        .post-item { background: white; padding: 22px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); margin-bottom: 20px; border-left: 5px solid #8B2C2D; position: relative; }
        .post-item h4 { margin-bottom: 6px; color: #6B1E1F; font-size: 1.25rem; font-weight: 700; }
        .post-item small { color: #718096; display: block; margin-bottom: 12px; font-size: 0.85rem; }
        .post-item p { color: #4a5568; line-height: 1.6; font-size: 0.95rem; white-space: pre-line; }
        
        .post-actions { margin-top: 20px; text-align: right; }
        .post-actions a { text-decoration: none; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; margin-left: 10px; display: inline-block; transition: opacity 0.2s; }
        .post-actions a:hover { opacity: 0.9; }
        .btn-edit { background: #16a34a; color: #ffffff; }
        .btn-delete { background: #dc2626; color: #ffffff; }
        
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 22px; font-weight: 600; font-size: 0.95rem; }
        .success { background: #c6f6d5; color: #22543d; border: 1px solid #9ae6b4; }
        .error { background: #fed7d7; color: #742a2a; border: 1px solid #feb2b2; }
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
        
        <form action="admin_publicaciones.php" method="POST" enctype="multipart/form-data">
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

            <div class="form-group">
                <label>Imagen de la Noticia (opcional):</label>
                <?php if ($edit_mode && !empty($edit_imagen)): ?>
                    <div style="margin-bottom:12px;">
                        <img src="<?php echo htmlspecialchars($edit_imagen); ?>" alt="Imagen actual" style="max-width:100%; border-radius:8px; display:block;">
                    </div>
                <?php endif; ?>
                <input type="file" name="imagen" accept=".jpg,.jpeg,.png,.webp,.gif">
                <?php if ($edit_mode): ?>
                    <input type="hidden" name="imagen_actual" value="<?php echo htmlspecialchars($edit_imagen); ?>">
                <?php endif; ?>
            </div>

            <div>
                <?php if ($edit_mode): ?>
                    <button type="submit" name="actualizar_post" class="btn-submit btn-update"><i class="fas fa-save"></i> Guardar Cambios</button>
                    <a href="admin_publicaciones.php" class="btn-cancel">Cancelar Edición</a>
                <?php else: ?>
                    <button type="submit" name="agregar_post" class="btn-submit"><i class="fas fa-paper-plane"></i> Lanzar Publicación</button>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <h3 class="section-title"><i class="fas fa-history"></i> Historial de Publicaciones Emitidas</h3>
    
    <div class="posts-list">
        <?php
        $res = mysqli_query($conn, "SELECT * FROM publicaciones ORDER BY id DESC");
        if ($res && mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                // Validación para la fecha en caso de que no tenga valor predeterminado válido en la base de datos
                $fecha_formateada = (!empty($row['fecha_creacion'])) ? date('d/m/Y H:i', strtotime($row['fecha_creacion'])) : 'Reciente';

                echo "<div class='post-item'>";
                if (!empty($row['imagen'])) {
                    // Ajuste de tamaño: altura fija para uniformidad (puedes cambiar 300px a la medida deseada)
                    echo "<div style='max-height:1000px; overflow:hidden; margin-bottom:16px; border-radius:12px;'>";
                    echo "<img src='" . htmlspecialchars($row['imagen']) . "' alt='Imagen de noticia' style='width:100%; height:300px; display:block; object-fit:cover;'>";
                    echo "</div>";
                }
                echo "<h4>" . htmlspecialchars($row['titulo']) . "</h4>";
                echo "<small><i class='far fa-calendar-alt'></i> " . $fecha_formateada . " | <i class='far fa-user'></i> Autor: " . htmlspecialchars($row['autor']) . "</small>";
                echo "<p>" . htmlspecialchars($row['contenido']) . "</p>";
                echo "<div class='post-actions'>";
                echo "<a href='admin_publicaciones.php?editar=" . $row['id'] . "' class='btn-edit'><i class='fas fa-edit'></i> Editar</a>";
                echo "<a href='admin_publicaciones.php?eliminar=" . $row['id'] . "' class='btn-delete' onclick='return confirm(\"¿Deseas eliminar permanentemente esta publicación del index?\");'><i class='fas fa-trash-alt'></i> Eliminar</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p style='color:#777; font-style:italic; padding-left: 5px;'>No hay comunicados registrados aún en tu base de datos.</p>";
        }
        ?>
    </div>

</body>
</html>