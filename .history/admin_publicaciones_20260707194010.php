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
        
        .header-modulo { background: #0d47a1; color: white; padding: 20px; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .header-modulo h2 { font-size: 1.4rem; font-weight: 700; }
        .header-modulo a { color: white; text-decoration: none; font-weight: 600; background: rgba(255,255,255,0.1); padding: 10px 18px; border-radius: 8px; transition: background 0.2s; font-size: 0.9rem; }
        .header-modulo a:hover { background: rgba(255,255,255,0.2); }
        
        .form-container { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 30px; border-top: 4px solid #D4AF37; }
        .form-container h3 { color: #0d47a1; font-size: 1.25rem; margin-bottom: 20px; }
        
        .form-group { margin-bottom: 18px; display: flex; flex-direction: column; }
        .form-group label { font-weight: 600; margin-bottom: 8px; font-size: 0.9rem; color: #444; }
        .form-group input, .form-group textarea { padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 0.95rem; outline: none; transition: border-color 0.2s; color: #333; }
        .form-group input:focus, .form-group textarea:focus { border-color: #0d47a1; }
        
        .btn-submit { background: #0d47a1; color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 0.95rem; transition: background 0.2s; }
        .btn-submit:hover { background: #0a3a7a; }
        .btn-update { background: #D4AF37; color: #1a1a2e; }
        .btn-update:hover { background: #bfa032; }
        .btn-cancel { background: #e2e8f0; color: #4a5568; text-decoration: none; padding: 12px 25px; border-radius: 8px; font-weight: 600; font-size: 0.95rem; display: inline-block; margin-left: 10px; transition: background 0.2s; }
        .btn-cancel:hover { background: #cbd5e1; }
        
        h3.section-title { color: #1a1a2e; font-size: 1.3rem; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        
        /* ========================================
           GRID DE PUBLICACIONES - CUATRITOS
        ======================================== */
        .grid-publicaciones { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
            gap: 25px; 
            margin-top: 15px;
        }
        
        .post-item { 
            background: white; 
            border: 1px solid #e5e7eb; 
            border-radius: 12px; 
            overflow: hidden; 
            position: relative; 
            text-align: left; 
            padding-bottom: 15px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.04); 
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        
        .post-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }
        
        .post-item .img-container { 
            width: 100%; 
            height: 200px; 
            overflow: hidden;
            background: #f3f4f6;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .post-item .img-container img { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
            display: block; 
        }
        
        .post-item .info { 
            padding: 15px; 
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .post-item .info h4 { 
            margin: 0 0 4px 0; 
            color: #0d47a1; 
            font-size: 1rem; 
            font-weight: 700; 
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .post-item .info small { 
            color: #718096; 
            font-size: 0.75rem; 
            margin-bottom: 8px; 
            display: block;
        }
        
        .post-item .info p { 
            color: #4a5568; 
            line-height: 1.5; 
            font-size: 0.85rem; 
            margin: 0 0 12px 0;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex: 1;
        }
        
        .post-actions { 
            margin-top: auto; 
            text-align: right; 
            padding-top: 10px;
            border-top: 1px solid #f3f4f6;
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }
        
        .post-actions a { 
            text-decoration: none; 
            padding: 5px 12px; 
            border-radius: 6px; 
            font-size: 0.75rem; 
            font-weight: 600; 
            display: inline-block; 
            transition: opacity 0.2s; 
        }
        
        .post-actions a:hover { opacity: 0.85; }
        .btn-edit { background: #16a34a; color: #ffffff; }
        .btn-delete { background: #dc2626; color: #ffffff; }
        
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 22px; font-weight: 600; font-size: 0.95rem; }
        .success { background: #c6f6d5; color: #22543d; border: 1px solid #9ae6b4; }
        .error { background: #fed7d7; color: #742a2a; border: 1px solid #feb2b2; }

        .sin-publicaciones { 
            color: #6b7280; 
            font-style: italic; 
            padding: 30px; 
            text-align: center; 
            background: #f9fafb; 
            border-radius: 12px;
            grid-column: 1 / -1;
        }

        /* ========================================
           RESPONSIVE
        ======================================== */
        @media (max-width: 768px) {
            body { padding: 15px; }
            .header-modulo { flex-direction: column; gap: 10px; text-align: center; }
            .grid-publicaciones { 
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); 
                gap: 15px;
            }
            .post-item .img-container { height: 160px; }
        }

        @media (max-width: 480px) {
            .grid-publicaciones { 
                grid-template-columns: 1fr 1fr; 
                gap: 12px;
            }
            .post-item .img-container { height: 130px; }
            .post-item .info h4 { font-size: 0.85rem; }
            .post-item .info p { font-size: 0.75rem; -webkit-line-clamp: 2; }
            .post-actions a { font-size: 0.65rem; padding: 4px 8px; }
        }
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
                <textarea name="contenido" rows="4" placeholder="Escribe aquí toda la información detallada que verá el público..." required><?php echo htmlspecialchars($edit_contenido); ?></textarea>
            </div>

            <div class="form-group">
                <label>Imagen de la Noticia (opcional):</label>
                <?php if ($edit_mode && !empty($edit_imagen) && file_exists($edit_imagen)): ?>
                    <div style="margin-bottom:12px;">
                        <img src="<?php echo htmlspecialchars($edit_imagen); ?>" alt="Imagen actual" style="max-width:100%; max-height:150px; border-radius:8px; display:block; object-fit:cover;">
                    </div>
                <?php endif; ?>
                <input type="file" name="imagen" accept=".jpg,.jpeg,.png,.webp,.gif">
                <?php if ($edit_mode): ?>
                    <input type="hidden" name="imagen_actual" value="<?php echo htmlspecialchars($edit_imagen); ?>">
                <?php endif; ?>
                <small style="color:#6b7280; font-size:0.75rem; margin-top:4px;">Formatos: JPG, JPEG, PNG, WEBP, GIF | Tamaño recomendado: 800x400px</small>
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

    <h3 class="section-title"><i class="fas fa-history"></i> Historial de Publicaciones</h3>
    
    <div class="grid-publicaciones">
        <?php
        $res = mysqli_query($conn, "SELECT * FROM publicaciones ORDER BY id DESC");
        if ($res && mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $fecha_formateada = (!empty($row['fecha_creacion'])) ? date('d/m/Y', strtotime($row['fecha_creacion'])) : 'Reciente';

                echo "<div class='post-item'>";
                
                // IMAGEN
                if (!empty($row['imagen']) && file_exists($row['imagen'])) {
                    echo "<div class='img-container'>";
                    echo "<img src='" . htmlspecialchars($row['imagen']) . "' alt='" . htmlspecialchars($row['titulo']) . "'>";
                    echo "</div>";
                } else {
                    echo "<div class='img-container' style='display:flex; align-items:center; justify-content:center; color:#9ca3af; font-size:0.8rem;'>";
                    echo "<i class='fas fa-image' style='font-size:2rem; opacity:0.3;'></i>";
                    echo "</div>";
                }
                
                echo "<div class='info'>";
                echo "<h4>" . htmlspecialchars($row['titulo']) . "</h4>";
                echo "<small><i class='far fa-calendar-alt'></i> " . $fecha_formateada . " | <i class='far fa-user'></i> " . htmlspecialchars($row['autor']) . "</small>";
                echo "<p>" . htmlspecialchars(substr(strip_tags($row['contenido']), 0, 120)) . "...</p>";
                echo "<div class='post-actions'>";
                echo "<a href='admin_publicaciones.php?editar=" . $row['id'] . "' class='btn-edit'><i class='fas fa-edit'></i> Editar</a>";
                echo "<a href='admin_publicaciones.php?eliminar=" . $row['id'] . "' class='btn-delete' onclick='return confirm(\"¿Deseas eliminar esta publicación?\");'><i class='fas fa-trash-alt'></i> Eliminar</a>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<div class='sin-publicaciones'>📭 No hay publicaciones registradas aún.</div>";
        }
        ?>
    </div>

</body>
</html>