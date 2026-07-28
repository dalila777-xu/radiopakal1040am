<?php include("db.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Radio Pakal 1040 AM</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Encabezado -->
  <header>
    <h1>Radio Pakal 1040 AM</h1>
    <p>La emisora que conecta con la comunidad y comparte cultura</p>
  </header>

  <!-- Menú de navegación -->
  <nav>
    <a href="index.php">Inicio</a>
    <a href="#programacion">Programación</a>
    <a href="#facebook">Facebook</a>
    <a href="#contacto">Contacto</a>
    <a href="admin.php">Panel Admin</a>
  </nav>

  <!-- Contenido principal -->
  <div class="container">
    <!-- Programación -->
    <h2 id="programacion">Programación</h2>
    <ul>
      <?php
      $result = mysqli_query($conn, "SELECT hora, programa FROM programacion");
      if ($result) {
          while ($row = mysqli_fetch_assoc($result)) {
              echo "<li>" . $row['hora'] . " - " . $row['programa'] . "</li>";
          }
      } else {
          echo "<li>No hay datos disponibles.</li>";
      }
      ?>
    </ul>

    <!-- Facebook -->
    <h2 id="facebook">Lo último en Facebook</h2>
    <div class="fb-page" 
         data-href="https://www.facebook.com/TuPaginaDeRadio"
         data-tabs="timeline"
         data-width="500"
         data-height="600">
    </div>
    <script async defer crossorigin="anonymous" 
      src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v17.0"></script>

    <!-- Contacto -->
    <h2 id="contacto">Contacto</h2>
    <p>Comunícate con nosotros:</p>
    <ul>
      <li>📞 WhatsApp: <a href="https://wa.me/529161234567">+52 916 123 4567</a></li>
      <li>✉️ Correo: <a href="mailto:contacto@radiopakal1040.com">contacto@radiopakal1040.com</a></li>
    </ul>
  </div>

  <!-- Pie de página -->
  <footer>
    <p>&copy; 2026 Radio Pakal 1040 AM - Todos los derechos reservados</p>
  </footer>
</body>
</html>
