<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
include("db.php");

$mensaje = "";

// Crear carpeta uploads si no existe
if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}

// ==========================================
// ACCIÓN: SUBIR NUEVA IMAGEN
// ==========================================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['subir_imagen'])) {
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo'] ?? 'Radio Pakal');
    
    if (isset($_FILES['foto_carrusel']) && $_FILES['foto_carrusel']['error'] == 0) {
        $filename = $_FILES['foto_carrusel']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (!in_array($ext, $allowed_extensions)) {
            $mensaje = "<div class='alert error'>❌ Formato no permitido. Usa JPG, JPEG, PNG, GIF o WEBP.</div>";
        } elseif ($_FILES['foto_carrusel']['size'] > 5000000) {
            $mensaje = "<div class='alert error'>❌ La imagen no debe superar los 5MB.</div>";
        } else {
            $nuevo_nombre = "carrusel_" . time() . "_" . uniqid() . "." . $ext;
            $ruta_destino = "uploads/" . $nuevo_nombre;
            
            if (move_uploaded_file($_FILES['foto_carrusel']['tmp_name'], $ruta_destino)) {
                $query = "INSERT INTO carrusel (titulo, ruta_imagen) VALUES ('$titulo', '$ruta_destino')";
                if (mysqli_query($conn, $query)) {
                    $mensaje = "<div class='alert success'>📸 Imagen subida correctamente.</div>";
                } else {
                    $mensaje = "<div class='alert error'>❌ Error al guardar en la BD: " . mysqli_error($conn) . "</div>";
                }
            } else {
                $mensaje = "<div class='alert error'>❌ Error al mover el archivo al servidor.</div>";
            }
        }
    } else {
        $mensaje = "<div class='alert error'>❌ Por favor selecciona una imagen válida.</div>";
    }
}

// ==========================================
// ACCIÓN: ACTUALIZAR TÍTULO DE IMAGEN
// ==========================================
if (isset($_POST['actualizar_titulo'])) {
    $id = intval($_POST['id'] ?? 0);
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo'] ?? '');
    
    if ($id > 0 && !empty($titulo)) {
        $query = "UPDATE carrusel SET titulo = '$titulo' WHERE id = $id";
        if (mysqli_query($conn, $query)) {
            $mensaje = "<div class='alert success'>✏️ Título actualizado correctamente.</div>";
        } else {
            $mensaje = "<div class='alert error'>❌ Error al actualizar el título: " . mysqli_error($conn) . "</div>";
        }
    } else {
        $mensaje = "<div class='alert error'>❌ Datos incompletos para actualizar.</div>";
    }
}

// ==========================================
// ACCIÓN: ELIMINAR IMAGEN
// ==========================================
if (isset($_GET['eliminar'])) {
    $id_eliminar = (int)$_GET['eliminar'];
    
    $res_img = mysqli_query($conn, "SELECT ruta_imagen FROM carrusel WHERE id = $id_eliminar");
    if ($row_img = mysqli_fetch_assoc($res_img)) {
        if (!empty($row_img['ruta_imagen']) && file_exists($row_img['ruta_imagen'])) {
            unlink($row_img['ruta_imagen']); 
        }
    }
    
    mysqli_query($conn, "DELETE FROM carrusel WHERE id = $id_eliminar");
    header("Location: admin_carrusel.php");
    exit();
}

$imagenes_carrusel = mysqli_query($conn, "SELECT * FROM carrusel ORDER BY id DESC");

// ==========================================
// OBTENER DATOS PARA EDITAR (si se pasa editar)
// ==========================================
$edit_mode = false;
$edit_id = "";
$edit_titulo = "";

