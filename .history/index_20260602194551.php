<?php include("db.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Radio Pakal 1040 AM - Palenque</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Encabezado con logotipo -->
  <header>
    <div class="header-content">
      <img src="logo.png" alt="Logo Radio Pakal" class="logo">
      <div class="header-text">
        <h1>Radio Pakal 1040 AM</h1>
        <p>La voz de Palenque que conecta con la comunidad</p>
      </div>
    </div>
  </header>

  <!-- Menú de navegación -->
  <nav>
    <a href="#quienes">Quiénes Somos</a>
    <a href="#ubicacion">Ubicación</a>
    <a href="#programacion">Programación</a>
    <a href="#redes">Redes Sociales</a>
    <a href="#app">App Móvil</a>
  </nav>

  <!-- Contenido principal -->
  <div class="container">
    <section id="quienes">
      <h2>Quiénes Somos</h2>
      <p>Radio Pakal 1040 AM es una emisora comunitaria de Palenque, Chiapas. 
         Promovemos la cultura, la música regional y la identidad de nuestra gente, 
         transmitiendo en español y lenguas originarias.</p>
    </section>

    <section id="ubicacion">
      <h2>Ubicación</h2>
      <p>📍 Av. 5 de Mayo entre Aldama y Allende, Centro, Palenque, Chiapas, C.P. 29960</p>
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!..." 
              width="100%" height="300" style="border:0;" allowfullscreen></iframe>
    </section>

    <section id="programacion">
      <h2>Programación</h2>
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
    </section>

    <section id="redes">
      <h2>Síguenos en Redes Sociales</h2>
      <p>
        📘 <a href="https://www.facebook.com/TuPaginaDeRadio" target="_blank">Facebook</a><br>
        📞 <a href="https://wa.me/529161234567" target="_blank">WhatsApp</a>
      </p>
    </section>

    <section id="app">
      <h2>Descarga nuestra App</h2>
      <p>
        📲 <a href="https://tu-enlace-de-app.com" target="_blank">Descargar aplicación móvil</a>
      </p>
    </section>
  </div>

  <footer>
    <p>&copy; 2026 Radio Pakal 1040 AM - Palenque, Chiapas</p>
  </footer>
</body>
</html>
