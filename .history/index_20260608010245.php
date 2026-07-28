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
       HEADER
    ======================================== */
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
      opacity: 0.15; /* Corregido para que no tape el texto */
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

    nav a, nav button {
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
      background: none;
      border: none;
      cursor: pointer;
      font-family: inherit;
    }

    nav a i, nav button i {
      font-size: 0.9rem;
      color: #8B2C2D;
    }

    nav a:hover, nav button:hover {
      background: #8B2C2D;
      color: white;
    }

    nav a:hover i, nav button:hover i {
      color: white;
    }

    /* Botón especial de login en Nav */
    .nav-admin-btn {
      border: 1px solid #8B2C2D;
      color: #8B2C2D;
    }

    /* ========================================
       VENTANA MODAL DE ACCESO (LOGIN)
    ======================================== */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(4px);
      z-index: 200;
      display: none; /* Se activa con JS */
      justify-content: center;
      align-items: center;
    }

    .modal-box {
      background: white;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
      width: 100%;
      max-width: 400px;
      border-top: 5px solid #8B2C2D;
      position: relative;
      animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
      from { transform: translateY(-20px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    .modal-close {
      position: absolute;
      top: 12px;
      right: 15px;
      background: none;
      border: none;
      font-size: 1.2rem;
      color: #888;
      cursor: pointer;
    }
    .modal-close:hover { color: #8B2C2D; }

    .modal-box h3 {
      color: #6B1E1F;
      text-align: center;
      margin-bottom: 1.5rem;
      font-size: 1.4rem;
    }

    .form-group {
      margin-bottom: 1.2rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.4rem;
      font-weight: 600;
      font-size: 0.85rem;
    }

    .form-group input, .form-group select {
      width: 100%;
      padding: 0.7rem;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 0.95rem;
      font-family: inherit;
      outline: none;
    }
    .form-group input:focus, .form-group select:focus {
      border-color: #8B2C2D;
    }

    .btn-login {
      width: 100%;
      padding: 0.75rem;
      background: #8B2C2D;
      color: white;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.2s;
    }
    .btn-login:hover { background: #6B1E1F; }

    /* ========================================
       CONTENEDOR PRINCIPAL
    ======================================== */
    .container {
      max-width: 1200px;
      margin: 2.5rem auto;
      padding: 0 1.5rem;
    }

    /* ========================================
       SECCIONES (MÓDULOS)
    ======================================== */
    section {
      background: white;
      border: 1px solid #f0f0f0;
      border-radius: 12px;
      padding: 2rem;
      margin-bottom: 2rem;
      transition: all 0.15s ease;
      scroll-margin-top: 85px;
    }

    section:hover {
      box-shadow: 0 2px 8px rgba(0,0,0,0.03);
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

    /* Tarjetas de Avisos */
    .pub-card {
      background: #faf8f5;
      padding: 1.5rem;
      border-radius: 10px;
      border-left: 4px solid #8B2C2D;
      margin-bottom: 1.2rem;
    }

    /* ========================================
       CARRUSEL MEJORADO
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

    .carousel {
      position: relative;
      overflow: hidden;
      width: 100%;
    }

    .carousel-track-container {
      overflow: hidden;
      width: 100%;
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
      position: relative;
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
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 10;
      transition: all 0.3s ease;
      font-size: 1.2rem;
    }

    .carousel-btn:hover {
      background: #8B2C2D;
      transform: translateY(-50%) scale(1.05);
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
      transition: all 0.3s ease;
    }

    .carousel-dot.active {
      background: #8B2C2D;
      transform: scale(1.2);
    }

    /* ========================================
       TABLA PROGRAMACIÓN
    ======================================== */
    .table-responsive {
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      border-radius: 10px;
      overflow: hidden;
    }

    th {
      background: #2C5F2D;
      color: white;
      padding: 12px 16px;
      text-align: left;
      font-weight: 600;
    }

    td {
      padding: 12px 16px;
      border-bottom: 1px solid #f0f0f0;
      background: white;
    }

    tr:hover td {
      background: #FDF9F0;
    }

    /* ========================================
       BOTONES REDES SOCIALES
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
      font-size: 0.9rem;
    }

    .facebook-btn { background: #1877F2; color: white; }
    .whatsapp-btn { background: #25D366; color: white; }
    .app-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }

    .btn-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    /* ========================================
       UBICACIÓN
    ======================================== */
    #ubicacion p {
      background: #faf8f5;
      padding: 1rem;
      border-radius: 10px;
      margin-bottom: 1rem;
      border-left: 3px solid #D4AF37;
    }

    iframe {
      width: 100%;
      height: 350px;
      border-radius: 12px;
      border: 1px solid #e8e8e8;
      margin-top: 0.5rem;
    }

    /* ========================================
       FOOTER
    ======================================== */
    footer {
      background: #1a1a2e;
      color: #cbd5e0;
      text-align: center;
      padding: 2rem;
      margin-top: 2rem;
    }

    footer p { margin: 5px 0; }
    footer p:first-child { font-weight: 600; color: white; }

    /* ========================================
       RESPONSIVE
    ======================================== */
    @media (max-width: 768px) {
      header h1 { font-size: 1.4rem; }
      nav a, nav button { padding: 0.4rem 0.9rem; font-size: 0.75rem; }
      section { padding: 1.3rem; }
      section h2 { font-size: 1.2rem; }
      .btn-card { padding: 0.6rem 1.2rem; font-size: 0.8rem; }
      iframe { height: 250px; }
      .carousel-slide img { height: 280px; }
      .carousel-btn { width: 35px; height: 35px; font-size: 1rem; }
    }

    @media (max-width: 480px) {
      .container { padding: 0 1rem; }
      .grid-buttons { flex-direction: column; }
      .btn-card { justify-content: center; }
      th, td { padding: 8px 12px; font-size: 0.85rem; }
      .carousel-slide img { height: 200px; }
      .carousel-btn { width: 30px; height: 30px; font-size: 0.9rem; }
    }
  </style>
</head>
<body>

  <div class="modal-overlay" id="loginModal">
    <div class="modal-box">
      <button class="modal-close" id="closeModalBtn">&times;</button>
      <h3><i class="fas fa-lock"></i> Acceso Interno</h3>
      
      <form action="login.php" method="POST">
        <div class="form-group">
          <label>Ingresar como:</label>
          <select name="rol" required>
            <option value="administrador">Administrador (Gerente)</option>
            <option value="colaborador">Colaborador</option>
          </select>
        </div>
        <div class="form-group">
          <label>Usuario</label>
          <input type="text" name="usuario" placeholder="Ej: gerente_admin" required>
        </div>
        <div class="form-group">
          <label>Contraseña</label>
          <input type="password" name="password" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn-login">Iniciar Sesión</button>
      </form>
    </div>
  </div>

  <header>
    <img src="logo.png" alt="Logo Radio Pakal" class="logo" onerror="this.src='https://placehold.co/85x85?text=RP'">
    <h1>RADIO PAKAL 1040 AM</h1>
    <p> CAPITAL MAYA </p>
  </header>

  <nav>
    <a href="#quienes"><i class="fas fa-users"></i> Quiénes Somos</a>
    <a href="#noticias"><i class="fas fa-newspaper"></i> Noticias y Avisos</a>
    <a href="#programacion"><i class="fas fa-calendar-alt"></i> Programación</a>
    <a href="#redes"><i class="fas fa-share-alt"></i> Redes Sociales</a>
    <a href="#app"><i class="fas fa-mobile-alt"></i> App Móvil</a>
    <a href="#ubicacion"><i class="fas fa-map-marker-alt"></i> Ubicación</a>
    <button class="nav-admin-btn" id="openModalBtn"><i class="fas fa-user-shield"></i> Acceso solo para Administradores</button>
  </nav>

  <div class="container">
    
    <section id="quienes">
      <h2><i class="fas fa-users"></i> Quiénes Somos</h2>
      <p><strong>Radio Pakal 1040 AM</strong> es una emisora comunitaria profundamente arraigada en Palenque, Chiapas. 
         Promovemos la riqueza cultural, la música de nuestra región y la identidad de nuestra gente, 
         transmitiendo con orgullo tanto en español como en nuestras valiosas lenguas originarias (Ch'ol y Tzeltal).</p>
      <p style="margin-top: 0.8rem;">Somos parte del compromiso del Gobierno del Estado de Chiapas por llevar información, educación y entertainment a cada rincón de nuestra tierra.</p>
      
      <div class="carousel-section">
        <div class="carousel-container">
          <div class="carousel">
            <div class="carousel-track-container">
              <ul class="carousel-track">
                <li class="carousel-slide"><img src="B.png" alt="Cabina" onerror="this.src='https://placehold.co/900x400?text=Radio+Pakal+1'"></li>
                <li class="carousel-slide"><img src="D.png" alt="Transmisión" onerror="this.src='https://placehold.co/900x400?text=Radio+Pakal+2'"></li>
                <li class="carousel-slide"><img src=".png" alt="Comunidad" onerror="this.src='https://placehold.co/900x400?text=Radio+Pakal+3'"></li>
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
    </section>

    <section id="noticias">
      <h2><i class="fas fa-newspaper"></i> Últimas Publicaciones y Comunicados</h2>
      <div style="margin-top: 1rem;">
        <?php
        $res_pub = mysqli_query($conn, "SELECT titulo, contenido, fecha_creacion, autor FROM publicaciones ORDER BY id DESC LIMIT 5");
        if ($res_pub && mysqli_num_rows($res_pub) > 0) {
            while ($pub = mysqli_fetch_assoc($res_pub)) {
                echo "<div class='pub-card'>";
                echo "<h3 style='color: #6B1E1F; margin-bottom: 0.2rem;'>" . htmlspecialchars($pub['titulo']) . "</h3>";
                echo "<small style='color: #777; display:block; margin-bottom: 0.8rem;'>📅 Publicado: " . date('d/m/Y H:i', strtotime($pub['fecha_creacion'])) . " por " . htmlspecialchars($pub['autor']) . "</small>";
                echo "<p style='white-space: pre-line; color: #222;'>" . htmlspecialchars($pub['contenido']) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p style='text-align: center; padding: 1rem; color: #777;'>📻 No hay comunicados recientes por el momento.</p>";
        }
        ?>
      </div>
    </section>

    <section id="programacion">
      <h2><i class="fas fa-calendar-alt"></i> Programación del Día</h2>
      <div class="table-responsive">
        <table>
          <thead>
            <tr>
              <th><i class="far fa-clock"></i> Horario</th>
              <th><i class="fas fa-microphone-alt"></i> Programa</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Ajustado para ordenar cronológicamente cualquier hora nueva ingresada en el panel
            $result = mysqli_query($conn, "SELECT hora, programme = programa FROM programacion ORDER BY hora ASC");
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td><strong>" . htmlspecialchars($row['hora']) . "</strong></td>";
                    echo "<td>" . htmlspecialchars($row['programme']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2' style='text-align: center; padding: 1.5rem;'>📻 Por el momento no hay horarios registrados. Consulte nuestras redes sociales.</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </section>

    <section id="redes">
      <h2><i class="fab fa-facebook"></i> Síguenos en Redes Sociales</h2>
      <div class="grid-buttons">
        <a href="https://www.facebook.com/search/top?q=XEPLE%20Radio%20Palenque" target="_blank" class="btn-card facebook-btn">
          <i class="fab fa-facebook-f"></i> Facebook: XEPLE Radio Palenque
        </a>
        <a href="https://wa.me/529935990830" target="_blank" class="btn-card whatsapp-btn">
          <i class="fab fa-whatsapp"></i> WhatsApp Cabina
        </a>
      </div>
    </section>

    <section id="app">
      <h2><i class="fas fa-download"></i> Lleva la Radio en tu Bolsillo</h2>
      <div class="grid-buttons">
        <a href="https://example.com/app" target="_blank" class="btn-card app-btn">
          <i class="fas fa-qrcode"></i> Descargar Aplicación Android / iOS
        </a>
      </div>
    </section>

    <section id="ubicacion">
      <h2><i class="fas fa-location-dot"></i> Nuestra Ubicación</h2>
      <p><i class="fas fa-map-pin"></i> <strong>Dirección:</strong> AV. Corregidora S/N Planta Alta, Palenque, Chiapas. C.P. 29960</p>
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3810.7351659223366!2d-91.985055!3d17.509444!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85f4426e7f4bcb7f%3A0x8b8b8b8b8b8b8b8b!2sPalenque%2C%20Chiapas!5e0!3m2!1ses!2smx!4v1700000000000" allowfullscreen="" loading="lazy"></iframe>
    </section>
  </div>

  <footer>
    <p>© <?php echo date('Y'); ?> Radio Pakal 1040 AM — Palenque, Chiapas</p>
    <p>Sistema Chiapaneco de Radio, Televisión y Cinematografía</p>
  </footer>

  <script>
    // Lógica para Abrir/Cerrar la Ventana Modal del Login
    const modal = document.getElementById('loginModal');
    const openBtn = document.getElementById('openModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');

    openBtn.addEventListener('click', () => modal.style.display = 'flex');
    closeBtn.addEventListener('click', () => modal.style.display = 'none');
    window.addEventListener('click', (e) => { if (e.target === modal) modal.style.display = 'none'; });

    // Resaltar menú activo al hacer scroll
    const sections = document.querySelectorAll('section');
    const navLinks = document.querySelectorAll('nav a');
    window.addEventListener('scroll', () => {
      let current = '';
      sections.forEach(section => {
        const sectionTop = section.offsetTop - 90;
        if (window.scrollY >= sectionTop) current = section.getAttribute('id');
      });
      navLinks.forEach(link => {
        link.style.background = ''; link.style.color = '';
        const icon = link.querySelector('i');
        if (icon) icon.style.color = '#8B2C2D';
        if (link.getAttribute('href') === `#${current}`) {
          link.style.background = '#8B2C2D'; link.style.color = 'white';
          if (icon) icon.style.color = 'white';
        }
      });
    });

    // CARRUSEL
    document.addEventListener('DOMContentLoaded', function() {
      const track = document.querySelector('.carousel-track');
      const slides = Array.from(document.querySelectorAll('.carousel-slide'));
      const prevBtn = document.getElementById('prevBtn');
      const nextBtn = document.getElementById('nextBtn');
      const dotsContainer = document.getElementById('dotsContainer');
      if (!track || slides.length === 0) return;
      let currentIndex = 0;

      function createDots() {
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
        track.style.transform = `translateX(${-currentIndex * 100}%)`;
        updateDots();
      }
      nextBtn.addEventListener('click', () => { currentIndex = (currentIndex + 1) % slides.length; goToSlide(currentIndex); });
      prevBtn.addEventListener('click', () => { currentIndex = (currentIndex - 1 + slides.length) % slides.length; goToSlide(currentIndex); });
      setInterval(() => { currentIndex = (currentIndex + 1) % slides.length; goToSlide(currentIndex); }, 5000);
      createDots();
    });
  </script>
</body>
</html>