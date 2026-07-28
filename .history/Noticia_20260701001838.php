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
  <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.75rem;">
    <h2><i class="fas fa-newspaper"></i> Ver noticias</h2>
    <a href="Noticia.php#ver-todas-noticias" style="display:inline-flex; align-items:center; gap:0.4rem; padding:0.65rem 1rem; border-radius:999px; background:#1d4ed8; color:#fff; text-decoration:none; font-weight:600;">
      <i class="fas fa-arrow-down"></i> Ver noticias
    </a>
  </div>

  <div style="display:flex; flex-wrap:wrap; gap:1rem; margin-top:0.75rem;">
    <?php $publicacionesRecientes = array_slice($publicaciones, 0, 6); ?>
    <?php if (!empty($publicacionesRecientes)): ?>
      <?php foreach ($publicacionesRecientes as $publicacion): ?>
        <?php $imagenPublicacion = obtenerImagenPublicacion($publicacion); ?>
        <article class="tarjeta-noticia" style="flex:1 1 300px; border:1px solid #e5e7eb; border-radius:8px; padding:12px; background:#fff; display:flex; flex-direction:column; gap:0.75rem;">
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
              Leer más →
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

<!-- ===== PROGRAMACIÓN ===== -->
<section id="programacion">
  <h2><i class="fas fa-calendar-alt"></i> Programación Radio Pakal</h2>
  
  <!-- LEYENDA CON RELOJ EN TIEMPO REAL -->
  <div class="leyenda">
            <span class="leyenda-item"><span class="circulo circulo-rojo"></span> <strong>Rojo:</strong> Comienza en 1 minuto</span>
    <span class="leyenda-item"><span class="circulo circulo-verde"></span> <strong>Verde:</strong> Transmitiendo AHORA</span>
    <span class="leyenda-item"><span class="circulo circulo-gris"></span> <strong>Gris:</strong> Fuera del aire</span>
    <span style="font-size:0.7rem;color:#6b7280;margin-left:auto;display:flex;align-items:center;gap:10px;">
      <span>📅 Hoy es <?php echo $diaActualNombre; ?></span>
      <span class="reloj-tiempo-real" id="relojTiempoReal"><?php echo date('H:i:s'); ?></span>
      <span style="font-size:0.6rem;color:#22c55e;"> </span>
    </span>
  </div>

  <!-- BARRA PROGRAMÁTICA -->
  <div class="programacion-container" id="programacionContainer">
    <table class="programacion-tabla" id="tablaProgramacion">
      <thead>
        <tr>
          <th>HORARIO</th>
          <?php foreach ($dias as $index => $dia): 
            $es_hoy = ($dia === $diaActualNombre);
          ?>
            <th class="<?php echo $es_hoy ? 'dia-actual' : ''; ?>">
              <?php echo $dia; ?>
            </th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody id="tablaBody">
        <?php foreach ($horarios as $hora): ?>
          <tr>
            <td class="hora-col"><?php echo htmlspecialchars($hora); ?></td>
            <?php foreach ($dias as $dia): ?>
              <?php 
                $programa = obtenerProgramaEnCelda($programas, $dia, $hora);
                $luz = '';
                $nombre = '';
                $clase_adicional = '';
                if ($programa) {
                  $nombre = $programa['programa'];
                  $luz = obtenerIndicadorTransmision($programa['dia'], $programa['hora'], $programa['programa']);
                  if (stripos($nombre, 'noticias') !== false || stripos($nombre, 'diez noticias') !== false) {
                    $clase_adicional = 'destacado';
                  }
                }
              ?>
              <td class="celda-programa <?php echo $programa ? '' : 'celda-vacia'; ?>" data-dia="<?php echo htmlspecialchars($dia); ?>" data-hora="<?php echo htmlspecialchars($hora); ?>" data-programa="<?php echo htmlspecialchars($nombre); ?>">
                <?php if ($programa): ?>
                  <?php echo $luz; ?>
                  <span class="nombre-programa <?php echo $clase_adicional; ?>">
                    <?php echo htmlspecialchars($nombre); ?>
                  </span>
                <?php else: ?>
                  <span class="nombre-programa" style="color:#9ca3af;font-size:0.6rem;">—</span>
                <?php endif; ?>
              </td>
            <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
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
