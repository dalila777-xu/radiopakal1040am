<?php
function escape_text($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';  // ← SIN CONTRASEÑA (XAMPP por defecto)
$dbName = 'radio_pakal';

$connectionError = '';
$newsItems = [];
$singleNews = null;

// ✅ CONEXIÓN CORREGIDA (sin contraseña)
$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($mysqli->connect_errno) {
    $connectionError = 'No se pudo conectar con la base de datos. Compruebe la configuración de MySQL.';
} else {
    $mysqli->set_charset('utf8mb4');
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (empty($connectionError)) {
    if ($id) {
        // Obtener una noticia específica
        $stmt = $mysqli->prepare('SELECT id, titulo, contenido, autor, fecha_creacion, imagen FROM publicaciones WHERE id = ? AND activo = 1 LIMIT 1');
        if ($stmt) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $singleNews = $result->fetch_assoc();
            $stmt->close();
        }
    } else {
        // Obtener todas las noticias activas
        $result = $mysqli->query('SELECT id, titulo, contenido, autor, fecha_creacion, imagen FROM publicaciones WHERE activo = 1 ORDER BY id DESC');
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $newsItems[] = $row;
            }
            $result->free();
        }
    }
    $mysqli->close();
}

// Si no hay noticias
if (!$id && empty($newsItems)) {
    $noNews = true;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias | Radio Pakal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f5f0;
            color: #1a1a2e;
            line-height: 1.6;
        }
        .container {
            max-width: 960px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }
        h1 {
            margin: 0 0 1.5rem;
            font-size: 2rem;
            color: #0d47a1;
            display: flex;
            align-items: center;
            gap: 12px;
            border-left: 4px solid #D4AF37;
            padding-left: 1rem;
        }
        h1 i { color: #D4AF37; }
        
        .notice-list {
            display: grid;
            gap: 1.5rem;
        }
        .notice-item {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
            text-decoration: none;
            color: inherit;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .notice-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }
        .notice-item img {
            width: 100%;
            display: block;
            object-fit: cover;
            max-height: 280px;
            background: #e5e7eb;
        }
        .notice-content {
            padding: 1.5rem;
        }
        .notice-content h2 {
            font-size: 1.3rem;
            margin: 0 0 0.5rem;
            color: #0d47a1;
        }
        .notice-content .meta {
            font-size: 0.8rem;
            color: #6b7280;
            margin-bottom: 0.8rem;
        }
        .notice-content .meta i { margin-right: 4px; }
        .notice-content p {
            margin: 0 0 1rem;
            line-height: 1.6;
            color: #4b5563;
        }
        .read-more {
            display: inline-block;
            color: #0d47a1;
            text-decoration: none;
            font-weight: 600;
        }
        .read-more:hover {
            color: #D4AF37;
        }
        .notice-detail article {
            background: #fff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        }
        .notice-detail article img {
            width: 100%;
            max-height: 420px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            background: #e5e7eb;
        }
        .notice-detail article h2 {
            font-size: 1.8rem;
            color: #0d47a1;
            margin-bottom: 0.5rem;
        }
        .notice-detail article .meta {
            font-size: 0.85rem;
            color: #6b7280;
            margin-bottom: 1.2rem;
        }
        .notice-detail article .meta i { margin-right: 4px; }
        .notice-detail article .contenido {
            font-size: 1rem;
            line-height: 1.8;
            color: #1f2937;
            white-space: pre-line;
        }
        .back-link {
            display: inline-block;
            margin-top: 1.5rem;
            text-decoration: none;
            color: #0d47a1;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .back-link:hover {
            color: #D4AF37;
        }
        .back-link i { margin-right: 6px; }
        .alert {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fcd34d;
            border-radius: 8px;
            padding: 1rem 1.2rem;
            margin-bottom: 1.5rem;
        }
        .no-news {
            text-align: center;
            padding: 3rem;
            color: #6b7280;
            font-size: 1.1rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.05);
        }
        .no-news i { font-size: 2.5rem; color: #d1d5db; margin-bottom: 1rem; display: block; }
        
        @media (max-width: 768px) {
            .container { margin: 1rem auto; }
            h1 { font-size: 1.5rem; }
            .notice-detail article { padding: 1.2rem; }
            .notice-detail article h2 { font-size: 1.4rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-newspaper"></i> Noticias y Publicaciones</h1>
        
        <?php if ($connectionError): ?>
            <div class="alert"><?= escape_text($connectionError) ?></div>
        <?php endif; ?>

        <?php if ($id): ?>
            <!-- VISTA DE DETALLE -->
            <?php if ($singleNews): ?>
                <div class="notice-detail">
                    <article>
                        <?php if (!empty($singleNews['imagen']) && file_exists($singleNews['imagen'])): ?>
                            <img src="<?= escape_text($singleNews['imagen']) ?>" alt="<?= escape_text($singleNews['titulo']) ?>">
                        <?php endif; ?>
                        <h2><?= escape_text($singleNews['titulo']) ?></h2>
                        <div class="meta">
                            <i class="far fa-calendar-alt"></i> <?= date('d/m/Y H:i', strtotime($singleNews['fecha_creacion'])) ?>
                            <span style="margin-left:1rem;"><i class="far fa-user"></i> <?= escape_text($singleNews['autor']) ?></span>
                        </div>
                        <div class="contenido"><?= nl2br(escape_text($singleNews['contenido'])) ?></div>
                        <a class="back-link" href="noticia.php"><i class="fas fa-arrow-left"></i> Volver a las noticias</a>
                    </article>
                </div>
            <?php else: ?>
                <div class="alert">❌ No se encontró la noticia solicitada.</div>
                <a class="back-link" href="noticia.php"><i class="fas fa-arrow-left"></i> Volver a las noticias</a>
            <?php endif; ?>
            
        <?php else: ?>
            <!-- VISTA DE LISTADO -->
            <?php if (!empty($newsItems)): ?>
                <div class="notice-list">
                    <?php foreach ($newsItems as $item): ?>
                        <a class="notice-item" href="noticia.php?id=<?= escape_text($item['id']) ?>">
                            <?php if (!empty($item['imagen']) && file_exists($item['imagen'])): ?>
                                <img src="<?= escape_text($item['imagen']) ?>" alt="<?= escape_text($item['titulo']) ?>">
                            <?php endif; ?>
                            <div class="notice-content">
                                <h2><?= escape_text($item['titulo']) ?></h2>
                                <div class="meta">
                                    <i class="far fa-calendar-alt"></i> <?= date('d/m/Y', strtotime($item['fecha_creacion'])) ?>
                                    <span style="margin-left:0.8rem;"><i class="far fa-user"></i> <?= escape_text($item['autor']) ?></span>
                                </div>
                                <p><?= escape_text(substr(strip_tags($item['contenido']), 0, 160)) ?>...</p>
                                <span class="read-more">Leer más →</span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-news">
                    <i class="fas fa-newspaper"></i>
                    <p>No hay publicaciones disponibles en este momento.</p>
                    <a href="index.php" style="color:#0d47a1; font-weight:600; text-decoration:none;">← Volver al inicio</a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>