<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
include("db.php");

$mensaje = "";

// --- ACCIÓN 1: INSERTAR NUEVO PROGRAMA ---
if (isset($_POST['agregar'])) {
    $dia = mysqli_real_escape_string($conn, $_POST['dia']);
    $programa = mysqli_real_escape_string($conn, $_POST['programa']);

    if (!empty($dia) && !empty($programa)) {
        $query = "INSERT INTO programacion (hora, programa) VALUES ('$dia', '$programa')";
        if (mysqli_query($conn, $query)) {
            $mensaje = "<div class='alert success'>✨ Programa agregado correctamente.</div>";
        } else {
            $mensaje = "<div class='alert error'>❌ Error al agregar: " . mysqli_error($conn) . "</div>";
        }
    }
}

// --- ACCIÓN 2: ELIMINAR PROGRAMA ---
if (isset($_GET['eliminar'])) {
    // Si tu llave primaria no se llama 'id', cámbiala por el nombre correcto (ej. 'id_programa')
    $id = intval($_GET['eliminar']); 
    $query = "DELETE FROM programacion WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        $mensaje = "<div class='alert success'>🗑️ Programa eliminado con éxito.</div>";
    } else {
        $mensaje = "<div class='alert error'>❌ Error al eliminar.</div>";
    }
}

// --- ACCIÓN 3: ACTUALIZAR PROGRAMA EN BD ---
if (isset($_POST['actualizar'])) {
    $id = intval($_POST['id']);
    $dia = mysqli_real_escape_string($conn, $_POST['dia']);
    $programa = mysqli_real_escape_string($conn, $_POST['programa']);

    $query = "UPDATE programacion SET hora = '$dia', programa = '$programa' WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        $mensaje = "<div class='alert success'>🔄 Programa actualizado correctamente.</div>";
    } else {
        $mensaje = "<div class='alert error'>❌ Error al actualizar.</div>";
    }
}

// --- PASO PREVIO PARA EDITAR (Cargar datos en el formulario) ---
$edit_mode = false;
$edit_id = "";
$edit_dia = "";
$edit_programa = "";

if (isset($_GET['editar'])) {
    $edit_mode = true;
    $id_editar = intval($_GET['editar']);
    $res_edit = mysqli_query($conn, "SELECT * FROM programacion WHERE id = $id_editar");
    if ($res_edit && mysqli_num_rows($res_edit) > 0) {
        $row_edit = mysqli_fetch_assoc($res_edit);
        $edit_id = $row_edit['id'];
        $edit_dia = $row_edit['hora'];
        $edit_programa = $row_edit['programa'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Programación | Radio Pakal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: sans-serif; background: #f4f6f9; margin: 0; padding: 20px; color: #333; }
        .header-modulo { background: #2C5F2D; color: white; padding: 15px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .header-modulo a { color: white; text-decoration: none; font-weight: bold; background: rgba(0,0,0,0.2); padding: 8px 15px; border-radius: 5px; }
        .form-container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 25px; border-top: 4px solid #D4AF37; }
        .form-inline { display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end; }
        .form-group { display: flex; flex-direction: column; }
        .form-group label { font-weight: bold; margin-bottom: 5px; font-size: 0.9rem; }
        .form-group input { padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem; }
        .btn-submit { background: #2C5F2D; color: white; border: none; padding: 11px 20px; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 1rem; }
        .btn-update { background: #D4AF37; color: #1a1a2e; }
        .btn-cancel { background: #666; color: white; text-decoration: none; padding: 11px 20px; border-radius: 4px; font-weight: bold; font-size: 0.9rem; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        th { background: #1a1a2e; color: white; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #eee; }
        tr:hover td { background: #fdf9f0; }
        .actions-btns a { text-decoration: none; padding: 5px 10px; border-radius: 4px; font-size: 0.85rem; font-weight: bold; margin-right: 5px; display: inline-block; }
        .btn-edit { background: #D4AF37; color: #1a1a2e; }
        .btn-delete { background: #8B2C2D; color: white; }
        .alert { padding: 12px; border-radius: 5px; margin-bottom: 15px; font-weight: bold; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

    <div class="header-modulo">
        <h2><i class="fas fa-calendar-alt"></i> Panel de Control de Horarios (Programación)</h2>
        <a href="admin.php"><i class="fas fa-arrow-left"></i> Volver al Menú</a>
    </div>

    <?php echo $mensaje; ?>

    <div class="form-container">
        <h3><?php echo $edit_mode ? "📝 Modificar Programa Seleccionado" : "➕ Registrar Nuevo Programa en la Parrilla"; ?></h3>
        <br>
        <form action="admin_programacion.php" method="POST" class="form-inline">
            <?php if ($edit_mode): ?>
                <input type="hidden" name="id" value="<?php echo $edit_id; ?>">
            <?php endif; ?>

            <div class="form-group">
                <label>Día de la semana (Lunes a Domingo):</label>
                <input type="text" name="dia" placeholder="Ej: Lunes" required value="<?php echo htmlspecialchars($edit_dia); ?>">
            </div>

            <div class="form-group" style="flex: 1; min-width: 250px;">
                <label>Programa / Horario:</label>
                <input type="text" name="programa" placeholder="Ej: Amanecer Maya - 06:00 a 09:00" required value="<?php echo htmlspecialchars($edit_programa); ?>">
            </div>

            <div>
                <?php if ($edit_mode): ?>
                    <button type="submit" name="actualizar" class="btn-submit btn-update"><i class="fas fa-save"></i> Guardar Cambios</button>
                    <a href="admin_programacion.php" class="btn-cancel">Cancelar</a>
                <?php else: ?>
                    <button type="submit" name="agregar" class="btn-submit"><i class="fas fa-plus-circle"></i> Agregar a la Lista</button>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <h3><i class="fas fa-list"></i> Programación por Día de la Semana</h3>
    <br>
    <table>
        <thead>
            <tr>
                <th style="width: 20%;">Día</th>
                <th>Programa / Horario</th>
                <th style="width: 20%; text-align: center;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM programacion ORDER BY FIELD(hora, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo') ASC");
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td><strong>" . htmlspecialchars($row['hora']) . "</strong></td>";
                    echo "<td>" . htmlspecialchars($row['programa']) . "</td>";
                    echo "<td class='actions-btns' style='text-align: center;'>";
                    echo "<a href='admin_programacion.php?editar=" . $row['id'] . "' class='btn-edit'><i class='fas fa-edit'></i> Editar</a>";
                    echo "<a href='admin_programacion.php?eliminar=" . $row['id'] . "' class='btn-delete' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este horario?\");'><i class='fas fa-trash-alt'></i> Borrar</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3' style='text-align: center; color: #777;'>No hay programas registrados actualmente.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>