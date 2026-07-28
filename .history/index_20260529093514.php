<?php include("db.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Radio Pakal 1040 AM - Palenque</title>
  
  <style>
    :root {
      --primary: #0f4c3a;     /* Verde Selva Maya */
      --secondary: #1d7a5c;   /* Verde Vibrante */
      --accent: #d4ac0d;      /* Oro Jade / Amarillo Cálido */
      --dark: #111a16;        /* Contraste Oscuro */
      --light: #f4f7f5;       /* Fondo Suave */
      --card-bg: #ffffff;
      --text: #2c3e50;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: var(--light);
      color: var(--text);
      line-height: 1.6;
    }

    /* --- ENCABEZADO (HERO) --- */
    header {
      background: linear-gradient(rgba(15, 76, 58, 0.8), rgba(17, 26, 22, 0.95)), 
                  url('https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?auto=format&fit=crop&w=1200&q=80') no-repeat center/cover;
      color: #fff;
      text-align: center;
      padding: 4rem 1rem;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    header .logo {
      max-width: 120px;
      height: auto;
      margin-bottom: 1rem;
      filter: drop-shadow(0px 4px 8px rgba(0,0,0,0.3));
    }

    header h1 {
      font-size: 2.8rem;
      letter-spacing: 1px;
      margin-bottom: 0.5rem;
      text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
    }

    header p {
      font-size: 1.2rem;
      color: #e0f2f1;
      font-style: italic;
      max-width: 600px;
    }

    /* --- REPRODUCTOR EN VIVO --- */
    .live-banner {
      background: var(--dark);
      color: white;
      text-align: center;
      padding: 1rem;
      box-shadow: inset 0 -5px 10px rgba(0,0,0,0.2);
    }
    
    .btn-live {
      background: var(--accent);
      color: var(--dark);
      border: none;
      padding: 0.7rem 2rem;
      font-size: 1rem;
      font-weight: bold;
      border-radius: 50px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      box-shadow: 0 0 0 0 rgba(212, 172, 13, 0.7);
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0% { transform: scale(0.98); box-shadow: 0 0 0 0 rgba(212, 172, 13, 0.7); }
      70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(212, 172, 13, 0); }
      100% { transform: scale(0.98); box-shadow: 0 0 0 0 rgba(212, 172, 13, 0); }
    }

    /* --- MENÚ DE NAVEGACIÓN --- */
    nav {
      background-color: var(--primary);
      position: sticky;
      top: 0;
      z-index: 1000;
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    nav a {
      color: #fff;
      text-decoration: none;
      padding: 1rem 1.5rem;
      font-weight: 500;
      font-size: 0.95rem;
      transition: all 0.3s ease;
    }

    nav a:hover {
      background-color: var(--secondary);
      color: var(--accent);
    }

    /* --- CONTENEDOR Y SECCIONES --- */
    .container {
      max-width: 1100px;
      margin: 2.5rem auto;
      padding: 0 1.5rem;
      display: flex;
      flex-direction: column;
      gap: 3rem;
    }

    section {
      background: var(--card-bg);
      padding: 2.5rem;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
      border: 1px solid #eaf2ee;
    }

    section h2 {
      color: var(--primary);
      font-size: 1.8rem;
      margin-bottom: 1.2rem;
      border-left: 5px solid var(--accent);
      padding-left: 12px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    /* --- DISEÑO DE SECCIONES ESPECÍFICAS --- */
    
    /* Quiénes Somos */
    #quienes p {
      font-size: 1.1rem;
      color: #4a5568;
      text-align: justify;
    }

    /* Ubicación */
    #ubicacion iframe {
      border-radius: 12px;
      margin-top: 1rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    /* Programación (Tabla) */
    .table-responsive {
      overflow-x: auto;
      border-radius: 8px;
      margin-top: 1rem;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
    }

    th, td {
      padding: 1rem 1.2rem;
      text-align: left;
    }

    th {
      background-color: var(--primary);
      color: white;
    }

    tr {
      border-bottom: 1px solid #e2e8f0;
      transition: background 0.2s;
    }

    tr:hover {
      background-color: #f1f8f5;
    }

    /* Redes y App Móvil (Botones Modulares) */
    .grid-buttons {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 1.5rem;
      margin-top: 1rem;
    }

    .btn-card {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      padding: 1.2rem;
      text-decoration: none;
      color: white;
      font-weight: bold;
      border-radius: 12px;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    }

    .facebook-btn { background-color: #1877f2; }
    .whatsapp-btn { background-color: #25d366; }
    .app-btn { background-color: var(--secondary); border: 2px solid var(--accent); }

    /* --- PIE DE PÁGINA --- */
    footer {
      background-color: var(--dark);
      color: #a0aec0;
      text-align: center;
      padding: 2.5rem 1rem;
      font-size: 0.95rem;
      margin-top: 5rem;
    }

    footer p {
      margin-bottom: 5px;
    }

    /* --- RESPONSIVO --- */
    @media (max-width: 768px) {
      header h1 { font-size: 2.1rem; }
      nav a { padding: 0.8rem 1rem; font-size: 0.85rem; }
      section { padding: 1.5rem; }
    }
  </style>
</head>
<body>

  <!-- Encabezado con Logotipo e Imagen de Fondo -->
  <header>
    <!-- Si no tienes el archivo logo.png, usará el texto alternativo limpiamente -->
    <img src="logo.png" alt="📻" class="logo">
    <h1>Radio Pakal 1040 AM</h1>
    <p>La voz de Palenque que conecta con la comunidad</p>
  </header>

  <!-- Barra de Señal en Vivo -->
  <div class="live-banner">
    <button class="btn-live" onclick="alert('Conectando al reproductor digital de Radio Pakal...')">
      🔴 ESCUCHAR EN VIVO
    </button>
  </div>

  <!-- Menú de navegación fijo -->
  <nav>
    <a href="#quienes">Quiénes Somos</a>
    <a href="#ubicacion">Ubicación</a>
    <a href="#programacion">Programación</a>
    <a href="#redes">Redes Sociales</a>
    <a href="#app">App Móvil</a>
  </nav>

  <!-- Contenido principal -->
  <div class="container">
    
    <!-- Quiénes Somos -->
    <section id="quienes">
      <h2>👥 Quiénes Somos</h2>
      <p>Radio Pakal 1040 AM es una emisora comunitaria profundamente arraigada en Palenque, Chiapas. 
         Promovemos la riqueza cultural, la música de nuestra región y la identidad de nuestra gente, 
         transmitiendo con orgullo tanto en español como en nuestras valiosas lenguas originarias.</p>
    </section>

    <!-- Programación cargada desde Base de Datos -->
    <section id="programacion">
      <h2>📅 Programación del Día</h2>
      <div class="table-responsive">
        <table>
          <thead>
            <tr>
              <th style="width: 30%;">Horario</th>
              <th>Programa de Emisión</th>
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
                echo "<tr><td colspan='2' style='text-align:center; color:#7f8c8d;'>Por el momento no hay horarios registrados. ¡Sintoniza nuestra señal en vivo!</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </section>

    <!-- Redes Sociales Modernizadas -->
    <section id="redes">
      <h2>📱 Síguenos en Redes Sociales</h2>
      <p style="margin-bottom: 1rem; color: #555;">Ponte en contacto con la cabina o síguenos en nuestras plataformas oficiales:</p>
      <div class="grid-buttons">
        <a href="https://www.facebook.com/TuPaginaDeRadio" target="_blank" class="btn-card facebook-btn">
          📘 Facebook Oficial
        </a>
        <a href="https://wa.me/529161234567" target="_blank" class="btn-card whatsapp-btn">
          💬 WhatsApp Cabina
        </a>
      </div>
    </section>

    <!-- App Móvil -->
    <section id="app">
      <h2>📲 Lleva la Radio en tu Bolsillo</h2>
      <p style="margin-bottom: 1rem; color: #555;">Descarga nuestra aplicación oficial y escúchanos sin interrupciones dondequiera que vayas.</p>
      <div class="grid-buttons" style="grid-template-columns: 1fr;">
        <a href="https://tu-enlace-de-app.com" target="_blank" class="btn-card app-btn">
          ✨ Descargar Aplicación Android / iOS
        </a>
      </div>
    </section>

    <!-- Ubicación -->
    <section id="ubicacion">
      <h2>📍 Nuestra Ubicación</h2>
      <p>Av. 5 de Mayo entre Aldama y Allende, Barrio Centro, Palenque, Chiapas, C.P. 29960</p>
      <!-- Asegúrate de cambiar la URL del 'src' por tu enlace completo de inserción de Maps cuando lo tengas -->
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3810.7351659223366!2d-91.983055!3d17.509444!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTfCsDMwJzM0LjAiTiA5McKwNTknMDAuMCJX!5e0!3m2!1ses-419!2smx!4v1650000000000!5m2!1ses-419!2smx" 
              width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </section>
  </div>

  <!-- Pie de página -->
  <footer>
    <p>&copy; <?php echo date('Y'); ?> Radio Pakal 1040 AM — Palenque, Chiapas</p>
    <p style="font-size: 0.8rem; color: #64748b;">Conectando culturas, uniendo comunidades.</p>
  </footer>

</body>
</html>