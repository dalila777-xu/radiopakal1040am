<?php include("db.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Radio Pakal 1040 AM</title>
</head>
<body>
  <h1>Programación</h1>
  <ul>
    <?php
    $result = mysqli_query($conn, "SELECT hora, programa FROM programacion");
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>" . $row['hora'] . " - " . $row['programa'] . "</li>";
    }
    ?>
  </ul>

  <h2>Lo último en Facebook</h2>
  <div class="fb-page" 
       data-href="https://www.facebook.com/TuPaginaDeRadio"
       data-tabs="timeline"
       data-width="500"
       data-height="600">
  </div>

  <script async defer crossorigin="anonymous" 
    src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v17.0"></script>

  <br>
  <a href="admin.php">Panel Administrativo</a>
</body>
</html>
