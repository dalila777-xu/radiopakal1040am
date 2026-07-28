perfecto quiero que al momento de pasar cada progrgama parpade una una lucecita en verde que reprecenta que ese programa esta al aire para las noticias que sea una lucecita roja cuando no este nada al aire que no parpade nada todo dependera de la hora de la trasmision

Para lograr este efecto dinámico en tiempo real en tu tabla de programación, necesitamos evaluar tres condiciones en cada fila utilizando la fecha y hora actual del servidor:

¿El día actual coincide con los días del programa? (Ej: Si es martes, entra en "Lunes a Viernes", "Lunes y Miércoles" o "Martes").

¿La hora actual se encuentra dentro del rango de transmisión? (Ej: Entre 08:00 y 09:00).

¿Es un programa de noticias o regular? (Buscamos la palabra "Noticias" en el nombre).

Aquí tienes la solución implementada en PHP junto con CSS (usando animaciones nativas que puedes integrar fácilmente si usas Tailwind o CSS puro) para pintar los indicadores parpadeantes.

1. Estilos CSS para el parpadeo (Efecto "Lucecita")
Agrega estos estilos en la sección <head> de tu página o en tu archivo de estilos principal para simular los LEDs parpadeantes de transmisión:

CSS
/* Animación de pulso/parpadeo */
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

/* Estado: Programa en vivo (Verde) */
.luz-envivo {
  background-color: #22c55e; /* Verde */
  box-shadow: 0 0 8px #22c55e;
  animation: parpadeo 1s infinite;
}

