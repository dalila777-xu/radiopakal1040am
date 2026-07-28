<?php include("db.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <meta name="description" content="Radio Pakal 1040 AM - La voz oficial de Palenque, Chiapas">
  <title>RADIO PAKAL 1040 AM | Oficial - Palenque, Chiapas</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: #ffffff;
      color: #1a1a2e;
      line-height: 1.6;
      scroll-behavior: smooth;
    }

    /* ========================================
       BOTÓN ADMIN FLOTANTE
    ======================================== */
    .admin-float-btn {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background: #8B2C2D;
      color: white;
      width: 55px;
      height: 55px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      transition: all 0.3s ease;
      z-index: 1000;
    }

    .admin-float-btn:hover {
      background: #6B1E1F;
      transform: scale(1.1);
    }

    /* Botón de usuario logueado */
    .user-menu {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background: #8B2C2D;
      color: white;
      padding: 12px 20px;
      border-radius: 50px;
      display: flex;
      align-items: center;
      gap: 12px;
      z-index: 1000;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .user-menu a {
      color: white;
      text-decoration: none;
      margin-left: 10px;
      padding: 5px 10px;
      background: rgba(255,255,255,0.2);
      border-radius: 20px;
    }

    /* Panel de administración en el header */
    .admin-panel-bar {
      background: #2C5F2D;
      color: white;
      padding: 8px 20px;
      text-align: center;
      font-size: 0.85rem;
    }

    .admin-panel-bar a {
      color: white;
      margin: 0 10px;
      text-decoration: none;
    }

    .admin-panel-bar a:hover {
      text-decoration: underline;
    }

    /* ========================================
       HEADER
    ======================================== */
    header {
      background: #ffffff;
      text-align: center;
      padding: 2rem 1.5rem;
      position: relative;
      border-bottom: 1px solid #f0f0f0;
    }

    .logo {
      width: 85px;
      height: auto;
      margin-bottom: 1rem;
    }

    header h1 {
      color: #8B2C2D;
      font-size: 1.8rem;
      margin-bottom: 0.5rem;
    }

    header p {
      color: #8B2C2D;
      font-size: 1rem;
    }

    /* Botón de login en header */
    .login-btn-header {
      position: absolute;
      top: 20px;
      right: 20px;
      background: #8B2C2D;
      color: white;
      padding: 8px 16px;
      border-radius: 30px;
      text-decoration: none;
      font-size: 0.8rem;
      font-weight: 600;
      transition: all 0.3s;
    }

    .login-btn-header:hover {
      background: #6B1E1F;
      transform: scale(1.05);
    }

    .user-info-header {
      position: absolute;
      top: 20px;
      right: 20px;
      background: #2C5F2D;
      color: white;
      padding: 8px 16px;
      border-radius: 30px;
      font-size: 0.8rem;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .user-info-header a {
      color: white;
      text-decoration: none;
      background: rgba(255,255,255,0.2);
      padding: 4px 10px;
      border-radius: 20px;
    }

    /* ========================================
       NAVEGACIÓN
    ======================================== */
    nav {
      background: white;
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 0.5rem;
      padding: 0.8rem 1rem;
      position: sticky;
      top: 0;
      z-index: 100;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      border-bottom: 2px solid #D4AF37;
    }

    nav a {
      color: #1a1a2e;
      text-decoration: none;
      font-weight: 600;
      padding: 0.5rem 1.2rem;
      border-radius: 40px;
      transition: all 0.3s ease;
      font-size: 0.85rem;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    nav a i {
      font-size: 0.9rem;
      color: #8B2C2D;
    }

    nav a:hover {
      background: #8B2C2D;
      color: white;
    }

    nav a:hover i {
      color: white;
    }

    /* ========================================
       CONTENEDOR PRINCIPAL
    ======================================== */
    .container {
      max-width: 1200px;
      margin: 2.5rem auto;
      padding: 0 1.5rem;
    }

    section {
      background: white;
      border: 1px solid #f0f0f0;
      border-radius: 12px;
      padding: 2rem;
      margin-bottom: 2rem;
      transition: all 0.15s ease;
      scroll-margin-top: 85px;
    }

    section h2 {
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 1.2rem;
      display: flex;
      align-items: center;
      gap: 12px;
      border-left: 3px solid #D4AF37;
      padding-left: 1rem;
      color: #6B1E1F;
    }

    section h2 i {
      color: #D4AF37;
      font-size: 1.5rem;
    }

    /* Botones de administración dentro de secciones */
    .admin-actions {
      margin-top: 1rem;
      padding-top: 1rem;
      border-top: 1px solid #e0e0e0;
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }

    .btn-edit, .btn-delete, .btn-add {
      padding: 6px 12px;
      border-radius: 6px;
      font-size: 0.75rem;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }

    .btn-edit {
      background: #D4AF37;
      color: #1a1a2e;
    }

    .btn-delete {
      background: #8B2C2D;
      color: white;
    }

    .btn-add {
      background: #2C5F2D;
      color: white;
    }

    /* ========================================
       CARRUSEL
    ======================================== */
    .carousel-section {
      margin-top: 1.5rem;
    }

    .carousel-container {
      position: relative;
      width: 100%;
      max-width: 900px;
      margin: 0 auto;
      border-radius: 16px;
      overflow: hidden;
      background: #f8f5f0;
      border: 1px solid #e8e8e8;
    }

    .carousel-track {
      display: flex;
      transition: transform 0.5s ease-in-out;
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .carousel-slide {
      min-width: 100%;
      flex-shrink: 0;
    }

    .carousel-slide img {
      width: 100%;
      height: 400px;
      object-fit: cover;
      display: block;
    }

    .carousel-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(139, 44, 45, 0.7);
      color: white;
      border: none;
      width: 45px;
      height: 45px;
      border-radius: 50%;
      cursor: pointer;
      z-index: 10;
      font-size: 1.2rem;
    }

    .carousel-btn-prev { left: 15px; }
    .carousel-btn-next { right: 15px; }

    .carousel-dots {
      display: flex;
      justify-content: center;
      gap: 10px;
      padding: 1rem;
      background: #f8f5f0;
    }

    .carousel-dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: #ccc;
      border: none;
      cursor: pointer;
    }

    .carousel-dot.active {
      background: #8B2C2D;
      transform: scale(1.2);
    }

    /* ========================================
       TABLA PROGRAMACIÓN
    ======================================== */
    .table-responsive { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; border-radius: 10px; overflow: hidden; }
    th { background: #2C5F2D; color: white; padding: 12px 16px; text-align: left; }
    td { padding: 12px 16px; border-bottom: 1px solid #f0f0f0; }
    tr:hover td { background: #FDF9F0; }

    /* ========================================
       REDES SOCIALES
    ======================================== */
    .grid-buttons {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      margin-top: 1rem;
    }

    .btn-card {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 0.8rem 1.5rem;
      border-radius: 50px;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .facebook-btn { background: #1877F2; color: white; }
    .whatsapp-btn { background: #25D366; color: white; }
    .app-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
    .btn-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }

    iframe {
      width: 100%;
      height: 350px;
      border-radius: 12px;
      border: 1px solid #e8e8e8;
    }

    footer {
      background: #1a1a2e;
      color: #cbd5e0;
      text-align: center;
      padding: 2rem;
      margin-top: 2rem;
    }

    footer p:first-child { font-weight: 600; color: white; }

    @media (max-width: 768px) {
      .carousel-slide img { height: 280px; }
      section { padding: 1.3rem; }
      section h2 { font-size: 1.2rem; }
      .login-btn-header, .user-info-header { top: 10px; right: 10px; font-size: 0.7rem; padding: 5px 10px; }
    }

    @media (max-width: 480px) {
      .carousel-slide img { height: 200px; }
      .grid-buttons { flex-direction: column; }
      .btn-card { justify-content: center; }
    }
  </style>
</head>
<body>

<?php
// Verificar si el usuario está logueado
$isLoggedIn = isset($_SESSION['admin_id']);
$userRol = isset($_SESSION['admin_rol']) ? $_SESSION['admin_rol'] : '';
$isAdmin = ($isLoggedIn && $userRol == 'admin');

// Mostrar barra de admin si está logueado
if ($isLoggedIn): ?>
<div class="admin-panel-bar">
  <i class="fas fa-user-shield"></i> Bienvenido, <?php echo htmlspecialchars($_SESSION['admin_nombre']); ?> (<?php echo $userRol; ?>)
  <a href="admin/dashboard.php"><i class="fas fa-tachometer-alt"></i> Panel de Control</a>
  <a href="admin/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
</div>
<?php endif; ?>

<!-- Encabezado con Logotipo -->
<header>
  <?php if (!$isLoggedIn): ?>
    <a href="admin/login.php" class="login-btn-header"><i class="fas fa-lock"></i> Solo usuarios autorizados</a>
  <?php else: ?>
    <div class="user-info-header">
      <i class="fas fa-user-check"></i> <?php echo htmlspecialchars($_SESSION['admin_nombre']); ?>
      <a href="admin/logout.php"><i class="fas fa-sign-out-alt"></i> Salir</a>
    </div>
  <?php endif; ?>
  
  <img src="logo.png" alt="Logo Radio Pakal" class="logo" onerror="this.src='https://placehold.co/85x85?text=RP'">
  <h1>RADIO PAKAL 1040 AM</h1>
  <p>CAPITAL MAYA</p>
</header>

<!-- Menú de navegación -->
<nav>
  <a href="#quienes"><i class="fas fa-users"></i> Quiénes Somos</a>
  <a href="#ubicacion"><i class="fas fa-map-marker-alt"></i> Ubicación</a>
  <a href="#programacion"><i class="fas fa-calendar-alt"></i> Programación</a>
  <a href="#publicaciones"><i class="fas fa-newspaper"></i> Publicaciones</a>
  <a href="#redes"><i class="fas fa-share-alt"></i> Redes Sociales</a>
  <a href="#app"><i class="fas fa-mobile-alt"></i> App Móvil</a>
</nav>

<div class="container">
  
  <!-- MÓDULO 1: Quiénes Somos -->
  <section id="quienes">
    <h2><i class="fas fa-users"></i> Quiénes Somos</h2>
    <p><strong>Radio Pakal 1040 AM</strong> es una emisora comunitaria profundamente arraigada en Palenque, Chiapas. 
       Promovemos la riqueza cultural, la música de nuestra región y la identidad de nuestra gente, 
       transmitiendo con orgullo tanto en español como en nuestras valiosas lenguas originarias (Ch'ol y Tzeltal).</p>
    <p style="margin-top: 0.8rem;">Somos parte del compromiso del Gobierno del Estado de Chiapas por llevar información, educación y entretenimiento a cada rincón de nuestra tierra.</p>
    
    <div class="carousel-section">
      <div class="carousel-container">
        <div class="carousel">
          <div class="carousel-track-container">
            <ul class="carousel-track">
              <li class="carousel-slide"><img src="B.png" alt="Radio Pakal" onerror="this.src='https://placehold.co/900x400?text=Radio+Pakal+1'"></li>
              <li class="carousel-slide"><img src="D.png" alt="Transmisión" onerror="this.src='https://placehold.co/900x400?text=Radio+Pakal+2'"></li>
              <li class="carousel-slide"><img src="A.png" alt="Comunidad" onerror="this.src='https://placehold.co/900x400?text=Radio+Pakal+3'"></li>
              <li class="carousel-slide"><img src="g.png" alt="Actividad" onerror="this.src='https://placehold.co/900x400?text=Radio+Pakal+4'"></li>
              <li class="carousel-slide"><img src="l.png" alt="Cultura" onerror="this.src='https://placehold.co/900x400?text=Radio+Pakal+5'"></li>
            </ul>
          </div>
          <button class="carousel-btn carousel-btn-prev" id="prevBtn">❮</button>
          <button class="carousel-btn carousel-btn-next" id="nextBtn">❯</button>
        </div>
        <div class="carousel-dots" id="dotsContainer"></div>
      </div>
    </div>
    
    <?php if ($isLoggedIn): ?>
    <div class="admin-actions">
      <a href="admin/editar_carrusel.php" class="btn-edit"><i class="fas fa-edit"></i> Editar Carrusel</a>
      <a href="admin/agregar_imagen.php" class="btn-add"><i class="fas fa-plus"></i> Agregar Imagen</a>
    </div>
    <?php endif; ?>
  </section>

  <!-- MÓDULO 2: Programación -->
  <section id="programacion">
    <h2><i class="fas fa-calendar-alt"></i> Programación del Día</h2>
    <div class="table-responsive">
      <table>
        <thead>
          <tr><th>Horario</th><th>Programa</th></tr>
        </thead>
        <tbody>
          <?php
          $result = mysqli_query($conn, "SELECT hora, programa FROM programacion WHERE activo = 1 ORDER BY orden ASC");
          if ($result && mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td><strong>" . htmlspecialchars($row['hora']) . "</strong></td>";
                  echo "<td>" . htmlspecialchars($row['programa']) . "</td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='2'>📻 No hay horarios registrados</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
    <?php if ($isLoggedIn): ?>
    <div class="admin-actions">
      <a href="admin/editar_programacion.php" class="btn-edit"><i class="fas fa-edit"></i> Editar Programación</a>
      <a href="admin/agregar_programa.php" class="btn-add"><i class="fas fa-plus"></i> Agregar Programa</a>
    </div>
    <?php endif; ?>
  </section>

  <!-- MÓDULO 3: Publicaciones/Noticias -->
  <section id="publicaciones">
    <h2><i class="fas fa-newspaper"></i> Últimas Publicaciones</h2>
    <?php
    $result_pub = mysqli_query($conn, "SELECT * FROM publicaciones WHERE activo = 1 ORDER BY fecha_publicacion DESC LIMIT 5");
    if (mysqli_num_rows($result_pub) > 0) {
        while ($pub = mysqli_fetch_assoc($result_pub)) {
            echo '<div style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid #eee;">';
            echo '<h3 style="color: #8B2C2D;">' . htmlspecialchars($pub['titulo']) . '</h3>';
            echo '<small style="color: #888;"><i class="far fa-calendar-alt"></i> ' . date('d/m/Y H:i', strtotime($pub['fecha_publicacion'])) . '</small>';
            echo '<p style="margin-top: 0.5rem;">' . nl2br(htmlspecialchars(substr($pub['contenido'], 0, 300))) . '</p>';
            if ($pub['imagen']) {
                echo '<img src="' . htmlspecialchars($pub['imagen']) . '" style="max-width: 100%; max-height: 200px; object-fit: cover; border-radius: 8px; margin-top: 0.5rem;">';
            }
            if ($isLoggedIn) {
                echo '<div style="margin-top: 0.5rem;">';
                echo '<a href="admin/editar_publicacion.php?id=' . $pub['id'] . '" class="btn-edit" style="font-size:0.7rem;"><i class="fas fa-edit"></i> Editar</a> ';
                echo '<a href="admin/eliminar_publicacion.php?id=' . $pub['id'] . '" class="btn-delete" style="font-size:0.7rem;" onclick="return confirm(\'¿Eliminar esta publicación?\')"><i class="fas fa-trash"></i> Eliminar</a>';
                echo '</div>';
            }
            echo '</div>';
        }
    } else {
        echo '<p>No hay publicaciones aún. ¡Síguenos en redes sociales para más contenido!</p>';
    }
    ?>
    <?php if ($isLoggedIn): ?>
    <div class="admin-actions">
      <a href="admin/nueva_publicacion.php" class="btn-add"><i class="fas fa-plus"></i> Nueva Publicación</a>
    </div>
    <?php endif; ?>
  </section>

  <!-- MÓDULO 4: Redes Sociales -->
  <section id="redes">
    <h2><i class="fab fa-facebook"></i> Síguenos en Redes Sociales</h2>
    <div class="grid-buttons">
      <a href="https://www.facebook.com/profile.php?id=61573503869607" target="_blank" class="btn-card facebook-btn">
        <i class="fab fa-facebook-f"></i> Facebook: Radio Pakal 1040 AM
      </a>
      <a href="https://wa.me/529935990830" target="_blank" class="btn-card whatsapp-btn">
        <i class="fab fa-whatsapp"></i> WhatsApp Cabina
      </a>
    </div>
  </section>

  <!-- MÓDULO 5: App Móvil -->
  <section id="app">
    <h2><i class="fas fa-download"></i> Lleva la Radio en tu Bolsillo</h2>
    <div class="grid-buttons">
      <a href="#" class="btn-card app-btn">
        <i class="fas fa-qrcode"></i> Descargar Aplicación Android / iOS
      </a>
    </div>
    <p style="margin-top: 1rem; font-size: 0.8rem; color: #666;">
      <i class="fas fa-headphones"></i> Escúchanos en vivo, participa en encuestas y recibe notificaciones exclusivas.
    </p>
  </section>

  <!-- MÓDULO 6: Ubicación -->
  <section id="ubicacion">
    <h2><i class="fas fa-location-dot"></i> Nuestra Ubicación</h2>
    <p><i class="fas fa-map-pin"></i> <strong>Dirección:</strong> AV. Corregidora S/N Planta Alta, entre Javier Mina y Chiapas, Palenque, Chiapas. C.P. 29960</p>
    <p><i class="fas fa-phone-alt"></i> <strong>Contacto:</strong> (961) 617 0500 Ext. 57000</p>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3810.7351659223366!2d-91.985055!3d17.509444!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85f4426e7f4bcb7f%3A0x8b8b8b8b8b8b8b8b!2sPalenque%2C%20Chiapas!5e0!3m2!1ses!2smx!4v1700000000000" allowfullscreen="" loading="lazy"></iframe>
  </section>
</div>

<footer>
  <p>&copy; <?php echo date('Y'); ?> Radio Pakal 1040 AM — Palenque, Chiapas</p>
  <p>🌽 Conectando culturas, uniendo comunidades.</p>
  <p>Sistema Chiapaneco de Radio, Televisión y Cinematografía | Humanismo que transforma</p>
</footer>

<script>
  // Carrusel funcional
  document.addEventListener('DOMContentLoaded', function() {
    const track = document.querySelector('.carousel-track');
    const slides = Array.from(document.querySelectorAll('.carousel-slide'));
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const dotsContainer = document.getElementById('dotsContainer');
    
    if (!track || slides.length === 0) return;
    
    let currentIndex = 0;
    
    function createDots() {
      dotsContainer.innerHTML = '';
      slides.forEach((_, index) => {
        const dot = document.createElement('button');
        dot.classList.add('carousel-dot');
        if (index === currentIndex) dot.classList.add('active');
        dot.addEventListener('click', () => goToSlide(index));
        dotsContainer.appendChild(dot);
      });
    }
    
    function updateDots() {
      document.querySelectorAll('.carousel-dot').forEach((dot, index) => {
        dot.classList.toggle('active', index === currentIndex);
      });
    }
    
    function goToSlide(index) {
      currentIndex = index;
      track.style.transform = `translateX(-${currentIndex * 100}%)`;
      updateDots();
    }
    
    function nextSlide() { goToSlide((currentIndex + 1) % slides.length); }
    function prevSlide() { goToSlide((currentIndex - 1 + slides.length) % slides.length); }
    
    nextBtn.addEventListener('click', nextSlide);
    prevBtn.addEventListener('click', prevSlide);
    
    let autoPlay = setInterval(nextSlide, 5000);
    const container = document.querySelector('.carousel-container');
    container.addEventListener('mouseenter', () => clearInterval(autoPlay));
    container.addEventListener('mouseleave', () => { autoPlay = setInterval(nextSlide, 5000); });
    
    createDots();
  });

  // Resaltar menú activo
  const sections = document.querySelectorAll('section');
  const navLinks = document.querySelectorAll('nav a');

  window.addEventListener('scroll', () => {
    let current = '';
    sections.forEach(section => {
      const sectionTop = section.offsetTop - 90;
      if (scrollY >= sectionTop) current = section.getAttribute('id');
    });
    navLinks.forEach(link => {
      link.style.background = '';
      link.style.color = '';
      if (link.getAttribute('href') === `#${current}`) {
        link.style.background = '#8B2C2D';
        link.style.color = 'white';
      }
    });
  });
</script>
</body>
</html>