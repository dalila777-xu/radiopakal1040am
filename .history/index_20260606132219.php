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
       CONTENEDOR
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

    /* ========================================
       CARRUSEL
    ======================================== */
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

    /* ========================================
       FACEBOOK FEED
    ======================================== */
    .facebook-feed-container {
      width: 100%;
      min-height: 600px;
      border-radius: 12px;
      border: 1px solid #e8e8e8;
      overflow: hidden;
      background: #f8f5f0;
    }

    .fb-page { width: 100% !important; }

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

    /* Responsive */
    @media (max-width: 768px) {
      .carousel-slide img { height: 280px; }
      .carousel-btn { width: 35px; height: 35px; font-size: 1rem; }
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

  <!-- Botón flotante para administradores -->
  <a href="admin/login.php" class="admin-float-btn" title="Panel de Administración">
    <i class="fas fa-cog"></i>
  </a>

  <header>
    <img src="logo.png" alt="Logo Radio Pakal" class="logo" onerror="this.src='https://placehold.co/85x85?text=RP'">
    <h1>RADIO PAKAL 1040 AM</h1>
    <p>CAPITAL MAYA</p>
  </header>

  <nav>
    <a href="#quienes"><i class="fas fa-users"></i> Quiénes Somos</a>
    <a href="#ubicacion"><i class="fas fa-map-marker-alt"></i> Ubicación</a>
    <a href="#programacion"><i class="fas fa-calendar-alt"></i> Programación</a>
    <a href="#facebook-feed"><i class="fab fa-facebook"></i> Últimas Publicaciones</a>
    <a href="#redes"><i class="fas fa-share-alt"></i> Redes Sociales</a>
    <a href="#app"><i class="fas fa-mobile-alt"></i> App Móvil</a>
  </nav>

  <div class="container">
    
    <section id="quienes">
      <h2><i class="fas fa-users"></i> Quiénes Somos</h2>
      <p><strong>Radio Pakal 1040 AM</strong> es una emisora comunitaria profundamente arraigada en Palenque, Chiapas. 
         Promovemos la riqueza cultural, la música de nuestra región y la identidad de nuestra gente, 
         transmitiendo con orgullo tanto en español como en nuestras valiosas lenguas originarias (Ch'ol y Tzeltal).</p>
      <p style="margin-top: 0.8rem;">Somos parte del compromiso del Gobierno del Estado de Chiapas por llevar información, educación y entretenimiento a cada rincón de nuestra tierra.</p>
      
      <div class="carousel-container">
        <div class="carousel-track" id="carouselTrack">
          <?php
          $result_carrusel = mysqli_query($conn, "SELECT * FROM carrusel WHERE activo = 1 ORDER BY orden ASC");
          if (mysqli_num_rows($result_carrusel) > 0) {
              while ($item = mysqli_fetch_assoc($result_carrusel)) {
                  echo '<div class="carousel-slide">';
                  echo '<img src="' . htmlspecialchars($item['imagen']) . '" alt="' . htmlspecialchars($item['titulo']) . '">';
                  echo '</div>';
              }
          } else {
              // Imágenes por defecto
              echo '<div class="carousel-slide"><img src="https://placehold.co/900x400?text=Radio+Pakal+1" alt="Radio Pakal"></div>';
              echo '<div class="carousel-slide"><img src="https://placehold.co/900x400?text=Radio+Pakal+2" alt="Radio Pakal"></div>';
              echo '<div class="carousel-slide"><img src="https://placehold.co/900x400?text=Radio+Pakal+3" alt="Radio Pakal"></div>';
          }
          ?>
        </div>
        <button class="carousel-btn carousel-btn-prev" id="prevBtn">❮</button>
        <button class="carousel-btn carousel-btn-next" id="nextBtn">❯</button>
        <div class="carousel-dots" id="dotsContainer"></div>
      </div>
    </section>

    <section id="programacion">
      <h2><i class="fas fa-calendar-alt"></i> Programación del Día</h2>
      <div class="table-responsive">
        <table>
          <thead>
            <tr><th>Horario</th><th>Programa</th><th>Descripción</th></tr>
          </thead>
          <tbody>
            <?php
            $result = mysqli_query($conn, "SELECT hora, programa, descripcion FROM programacion WHERE activo = 1 ORDER BY orden ASC");
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td><strong>" . htmlspecialchars($row['hora']) . "</strong></td>";
                    echo "<td>" . htmlspecialchars($row['programa']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['descripcion']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>📻 No hay horarios registrados</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </section>

    <section id="facebook-feed">
      <h2><i class="fab fa-facebook"></i> Últimas Publicaciones - Facebook</h2>
      <p style="margin-bottom: 1rem; color: #666;">
        <i class="fas fa-sync-alt"></i> Contenido actualizado automáticamente. 
        <strong>¡Síguenos para más contenido!</strong> Publicaciones, fotos, videos y transmisiones en vivo.
      </p>
      <div id="fb-root"></div>
      <div class="facebook-feed-container">
        <div class="fb-page" 
             data-href="https://www.facebook.com/profile.php?id=61573503869607" 
             data-tabs="timeline" 
             data-width="100%" 
             data-height="650" 
             data-small-header="false" 
             data-adapt-container-width="true" 
             data-hide-cover="false" 
             data-show-facepile="true">
          <blockquote cite="https://www.facebook.com/profile.php?id=61573503869607" class="fb-xfbml-parse-ignore">
            <a href="https://www.facebook.com/profile.php?id=61573503869607">Radio Pakal 1040 AM</a>
          </blockquote>
        </div>
      </div>
    </section>

    <section id="redes">
      <h2><i class="fas fa-share-alt"></i> Síguenos en Redes Sociales</h2>
      <div class="grid-buttons">
        <a href="https://www.facebook.com/profile.php?id=61573503869607" target="_blank" class="btn-card facebook-btn">
          <i class="fab fa-facebook-f"></i> Facebook: Radio Pakal 1040 AM
        </a>
        <a href="https://wa.me/529935990830" target="_blank" class="btn-card whatsapp-btn">
          <i class="fab fa-whatsapp"></i> WhatsApp Cabina
        </a>
      </div>
    </section>

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

  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v18.0"></script>

  <script>
    // Menú activo
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

    // Carrusel
    document.addEventListener('DOMContentLoaded', function() {
      const track = document.getElementById('carouselTrack');
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