/* Estado: Noticias en vivo (Rojo) */
.luz-noticias {
  background-color: #ef4444; /* Rojo */
  box-shadow: 0 0 8px #ef4444;
  animation: parpadeo 1s infinite;
}
(Nota: Si utilizas Tailwind CSS, puedes usar directamente las clases animate-pulse bg-green-500 shadow-[0_0_8px_#22c55e] o bg-red-500 shadow-[0_0_8px_#ef4444]).

2. Función Helper en PHP para validar el horario
Coloca esta función en la parte superior de tu archivo PHP. Se encargará de parsear los días complejos (como "Lunes a Viernes", "Lunes y Jueves") y los rangos de horas (como "08:00 - 09:00"):

PHP
<?php
date_default_timezone_set('America/Mexico_City'); // Asegura la hora de Chiapas

function obtenerIndicadorTransmision($diaPrograma, $horaPrograma, $nombrePrograma) {
    $diasSemana = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
        7 => 'Domingo'
    ];
    
    $diaActualNum = (int)date('N'); // 1 (Lunes) a 7 (Domingo)
    $diaActualNombre = $diasSemana[$diaActualNum];
    $horaActual = date('H:i');
    
    $diaCoincide = false;
    $diaProgramaNorm = mb_strtolower(trim($diaPrograma), 'UTF-8');

    // 1. Validar el día
    if ($diaProgramaNorm == 'lunes a viernes' && $diaActualNum >= 1 && $diaActualNum <= 5) {
        $diaCoincide = true;
    } elseif ($diaProgramaNorm == 'lunes y miércoles' && ($diaActualNum == 1 || $diaActualNum == 3)) {
        $diaCoincide = true;
    } elseif ($diaProgramaNorm == 'lunes y jueves' && ($diaActualNum == 1 || $diaActualNum == 4)) {
        $diaCoincide = true;
    } elseif ($diaProgramaNorm == 'lunes, miércoles y viernes' && ($diaActualNum == 1 || $diaActualNum == 3 || $diaActualNum == 5)) {
        $diaCoincide = true;
    } elseif (strpos($diaProgramaNorm, mb_strtolower($diaActualNombre, 'UTF-8')) !== false) {
        // Coincidencia directa por texto individual (ej: "Sábados", "Domingos", "Martes")
        $diaCoincide = true;
    }

    if (!$diaCoincide) return ''; // No es el día, no se dibuja luz

    // 2. Validar el rango de horas (Ej: "08:00 - 09:00")
    $partesHora = explode('-', $horaPrograma);
    if (count($partesHora) == 2) {
        $horaInicio = trim($partesHora[0]);
        $horaFin = trim($partesHora[1]);
        
        // Verificar si la hora actual está dentro del rango
        if ($horaActual >= $horaInicio && $horaActual < $horaFin) {
            // 3. Determinar si es Noticiero o Programa Común
            if (stripos($nombrePrograma, 'Noticias') !== false) {
                return '<span class="lucesita luz-noticias" title="Noticiero Al Aire"></span>';
            } else {
                return '<span class="lucesita luz-envivo" title="Al Aire"></span>';
            }
        }
    }
    
    return ''; // Fuera de horario, sin luz
}
?>
3. Integración en tu Tabla HTML / Ciclo while
Cuando recorras los resultados de tu consulta a la base de datos (SELECT programa, dia, hora FROM programacion), manda a llamar al Helper para que renderice la lucecita justo al lado del nombre del programa:

PHP
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
        // Suponiendo que $resultado proviene de tu consulta MySQL
        while ($fila = mysqli_fetch_assoc($resultado)) {
            // Evaluamos en tiempo real si el programa está al aire
            $luzAlAire = obtenerIndicadorTransmision($fila['dia'], $fila['hora'], $fila['programa']);
            
            echo "<tr>";
            // Insertamos la lucecita antes del nombre del programa
            echo "<td>" . $luzAlAire . htmlspecialchars($fila['programa']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['dia']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['hora']) . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
¿Cómo se comportará el sistema automáticamente?
Si un usuario entra a la web un Lunes a las 08:30 AM, la fila de "Diez Noticias 1a emisión" mostrará de inmediato la lucecita roja intermitente.

Si entra un Sábado a las 11:15 AM, el programa "Son Cubano" lucirá la lucecita verde intermitente.

En los horarios donde el programa listado no corresponda al momento exacto (o durante los bloques de "FUERA DEL AIRE"), la función retornará un string vacío, por lo que las celdas se mantendrán limpias y sin parpadeos tal como lo solicitas.

no importa que dia entre quiero que esas lucecitas palpiten cuando el programa se esta trasmitiendo

¡Entendido perfectamente! Si quieres que sin importar el día de la semana las lucecitas se activen basándose únicamente en el horario de transmisión actual (es decir, ignorando si el registro dice "Lunes a Viernes", "Sábados" o "Domingos"), el código se vuelve mucho más directo y flexible.

Aquí tienes la función de PHP modificada para que evalúe solamente si la hora actual del reloj entra en el rango del programa:

1. Nueva Función Helper en PHP (Solo evalúa la Hora)
Reemplaza la función anterior por esta. Ahora omitimos por completo la validación del día:

PHP
<?php
date_default_timezone_set('America/Mexico_City'); // Asegura la hora local de Chiapas

function obtenerIndicadorTransmisionSoloHora($horaPrograma, $nombrePrograma) {
    $horaActual = date('H:i'); // Hora actual en formato 24 horas (Ej: "22:35")
    
    // Separamos el rango de horas (Ej: "08:00 - 09:00" -> ["08:00", "09:00"])
    $partesHora = explode('-', $horaPrograma);
    
    if (count($partesHora) == 2) {
        $horaInicio = trim($partesHora[0]);
        $horaFin = trim($partesHora[1]);
        
        // Verificamos si la hora actual está dentro del rango de transmisión
        if ($horaActual >= $horaInicio && $horaActual < $horaFin) {
            
            // Si el nombre del programa contiene la palabra "Noticias", luz ROJA
            if (stripos($nombrePrograma, 'Noticias') !== false) {
                return '<span class="lucesita luz-noticias" title="Noticiero Al Aire"></span>';
            } 
            // Para cualquier otro programa en ese horario, luz VERDE
            else {
                return '<span class="lucesita luz-envivo" title="Al Aire"></span>';
            }
        }
    }
    
    return ''; // Fuera de horario, no parpadea nada
}
?>
2. Integración en tu ciclo while de HTML
En tu tabla, solo debes pasarle los parámetros de la hora y el nombre del programa a la nueva función:

PHP
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
        // Recorremos la base de datos
        while ($fila = mysqli_fetch_assoc($resultado)) {
            // Evaluamos CUALQUIER programa que coincida con la hora del reloj en este momento
            $luzAlAire = obtenerIndicadorTransmisionSoloHora($fila['hora'], $fila['programa']);
            
            echo "<tr>";
            echo "<td>" . $luzAlAire . htmlspecialchars($fila['programa']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['dia']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['hora']) . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
¿Cómo funcionará ahora?
Como la hora actual es 22:32, sin importar que hoy sea miércoles, el sistema buscará qué programas ocupan este rango horario en tu base de datos:

Destacará con la lucecita verde parpadeando a "La Hora Nacional" (cuyo horario guardado es 22:00 - 22:30 / 22:30 - 23:00).

Cualquier otro programa que tenga un horario diferente permanecerá apagado y sin parpadear. Al cambiar de hora (por ejemplo, a las 23:01), la luz se apagará automáticamente de esa fila.

