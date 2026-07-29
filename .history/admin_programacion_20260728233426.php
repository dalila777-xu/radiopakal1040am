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
    $programa = trim($_POST['programa'] ?? '');
    $dia = trim($_POST['dia'] ?? '');
    $hora = trim($_POST['hora'] ?? '');

    if (!empty($programa) && !empty($dia) && !empty($hora)) {
        $data = [
            'programa' => $programa,
            'dia' => $dia,
            'hora' => $hora
        ];
        
        $response = supabaseRequest('programacion', 'POST', $data);
        
        if (is_array($response)) {
            $mensaje = "<div class='alert success'>✨ Programa agregado correctamente a la lista.</div>";
        } else {
            $mensaje = "<div class='alert error'>❌ Error al agregar a Supabase.</div>";
        }
    } else {
        $mensaje = "<div class='alert error'>⚠️ Por favor, llena todos los campos del formulario.</div>";
    }
}

// --- ACCIÓN 2: ELIMINAR PROGRAMA ---
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']); 
    supabaseRequest('programacion', 'DELETE', null, "id=eq.$id");
    
    header("Location: admin-programacion.php");
    exit();
}

// --- ACCIÓN 3: ACTUALIZAR PROGRAMA EN BD ---
if (isset($_POST['actualizar'])) {
    $id = intval($_POST['id'] ?? 0);
    $programa = trim($_POST['programa'] ?? '');
    $dia = trim($_POST['dia'] ?? '');
    $hora = trim($_POST['hora'] ?? '');

    if ($id > 0 && !empty($programa) && !empty($dia) && !empty($hora)) {
        $data = [
            'programa' => $programa,
            'dia' => $dia,
            'hora' => $hora
        ];
        
        $response = supabaseRequest('programacion', 'PATCH', $data, "id=eq.$id");
        $mensaje = "<div class='alert success'>🔄 Programa actualizado correctamente.</div>";
    } else {
        $mensaje = "<div class='alert error'>❌ Error al actualizar el registro.</div>";
    }
}

// --- PASO PREVIO PARA EDITAR (Cargar datos en el formulario) ---
$edit_mode = false;
$edit_id = "";
$edit_programa = "";
$edit_dia = "";
$edit_hora = "";

if (isset($_GET['editar'])) {
    $edit_mode = true;
    $id_editar = intval($_GET['editar']);
    $res_edit = supabaseRequest('programacion', 'GET', null, "id=eq.$id_editar");
    
    if (!empty($res_edit) && is_array($res_edit)) {
        $row_edit = $res_edit[0];
        $edit_id = $row_edit['id'];
        $edit_programa = $row_edit['programa'] ?? '';
        $edit_dia = $row_edit['dia'] ?? '';
        $edit_hora = $row_edit['hora'] ?? '';
    }
}

// --- OBTENER TODA LA PROGRAMACIÓN ---
$programacion_lista = supabaseRequest('programacion', 'GET', null, "order=id.asc");
if (!is_array($programacion_lista)) {
    $programacion_lista = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Programación | Panel de Control</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: sans-serif; background: #f4f6f9; margin: 0; padding: 20px; color: #333; }
        .header-modulo { background: #0099FF; color: white; padding: 15px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .header-modulo a { color: white; text-decoration: none; font-weight: bold; background: rgba(255,255,255,0.15); padding: 8px 15px; border-radius: 5px; }
        .form-container { background: #000000; color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 25px; border-top: 4px solid #0099FF; }
        .form-inline { display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end; }
        .form-group { display: flex; flex-direction: column; }
        .form-group label { font-weight: bold; margin-bottom: 5px; font-size: 0.9rem; color: white; }
        .form-group input { padding: 10px; border: 1px solid #444; border-radius: 4px; font-size: 1rem; background: #fff; color: #000; }
        .btn-submit { background: #4aa1ec; color: white; border: none; padding: 11px 20px; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 1rem; }
        .btn-update { background: #D4AF37; color: #1a1a2e; }
        .btn-cancel { background: #666; color: white; text-decoration: none; padding: 11px 20px; border-radius: 4px; font-weight: bold; font-size: 0.9rem; display: inline-block; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        th { background: #1a1a2e; color: white; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #eee; }
        tr:hover td { background: #fdf9f0; }
        .actions-btns a { text-decoration: none; padding: 5px 10px; border-radius: 4px; font-size: 0.85rem; font-weight: bold; margin-right: 5px; display: inline-block; }
        .btn-edit { background: #1a9154; color: #ffffff; }
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
        <form action="admin-programacion.php" method="POST" class="form-inline">
            <?php if ($edit_mode): ?>
                <input type="hidden" name="id" value="<?php echo $edit_id; ?>">
            <?php endif; ?>

            <div class="form-group" style="flex: 1.5; min-width: 200px;">
                <label>Nombre del Programa:</label>
                <input type="text" name="programa" placeholder="Ej: Tierra Nueva" required value="<?php echo htmlspecialchars($edit_programa); ?>">
            </div>

            <div class="form-group" style="flex: 1; min-width: 180px;">
                <label>Días de Transmisión:</label>
                <input type="text" name="dia" placeholder="Ej: Lunes a viernes" required value="<?php echo htmlspecialchars($edit_dia); ?>">
            </div>

            <div class="form-group" style="flex: 0.8; min-width: 130px;">
                <label>Duración / Hora:</label>
                <input type="text" name="hora" placeholder="Ej: 1 hora o 30 min" required value="<?php echo htmlspecialchars($edit_hora); ?>">
            </div>

            <div>
                <?php if ($edit_mode): ?>
                    <button type="submit" name="actualizar" class="btn-submit btn-update"><i class="fas fa-save"></i> Guardar Cambios</button>
                    <a href="admin-programacion.php" class="btn-cancel">Cancelar</a>
                <?php else: ?>
                    <button type="submit" name="agregar" class="btn-submit"><i class="fas fa-plus-circle"></i> Agregar a la Lista</button>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <h3><i class="fas fa-list"></i> Programación Actual en el Sistema</h3>
    <br>
    <table>
        <thead>
            <tr>
                <th><i class="fas fa-microphone"></i> Programa</th>
                <th><i class="fas fa-calendar-alt"></i> Días</th>
                <th><i class="fas fa-clock"></i> Duración / Hora</th>
                <th style="width: 20%; text-align: center;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($programacion_lista)): ?>
                <?php foreach ($programacion_lista as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['programa'] ?? ''); ?></td>
                        <td><strong><?php echo htmlspecialchars($row['dia'] ?? ''); ?></strong></td>
                        <td><?php echo htmlspecialchars($row['hora'] ?? ''); ?></td>
                        <td class='actions-btns' style='text-align: center;'>
                            <a href='admin-programacion.php?editar=<?php echo $row['id']; ?>' class='btn-edit'><i class='fas fa-edit'></i> Editar</a>
                            <a href='admin-programacion.php?eliminar=<?php echo $row['id']; ?>' class='btn-delete' onclick='return confirm("¿Estás seguro de que deseas eliminar este programa?");'><i class='fas fa-trash-alt'></i> Borrar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan='4' style='text-align: center; color: #777; padding: 20px;'>📻 No hay programas registrados actualmente.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>