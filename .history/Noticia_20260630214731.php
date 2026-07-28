<?php
function escape_text($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'Radio_pakal_1040';

$connectionError = '';
$newsItems = [];
$singleNews = null;

$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($mysqli->connect_errno) {
    $connectionError = 'No se pudo conectar con la base de datos. Compruebe la configuración de MySQL.';
} else {
    $mysqli->set_charset('utf8mb4');
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (empty($connectionError)) {
    if ($id) {
        $stmt = $mysqli->prepare('SELECT id, titulo, resumen, contenido, imagen, fecha_publicacion FROM noticias WHERE id = ? LIMIT 1');
        if ($stmt) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $singleNews = $result->fetch_assoc();
            $stmt->close();
        }
    } else {
        $result = $mysqli->query('SELECT id, titulo, resumen, imagen FROM noticias WHERE publicado = 1 ORDER BY fecha_publicacion DESC');
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $newsItems[] = $row;
            }
            $result->free();
        }
    }
    $mysqli->close();
}

if (!$id && empty($newsItems)) {
    $newsItems = [
        ['id' => 11, 'titulo' => 'Título de la noticia 1', 'resumen' => 'Resumen breve de la publicación. Pulse para leer más.', 'imagen' => 'https://via.placeholder.com/760x420?text=Noticia+1'],
        ['id' => 12, 'titulo' => 'Título de la noticia 2', 'resumen' => 'Resumen breve de la publicación. Pulse para leer más.', 'imagen' => 'https://via.placeholder.com/760x420?text=Noticia+2'],
        ['id' => 13, 'titulo' => 'Título de la noticia 3', 'resumen' => 'Resumen breve de la publicación. Pulse para leer más.', 'imagen' => 'https://via.placeholder.com/760x420?text=Noticia+3'],
    ];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            max-width: 960px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            margin: 0 0 20px;
            font-size: 2rem;
        }
        .notice-list {
            display: grid;
            gap: 20px;
        }
        .notice-item {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
            text-decoration: none;
            color: inherit;
        }
        .notice-item img {
            width: 100%;
            display: block;
            object-fit: cover;
            max-height: 280px;
        }
        .notice-content {
            padding: 20px;
        }
        .notice-content h2 {
            font-size: 1.4rem;
            margin: 0 0 12px;
        }
        .notice-content p {
            margin: 0 0 16px;
            line-height: 1.6;
            color: #555;
        }
        .read-more {
            display: inline-block;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .notice-detail img {
            width: 100%;
            max-height: 420px;
            object-fit: cover;
            display: block;
            border-radius: 10px;
        }
        .notice-detail article {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        }
        .notice-detail article h2 {
            margin-top: 0;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
        }
        .alert {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
            border-radius: 8px;
            padding: 14px 18px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Noticias publicadas</h1>
        <?php if ($connectionError): ?>
            <div class="alert"><?= escape_text($connectionError) ?></div>
        <?php endif; ?>

        <?php if ($id): ?>
            <?php if ($singleNews): ?>
                <div class="notice-detail">
                    <article>
                        <?php if (!empty($singleNews['imagen'])): ?>
                            <img src="<?= escape_text($singleNews['imagen']) ?>" alt="<?= escape_text($singleNews['titulo']) ?>">
                        <?php endif; ?>
                        <h2><?= escape_text($singleNews['titulo']) ?></h2>
                        <p><?= nl2br(escape_text($singleNews['resumen'])) ?></p>
                        <?php if (!empty($singleNews['contenido'])): ?>
                            <div><?= nl2br(escape_text($singleNews['contenido'])) ?></div>
                        <?php endif; ?>
                        <a class="back-link" href="Noticia.php">← Volver a las noticias</a>
                    </article>
                </div>
            <?php else: ?>
                <div class="alert">No se encontró la noticia solicitada.</div>
                <a class="back-link" href="Noticia.php">← Volver a las noticias</a>
            <?php endif; ?>
        <?php else: ?>
            <div class="notice-list">
                <?php foreach ($newsItems as $item): ?>
                    <a class="notice-item" href="Noticia.php?id=<?= escape_text($item['id']) ?>">
                        <?php if (!empty($item['imagen'])): ?>
                            <img src="<?= escape_text($item['imagen']) ?>" alt="<?= escape_text($item['titulo']) ?>">
                        <?php endif; ?>
                        <div class="notice-content">
                            <h2><?= escape_text($item['titulo']) ?></h2>
                            <p><?= escape_text($item['resumen']) ?></p>
                            <span class="read-more">Leer más →</span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
