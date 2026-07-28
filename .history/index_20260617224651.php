<?php
date_default_timezone_set('America/Mexico_City');

function obtenerIndicadorTransmision($horaPrograma, $nombrePrograma) {
    $horaActual = date('H:i');
    $partesHora = explode('-', $horaPrograma);
    
    if (count($partesHora) == 2) {
        $horaInicio = trim($partesHora[0]);
        $horaFin = trim($partesHora[1]);
        
        if ($horaActual >= $horaInicio && $horaActual < $horaFin) {
            if (stripos($nombrePrograma, 'Noticias') !== false) {
                return '<span class="lucesita luz-noticias" title="Noticiero Al Aire"></span>';
            } else {
                return '<span class="lucesita luz-envivo" title="Al Aire"></span>';
            }
        }
    }
    
    return '';
}
?>

<style>
@keyframes parpadeo {
  0% { opacity: 0.3; }
  50% { opacity: 1; }
  100% { opacity: 0.3; }
}

.lucesita {
  display: inline-block;
  width: 12px;
  height: 12px;
  border-radius: 50%;
  margin-right: 8px;
  vertical-align: middle;
}

.luz-envivo {
  background-color: #22c55e;
  box-shadow: 0 0 8px #22c55e;
  animation: parpadeo 1s infinite;
}

.luz-noticias {
  background-color: #ef4444;
  box-shadow: 0 0 8px #ef4444;
  animation: parpadeo 1s infinite;
}
</style>

<table class="tabla-programacion">
    <thead>
        <tr>
            <th>Programa</th>
            <th>Día</th>
            <th>Horario</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $luzAlAire = obtenerIndicadorTransmision($fila['hora'], $fila['programa']);
            
            echo "<tr>";
            echo "<td>" . $luzAlAire . htmlspecialchars($fila['programa']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['dia']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['hora']) . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>

