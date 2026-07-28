<?php include("db.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <meta name="description" content="Radio Pakal 1040 AM - La voz oficial de Palenque, Chiapas. Música, cultura y noticias comunitarias.">
  <title>RADIO PAKAL 1040 AM | Oficial - Palenque, Chiapas</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    /* ========================================
       VARIABLES Y RESET
    ======================================== */
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
       MODAL LOGIN
    ======================================== */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.7);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 2000;
    }

    .modal-overlay.active {
      display: flex;
    }

    .modal-box {
      background: white;
      border-radius: 20px;
      padding: 2rem;
      width: 90%;
      max-width: 420px;
      position: relative;
      box-shadow: 0 20px 40px rgba(0,0,0,0.3);
      animation: modalSlide 0.3s ease-out;
    }

    @keyframes modalSlide {
      from { transform: translateY(-50px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    .modal-close {
      position: absolute;
      top: 15px;
      right: 20px;
      background: none;
      border: none;
      font-size: 1.8rem;
      cursor: pointer;
      color: #999;
      transition: all 0.3s;
    }

    .modal-close:hover {
      color: #8B2C2D;
    }

    .modal-box h3 {
      color: #8B2C2D;
      margin-bottom: 1.5rem;
      text-align: center;
      font-size: 1.5rem;
    }

    .modal-box h3 i {
      margin-right: 10px;
    }

    .form-group {
      margin-bottom: 1.2rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 600;
      color: #333;
    }

    .form-group select,
    .form-group input {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 0.9rem;
      transition: all 0.3s;
    }

    .form-group select:focus,
    .form-group input:focus {
      outline: none;
      border-color: #8B2C2D;
      box-shadow: 0 0 0 3px rgba(139,44,45,0.1);
    }

    .btn-login {
      width: 100%;
      padding: 12px;
      background: #8B2C2D;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
    }

    .btn-login:hover {
      background: #6B1E1F;
      transform: translateY(-2px);
    }

    /* Barra de Admin */
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

    /* Botón Admin en navegación */
    .btn-nav-admin {
      background: #8B2C2D !important;
      color: white !important;
    }

    .btn-nav-admin i {
      color: white !important;
    }

    .btn-nav-admin:hover {
      background: #6B1E1F !important;
    }

    /* Header */
    header {
      background: #ffffff;
      text-align: center;
      padding: 2rem 1.5rem;
      position: relative;
      border-bottom: 1px solid #f0f0f0;
    }

    header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image: url('F.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      opacity: 0.15;
      pointer-events: none;
    }

    header > * {
      position: relative;
      z-index: 1;
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

    /* Navegación */
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

    /* Contenedor */
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

    /* Tarjetas de publicaciones */
    .pub-card {
      background: #faf8f5;
      padding: 1.5rem;
      border-radius: 10px;
      border-left: 4px solid #8B2C2D;
      margin-bottom: 1.2rem;
    }

    .pub-card h3 {
      color: #6B1E1F;
      margin-bottom: 0.3rem;
    }

    .pub-date {
      color: #777;
      font-size: 0.8rem;
      display: block;
      margin-bottom: 0.8rem;
    }

    /* Carrusel */
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
      background: rgba(139,44,45,0.7);
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

    /* Tabla */
    .table-responsive { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; border-radius: 10px; overflow: hidden; }
    th { background: #2C5F2D; color: white; padding: 12px 16px; text-align: left; }
    td { padding: 12px 16px; border-bottom: 1px solid #f0f0f0; }
    tr:hover td { background: #FDF9F0; }

    /* Redes Sociales */
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
      transition: all 0.3s;
    }

    .facebook-btn { background: #1877F2; color: white; }
    .whatsapp-btn { background: #25D366; color: white; }
    .app-btn { background: linear-gradient(135deg, #667eea, #764ba2); color: white; }
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
$isLoggedIn = isset($_SESSION['admin_id']);
$userRol = isset($_SESSION['admin_rol']) ? $_SESSION['admin_rol'] : '';
$userNombre = isset($_SESSION['admin_nombre']) ? $_SESSION['admin_nombre'] : '';

if ($isLoggedIn): ?>
<div class="admin-panel-bar">
  <i class="fas fa-user-shield"></i> Bienvenido, <?php echo htmlspecialchars($userNombre); ?> (<?php echo $userRol; ?>)
  <a href="admin/dashboard.php"><i class="fas fa-tachometer-alt"></i> Panel de Control</a>
  <a href="admin/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
</div>
<?php endif; ?>

<header>
  <img src="logo.png" alt="Logo Radio Pakal" class="logo" onerror="this.src='https://placehold.co/85x85?text=RP'">
  <h1>RADIO PAKAL 1040 AM</h1>
  <p>CAPITAL MAYA</p>
</header>

<nav>
  <a href="#quienes"><i class="fas fa-users"></i> Quiénes Somos</a>
  <a href="#publicaciones"><i class="fas fa-newspaper"></i> Publicaciones</a>
  <a href="#programacion"><i class="fas fa-calendar-alt"></i> Programación</a>
  <a href="#redes"><i class="fas fa-share-alt"></i> Redes Sociales</a>
  <a href="#app"><i class="fas fa-mobile-alt"></i> App Móvil</a>
  <a href="#ubicacion"><i class="fas fa-map-marker-alt"></i> Ubicación</a>
  <button class="btn-nav-admin" id="openModalBtn"><i class="fas fa-user-lock"></i> Acceso Administrativo</button>
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
        <div class="carousel-dots" id="dotsContainer"></div>
      </div>
    </div>
  </section>

  <!-- MÓDULO 2: Publicaciones/Noticias -->
  <section id="publicaciones">
    <h2><i class="fas fa-newspaper"></i> Últimas Publicaciones</h2>
    <?php
    $result_pub = mysqli_query($conn, "SELECT * FROM publicaciones WHERE activo = 1 ORDER BY fecha_publicacion DESC LIMIT 10");
    if (mysqli_num_rows($result_pub) > 0) {
        while ($pub = mysqli_fetch_assoc($result_pub)) {
            echo '<div class="pub-card">';
            echo '<h3>' . htmlspecialchars($pub['titulo']) . '</h3>';
            echo '<small class="pub-date"><i class="far fa-calendar-alt"></i> ' . date('d/m/Y H:i', strtotime($pub['fecha_publicacion'])) . '</small>';
            echo '<p>' . nl2br(htmlspecialchars(substr($pub['contenido'], 0, 500))) . '</p>';
            if ($pub['imagen']) {
                echo '<img src="' . htmlspecialchars($pub['imagen']) . '" style="max-width: 100%; max-height: 250px; object-fit: cover; border-radius: 8px; margin-top: 0.5rem;">';
            }
            echo '</div>';
        }
    } else {
        echo '<p style="text-align: center; padding: 1rem;">No hay publicaciones aún. ¡Pronto más contenido!</p>';
    }
    ?>
  </section>

  <!-- MÓDULO 3: Programación -->
  <section id="programacion">
    <h2><i class="fas fa-calendar-alt"></i> Programación del Día</h2>
    <div class="table-responsive">
      <table>
        <thead><tr><th>Horario</th><th>Programa</th></tr></thead>
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
      <a href="#" class="btn-card app-btn"><i class="fas fa-qrcode"></i> Descargar Aplicación Android / iOS</a>
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

<!-- MODAL LOGIN -->
<div class="modal-overlay" id="loginModal">
  <div class="modal-box">
    <button class="modal-close" id="closeModalBtn">&times;</button>
    <h3><i class="fas fa-lock"></i> Acceso Interno</h3>
    
    <form action="admin/login_process.php" method="POST">
      <div class="form-group">
        <label>Ingresar como:</label>
        <select name="rol" required>
          <option value="admin">Administrador (Gerente)</option>
          <option value="colaborador">Colaborador</option>
        </select>
      </div>
      <div class="form-group">
        <label>Usuario</label>
        <input type="text" name="usuario" placeholder="Ingresa tu usuario" required>
      </div>
      <div class="form-group">
        <label>Contraseña</label>
        <input type="password" name="password" placeholder="••••••••" required>
      </div>
      <button type="submit" class="btn-login"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</button>
    </form>
  </div>
</div>

<script>
  // Modal Login
  const modal = document.getElementById('loginModal');
  const openBtn = document.getElementById('openModalBtn');
  const closeBtn = document.getElementById('closeModalBtn');

  openBtn.addEventListener('click', () => {
    modal.classList.add('active');
  });

  closeBtn.addEventListener('click', () => {
    modal.classList.remove('active');
  });

  modal.addEventListener('click', (e) => {
    if (e.target === modal) {
      modal.classList.remove('active');
    }
  });

  // Resaltar menú activo al hacer scroll
  const sections = document.querySelectorAll('section');
  const navLinks = document.querySelectorAll('nav a');

  window.addEventListener('scroll', () => {
    let current = '';
    sections.forEach(section => {
      const sectionTop = section.offsetTop - 90;
      if (window.scrollY >= sectionTop) {
        current = section.getAttribute('id');
      }
    });

    navLinks.forEach(link => {
      link.style.background = '';
      link.style.color = '';
      const icon = link.querySelector('i');
      if (link.getAttribute('href') === `#${current}`) {
        link.style.background = '#8B2C2D';
        link.style.color = 'white';
        if (icon) icon.style.color = 'white';
      } else {
        link.style.background = '';
        link.style.color = '';
        if (icon) icon.style.color = '#8B2C2D';
      }
    });
  });

  // Carrusel
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
</script>
</body>
</html>