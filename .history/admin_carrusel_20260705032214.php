<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
include("db.php");

$mensaje = "";

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
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        
        $nuevo_nombre = "carrusel_" . time() . "." . $ext;
        $ruta_destino = "uploads/" . $nuevo_nombre;
        
        if (move_uploaded_file($_FILES['foto_carrusel']['tmp_name'], $ruta_destino)) {
            // Insertar usando las columnas reales: titulo y ruta_imagen
            $query = "INSERT INTO carrusel (titulo, ruta_imagen) VALUES ('$titulo', '$ruta_destino')";
            if (mysqli_query($conn, $query)) {
                $mensaje = "<div class='alert-success'>Imagen subida correctamente.</div>";
            } else {
                $mensaje = "<div class='alert-error'>Error al guardar en la BD: " . mysqli_error($conn) . "</div>";
            }
        } else {
            $mensaje = "<div class='alert-error'>Error al mover el archivo al servidor.</div>";
        }
    } else {
        $mensaje = "<div class='alert-error'>Por favor selecciona una imagen válida.</div>";
    }
}

// ==========================================
// ACCIÓN: ELIMINAR IMAGEN
// ==========================================
if (isset($_GET['eliminar'])) {
    $id_eliminar = (int)$_GET['eliminar'];
    
    $res_img = mysqli_query($conn, "SELECT ruta_imagen FROM carrusel WHERE id = $id_eliminar");
    if ($row_img = mysqli_fetch_assoc($res_img)) {
        if (file_exists($row_img['ruta_imagen'])) {
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
        body { font-family: sans-serif; background: #f4f6f9; margin: 0; padding: 20px; color: #333; }
        .container-admin { max-width: 900px; margin: 0 auto; }
        .btn-back { display: inline-block; background: #333; color: white; padding: 10px 15px; text-decoration: none; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem; }
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 25px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; font-size: 0.9rem; }
        input[type="text"], input[type="file"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; }
        .btn-save { background: #0099FF; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: bold; }
        .btn-save:hover { background: #0077CC; }
        .alert-success { background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 15px; }
        .alert-error { background: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 15px; }
        .grid-imagenes { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 20px; align-items: start; }
        .img-card { background: white; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; position: relative; text-align: center; padding-bottom: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .img-card img { width: 100%; height: 180px; object-fit: cover; display: block; }
        .btn-delete { display: inline-block; background: #dc3545; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 0.8rem; margin-top: 10px; font-weight: bold; }
        .btn-delete:hover { background: #c82333; }
    </style>
</head>
<body>
<div class="container-admin">
    <a href="admin.php" class="btn-back"><i class="fas fa-arrow-left"></i> Volver al Panel Principal</a>
    
    <h2><i class="fas fa-images"></i> Gestor de Imágenes del Carrusel</h2>
    <?php echo $mensaje; ?>

    <div class="card">
        <h3>Subir Nueva Imagen</h3>
        <form action="admin_carrusel.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="foto_carrusel">Seleccionar Archivo:</label>
                <input type="file" id="foto_carrusel" name="foto_carrusel" required>
            </div>
            <div class="form-group">
                <label for="titulo">Título o descripción corta de la foto:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Ej. Transmisión Especial del Día">
            </div>
            <button type="submit" name="subir_imagen" class="btn-save"><i class="fas fa-upload"></i> Subir al Carrusel</button>
        </form>
    </div>

    <h3>Imágenes Activas en el Sitio</h3>
    <div class="grid-imagenes">
        <?php if (mysqli_num_rows($imagenes_carrusel) > 0): ?>
            <?php while($img = mysqli_fetch_assoc($imagenes_carrusel)): ?>
                <div class="img-card">
                    <img src="<?php echo htmlspecialchars($img['ruta_imagen']); ?>" alt="">
                    <p style="font-size:0.8rem; margin: 8px 5px 0; color:#555; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
                        <?php echo htmlspecialchars($img['titulo']); ?>
                    </p>
                    <a href="admin_carrusel.php?eliminar=<?php echo $img['id']; ?>" class="btn-delete" onclick="return confirm('¿Estás seguro de eliminar esta foto?')"><i class="fas fa-trash-alt"></i> Eliminar</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="color: #777;">No hay imágenes en el carrusel.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>