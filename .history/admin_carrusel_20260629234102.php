<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
include("db.php");

$mensaje = "";

// Directorio donde se guardarán físicamente las imágenes
// Ruta en el sistema de archivos donde se guardarán las imágenes
$directorio_subida = __DIR__ . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;
// Ruta relativa (para guardar en DB y usar en <img src=>)
$directorio_publica = "uploads/";

// Crear la carpeta si no existe automáticamente
if (!file_exists($directorio_subida)) {
    mkdir($directorio_subida, 0777, true);
}

// --- ACCIÓN 1: SUBIR NUEVA IMAGEN ---
if (isset($_POST['subir_imagen'])) {
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    
    // Validar si se seleccionó un archivo
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $nombre_archivo = basename($_FILES['imagen']['name']);
        $tipo_archivo = strtolower(pathinfo($nombre_archivo, PATHINFO_EXTENSION));
        
        // Generar un nombre único para evitar que imágenes con el mismo nombre se borren entre sí
        $nuevo_nombre = "carrusel_" . uniqid() . "." . $tipo_archivo;
        // Ruta física (servidor) y ruta pública (web)
        $ruta_destino_fs = $directorio_subida . $nuevo_nombre;
        $ruta_destino_db = $directorio_publica . $nuevo_nombre;
        
        // Validar que sea un formato de imagen permitido
        $formatos_permitidos = array("jpg", "jpeg", "png", "gif", "webp");
        
        if (in_array($tipo_archivo, $formatos_permitidos)) {
            // Mover el archivo de la carpeta temporal a nuestra carpeta de destino
            if (is_uploaded_file($_FILES['imagen']['tmp_name']) && move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino_fs)) {
                
                // Insertar en la Base de Datos la ruta de la imagen
                $query = "INSERT INTO carrusel (titulo, ruta_imagen) VALUES ('$titulo', '$ruta_destino_db')";
                if (mysqli_query($conn, $query)) {
                    // Redirigir para evitar reenvío de formulario y mostrar el nuevo elemento
                    header("Location: admin_carrusel.php");
                    exit();
                } else {
                    $mensaje = "<div class='alert error'>❌ Error al guardar en la base de datos: " . mysqli_error($conn) . "</div>";
                }
                
            } else {
                $mensaje = "<div class='alert error'>❌ Error al mover el archivo al servidor. Verifica permisos de la carpeta.</div>";
            }
        } else {
            $mensaje = "<div class='alert error'>❌ Formato no permitido. Solo se aceptan: JPG, JPEG, PNG, GIF y WEBP.</div>";
        }
    } else {
        $mensaje = "<div class='alert error'>❌ Por favor, selecciona una imagen válida.</div>";
    }
}

