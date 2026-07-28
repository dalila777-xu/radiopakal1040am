<?php include("db.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Radio Pakal 1040 AM</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Encabezado con logotipo -->
  <header>
    <img src="logo.png" alt="Logo Radio Pakal" style="height:80px;">
    <h1>Radio Pakal 1040 AM</h1>
    <p>La emisora que conecta con la comunidad y comparte cultura</p>
  </header>

  <!-- Menú de navegación -->
  <nav>
    <a href="#quienes">Quiénes Somos</a>
    <a href="#ubicacion">Ubicación</a>
    <a href="#programacion">Programación</a>
    <a href="#redes">Redes Sociales</a>
    <a href="#app">App Móvil</a>
  </nav>

  <div class="container">
    <!-- Sección Quiénes Somos -->
    <h2 id="quienes">Quiénes Somos</h2>
    <p>Radio Pakal 1040 AM es una emisora comunitaria que busca promover la cultura,
       la música regional y la voz de Palenque hacia todo Chiapas y más allá.</p>

    <!-- Sección Ubicación -->
    <h2 id="ubicacion">Ubicación</h2>
    <p>📍 Palenque, Chiapas, México</p>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!..." 
            width="100%" height="300" style="border:0;" allowfullscreen></iframe>

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

    <!-- Redes Sociales -->
    <h2 id="redes">Síguenos en Redes Sociales</h2>
    <p>
      📘 <a href="https://www.facebook.com/TuPaginaDeRadio" target="_blank">Facebook</a><br>
      📞 <a href="https://wa.me/529161234567" target="_blank">WhatsApp</a>
    </p>

    <!-- App Móvil -->
    <h2 id="app">Descarga nuestra App</h2>
    <p>
      📲 <a href="https://tu-enlace-de-app.com" target="_blank">Descargar aplicación móvil</a>
    </p>
  </div>

  <!-- Pie de página -->
  <footer>
    <p>&copy; 2026 Radio Pakal 1040 AM - Todos los derechos reservados</p>
  </footer>
</body>
</html>
