<?php include("db.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Radio Pakal 1040 AM | La Voz del Sureste</title>
  
  <!-- Estilos Modernos Integrados -->
  <style>
    :root {
      --primary: #0f4c3a;     /* Verde Selva Profundo */
      --secondary: #1d7a5c;   /* Verde Claro */
      --accent: #d4ac0d;      /* Oro / Amarillo Cálido */
      --dark: #111a16;        /* Fondo oscuro suave */
      --light: #f4f7f5;       /* Fondo claro */
      --text: #2c3e50;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: var(--light);
      color: var(--text);
      line-height: 1.6;
    }

    /* Encabezado */
    header {
      background: linear-gradient(rgba(15, 76, 58, 0.85), rgba(17, 26, 22, 0.95)), 
                  url('https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?auto=format&fit=crop&w=1200&q=80') no-repeat center/cover;
      color: #fff;
      text-align: center;
      padding: 5rem 1rem;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    header h1 {
      font-size: 3rem;
      letter-spacing: 2px;
      margin-bottom: 0.5rem;
      text-shadow: 2px 2px 8px rgba(0,0,0,0.5);
    }

    header p {
      font-size: 1.2rem;
      color: #e0f2f1;
      font-style: italic;
    }

    /* Contenedor Principal */
    .container {
      max-width: 1000px;
      margin: -2rem auto 4rem auto;
      background: #ffffff;
      padding: 3rem 2rem;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    h2 {
      color: var(--primary);
      font-size: 1.8rem;
      margin-top: 2.5rem;
      margin-bottom: 1.2rem;
      border-left: 5px solid var(--accent);
      padding-left: 10px;
    }
    h2:first-of-type { margin-top: 0; }

    /* Sección Programación (Tabla Estilizada) */
    .table-responsive {
      overflow-x: auto;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.03);
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
      font-weight: 600;
    }

    tr {
      border-bottom: 1px solid #e2e8f0;
      transition: background 0.2s;
    }

    tr:hover {
      background-color: #f1f8f5;
    }

    /* Redes Sociales y Layout Dividido */
    .grid-content {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 2.5rem;
      margin-top: 2rem;
    }

    .fb-container {
      display: flex;
      justify-content: center;
      background: #f0f2f5;
      padding: 1rem;
      border-radius: 12px;
    }

    /* Bloque de Contacto */
    .contacto-box {
      background: #fafafa;
      border: 1px solid #eaf2ee;
      padding: 2rem;
      border-radius: 12px;
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .btn-contacto {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 1rem;
      text-decoration: none;
      color: white;
      border-radius: 8px;
      font-weight: bold;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-contacto:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .whatsapp { background-color: #25d366; }
    .email { background-color: var(--secondary); }

    /* Enlace Admin Oculto Elegantemente */
    .admin-link-wrapper {
      text-align: right;
      margin-top: 3rem;
    }

    .btn-admin {
      color: #7f8c8d;
      text-decoration: none;
      font-size: 0.9rem;
      padding: 6px 12px;
      border: 1px dashed #cbd5e1;
      border-radius: 6px;
      transition: 0.3s;
    }

    .btn-admin:hover {
      color: var(--primary);
      border-color: var(--primary);
      background: #f0f7f4;
    }

    /* Botón de Streaming Animado */
    .stream-player {
      text-align: center;
      margin-bottom: 2rem;
    }

    .btn-live {
      background: var(--accent);
      color: var(--dark);
      border: none;
      padding: 1rem 2rem;
      font-size: 1.1rem;
      font-weight: bold;
      border-radius: 50px;
      cursor: pointer;
      box-shadow: 0 0 0 0 rgba(212, 172, 13, 0.7);
      animation: pulse 2s infinite;
      display: inline-flex;
      align-items: center;
      gap: 10px;
    }

    @keyframes pulse {
      0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(212, 172, 13, 0.7); }
      70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(212, 172, 13, 0); }
      100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(212, 172, 13, 0); }
    }

    /* Pie de página */
    footer {
      background-color: var(--dark);
      color: #94a3b8;
      text-align: center;
      padding: 2.5rem 1rem;
      font-size: 0.95rem;
    }

    /* Responsivo */
    @media (max-width: 768px) {
      header h1 { font-size: 2.2rem; }
      .container { padding: 1.5rem 1rem; margin-top: -1rem; }
    }
  </style>
</head>
<body>

  <!-- Encabezado con Imagen de Fondo -->
  <header>
    <h1>Radio Pakal 1040 AM</h1>
    <p>La emisora que conecta con la comunidad y comparte cultura</p>
  </header>

  <div class="container">
    
    <!-- Botón Escuchar en Vivo -->
    <div class="stream-player">
      <button class="btn-live" onclick="alert('Conectando con el servidor de audio de la 1040 AM...')">
        🔴 ESCUCHAR EN VIVO
      </button>
    </div>

    <!-- Sección Programación -->
    <h2>📅 Nuestra Programación</h2>
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
              echo "<tr><td colspan='2' style='text-align:center; color:#7f8c8d;'>No hay datos de programación disponibles en este momento.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

    <!-- Layout en Rejilla para Facebook y Contacto -->
    <div class="grid-content">
      
      <!-- Contenedor Facebook -->
      <div>
        <h2>📱 Lo último en Facebook</h2>
        <div class="fb-container">
          <div class="fb-page" 
               data-href="https://www.facebook.com/TuPaginaDeRadio"
               data-tabs="timeline"
               data-width="500"
               data-height="500"
               data-small-header="false"
               data-adapt-container-width="true"
               data-hide-cover="false"
               data-show-facepile="true">
          </div>
        </div>
      </div>

      <!-- Contenedor Contacto -->
      <div>
        <h2>✉️ Cabina y Contacto</h2>
        <p style="margin-bottom: 1rem; color: #555;">Envía tus saludos, reportes ciudadanos o pide tu canción favorita:</p>
        <div class="contacto-box">
          <a href="https://wa.me/529161234567" class="btn-contacto whatsapp" target="_blank">
            💬 WhatsApp Cabina
          </a>
          <a href="mailto:contacto@radiopakal1040.com" class="btn-contacto email">
            📧 Correo Electrónico
          </a>
        </div>
      </div>

    </div>

    <!-- Enlace al Panel Técnico/Admin -->
    <div class="admin-link-wrapper">
      <a href="admin.php" class="btn-admin">🔑 Acceso Operadores</a>
    </div>

  </div>

  <!-- Pie de página -->
  <footer>
    <p>&copy; <?php echo date('Y'); ?> Radio Pakal 1040 AM — Palenque, Chiapas</p>
    <p style="font-size: 0.8rem; margin-top: 5px; color: #576574;">Todos los derechos reservados</p>
  </footer>

  <!-- SDK de Facebook -->
  <div id="fb-root"></div>
  <script async defer crossorigin="anonymous" 
    src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v17.0"></script>

</body>
</html>