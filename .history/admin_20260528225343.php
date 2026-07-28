<?php include("db.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel Administrativo - Radio Pakal 1040</title>
</head>
<body>
  <h1>Agregar Programa</h1>
  <form method="POST">
    Hora: <input type="text" name="hora"><br>
    Programa: <input type="text" name="programa"><br>
    <button type="submit">Guardar</button>
  </form>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $hora = $_POST["hora"];
      $programa = $_POST["programa"];
      $sql = "INSERT INTO programacion (hora, programa) VALUES ('$hora', '$programa')";
      if (mysqli_query($conn, $sql)) {
          echo "<p>Programa agregado correctamente.</p>";
      } else {
          echo "<p>Error: " . mysqli_error($conn) . "</p>";
      }
  }
  ?>
</body>
</html>
