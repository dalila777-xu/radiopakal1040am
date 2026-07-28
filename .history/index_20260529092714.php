<?php include("db.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Radio Pakal 1040 AM — Palenque, Chiapas</title>
  <!-- Vinculación del archivo de estilos externo -->
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <!-- Menú de Navegación Fijo (Navbar) -->
  <nav>
    <a href="#" class="nav-brand">
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