if (isset($_GET['editar'])) {
    $id_editar = intval($_GET['editar']);
    if ($id_editar > 0) {
        $res_edit = mysqli_query($conn, "SELECT * FROM carrusel WHERE id = $id_editar");
        if ($res_edit && mysqli_num_rows($res_edit) > 0) {
            $row_edit = mysqli_fetch_assoc($res_edit);
            $edit_mode = true;
            $edit_id = $row_edit['id'];
            $edit_titulo = $row_edit['titulo'] ?? '';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Carrusel | Radio Pakal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #f8f5f0; padding: 30px; color: #1a1a2e; }
        
        /* ========================================
           ENCABEZADO - IGUAL QUE PUBLICACIONES
        ======================================== */
        .header-modulo { 
            background: #0099FF; 
            color: white; 
            padding: 20px; 
            border-radius: 12px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 25px; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.05); 
        }
        .header-modulo h2 { 
            font-size: 1.4rem; 
            font-weight: 700; 
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .header-modulo h2 i { color: white; }
        .header-modulo a { 
            color: white; 
            text-decoration: none; 
            font-weight: 600; 
            background: rgba(255,255,255,0.15); 
            padding: 10px 18px; 
            border-radius: 8px; 
            transition: background 0.2s; 
            font-size: 0.9rem; 
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .header-modulo a:hover { background: rgba(255,255,255,0.25); }
        
        /* ========================================
           FORMULARIO - IGUAL QUE PUBLICACIONES
        ======================================== */
        .form-container { 
            background: white; 
            padding: 25px; 
            border-radius: 12px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.03); 
            margin-bottom: 30px; 
            border-top: 4px solid #0099FF; 
        }
        .form-container h3 { 
            color: #0099FF; 
            font-size: 1.25rem; 
            margin-bottom: 20px; 
        }
        
        .form-group { 
            margin-bottom: 18px; 
            display: flex; 
            flex-direction: column; 
        }
        .form-group label { 
            font-weight: 600; 
            margin-bottom: 8px; 
            font-size: 0.9rem; 
            color: #444; 
        }
        .form-group input[type="text"], 
        .form-group input[type="file"] { 
            padding: 12px; 
            border: 1px solid #ddd; 
            border-radius: 8px; 
            font-size: 0.95rem; 
            outline: none; 
            transition: border-color 0.2s; 
            color: #333; 
            width: 100%;
            background: #fafafa;
        }
        .form-group input:focus { 
            border-color: #0099FF; 
            background: #fff; 
        }
        .form-group small {
            color: #6b7280;
            font-size: 0.75rem;
            margin-top: 4px;
        }
        
        .btn-submit { 
            background: #0099FF; 
            color: white; 
            border: none; 
            padding: 12px 25px; 
            border-radius: 8px; 
            font-weight: 600; 
            cursor: pointer; 
            font-size: 0.95rem; 
            transition: background 0.2s; 
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-submit:hover { background: #0077CC; }
        .btn-update { background: #D4AF37; color: #1a1a2e; }
        .btn-update:hover { background: #bfa032; }
        .btn-cancel { 
            background: #e2e8f0; 
            color: #4a5568; 
            text-decoration: none; 
            padding: 12px 25px; 
            border-radius: 8px; 
            font-weight: 600; 
            font-size: 0.95rem; 
            display: inline-block; 
            margin-left: 10px; 
            transition: background 0.2s; 
        }
        .btn-cancel:hover { background: #cbd5e1; }
        
        /* ========================================
           ALERTAS - IGUAL QUE PUBLICACIONES
        ======================================== */
        .alert { 
            padding: 15px; 
            border-radius: 8px; 
            margin-bottom: 22px; 
            font-weight: 600; 
            font-size: 0.95rem; 
        }
        .success { 
            background: #c6f6d5; 
            color: #22543d; 
            border: 1px solid #9ae6b4; 
        }
        .error { 
            background: #fed7d7; 
            color: #742a2a; 
            border: 1px solid #feb2b2; 
        }
        
        /* ========================================
           TÍTULO DE SECCIÓN
        ======================================== */
        .section-title { 
            color: #1a1a2e; 
            font-size: 1.3rem; 
            font-weight: 700; 
            margin-bottom: 20px; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
        }
        .section-title i { color: #0099FF; }
        
        /* ========================================
           GRID DE IMÁGENES
        ======================================== */
        .grid-imagenes { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
            gap: 25px; 
            margin-top: 15px;
        }
        
        .img-card { 
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
        
        .img-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }
        
        .img-card .img-container { 
            width: 100%; 
            height: 200px; 
            overflow: hidden;
            background: #f3f4f6;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .img-card .img-container img { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
            display: block; 
        }
        
        .img-card .info { 
            padding: 15px; 
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .img-card .info .titulo { 
            margin: 0 0 4px 0; 
            color: #0d47a1; 
            font-size: 1rem; 
            font-weight: 700; 
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .img-card .info small { 
            color: #718096; 
            font-size: 0.75rem; 
            margin-bottom: 8px; 
            display: block;
        }
        
        .post-actions { 
            margin-top: auto; 
            text-align: right; 
            padding-top: 10px;
            border-top: 1px solid #f3f4f6;
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            flex-wrap: wrap;
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
        .btn-edit:hover { background: #15803d; }
        .btn-delete { background: #dc2626; color: #ffffff; }
        .btn-delete:hover { background: #b91c1c; }

        .sin-imagenes { 
            color: #6b7280; 
            font-style: italic; 
            padding: 30px; 
            text-align: center; 
            background: #f9fafb; 
            border-radius: 12px;
            grid-column: 1 / -1;
        }

        /* ========================================
           MODAL DE EDICIÓN
        ======================================== */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.active { display: flex; }
        .modal-content {
            background: white;
            border-radius: 12px;
            padding: 30px;
            max-width: 500px;
            width: 90%;
            position: relative;
        }
        .modal-content h3 { 
            color: #0099FF; 
            margin-bottom: 20px; 
            font-size: 1.25rem;
        }
        .modal-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            flex-wrap: wrap;
        }

        /* ========================================
           RESPONSIVE
        ======================================== */
        @media (max-width: 768px) {
            body { padding: 15px; }
            .header-modulo { flex-direction: column; gap: 10px; text-align: center; }
            .grid-imagenes { 
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); 
                gap: 15px;
            }
            .img-card .img-container { height: 160px; }
        }

        @media (max-width: 480px) {
            .grid-imagenes { 
                grid-template-columns: 1fr 1fr; 
                gap: 12px;
            }
            .img-card .img-container { height: 130px; }
            .img-card .info .titulo { font-size: 0.85rem; }
            .post-actions a { font-size: 0.65rem; padding: 4px 8px; }
        }
    </style>
</head>
<body>

    <!-- ========================================
    ENCABEZADO - IGUAL QUE PUBLICACIONES
    ======================================== -->
    <div class="header-modulo">
        <h2><i class="fas fa-images"></i> Gestor de Imágenes del Carrusel</h2>
        <a href="admin.php"><i class="fas fa-arrow-left"></i> Volver al Menú</a>
    </div>

    <?php echo $mensaje; ?>

    <!-- ========================================
    FORMULARIO - IGUAL QUE PUBLICACIONES
    ======================================== -->
    <div class="form-container">
        <h3>📸 Subir Nueva Imagen</h3>
        
        <form action="admin_carrusel.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Seleccionar Archivo:</label>
                <input type="file" name="foto_carrusel" accept=".jpg,.jpeg,.png,.gif,.webp" required>
                <small>Formatos: JPG, JPEG, PNG, GIF, WEBP | Máximo 5MB</small>
            </div>
            <div class="form-group">
                <label>Título o descripción corta:</label>
                <input type="text" name="titulo" placeholder="Ej. Transmisión Especial del Día" value="Radio Pakal 1040 AM">
            </div>
            <button type="submit" name="subir_imagen" class="btn-submit"><i class="fas fa-upload"></i> Subir al Carrusel</button>
        </form>
    </div>

    <!-- ========================================
    LISTA DE IMÁGENES CON BOTÓN EDITAR
    ======================================== -->
    <h3 class="section-title"><i class="fas fa-images"></i> Imágenes Activas</h3>
    
    <div class="grid-imagenes">
        <?php if (mysqli_num_rows($imagenes_carrusel) > 0): ?>
            <?php while($img = mysqli_fetch_assoc($imagenes_carrusel)): ?>
                <div class="img-card">
                    <div class="img-container">
                        <img src="<?php echo htmlspecialchars($img['ruta_imagen']); ?>" alt="<?php echo htmlspecialchars($img['titulo']); ?>">
                    </div>
                    <div class="info">
                        <div class="titulo"><?php echo htmlspecialchars($img['titulo']); ?></div>
                        <small><i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y', filemtime($img['ruta_imagen'])); ?></small>
                        <div class="post-actions">
                            <a href="admin_carrusel.php?editar=<?php echo $img['id']; ?>" class="btn-edit" onclick="event.preventDefault(); abrirModal(<?php echo $img['id']; ?>, '<?php echo htmlspecialchars(addslashes($img['titulo'])); ?>');">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="admin_carrusel.php?eliminar=<?php echo $img['id']; ?>" class="btn-delete" onclick="return confirm('¿Eliminar esta imagen del carrusel?')">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="sin-imagenes">📭 No hay imágenes en el carrusel. Sube una nueva.</div>
        <?php endif; ?>
    </div>

    <!-- ========================================
    MODAL DE EDICIÓN
    ======================================== -->
    <div class="modal-overlay" id="editModal">
        <div class="modal-content">
            <h3>✏️ Editar Título de Imagen</h3>
            <form action="admin_carrusel.php" method="POST">
                <input type="hidden" name="id" id="edit_id" value="">
                <div class="form-group">
                    <label>Título:</label>
                    <input type="text" name="titulo" id="edit_titulo" value="" required>
                </div>
                <div class="modal-actions">
                    <button type="submit" name="actualizar_titulo" class="btn-submit btn-update"><i class="fas fa-save"></i> Guardar</button>
                    <button type="button" class="btn-cancel" onclick="cerrarModal()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // ==========================================
        // MODAL DE EDICIÓN
        // ==========================================
        function abrirModal(id, titulo) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_titulo').value = titulo;
            document.getElementById('editModal').classList.add('active');
        }

        function cerrarModal() {
            document.getElementById('editModal').classList.remove('active');
        }

        // Cerrar modal con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                cerrarModal();
            }
        });

        // Cerrar modal al hacer clic fuera
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                cerrarModal();
            }
        });
    </script>

</body>
</html>