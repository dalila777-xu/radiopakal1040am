<?php
$noticias = [
    [
        'titulo' => 'Nueva programación en Radio Pakal 104.0',
        'descripcion' => 'Descubre los nuevos programas y horarios de la semana.',
        'imagen' => 'https://via.placeholder.com/150x100?text=Noticia+1'
    ],
    [
        'titulo' => 'Evento especial con la comunidad',
        'descripcion' => 'Conoce la próxima actividad cultural organizada por la radio.',
        'imagen' => 'https://via.placeholder.com/150x100?text=Noticia+2'
    ],
    [
        'titulo' => 'Entrevista exclusiva',
        'descripcion' => 'Escucha la conversación con nuestros invitados especiales.',
        'imagen' => 'https://via.placeholder.com/150x100?text=Noticia+3'
    ]
];
?>

<?php
$publicaciones = $noticias;
function obtenerImagenPublicacion($publicacion) {
    return $publicacion['imagen'] ?? '';
}
?>

<!-- ===== NOTICIAS Y PUBLICACIONES ===== -->
<section id="noticias" style="margin-top: 2rem;">
  <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.75rem;">
    <h2><i class="fas fa-newspaper"></i> Ver noticias</h2>
    <a href="#ver-todas-noticias" style="display:inline-flex; align-items:center; gap:0.4rem; padding:0.65rem 1rem; border-radius:999px; background:#1d4ed8; color:#fff; text-decoration:none; font-weight:600;">
      <i class="fas fa-arrow-down"></i> Ver noticias
    </a>
  </div>
    <div class="noticias">
        <div class="lista-noticias">
        <?php foreach ($publicaciones as $publicacion): ?>
            <div class="noticia">
            <img src="<?php echo obtenerImagenPublicacion($publicacion); ?>" alt="<?php echo htmlspecialchars($publicacion['titulo']); ?>" width="150" height="100">
            <h3><?php echo htmlspecialchars($publicacion['titulo']); ?></h3>
            <p><?php echo htmlspecialchars($publicacion['descripcion']); ?></p>
            </div>
        <?php endforeach; ?>
        </div>

<style>
.noticias {
    font-family: Arial, sans-serif;
    margin: 20px 0;
}

.lista-noticias {
    display: grid;
    gap: 15px;
}

.noticia {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 8px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #fff;
}

.noticia img {
    border-radius: 6px;
    object-fit: cover;
}

.noticia h3 {
    margin: 0;
    font-size: 18px;
}
</style>
