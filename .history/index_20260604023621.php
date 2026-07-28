<?php include("db.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Radio Pakal 1040 AM - Palenque</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* Estilo rápido para controlar el tamaño de tu imagen de portada */
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
  </style>
</head>
<body>

  <!-- Encabezado con Logotipo -->
  <header>
    <img src="logo.png" alt="Logo Radio Pakal" class="logo">
    <h1>Radio Pakal 1040 AM</h1>
    <p>La voz de Palenque que conecta con la comunidad</p>
  </header>

  <!-- Menú de navegación -->
  <nav>
    <a href="#quienes">Quiénes Somos</a>
    <a href="#ubicacion">Ubicación</a>
    <a href="#programacion">Programación</a>
    <a href="#redes">Redes Sociales</a>
    <a href="#app">App Móvil</a>
  </nav>

  <!-- IMAGEN DE PORTADA / PRESENTACIÓN -->
  <div class="banner-presentacion">
    <!-- Reemplaza 'portada.jpg' por el nombre de tu archivo de imagen real -->
    <img src="portada.jpg" alt="Presentación de Radio Pakal 1040 AM">
  </div>

  <div class="container">
    <!-- Quiénes Somos -->
    <section id="quienes">
      <h2>👥 Quiénes Somos</h2>
      <p>Radio Pakal 1040 AM es una emisora comunitaria profundamente arraigada en Palenque, Chiapas. 
         Promovemos la riqueza cultural, la música de nuestra región y la identidad de nuestra gente, 
         transmitiendo con orgullo tanto en español como en nuestras valiosas lenguas originarias.</p>
      <img src="radio.png" alt="Imagen de Radio Pakal 1040" class="about-img">
    </section>

    <!-- Programación -->
    <section id="programacion">
      <h2>📅 Programación del Día</h2>
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
                    echo "<tr>";
                    echo "<td><strong>" . htmlspecialchars($row['hora']) . "</strong></td>";
                    echo "<td>" . htmlspecialchars($row['programa']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>Por el momento no hay horarios registrados.</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </section>

    <!-- Redes Sociales -->
    <section id="redes">
      <h2>📱 Síguenos en Redes Sociales</h2>
      <div class="grid-buttons">
        <a href="https://www.facebook.com/search/top?q=XEPLE%20Radio%20Palenque" target="_blank" class="btn-card facebook-btn">
          📘 Facebook: XEPLE Radio Palenque
        </a>
        <a href="https://wa.me/529935990830" target="_blank" class="btn-card whatsapp-btn">
          💬 WhatsApp Cabina
        </a>
      </div>
    </section>

    <!-- App Móvil -->
    <section id="app">
      <h2>📲 Lleva la Radio en tu Bolsillo</h2>
      <div class="grid-buttons">
        <a href="https://tu-enlace-de-app.com" target="_blank" class="btn-card app-btn">
          ✨ Descargar Aplicación Android / iOS
        </a>
      </div>
    </section>

    <!-- Ubicación -->
    <section id="ubicacion">
      <h2>📍 Nuestra Ubicación</h2>
      <p>Dirección: AV. Corregidora S/N Planta Alta entre las calles Javier Mina y Chiapas, Palenque, Chiapas.</p>
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3810.7351659223366!2d-91.983055!3d17.509444!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTfCsDMwJzM0LjAiTiA5McKwNTknMDAuMCJX!5e0!3m2!1ses-419!2smx!4v1650000000000!5m2!1ses-419!2smx" width="100%" height="420" style="border:0;" allowfullscreen></iframe>
    </section>
  </div>

  <!-- Pie de página -->
  <footer>
    <p>&copy; <?php echo date('Y'); ?> Radio Pakal 1040 AM — Palenque, Chiapas</p>
    <p>Conectando culturas, uniendo comunidades.</p>
  </footer>

</body>
</html>