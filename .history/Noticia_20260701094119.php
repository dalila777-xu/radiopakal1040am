<?php
$noticias = [
    [
        'id' => 1,
        'titulo' => 'Nueva programación en Radio Pakal 104.0',
        'descripcion' => 'Descubre los nuevos programas y horarios de la semana.',
        'resumen' => 'Descubre los nuevos programas y horarios de la semana.',
        'url' => 'noticia.php?id=1',
        'imagen' => 'https://via.placeholder.com/150x100?text=Noticia+1'
    ],
    [
        'id' => 2,
        'titulo' => 'Evento especial con la comunidad',
        'descripcion' => 'Conoce la próxima actividad cultural organizada por la radio.',
        'resumen' => 'Conoce la próxima actividad cultural organizada por la radio.',
        'url' => 'noticia.php?id=2',
        'imagen' => 'https://via.placeholder.com/150x100?text=Noticia+2'
    ],
    [
        'id' => 3,
        'titulo' => 'Entrevista exclusiva',
        'descripcion' => 'Escucha la conversación con nuestros invitados especiales.',
        'resumen' => 'Escucha la conversación con nuestros invitados especiales.',
        'url' => 'noticia.php?id=3',
        'imagen' => 'https://via.placeholder.com/150x100?text=Noticia+3'
    ]
];
?>

<?php
$publicaciones = $noticias;

function obtenerImagenPublicacion($publicacion) {
    return $publicacion['imagen'] ?? '';
}

function obtenerUrlPublicacion($publicacion) {
    if (!empty($publicacion['url'])) {
        return $publicacion['url'];
    }
    if (!empty($publicacion['id'])) {
        return 'noticia.php?id=' . urlencode($publicacion['id']);
    }
    return 'noticia.php';
}
?>

<!-- ===== NOTICIAS Y PUBLICACIONES ===== -->
<section id="noticias" style="margin-top: 2rem;">
  <div style="display:flex; flex-wrap:wrap; align-items:center; gap:1rem; background:#fff; padding:1rem; border-radius:12px; border:1px solid #e5e7eb;">
    <div style="flex:1; min-width:240px;">
      <?php $imagenPrincipal = obtenerImagenPublicacion($publicaciones[0] ?? []); ?>
      <?php if (!empty($imagenPrincipal)): ?>
        <img src="<?php echo htmlspecialchars($imagenPrincipal); ?>" alt="Ver más noticias" style="width:100%; max-height:260px; object-fit:cover; border-radius:12px;" onerror="this.onerror=null; this.src='https://placehold.co/600x400?text=Más+noticias'">
      <?php else: ?>
        <div style="width:100%; height:260px; display:flex; align-items:center; justify-content:center; border-radius:12px; background:#f3f4f6; color:#6b7280; font-size:1rem;">Ver más noticias</div>
      <?php endif; ?>
    </div>
    <div style="flex:1; min-width:260px; display:flex; flex-direction:column; justify-content:center; gap:1rem;">
      <h2 style="margin:0; font-size:1.6rem;"><i class="fas fa-newspaper"></i> Noticias</h2>
      <p style="margin:0; color:#6b7280;">Presiona el botón para ver todas las noticias en el apartado de noticias dentro de esta página.</p>
      <a href="#ver-todas-noticias" style="display:inline-flex; align-items:center; gap:0.5rem; padding:0.85rem 1.2rem; border-radius:999px; background:#1d4ed8; color:#fff; text-decoration:none; font-weight:600;">
        <i class="fas fa-arrow-down"></i> Ver más noticias
      </a>
    </div>
  </div>

  <div id="ver-todas-noticias" style="margin-top:2rem;">
    <h3 style="margin-bottom:1rem;">Todas las noticias</h3>
    <div style="display:flex; flex-wrap:wrap; gap:1rem;">
      <?php if (!empty($publicaciones)): ?>
        <?php foreach ($publicaciones as $publicacion): ?>
          <?php $imagenPublicacion = obtenerImagenPublicacion($publicacion); ?>
          <article class="tarjeta-noticia" style="flex:1 1 280px; max-width:320px; border:1px solid #e5e7eb; border-radius:8px; padding:12px; background:#fff; display:flex; flex-direction:column; gap:0.75rem;">
            <?php if (!empty($imagenPublicacion)): ?>
              <img src="<?php echo htmlspecialchars($imagenPublicacion); ?>" alt="<?php echo htmlspecialchars($publicacion['titulo'] ?? 'Noticia'); ?>" style="width:100%; height:180px; object-fit:cover; border-radius:6px;" onerror="this.onerror=null;this.src='https://placehold.co/600x400?text=Sin+imagen'">
            <?php else: ?>
              <div style="width:100%; height:180px; display:flex; align-items:center; justify-content:center; border-radius:6px; background:#f3f4f6; color:#6b7280; font-size:0.95rem;">Sin imagen</div>
            <?php endif; ?>
            <div>
              <h3 style="margin:0 0 6px 0; font-size:1rem;">
                <?php echo htmlspecialchars($publicacion['titulo'] ?? 'Noticia sin título'); ?>
              </h3>
              <p style="margin:0 0 8px 0; color:#6b7280; font-size:0.9rem;">
                <?php echo htmlspecialchars($publicacion['resumen'] ?? $publicacion['contenido'] ?? 'Resumen no disponible.'); ?>
              </p>
              <a href="<?php echo htmlspecialchars($publicacion['url'] ?? ('noticia.php?id=' . urlencode($publicacion['id'] ?? ''))); ?>" style="color:#1f2937; font-weight:600; text-decoration:none;" target="_blank" rel="noopener">
                Ver noticia →
              </a>
            </div>
          </article>
        <?php endforeach; ?>
      <?php else: ?>
        <article class="tarjeta-noticia" style="flex:1 1 300px; border:1px solid #e5e7eb; border-radius:8px; padding:12px; background:#fff;">
          <h3 style="margin:0 0 6px 0; font-size:1rem;">No hay noticias disponibles</h3>
          <p style="margin:0 0 8px 0; color:#6b7280; font-size:0.9rem;">Por el momento no se encontraron publicaciones recientes.</p>
        </article>
      <?php endif; ?>
    </div>
  </div>
</section>

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
