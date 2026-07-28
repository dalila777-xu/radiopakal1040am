<?php include("db.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Radio Pakal 1040 AM - Sistema Chiapaneco</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <div class="gob-bar">
    <div class="gob-bar-container">
      <div class="gob-logo">
        <img src="https://radiotvycine.chiapas.gob.mx/images/logo-chiapas.png" alt="chiapas.gob.mx" onerror="this.src='logo.png'">
        <span>chiapas<span>.gob.mx</span></span>
      </div>
      <div class="gob-menu">
        <a href="#">Participa</a>
        <a href="#">Trámites</a>
        <a href="#">Gobierno</a>
        <a href="#">Transparencia</a>
        <a href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
      </div>
    </div>
  </div>

  <header class="main-banner">
    <div class="banner-container">
      <div class="banner-logo-center">
        <div class="logo-placeholder-pattern">
          <i class="fa-solid fa-radio" style="font-size: 3rem; color: #80243e;"></i>
        </div>
      </div>
      <div class="banner-text">
        <h1>SISTEMA CHIAPANECO DE RADIO, TELEVISIÓN Y CINEMATOGRAFÍA</h1>
        <hr class="banner-divider">
        <p class="banner-slogan">RADIO PAKAL 1040 AM — VISIÓN DE LA NUEVA ERA</p>
      </div>
    </div>
    <div class="cenefa-decorativa"></div>
  </header>

  <nav class="main-nav">
    <div class="nav-container">
      <a href="#quienes" class="active">Inicio</a>
      <a href="#programacion">Programación</a>
      <a href="#redes">Redes Sociales</a>
      <a href="#app">App Móvil</a>
      <a href="#ubicacion">Ubicación</a>
    </div>
  </nav>

  <div class="main-layout container">
    
    <main class="content-area">
      <section id="quienes" class="info-section">
        <h2 class="section-title">Misión</h2>
        <p>Radio Pakal 1040 AM es una emisora comunitaria profundamente arraigada en Palenque, Chiapas. 
           Promovemos la riqueza cultural, la música de nuestra región y la identidad de nuestra gente, 
           transmitiendo con orgullo tanto en español como en nuestras valiosas lenguas originarias.</p>
        
        <h2 class="section-title" style="margin-top: 2rem;">Visión</h2>
        <p>Ser el Sistema de Comunicación Audiovisual reconocido a nivel nacional e internacional, que promueva la 
           calidad de nuestros programas radiofónicos y televisivos, sirviendo para contribuir al desarrollo social y económico del Estado de Chiapas.</p>
      </section>

      <section id="programacion" class="info-section">
        <h2 class="section-title">📅 Programación del Día</h2>
        <div class="table-responsive">
          <table class="inst-table">
            <thead>
              <tr>
                <th>Horario</th>
                <th>Programa</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $result = mysqli_query($conn, "SELECT hora, programa FROM programacion");
              if ($result && mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                      echo "<tr><td><strong>" . htmlspecialchars($row['hora']) . "</strong></td>";
                      echo "<td>" . htmlspecialchars($row['programa']) . "</td></tr>";
                  }
              } else {
                  echo "<tr><td colspan='2' class='no-data'>Por el momento no hay horarios registrados. ¡Sintoniza nuestra señal en vivo!</td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </section>
    </main>

    <aside class="sidebar-area">
      
      <div class="sidebar-widget player-widget">
        <h3><i class="fa-solid fa-play"></i> TRANSMISIÓN EN VIVO</h3>
        <p>Escucha nuestra señal digital</p>
        <audio controls src="TU_URL_DE_STREAMING" style="width: 100%; margin-top: 10px;"></audio>
      </div>

      <div class="sidebar-widget">
        <h3>Contacto y Redes</h3>
        <div class="grid-buttons">
          <a href="https://www.facebook.com/search/top?q=XEPLE%20Radio%20Palenque" target="_blank" class="btn-inst fb-color">
            <i class="fa-brands fa-facebook-f"></i> XEPLE Radio Palenque
          </a>
          <a href="https://wa.me/529935990830" target="_blank" class="btn-inst wa-color">
            <i class="fa-brands fa-whatsapp"></i> WhatsApp Cabina
          </a>
          <a href="https://tu-enlace-de-app.com" target="_blank" class="btn-inst app-color" id="app">
            <i class="fa-solid fa-mobile-screen-button"></i> Descargar App Móvil
          </a>
        </div>
      </div>

      <div class="sidebar-widget" id="ubicacion">
        <h3>Ubicación</h3>
        <p class="address-text">
          <i class="fa-solid fa-location-dot" style="color: #80243e;"></i> 
          AV. Corregidora S/N Planta Alta entre las calles Javier Mina y Chiapas, Palenque, Chiapas.
        </p>
        <div class="map-box">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3810.7351659223366!2d-91.983055!3d17.509444!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTfCsDMwJzM0LjAiTiA5McKwNTknMDAuMCJX!5e0!3m2!1ses-419!2smx!4v1650000000000!5m2!1ses-419!2smx" width="100%" height="220" style="border:0;" allowfullscreen loading="lazy"></iframe>
        </div>
      </div>
    </aside>

  </div>

  <footer class="main-footer">
    <div class="footer-container">
      <div class="footer-logo">
        <i class="fa-solid fa-gavel"></i>
        <p><strong>HUMANISMO QUE TRANSFORMA</strong><br>GOBIERNO DE CHIAPAS<br>2024 - 2030</p>
      </div>
      <div class="footer-links">
        <h4>Acerca de</h4>
        <a href="#quienes">Misión y Visión</a>
        <a href="#">Avisos de Privacidad</a>
      </div>
      <div class="footer-links">
        <h4>Contáctanos</h4>
        <p>AV. Corregidora S/N Planta Alta, Palenque, Chiapas.</p>
        <p>Teléfono: 993 599 0830</p>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© <?php echo date('Y'); ?> Sistema Chiapaneco de Radio, Televisión y Cinematografía — Radio Pakal 1040 AM</p>
    </div>
  </footer>

</body>
</html>