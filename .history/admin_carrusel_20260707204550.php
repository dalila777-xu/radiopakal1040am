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
            $mensaje = "<div class='alert-error'>❌ Formato no permitido. Usa JPG, JPEG, PNG, GIF o WEBP.</div>";
        } elseif ($_FILES['foto_carrusel']['size'] > 5000000) {
            $mensaje = "<div class='alert-error'>❌ La imagen no debe superar los 5MB.</div>";
        } else {
            $nuevo_nombre = "carrusel_" . time() . "_" . uniqid() . "." . $ext;
            $ruta_destino = "uploads/" . $nuevo_nombre;
            
            if (move_uploaded_file($_FILES['foto_carrusel']['tmp_name'], $ruta_destino)) {
                $query = "INSERT INTO carrusel (titulo, ruta_imagen) VALUES ('$titulo', '$ruta_destino')";
                if (mysqli_query($conn, $query)) {
                    $mensaje = "<div class='alert-success'>📸 Imagen subida correctamente.</div>";
                } else {
                    $mensaje = "<div class='alert-error'>❌ Error al guardar en la BD: " . mysqli_error($conn) . "</div>";
                }
            } else {
                $mensaje = "<div class='alert-error'>❌ Error al mover el archivo al servidor.</div>";
            }
        }
    } else {
        $mensaje = "<div class='alert-error'>❌ Por favor selecciona una imagen válida.</div>";
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Carrusel | Radio Pakal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #f8f5f0; padding: 30px; color: #1a1a2e; }
        
        .container-admin { max-width: 1000px; margin: 0 auto; }
        
        .btn-back { 
            display: inline-block; 
            background: #1a1a2e; 
            color: white; 
            padding: 10px 18px; 
            text-decoration: none; 
            border-radius: 8px; 
            margin-bottom: 20px; 
            font-size: 0.9rem; 
            font-weight: 600; 
            transition: background 0.3s; 
        }
        .btn-back:hover { background: #2d2d44; }
        
        .card { 
            background: white; 
            padding: 25px; 
            border-radius: 12px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.05); 
            margin-bottom: 25px; 
            border-top: 4px solid #D4AF37; 
        }
        .card h3 { color: #0d47a1; margin-bottom: 15px; font-size: 1.3rem; }
        
        .form-group { margin-bottom: 15px; }
        label { 
            display: block; 
            font-weight: 600; 
            margin-bottom: 5px; 
            font-size: 0.9rem; 
            color: #444; 
        }
        input[type="text"], input[type="file"] { 
            width: 100%; 
            padding: 10px; 
            border: 1px solid #ddd; 
            border-radius: 6px; 
            font-size: 0.95rem; 
            background: #fafafa; 
            transition: border-color 0.3s; 
        }
        input[type="text"]:focus, input[type="file"]:focus { 
            border-color: #0d47a1; 
            outline: none; 
            background: #fff; 
        }
        
        .btn-save { 
            background: #0d47a1; 
            color: white; 
            border: none; 
            padding: 12px 25px; 
            border-radius: 8px; 
            cursor: pointer; 
            font-weight: 600; 
            font-size: 0.95rem; 
            transition: background 0.3s; 
        }
        .btn-save:hover { background: #0a3a7a; }
        
        .alert-success { 
            background: #d4edda; 
            color: #155724; 
            padding: 12px 15px; 
            border-radius: 6px; 
            margin-bottom: 15px; 
            border: 1px solid #c3e6cb; 
            font-weight: 600; 
        }
        .alert-error { 
            background: #f8d7da; 
            color: #721c24; 
            padding: 12px 15px; 
            border-radius: 6px; 
            margin-bottom: 15px; 
            border: 1px solid #f5c6cb; 
            font-weight: 600; 
        }
        
        /* ========================================
           GRID DE IMÁGENES - ESTILO MEJORADO
        ======================================== */
        .grid-imagenes { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); 
            gap: 25px; 
            margin-top: 15px;
        }
        
        .img-card { 
            background: white; 
            border: 1px solid #e5e7eb; 
            border-radius: 12px; 
            overflow: hidden; 
            position: relative; 
            text-align: center; 
            padding-bottom: 15px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.04); 
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .img-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }
        
        .img-card img { 
            width: 100%; 
            height: 200px; 
            object-fit: cover; 
            display: block; 
            background: #e5e7eb;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .img-card .info { 
            padding: 12px 15px; 
        }
        
        .img-card .info .titulo { 
            font-size: 0.9rem; 
            color: #1f2937; 
            font-weight: 600;
            margin: 0 0 8px 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .btn-delete { 
            display: inline-block; 
            background: #dc2626; 
            color: white; 
            padding: 8px 16px; 
            text-decoration: none; 
            border-radius: 6px; 
            font-size: 0.8rem; 
            font-weight: 600; 
            transition: background 0.3s;
            border: none;
            cursor: pointer;
        }
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
           RESPONSIVE
        ======================================== */
        @media (max-width: 768px) {
            body { padding: 15px; }
            .grid-imagenes { 
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); 
                gap: 15px;
            }
            .img-card img { height: 160px; }
        }

        @media (max-width: 480px) {
            .grid-imagenes { 
                grid-template-columns: 1fr 1fr; 
                gap: 12px;
            }
            .img-card img { height: 130px; }
            .img-card .info .titulo { font-size: 0.75rem; }
            .btn-delete { font-size: 0.65rem; padding: 5px 10px; }
        }
    </style>
</head>
<body>
<div class="container-admin">
    <a href="admin.php" class="btn-back"><i class="fas fa-arrow-left"></i> Volver al Panel Principal</a>
    
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; margin-bottom:20px;">
        <h2 style="color:#0d47a1;"><i class="fas fa-images"></i> Gestor de Imágenes del Carrusel</h2>
        <span style="font-size:0.85rem; color:#6b7280;"><?php echo mysqli_num_rows($imagenes_carrusel); ?> imágenes</span>
    </div>
    
    <?php echo $mensaje; ?>

    <!-- FORMULARIO PARA SUBIR -->
    <div class="card">
        <h3>📸 Subir Nueva Imagen</h3>
        <form action="admin_carrusel.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="foto_carrusel">Seleccionar Archivo:</label>
                <input type="file" id="foto_carrusel" name="foto_carrusel" accept=".jpg,.jpeg,.png,.gif,.webp" required>
                <small style="color:#6b7280; font-size:0.75rem; margin-top:4px;">Formatos: JPG, JPEG, PNG, GIF, WEBP | Máximo 5MB</small>
            </div>
            <div class="form-group">
                <label for="titulo">Título o descripción corta:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Ej. Transmisión Especial del Día" value="Radio Pakal 1040 AM">
            </div>
            <button type="submit" name="subir_imagen" class="btn-save"><i class="fas fa-upload"></i> Subir al Carrusel</button>
        </form>
    </div>

    <!-- LISTA DE IMÁGENES -->
    <h3 style="color:#0d47a1; margin-bottom:15px;"><i class="fas fa-images"></i> Imágenes Activas</h3>
    
    <div class="grid-imagenes">
        <?php if (mysqli_num_rows($imagenes_carrusel) > 0): ?>
            <?php while($img = mysqli_fetch_assoc($imagenes_carrusel)): ?>
                <div class="img-card">
                    <img src="<?php echo htmlspecialchars($img['ruta_imagen']); ?>" alt="<?php echo htmlspecialchars($img['titulo']); ?>">
                    <div class="info">
                        <div class="titulo"><?php echo htmlspecialchars($img['titulo']); ?></div>
                        <a href="admin_carrusel.php?eliminar=<?php echo $img['id']; ?>" class="btn-delete" onclick="return confirm('¿Eliminar esta imagen del carrusel?')">
                            <i class="fas fa-trash-alt"></i> Eliminar
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="sin-imagenes">📭 No hay imágenes en el carrusel. Sube una nueva.</div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>