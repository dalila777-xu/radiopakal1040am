Aquí tienes el archivo **`admin_carrusel.php`** completamente reestructurado, unificado y corregido.

Se integró la lógica interna de tu backend PHP junto con los estilos profesionales de la paleta oficial (**Rojo Vino, Negro, Blanco y detalles Dorados**), se añadió la zona interactiva de **Vista Previa Panorámica** mediante JavaScript, y se aplicaron las reglas CSS (`object-fit: cover;`) para garantizar que tanto las miniaturas como la previsualización adapten cualquier formato de imagen a la medida solicitada sin deformarla.

Reemplaza todo el contenido de tu archivo por el siguiente código limpio:

```php
<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
include("db.php");

$mensaje = "";

// Directorio donde se guardarán físicamente las imágenes
$directorio_subida = "uploads/";

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
        
        // Generar un nombre único para evitar sobreescrituras
        $nuevo_nombre = "carrusel_" . uniqid() . "." . $tipo_archivo;
        $ruta_destino = $directorio_subida . $nuevo_nombre;
        
        // Validar formatos permitidos
        $formatos_permitidos = array("jpg", "jpeg", "png", "gif", "webp");
        
        if (in_array($tipo_archivo, $formatos_permitidos)) {
            // Mover el archivo de la carpeta temporal a la de destino
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino)) {
                
                // Insertar en la Base de Datos
                $query = "INSERT INTO carrusel (titulo, ruta_imagen) VALUES ('$titulo', '$ruta_destino')";
                if (mysqli_query($conn, $query)) {
                    $mensaje = "<div class='alert success'><i class='fas fa-check-circle'></i> 📸 Imagen subida correctamente y agregada al carrusel activo.</div>";
                } else {
                    $mensaje = "<div class='alert error'><i class='fas fa-exclamation-triangle'></i> Error al guardar en la base de datos: " . mysqli_error($conn) . "</div>";
                }
                
            } else {
                $mensaje = "<div class='alert error'><i class='fas fa-exclamation-triangle'></i> Error al mover el archivo al servidor. Verifica los permisos de la carpeta 'uploads/'.</div>";
            }
        } else {
            $mensaje = "<div class='alert error'><i class='fas fa-exclamation-triangle'></i> Formato no permitido. Solo se aceptan: JPG, JPEG, PNG, GIF y WEBP.</div>";
        }
    } else {
        $mensaje = "<div class='alert error'><i class='fas fa-exclamation-triangle'></i> Por favor, selecciona un archivo de imagen válido.</div>";
    }
}

// --- ACCIÓN 2: ELIMINAR IMAGEN ---
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    
    // Buscar la ruta física para removerlo del almacenamiento
    $res_buscar = mysqli_query($conn, "SELECT ruta_imagen FROM carrusel WHERE id = $id");
    if ($res_buscar && mysqli_num_rows($res_buscar) > 0) {
        $row = mysqli_fetch_assoc($res_buscar);
        $ruta_archivo = $row['ruta_imagen'];
        
        // Borrar archivo del servidor si existe
        if (file_exists($ruta_archivo)) {
            unlink($ruta_archivo);
        }
        
        // Borrar de la base de datos
        $query_borrar = "DELETE FROM carrusel WHERE id = $id";
        if (mysqli_query($conn, $query_borrar)) {
            $mensaje = "<div class='alert success'><i class='fas fa-trash-alt'></i> Imagen eliminada con éxito del carrusel público.</div>";
        } else {
            $mensaje = "<div class='alert error'><i class='fas fa-exclamation-triangle'></i> Error al eliminar el registro de la base de datos.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Carrusel | Radio Pakal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Base y Tipografía */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #f8f5f0; padding: 25px; color: #1a1a2e; line-height: 1.5; }
        
        /* Encabezado */
        .header-modulo { background: #8B2C2D; color: white; padding: 1.2rem 1.5rem; border-radius: 10px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .header-modulo h2 { font-size: 1.3rem; font-weight: 600; display: flex; align-items: center; gap: 10px; }
        .header-modulo a { color: white; text-decoration: none; font-weight: 600; background: rgba(255,255,255,0.15); padding: 8px 16px; border-radius: 6px; font-size: 0.9rem; transition: background 0.2s; display: flex; align-items: center; gap: 8px; }
        .header-modulo a:hover { background: rgba(255,255,255,0.25); }

        /* Alertas */
        .alert { padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-weight: 600; font-size: 0.9rem; display: flex; align-items: center; gap: 10px; }
        .success { background: #e6f6ec; color: #1e7e34; border: 1px solid #c3e6cb; }
        .error { background: #fdf2f2; color: #d9383a; border: 1px solid #fbd5d5; }

        /* Estructura de Panel (Dos Columnas Responsivo) */
        .admin-main-layout { display: grid; grid-template-columns: 1fr 1.1fr; gap: 25px; align-items: start; }
        @media (max-width: 992px) { .admin-main-layout { grid-template-columns: 1fr; } }

        /* Tarjetas de Contenido */
        .panel-card { background: white; border: 1px solid #e8e8e8; border-radius: 12px; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.02); }
        .form-container { border-top: 4px solid #D4AF37; }
        .list-container { border-top: 4px solid #8B2C2D; }
        
        h3 { color: #6B1E1F; font-size: 1.15rem; font-weight: 700; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }
        .subtitle-notice { font-size: 0.82rem; color: #666; line-height: 1.4; margin-bottom: 18px; background: #eef7ff; padding: 10px; border-radius: 6px; border-left: 3px solid #1877F2; }

        /* Elementos del Formulario */
        .form-vertical { display: flex; flex-direction: column; gap: 15px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group label { font-weight: 600; font-size: 0.88rem; color: #333; }
        .form-group input[type="text"] { width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 0.95rem; background: #fff; outline: none; transition: border-color 0.2s; }
        .form-group input[type="text"]:focus { border-color: #8B2C2D; }
        
        /* Subida de archivo e Input oculto */
        .file-upload-zone { display: flex; align-items: center; gap: 12px; background: #fafafa; padding: 8px; border: 1px dashed #bbb; border-radius: 6px; position: relative; }
        .file-upload-zone input[type="file"] { display: none; }
        .custom-file-btn { background: #8B2C2D; color: white; padding: 6px 14px; border-radius: 4px; font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: background 0.2s; }
        .custom-file-btn:hover { background: #6B1E1F; }
        .file-name-info { font-size: 0.85rem; color: #555; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 220px; }

        /* 🌟 AJUSTE PERFECTO Y CONTENEDOR DE VISTA PREVIA 🌟 */
        .preview-box { background: #1a1a2e; padding: 5px; border-radius: 8px; border: 1px solid #ddd; overflow: hidden; margin-top: 5px; }
        .preview-crop-frame { position: relative; width: 100%; height: 135px; overflow: hidden; background: #2a2a40; border-radius: 4px; }
        /* Fuerza la adaptación panorámica exacta sin aplastar los píxeles */
        .preview-crop-frame img { width: 100%; height: 100%; object-fit: cover; object-position: center; display: block; }
        .preview-badge { position: absolute; top: 8px; right: 8px; background: rgba(212, 175, 55, 0.95); color: #1a1a2e; font-size: 0.68rem; font-weight: 700; padding: 2px 8px; border-radius: 20px; text-transform: uppercase; }

        .btn-submit { background: #2C5F2D; color: white; border: none; padding: 12px; border-radius: 6px; font-weight: 700; cursor: pointer; font-size: 0.95rem; display: flex; align-items: center; justify-content: center; gap: 8px; transition: background 0.2s; margin-top: 5px; }
        .btn-submit:hover { background: #1e4220; }

        /* Cuadrícula de Galería Actual */
        .grid-fotos { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 15px; max-height: 540px; overflow-y: auto; padding-right: 4px; }
        .card-foto { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.04); border: 1px solid #e2e8f0; display: flex; flex-direction: column; justify-content: space-between; }
        
        /* Forzar las medidas en las miniaturas de la lista */
        .img-wrapper { width: 100%; height: 110px; overflow: hidden; background: #eaeaea; }
        .img-wrapper img { width: 100%; height: 100%; object-fit: cover; object-position: center; }
        
        .card-foto-info { padding: 10px; background: #ffffff; }
        .card-foto-info h4 { margin: 0 0 8px 0; font-size: 0.85rem; font-weight: 600; color: #333; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .btn-delete { display: flex; align-items: center; justify-content: center; gap: 5px; background: #fff5f5; color: #c53030; border: 1px solid #feb2b2; text-decoration: none; padding: 6px; font-size: 0.8rem; font-weight: 700; border-radius: 4px; transition: all 0.2s; }
        .btn-delete:hover { background: #c53030; color: white; border-color: #c53030; }
        
        .empty-gallery { text-align: center; padding: 40px 10px; color: #718096; grid-column: 1/-1; }
        .empty-gallery i { font-size: 2.2rem; color: #cbd5e0; margin-bottom: 8px; }
        .empty-gallery p { font-size: 0.85rem; font-style: italic; }
    </style>
</head>
<body>

    <div class="header-modulo">
        <h2><i class="fas fa-images"></i> Administrador de Fotos del Carrusel Principal</h2>
        <a href="admin.php"><i class="fas fa-arrow-left"></i> Volver al Menú</a>
    </div>

    <?php echo $mensaje; ?>

    <div class="admin-main-layout">
        
        <div class="panel-card form-container">
            <h3><i class="fas fa-plus-circle"></i> Subir una Nueva Imagen</h3>
            <div class="subtitle-notice">
                <i class="fas fa-info-circle"></i> <strong>Sugerencia de encuadre:</strong> El sistema adaptará de forma panorámica la imagen cargada. Las dimensiones ideales son de <strong>1200x400 píxeles</strong>. Archivos de otras proporciones se ajustarán sin estirarse.
            </div>
            
            <form action="admin_carrusel.php" method="POST" enctype="multipart/form-data" class="form-vertical">
                
                <div class="form-group">
                    <label for="titulo">Descripción / Título de la Imagen:</label>
                    <input type="text" id="titulo" name="titulo" placeholder="Ej: Transmisión Especial del Aniversario" required>
                </div>

                <div class="form-group">
                    <label>Selecciona el Archivo:</label>
                    <div class="file-upload-zone">
                        <input type="file" id="imagen" name="imagen" accept="image/*" required onchange="procesarVistaPrevia(event)">
                        <label for="imagen" class="custom-file-btn"><i class="fas fa-search"></i> Buscar Foto</label>
                        <span id="file-chosen-text" class="file-name-info">Ningún archivo seleccionado</span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Encuadre en el Sitio Web (Vista Previa):</label>
                    <div class="preview-box">
                        <div class="preview-crop-frame">
                            <img id="carrusel-live-preview" src="https://placehold.co/1200x400?text=Previsualizaci%C3%B3n+Panor%C3%A1mica" alt="Vista previa del slider">
                            <span class="preview-badge">Recorte Automático</span>
                        </div>
                    </div>
                </div>

                <button type="submit" name="subir_imagen" class="btn-submit"><i class="fas fa-upload"></i> Subir y Publicar</button>
            </form>
        </div>

        <div class="panel-card list-container">
            <h3><i class="fas fa-photo-video"></i> Fotos actualmente visibles en el Carrusel</h3>
            <p style="font-size: 0.8rem; color: #777; margin-bottom: 15px;">A continuación se despliegan los elementos multimedia dinámicos enlazados al index de la radio.</p>
            
            <div class="grid-fotos">
                <?php
                $result = mysqli_query($conn, "SELECT * FROM carrusel ORDER BY id DESC");
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="card-foto">
                            <div class="img-wrapper">
                                <img src="<?php echo htmlspecialchars($row['ruta_imagen']); ?>" alt="Foto Carrusel" onerror="this.src='https://placehold.co/900x400?text=Error+al+cargar+archivo'">
                            </div>
                            <div class="card-foto-info">
                                <h4><?php echo htmlspecialchars($row['titulo']); ?></h4>
                                <a href="admin_carrusel.php?eliminar=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('¿Estás totalmente seguro de quitar esta imagen del carrusel público?');">
                                    <i class="fas fa-trash-alt"></i> Eliminar Foto
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="empty-gallery">
                        <i class="fas fa-images"></i>
                        <p>No hay fotos cargadas en el servidor. El sitio web está ejecutando el carrusel de respaldo por defecto.</p>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

    </div>

    <script>
    function procesarVistaPrevia(event) {
        const input = event.target;
        const textLabel = document.getElementById('file-chosen-text');
        const previewImg = document.getElementById('carrusel-live-preview');
        
        if (input.files && input.files[0]) {
            // Actualizar texto del label con el nombre del archivo
            textLabel.textContent = input.files[0].name;
            
            // Renderizar la imagen dentro del contenedor panorámico simulado
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            textLabel.textContent = "Ningún archivo seleccionado";
        }
    }
    </script>
</body>
</html>

```