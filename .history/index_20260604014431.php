<?php include("db.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Radio Pakal 1040 AM - La voz oficial de Palenque, Chiapas. Programación cultural, música tradicional y noticias comunitarias.">
  <meta name="keywords" content="Radio Pakal, Palenque, Chiapas, 1040 AM, radio comunitaria, música tradicional">
  <title>Radio Pakal 1040 AM | Oficial - Palenque, Chiapas</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    /* ========================================
       VARIABLES Y RESET
    ======================================== */
    :root {
      --primary: #8B2C2D;
      --primary-dark: #6B1E1F;
      --secondary: #2C5F2D;
      --accent: #D4AF37;
      --light: #FDF9F0;
      --dark: #1A1A2E;
      --gray: #4A5568;
      --gray-light: #E2E8F0;
      --white: #FFFFFF;
      --shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
      --shadow-lg: 0 20px 40px -12px rgba(0,0,0,0.15);
      --transition: all 0.3s ease;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--light);
      color: var(--dark);
      line-height: 1.6;
      scroll-behavior: smooth;
    }

    /* ========================================
       HEADER PROFESIONAL
    ======================================== */
    header {
      background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
      text-align: center;
      padding: 2.5rem 1.5rem;
      position: relative;
      overflow: hidden;
    }

    header::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255,255,255,0.08) 1px, transparent 1px);
      background-size: 40px 40px;
      pointer-events: none;
    }

    .logo {
      width: 85px;
      height: auto;
      margin-bottom: 1rem;
      filter: drop-shadow(0 4px 10px rgba(0,0,0,0.2));
      transition: var(--transition);
    }

    .logo:hover {
      transform: scale(1.05);
    }

    header h1 {
      color: var(--white);
      font-size: 2rem;
      font-weight: 700;
      letter-spacing: -0.5px;
      margin-bottom: 0.5rem;
    }

    header p {
      color: rgba(255,255,255,0.9);
      font-size: 1rem;
      font-weight: 400;
    }

    /* ========================================
       NAVEGACIÓN STICKY
    ======================================== */
    nav {
      background: var(--white);
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 0.5rem;
      padding: 1rem 1.5rem;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: var(--shadow);
      border-bottom: 3px solid var(--accent);
    }

    nav a {
      color: var(--dark);
      text-decoration: none;
      font-weight: 600;
      padding: 0.6rem 1.3rem;
      border-radius: 40px;
      transition: var(--transition);
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    nav a i {
      font-size: 1rem;
      color: var(--primary);
    }

    nav a:hover {
      background: var(--primary);
      color: var(--white);
      transform: translateY(-2px);
    }

    nav a:hover i {
      color: var(--white);
    }

    /* ========================================
       BANNER PRINCIPAL
    ======================================== */
    .banner-presentacion {
      max-width: 1200px;
      margin: 2rem auto 0 auto;
      padding: 0 1.5rem;
    }

    .banner-presentacion img {
      width: 100%;
      height: auto;
      max-height: 450px;
      object-fit: cover;
      border-radius: 24px;
      box-shadow: var(--shadow-lg);
      transition: transform 0.4s ease;
    }

    .banner-presentacion img:hover {
      transform: scale(1.01);
    }

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
      background: var(--white);
      border-radius: 28px;
      padding: 2rem;
      margin-bottom: 2rem;
      box-shadow: 0 5px 20px rgba(0,0,0,0.03);
      transition: var(--transition);
      border: 1px solid rgba(0,0,0,0.05);
      scroll-margin-top: 90px;
    }

    section:hover {
      box-shadow: var(--shadow);
      transform: translateY(-3px);
    }

    section h2 {
      font-size: 1.6rem;
      font-weight: 700;
      margin-bottom: 1.2rem;
      display: flex;
      align-items: center;
      gap: 12px;
      border-left: 4px solid var(--accent);
      padding-left: 1rem;
      color: var(--primary-dark);
    }

    section h2 i {
      color: var(--accent);
      font-size: 1.6rem;
    }

    .about-img {
      width: 100%;
      max-width: 450px;
      border-radius: 20px;
      margin-top: 1.5rem;
      box-shadow: var(--shadow);
      display: block;
    }

    /* ========================================
       TABLA DE PROGRAMACIÓN
    ======================================== */
    .table-responsive {
      overflow-x: auto;
      margin-top: 1rem;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      border-radius: 16px;
      overflow: hidden;
    }

    th {
      background: var(--secondary);
      color: var(--white);
      padding: 14px 16px;
      font-weight: 600;
      text-align: left;
    }

    td {
      padding: 12px 16px;
      border-bottom: 1px solid var(--gray-light);
      background: var(--white);
    }

    tr:hover td {
      background: rgba(212, 175, 55, 0.05);
    }

    /* ========================================
       BOTONES Y TARJETAS
    ======================================== */
    .grid-buttons {
      display: flex;
      flex-wrap: wrap;
      gap: 1.2rem;
      margin-top: 1rem;
    }

    .btn-card {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      padding: 0.9rem 1.8rem;
      border-radius: 50px;
      text-decoration: none;
      font-weight: 600;
      transition: var(--transition);
      font-size: 0.95rem;
    }

    .facebook-btn {
      background: #1877F2;
      color: var(--white);
    }

    .whatsapp-btn {
      background: #25D366;
      color: var(--white);
    }

    .app-btn {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: var(--white);
    }

    .btn-card:hover {
      transform: translateY(-4px);
      box-shadow: var(--shadow-lg);
      filter: brightness(1.05);
    }

    /* ========================================
       MAPA Y UBICACIÓN
    ======================================== */
    #ubicacion p {
      background: var(--light);
      padding: 1rem;
      border-radius: 12px;
      margin: 1rem 0;
      border-left: 3px solid var(--accent);
    }

    iframe {
      border-radius: 20px;
      margin-top: 0.5rem;
      width: 100%;
      height: 380px;
      border: 0;
      box-shadow: var(--shadow);
    }

    /* ========================================
       FOOTER
    ======================================== */
    footer {
      background: var(--dark);
      color: #CBD5E0;
      text-align: center;
      padding: 2rem;
      margin-top: 2rem;
    }

    footer p {
      margin: 8px 0;
    }

    footer p:first-child {
      font-weight: 600;
      color: var(--white);
    }

    /* ========================================
       RESPONSIVE
    ======================================== */
    @media (max-width: 768px) {
      header h1 {
        font-size: 1.5rem;
      }
      
      nav a {
        padding: 0.4rem 1rem;
        font-size: 0.8rem;
      }
      
      section {
        padding: 1.5rem;
      }
      
      section h2 {
        font-size: 1.3rem;
      }
      
      .btn-card {
        padding: 0.7rem 1.2rem;
        font-size: 0.85rem;
      }
      
      .banner-presentacion img {
        max-height: 250px;
      }
    }

    @media (max-width: 480px) {
      .container {
        padding: 0 1rem;
      }
      
      nav {
        gap: 0.3rem;
      }
      
      nav a {
        padding: 0.3rem 0.8rem;
        font-size: 0.7rem;
      }
      
      .grid-buttons {
        flex-direction: column;
      }
      
      .btn-card {
        justify-content: center;
      }
    }
  </style>
