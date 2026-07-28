<?php include("db.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Radio Pakal 1040 AM — Palenque, Chiapas</title>
  
  <style>
    :root {
      --primary: #0a3d2e;     /* Verde Esmeralda Corporativo */
      --secondary: #16644c;   /* Verde Medio */
      --accent: #ca9e1b;      /* Oro Viejo Metálico */
      --dark: #0f1412;        /* Fondo footer oscuro */
      --bg-slate: #f8faf9;    /* Fondo general limpio */
      --border-color: #e2e8f0;
      --text-main: #1e293b;
      --text-muted: #64748b;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      scroll-behavior: smooth;
    }

    body {
      font-family: '-apple-system', BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      background-color: var(--bg-slate);
      color: var(--text-main);
      -webkit-font-smoothing: antialiased;
    }

    /* --- NAVEGACIÓN SUPERIOR --- */
    nav {
      background-color: rgba(255, 255, 255, 0.95);
      position: sticky;
      top: 0;
      z-index: 1000;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.8rem 4rem;
      border-bottom: 1px solid var(--border-color);
      backdrop-filter: blur(8px);
    }

    .nav-brand {
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
      color: var(--primary);
      font-weight: 700;
      font-size: 1.25rem;
      letter-spacing: -0.5px;
    }

    .nav-brand img {
      height: 40px;
      width: auto;
    }

    .nav-links {
      display: flex;
      gap: 2rem;
      list-style: none;
    }

    .nav-links a {
      color: var(--text-muted);
      text-decoration: none;
      font-weight: 500;
      font-size: 0.95rem;
      transition: color 0.2s ease;
    }

    .nav-links a:hover {
      color: var(--primary);
    }

    /* --- ENCABEZADO PRINCIPAL (HERO) --- */
    header {
      background: linear-gradient(135deg, var(--primary) 0%, #052219 100%);
      color: #ffffff;
      padding: 5rem 4rem;
      position: relative;
      overflow: hidden;
    }

    .header-container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 2rem;
    }

    .header-text h1 {
      font-size: 3rem;
      font-weight: 800;
      line-height: 1.1;
      margin-bottom: 0.75rem;
      letter-spacing: -1px;
    }

    .header-text p {
      font-size: 1.2rem;
      color: #a3cbd2;
      font-weight: 400;
      max-width: 550px;
    }

    /* --- REPRODUCTOR EN VIVO --- */
    .player-box {
      background: rgba(255, 255, 255, 0.07);
      padding: 1.5rem 2rem;
      border-radius: 16px;
      border: 1px solid rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(4px);
      text-align: center;
    }

    .btn-live {
      background-color: var(--accent);
      color: #ffffff;
      border: none;
      padding: 0.9rem 2.2rem;
      font-size: 1rem;
      font-weight: 600;
      border-radius: 30px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      letter-spacing: 0.5px;
      box-shadow: 0 4px 15px rgba(202, 158, 27, 0.3);
      transition: all 0.2s ease;
    }

    .btn-live:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(202, 158, 27, 0.5);
    }

    /* --- DISTRIBUCIÓN DEL CONTENIDO (GRID) --- */
    .main-layout {
      max-width: 1200px;
      margin: 3rem auto;
      padding: 0 2rem;
      display: grid;
      grid-template-columns: 2fr 1fr; /* Columna principal amplia, lateral estrecha */
      gap: 3rem;
    }

    /* Estilos de Tarjetas Estándar */
    .card {
      background: #ffffff;
      border: 1px solid var(--border-color);
      border-radius: 16px;
      padding: 2.5rem;
      margin-bottom: 2.5rem;
      box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .card h2 {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--primary);
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    /* --- TABLA DE PROGRAMACIÓN --- */
    .table-container {
      width: 100%;
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th {
      text-align: left;
      padding: 1rem;
      font-size: 0.85rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: var(--text-muted);
      border-bottom: 2px solid var(--border-color);
    }

    td {
      padding: 1.2rem 1rem;
      border-bottom: 1px solid var(--border-color);
      font-size: 0.95rem;
    }

    tr:last-child td {
      border-bottom: none;
    }

    .time-badge {
      color: var(--primary);
      font-weight: 600;
      background-color: #eef7f4;
      padding: 4px 10px;
      border-radius: 6px;
      font-size: 0.9rem;
    }

    /* --- COLUMNA LATERAL (SIDEBAR) --- */
    .sidebar {
      display: flex;
      flex-direction: column;
      gap: 2rem;
    }

    .sidebar .card {
      padding: 2rem;
      margin-bottom: 0;
    }

    .about-text {
      color: var(--text-muted);
      font-size: 0.95rem;
      line-height: 1.6;
      text-align: justify;
    }

    /* Botones de Acción de Redes y App */
    .action-list {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .btn-action {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      padding: 1rem;
      border-radius: 10px;
      text-decoration: none;
      font-weight: 600;
      font-size: 0.95rem;
      transition: background 0.2s, transform 0.1s;
    }

    .btn-action:active { transform: scale(0.98); }

    .btn-facebook { background-color: #f0f4f9; color: #1c64f2; }
    .btn-facebook:hover { background-color: #e1ebf7; }

    .btn-whatsapp { background-color: #ecfdf5; color: #047857; }
    .btn-whatsapp:hover { background-color: #d1fae5; }

    .btn-app { background-color: var(--primary); color: #ffffff; }
    .btn-app:hover { background-color: var(--secondary); }

    /* Mapa de Ubicación */
    .map-frame {
      border-radius: 12px;
      overflow: hidden;
      border: 1px solid var(--border-color);
    }

    /* --- PIE DE PÁGINA --- */
    footer {
      background-color: var(--dark);
      color: #94a3b8;
      padding: 4rem 2rem;
      text-align: center;
      border-top: 1px solid #1e293b;
    }

    footer p { font-size: 0.95rem; }
    footer .brand-footer { color: #ffffff; font-weight: 600; margin-bottom: 0.5rem; }

    /* --- RESPONSIVO --- */
    @media (max-width: 1024px) {
      .main-layout { grid-template-columns: 1fr; gap: 2rem; }
      nav { padding: 1rem 2rem; }
      header { padding: 4rem 2rem; }
      .header-container { flex-direction: column; text-align: center; }
    }
  </style>
</head>
<body>

  <!-- Menú de Navegación Fijo (Navbar) -->
  <nav>
    <a href="#" class="nav-brand">
      <!-- Si cuentas con logo.png se renderiza aquí, de lo contrario la experiencia se mantiene limpia -->
      <img src="logo.png" alt="📻"> 
      <span>Radio Pakal</span>
    </a>
    <ul class="nav-links">
      <li><a href="#programacion">Programación</a></li>
      <li><a href="#quienes">Quiénes Somos</a></li>
      <li><a href="#ubicacion">Ubicación</a></li>
      <li><a href="#redes">Contacto</a></li>
    </ul>
  </nav>

  <!-- Encabezado Corporativo -->
  <header>
    <div class="header-container">
      <div class="header-text">
        <h1>Radio Pakal 1040 AM</h1>
        <p>La voz de Palenque que conecta con la comunidad e impulsa nuestra identidad cultural.</p>
      </div>
      <div class="player-box">
        <button class="btn-live" onclick="alert('Conectando al stream de audio en alta definición...')">
          <span>🔊</span> ESCUCHAR SEÑAL EN VIVO
        </button>
      </div>
    </div>
  </header>

  <!-- Grid Profesional de Distribución -->
  <div class="main-layout">
    
    <!-- COLUMNA PRINCIPAL (IZQUIERDA) -->
    <main>
      <!-- Sección Programación -->
      <section id="programacion" class="card">
        <h2>📅 Parrilla de Programación</h2>
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th style="width: 25%;">Horario</th>
                <th>Espacio Radial</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $result = mysqli_query($conn, "SELECT hora, programa FROM programacion");
              if ($result && mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                      echo "<tr>";
                      echo "<td><span class='time-badge'>" . htmlspecialchars($row['hora']) . "</span></td>";
                      echo "<td><strong>" . htmlspecialchars($row['programa']) . "</strong></td>";
                      echo "</tr>";
                  }
              } else {
                  echo "<tr><td colspan='2' style='text-align:center; color:var(--text-muted); padding: 2rem;'>No hay transmisiones agendadas para hoy. Sintoniza nuestra señal en vivo.</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </section>

      <!-- Sección Ubicación -->
      <section id="ubicacion" class="card">
        <h2>📍 Cobertura y Ubicación</h2>
        <p style="margin-bottom: 1.5rem; color: var(--text-muted); font-size: 0.95rem;">
          Estudios centrales: Av. 5 de Mayo entre Aldama y Allende, Barrio Centro, Palenque, Chiapas, C.P. 29960
        </p>
        <div class="map-frame">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3810.7351659223366!2d-91.983055!3d17.509444!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTfCsDMwJzM0LjAiTiA5McKwNTknMDAuMCJX!5e0!3m2!1ses-419!2smx!4v1650000000000!5m2!1ses-419!2smx" 
                  width="100%" height="320" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
      </section>
    </main>

    <!-- COLUMNA LATERAL (DERECHA) -->
    <aside class="sidebar">
      <!-- Tarjeta Institucional -->
      <section id="quienes" class="card">
        <h2>👥 Quiénes Somos</h2>
        <p class="about-text">
          Somos una institución de radiodifusión comunitaria con base en Palenque, Chiapas. Nuestro propósito primordial radica en la preservación de la música regional, el fomento de los valores comunales y el fortalecimiento de la diversidad lingüística, transmitiendo contenidos selectos en español y lenguas originarias.
        </p>
      </section>

      <!-- Tarjeta Enlaces de Interacción y Canales Digitales -->
      <section id="redes" class="card">
        <h2>🔗 Canales Oficiales</h2>
        <div class="action-list">
          <a href="https://www.facebook.com/TuPaginaDeRadio" target="_blank" class="btn-action btn-facebook">
            Facebook Corporativo
          </a>
          <a href="https://wa.me/529161234567" target="_blank" class="btn-action btn-whatsapp">
            Línea Directa de Cabina
          </a>
        </div>
      </section>

      <!-- Tarjeta App Móvil -->
      <section id="app" class="card">
        <h2>📲 Plataforma Móvil</h2>
        <p class="about-text" style="margin-bottom: 1.25rem;">
          Acceda a nuestra transmisión ininterrumpida y libre de demoras directamente en su smartphone.
        </p>
        <a href="https://tu-enlace-de-app.com" target="_blank" class="btn-action btn-app">
          Descargar Aplicación Oficial
        </a>
      </section>
    </aside>

  </div>

  <!-- Pie de Página -->
  <footer>
    <p class="brand-footer">Radio Pakal 1040 AM</p>
    <p>&copy; <?php echo date('Y'); ?> — Todos los derechos reservados. Palenque, Chiapas, México.</p>
  </footer>

</body>
</html>