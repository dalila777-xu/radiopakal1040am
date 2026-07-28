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
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<li>" . $row['hora'] . " - " . $row['programa'] . "</li>";
        }
    } else {
        echo "<li>No hay datos disponibles.</li>";
    }
    ?>
  </ul>
</body>
</html>