</head>
<body>

  <!-- Encabezado con Logotipo -->
  <header>
    <img src="logo.png" alt="Logo Radio Pakal" class="logo" onerror="this.src='https://placehold.co/85x85?text=RP'">
    <h1>Radio Pakal 1040 AM</h1>
    <p>La voz de Palenque que conecta con la comunidad</p>
  </header>

  <!-- Menú de navegación (con íconos) -->
  <nav>
    <a href="#quienes"><i class="fas fa-users"></i> Quiénes Somos</a>
    <a href="#ubicacion"><i class="fas fa-map-marker-alt"></i> Ubicación</a>
    <a href="#programacion"><i class="fas fa-calendar-alt"></i> Programación</a>
    <a href="#redes"><i class="fas fa-share-alt"></i> Redes Sociales</a>
    <a href="#app"><i class="fas fa-mobile-alt"></i> App Móvil</a>
  </nav>

  <!-- IMAGEN DE PORTADA / PRESENTACIÓN -->
  <div class="banner-presentacion">
    <img src="portada.jpg" alt="Presentación de Radio Pakal 1040 AM - Palenque, Chiapas" onerror="this.src='https://placehold.co/1200x450?text=Radio+Pakal+1040+AM'">
  </div>

  <div class="container">
    
    <!-- MÓDULO 1: Quiénes Somos -->
    <section id="quienes">
      <h2><i class="fas fa-users"></i> Quiénes Somos</h2>
      <p><strong>Radio Pakal 1040 AM</strong> es una emisora comunitaria profundamente arraigada en Palenque, Chiapas. 
         Promovemos la riqueza cultural, la música de nuestra región y la identidad de nuestra gente, 
         transmitiendo con orgullo tanto en español como en nuestras valiosas lenguas originarias (Ch'ol y Tzeltal).</p>
      <p style="margin-top: 1rem;">Somos parte del compromiso del Gobierno del Estado de Chiapas por llevar información, educación y entretenimiento a cada rincón de nuestra tierra.</p>
      <img src="radio.png" alt="Imagen de Radio Pakal 1040" class="about-img" onerror="this.style.display='none'">
    </section>

    <!-- MÓDULO 2: Programación -->
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
            $result = mysqli_query($conn, "SELECT hora, programa FROM programacion ORDER BY FIELD(hora, '06:00', '08:00', '12:00', '15:00', '18:00', '20:00', '22:00')");
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td><strong>" . htmlspecialchars($row['hora']) . "</strong></td>";
                    echo "<td>" . htmlspecialchars($row['programa']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2' style='text-align: center; padding: 2rem;'>📻 Por el momento no hay horarios registrados. Consulte nuestras redes sociales.</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </section>

    <!-- MÓDULO 3: Redes Sociales -->
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

    <!-- MÓDULO 4: App Móvil -->
    <section id="app">
      <h2><i class="fas fa-download"></i> Lleva la Radio en tu Bolsillo</h2>
      <div class="grid-buttons">
        <a href="https://tu-enlace-de-app.com" target="_blank" class="btn-card app-btn">
          <i class="fas fa-qrcode"></i> Descargar Aplicación Android / iOS
        </a>
      </div>
      <p style="margin-top: 1rem; font-size: 0.85rem; color: var(--gray);">
        <i class="fas fa-headphones"></i> Escúchanos en vivo, participa en encuestas y recibe notificaciones exclusivas.
      </p>
    </section>

    <!-- MÓDULO 5: Ubicación -->
    <section id="ubicacion">
      <h2><i class="fas fa-location-dot"></i> Nuestra Ubicación</h2>
      <p><i class="fas fa-map-pin"></i> <strong>Dirección:</strong> AV. Corregidora S/N Planta Alta, entre las calles Javier Mina y Chiapas, Palenque, Chiapas. C.P. 29960</p>
      <p><i class="fas fa-phone-alt"></i> <strong>Contacto:</strong> (961) 617 0500 Ext. 57000</p>
      <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3810.7351659223366!2d-91.985055!3d17.509444!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85f4426e7f4bcb7f%3A0x8b8b8b8b8b8b8b8b!2sPalenque%2C%20Chiapas!5e0!3m2!1ses!2smx!4v1700000000000" 
        allowfullscreen="" 
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </section>
  </div>

  <!-- Pie de página -->
  <footer>
    <p>&copy; <?php echo date('Y'); ?> Radio Pakal 1040 AM — Palenque, Chiapas</p>
    <p>🌽 Conectando culturas, uniendo comunidades.</p>
    <p style="font-size: 0.8rem; margin-top: 0.5rem;">Sistema Chiapaneco de Radio, Televisión y Cinematografía | Humanismo que transforma</p>
  </footer>

  <!-- Script para resaltar el menú activo al hacer scroll -->
  <script>
    const sections = document.querySelectorAll('section');
    const navLinks = document.querySelectorAll('nav a');

    window.addEventListener('scroll', () => {
      let current = '';
      sections.forEach(section => {
        const sectionTop = section.offsetTop - 100;
        const sectionBottom = sectionTop + section.offsetHeight;
        if (scrollY >= sectionTop && scrollY < sectionBottom) {
          current = section.getAttribute('id');
        }
      });

      navLinks.forEach(link => {
        link.style.background = '';
        link.style.color = '';
        if (link.getAttribute('href') === `#${current}`) {
          link.style.background = '#8B2C2D';
          link.style.color = 'white';
          const icon = link.querySelector('i');
          if (icon) icon.style.color = 'white';
        } else {
          link.style.background = '';
          link.style.color = '';
          const icon = link.querySelector('i');
          if (icon) icon.style.color = '#8B2C2D';
        }
      });
    });
  </script>
</body>
</html>