<?php include("db.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Radio Pakal 1040 AM - Palenque</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <link rel="stylesheet" href="style.css">
  
  <style>
    /* REPRODUCCTOR FIJO EN LA PARTE INFERIOR (INNOVACIÓN) */
    .audio-player-fixed {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      background: #111a16; /* Contraste Oscuro */
      color: #fff;
      padding: 12px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 9999;
      box-shadow: 0 -4px 15px rgba(0,0,0,0.3);
    }
    .player-info { 
      display: flex; 
      align-items: center; 
      gap: 12px; 
    }
    .player-info i { 
      color: #d4ac0d; /* Oro Jade */
      font-size: 1.6rem; 
      animation: pulse-icon 2s infinite;
    }
    @keyframes pulse-icon {
      0% { transform: scale(1); opacity: 0.8; }
      50% { transform: scale(1.1); opacity: 1; }
      100% { transform: scale(1); opacity: 0.8; }
    }
    .player-text strong {
      display: block;
      font-size: 0.95rem;
      letter-spacing: 0.5px;
    }
    .player-text span {
      font-size: 0.8rem;
      color: #a0aec0;
    }
    .audio-player-fixed audio {
      max-width: 220px;
      height: 32px;
    }

    /* Espacio extra en el fondo de la página para que el reproductor no tape el contenido */
    body { 
      padding-bottom: 80px; 
    }

    /* ESTILO CONTROLADO PARA LA IMAGEN DE PORTADA / PRESENTACIÓN */
    .banner-presentacion {
      width: 100%;
      max-width: 1100px;
      margin: 2rem auto 0 auto;
      padding: 0 1.5rem;
    }
    .banner-presentacion img {
      width: 100%;
      height: auto;
      max-height: 450px;
      object-fit: cover;
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.15);
      display: block;
    }

    /* Ajuste responsivo para celulares */
    @media (max-width: 600px) {
      .audio-player-fixed {
        flex-direction: column;
        gap: 8px;
        text-align: center;
        padding: 10px;
      }
      .audio-player-fixed audio {
        width: 100%;
        max-width: 100%;
      }
      body {
        padding-bottom: 120px;
      }
    }
  </style>
</head>
<body>

  <div class="audio-player-fixed">
    <div class="player-info">
      <i class="fa-solid fa-radio"></i>
      <div class="player-text">
        <strong>Radio Pakal 1040 AM</strong>
        <span><span style="color: #25d366;">●</span> En Vivo desde Palenque</span>
      </div>
    </div>
    <audio controls src="TU_URL_DE_STREAMING"></audio>
  </div>

  <header>
    <img src="logo.png" alt="Logo Radio Pakal" class="logo">
    <h1>Radio Pakal 1040 AM</h1>
    <p>La voz de Palenque que conecta con la comunidad</p>
  </header>

  <nav>
    <a href="#quienes">Quiénes Somos</a>
    <a href="#ubicacion">Ubicación</a>
    <a href="#programacion">Programación</a>
    <a href="#redes">Redes Sociales</a>
    <a href="#app">App Móvil</a>
  </nav>

  <div class="banner-presentacion">
    <img src="portada.jpg" alt="Presentación Oficial Radio Pakal">
  </div>

  <div class="container">
    
    <section id="quienes">
      <h2><i class="fa-solid fa-users"></i> Quiénes Somos</h2>
      <p>Radio Pakal 1040 AM es una emisora comunitaria profundamente arraigada en Palenque, Chiapas. 
         Promovemos la riqueza cultural, la música de nuestra región y la identidad de nuestra gente, 
         transmitiendo con orgullo tanto en español como en nuestras valiosas lenguas originarias.</p>
      <img src="radio.png" alt="Imagen de Radio Pakal 1040" class="about-img">
    </section>

    <section id="programacion">
      <h2><i class="fa-solid fa-calendar-days"></i> Programación del Día</h2>
      <div class="table-responsive">
        <table>
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
                echo "<tr><td colspan='2' style='text-align:center; color:#7f8c8d;'>Por el momento no hay horarios registrados. ¡Sintoniza nuestra señal en vivo!</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </section>

    <section id="redes">
      <h2><i class="fa-solid fa-circle-nodes"></i> Síguenos en Redes Sociales</h2>
      <div class="grid-buttons">
        <a href="https://www.facebook.com/search/top?q=XEPLE%20Radio%20Palenque" target="_blank" class="btn-card facebook-btn">
          <i class="fa-brands fa-facebook-f"></i> Facebook: XEPLE Radio Palenque
        </a>
        <a href="https://wa.me/529935990830" target="_blank" class="btn-card whatsapp-btn">
          <i class="fa-brands fa-whatsapp"></i> WhatsApp Cabina
        </a>
      </div>
    </section>

    <section id="app">
      <h2><i class="fa-solid fa-mobile-screen-button"></i> Lleva la Radio en tu Bolsillo</h2>
      <div class="grid-buttons">
        <a href="https://tu-enlace-de-app.com" target="_blank" class="btn-card app-btn">
          <i class="fa-solid fa-download"></i> Descargar Aplicación Android / iOS
        </a>
      </div>
    </section>

    <section id="ubicacion">
      <h2><i class="fa-solid fa-location-dot"></i> Nuestra Ubicación</h2>
      <p><strong>Dirección:</strong> AV. Corregidora S/N Planta Alta entre las calles Javier Mina y Chiapas, Palenque, Chiapas.</p>
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3810.7351659223366!2d-91.983055!3d17.509444!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTfCsDMwJzM0LjAiTiA5McKwNTknMDAuMCJX!5e0!3m2!1ses-419!2smx!4v1650000000000!5m2!1ses-419!2smx" width="100%" height="420" style="border:0;" allowfullscreen loading="lazy"></iframe>
    </section>
  </div>

  <footer>
    <p>© <?php echo date('Y'); ?> Radio Pakal 1040 AM — Palenque, Chiapas</p>
    <p>Conectando culturas, uniendo comunidades.</p>
  </footer>

</body>
</html>