// --- ACCIÓN 2: ELIMINAR IMAGEN ---
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    
    // Primero buscamos la ruta de la imagen para borrar el archivo físico del servidor
    $res_buscar = mysqli_query($conn, "SELECT ruta_imagen FROM carrusel WHERE id = $id");
    if ($res_buscar && mysqli_num_rows($res_buscar) > 0) {
        $row = mysqli_fetch_assoc($res_buscar);
        $ruta_archivo = $row['ruta_imagen'];
        
        // Borrar el archivo físico si existe
        // Eliminar archivo físico si existe (ruta almacenada en DB es relativa)
        $ruta_archivo_fs = __DIR__ . DIRECTORY_SEPARATOR . $ruta_archivo;
        if (file_exists($ruta_archivo_fs)) {
            unlink($ruta_archivo_fs);
        }
        
        // Borrar el registro en la base de datos
        $query_borrar = "DELETE FROM carrusel WHERE id = $id";
        if (mysqli_query($conn, $query_borrar)) {
            // Redirigir para actualizar la lista
            header("Location: admin_carrusel.php");
            exit();
        } else {
            $mensaje = "<div class='alert error'>❌ Error al eliminar el registro de la base de datos.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Carrusel | Radio Pakal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: sans-serif; background: #f4f6f9; margin: 0; padding: 20px; color: #333; }
        .header-modulo { background: #1a1a2e; color: white; padding: 15px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .header-modulo a { color: white; text-decoration: none; font-weight: bold; background: rgba(255,255,255,0.1); padding: 8px 15px; border-radius: 5px; }
        .form-container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 25px; border-top: 4px solid #D4AF37; }
        .form-inline { display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end; }
        .form-group { display: flex; flex-direction: column; }
        .form-group label { font-weight: bold; margin-bottom: 5px; font-size: 0.9rem; }
        .form-group input[type="text"], .form-group input[type="file"] { padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem; background: #fafafa; }
        .btn-submit { background: #1a1a2e; color: white; border: none; padding: 11px 20px; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 1rem; }
        
        /* Estilos de la Cuadrícula de Fotos */
        .grid-fotos { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin-top: 15px; }
        .card-foto { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 3px 6px rgba(0,0,0,0.05); border: 1px solid #ddd; display: flex; flex-direction: column; justify-content: space-between; }
        .card-foto img { width: 100%; height: 130px; object-fit: cover; background: #eaeaea; }
        .card-foto-info { padding: 10px; text-align: center; }
        .card-foto-info h4 { margin: 0 0 10px 0; font-size: 0.95rem; color: #333; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .btn-delete { display: block; background: #8B2C2D; color: white; text-decoration: none; padding: 6px; font-size: 0.85rem; font-weight: bold; border-radius: 4px; }
        
        .alert { padding: 12px; border-radius: 5px; margin-bottom: 15px; font-weight: bold; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

    <div class="header-modulo">
        <h2><i class="fas fa-images"></i> Administrador de Fotos del Carrusel Principal</h2>
        <a href="admin.php"><i class="fas fa-arrow-left"></i> Volver al Menú</a>
    </div>

    <?php echo $mensaje; ?>

    <div class="form-container">
        <h3>➕ Subir una Nueva Imagen a la Marquesina</h3>
        <p style="font-size: 0.85rem; color: #666; margin-top:0;">*Se recomienda que las imágenes tengan dimensiones panorámicas (ej: 1200x400 píxeles) para que luzcan perfectas.</p>
        <br>
        <form action="admin_carrusel.php" method="POST" enctype="multipart/form-data" class="form-inline">
            
            <div class="form-group" style="flex: 1; min-width: 220px;">
                <label>Descripción / Título de la Imagen:</label>
                <input type="text" name="titulo" placeholder="Ej: Transmisión Especial del Aniversario" required>
            </div>

            <div class="form-group">
                <label>Selecciona el Archivo:</label>
                <input type="file" name="imagen" accept="image/*" required>
            </div>

            <div>
                <button type="submit" name="subir_imagen" class="btn-submit"><i class="fas fa-upload"></i> Subir y Publicar</button>
            </div>
        </form>
    </div>

    <h3><i class="fas fa-images"></i> Fotos actualmente visibles en el Carrusel</h3>
    
    <div class="grid-fotos">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM carrusel ORDER BY id DESC");
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='card-foto'>";
                echo "<img src='" . htmlspecialchars($row['ruta_imagen']) . "' alt='Foto Carrusel'>";
                echo "<div class='card-foto-info'>";
                echo "<h4>" . htmlspecialchars($row['titulo']) . "</h4>";
                echo "<a href='admin_carrusel.php?eliminar=" . $row['id'] . "' class='btn-delete' onclick='return confirm(\"¿Estás seguro de quitar esta imagen del carrusel público?\");'><i class='fas fa-trash-alt'></i> Eliminar Foto</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p style='color: #777; font-style: italic; grid-column: 1/-1;'>No hay fotos cargadas. El sitio mostrará imágenes por defecto.</p>";
        }
        ?>
    </div>

</body>
</html>