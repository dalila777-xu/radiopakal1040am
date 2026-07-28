<?php
include 'db.php';
session_start();

// --- 1. PROCESAR CIERRE DE SESIÓN ---
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

// --- 2. PROCESAR INICIO DE SESIÓN ---
$login_error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $user_input = mysqli_real_escape_string($conn, $_POST['usuario']);
    $pass_input = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE usuario = '$user_input'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        // Verifica si la contraseña coincide (Texto plano o encriptada)
        if (password_verify($pass_input, $user_data['password']) || $pass_input === $user_data['password']) {
            $_SESSION['usuario'] = $user_data['usuario'];
            $_SESSION['nombre'] = $user_data['nombre'];
            header("Location: admin.php");
            exit;
        } else {
            $login_error = "Contraseña incorrecta.";
        }
    } else {
        $login_error = "El usuario no existe.";
    }
}

// --- VISTA 1: FORMULARIO DE LOG IN (Si no ha iniciado sesión) ---
if (!isset($_SESSION['usuario'])): 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radio Pakal - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #1e3c72, #2a5298); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
        .btn-primary { background: #1e3c72; border: none; }
        .btn-primary:hover { background: #2a5298; }
    </style>
</head>
<body>
    <div class="container" style="max-width: 450px;">
        <div class="card p-4">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-dark m-0">Radio Pakal</h2>
                <small class="text-muted">Panel de Administración</small>
            </div>
            <?php if(!empty($login_error)): ?>
                <div class="alert alert-danger text-center py-2"><?= $login_error ?></div>
            <?php endif; ?>
            <form action="" method="POST">
                <input type="hidden" name="login" value="1">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Usuario</label>
                    <input type="text" name="usuario" class="form-control" placeholder="Ej. admin o Malena p" required autocomplete="off">
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Contraseña</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Entrar al Sistema</button>
            </form>
        </div>
    </div>
</body>
</html>
<?php 
exit; 
endif; 

// --- LÓGICA INTERNA DEL PANEL (Solo usuarios autorizados) ---
$msg = "";

// Acciones: Agregar o Editar Programa
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['guardar_programa'])) {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $hora = mysqli_real_escape_string($conn, $_POST['hora']);
    $programa = mysqli_real_escape_string($conn, $_POST['programa']);
    $locutor = mysqli_real_escape_string($conn, $_POST['locutor']);

    if ($id > 0) {
        $sql = "UPDATE programacion SET hora='$hora', programa='$programa', locutor='$locutor' WHERE id=$id";
        $msg = mysqli_query($conn, $sql) ? "Programa actualizado con éxito." : "Error al actualizar.";
    } else {
        $sql = "INSERT INTO programacion (hora, programa, locutor) VALUES ('$hora', '$programa', '$locutor')";
        $msg = mysqli_query($conn, $sql) ? "Programa agregado a la parrilla." : "Error al guardar.";
    }
}

// Acción: Eliminar Programa
if (isset($_GET['eliminar'])) {
    $id_del = intval($_GET['eliminar']);
    mysqli_query($conn, "DELETE FROM programacion WHERE id=$id_del");
    header("Location: admin.php");
    exit;
}

// Variables para editar
$edit_id = 0; $edit_hora = ""; $edit_prog = ""; $edit_loc = "";
if (isset($_GET['editar'])) {
    $id_edit = intval($_GET['editar']);
    $res_edit = mysqli_query($conn, "SELECT * FROM programacion WHERE id=$id_edit");
    if ($res_edit && $row_edit = mysqli_fetch_assoc($res_edit)) {
        $edit_id = $row_edit['id'];
        $edit_hora = $row_edit['hora'];
        $edit_prog = $row_edit['programa'];
        $edit_loc = $row_edit['locutor'];
    }
}

// Traer la programación completa ordenada por hora
$programas = mysqli_query($conn, "SELECT * FROM programacion ORDER BY hora ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Radio Pakal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Barra de Navegación -->
    <nav class="navbar navbar-dark bg-dark px-4">
        <span class="navbar-brand mb-0 h1">🎙️ Radio Pakal 1040 AM - Panel</span>
        <div class="d-flex align-items-center gap-3">
            <span class="text-white-50">Bienvenido(a), <strong><?= htmlspecialchars($_SESSION['nombre']) ?></strong></span>
            <a href="?logout=1" class="btn btn-outline-danger btn-sm">Cerrar Sesión</a>
        </div>
    </nav>

    <div class="container my-5">
        <?php if(!empty($msg)): ?>
            <div class="alert alert-info alert-dismissible fade show"><?= $msg ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Formulario (Izquierda) -->
            <div class="col-md-4">
                <div class="card p-4 shadow-sm">
                    <h5 class="fw-bold text-primary mb-3"><?= $edit_id > 0 ? "📝 Editar Programa" : "✨ Nuevo Programa" ?></h5>
                    <form action="admin.php" method="POST">
                        <input type="hidden" name="id" value="<?= $edit_id ?>">
                        <div class="mb-3">
                            <label class="form-label">Horario</label>
                            <input type="text" name="hora" class="form-control" placeholder="Ej: 08:00 AM" value="<?= htmlspecialchars($edit_hora) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nombre del Programa</label>
                            <input type="text" name="programa" class="form-control" placeholder="Ej: Románticas del Recuerdo" value="<?= htmlspecialchars($edit_prog) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Locutor(es)</label>
                            <input type="text" name="locutor" class="form-control" placeholder="Ej: Fabián" value="<?= htmlspecialchars($edit_loc) ?>">
                        </div>
                        <button type="submit" name="guardar_programa" class="btn btn-success w-100 fw-bold"><?= $edit_id > 0 ? "Actualizar Cambios" : "Guardar en Parrilla" ?></button>
                        <?php if($edit_id > 0): ?>
                            <a href="admin.php" class="btn btn-secondary w-100 btn-sm mt-2">Cancelar Edición</a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <!-- Tabla de programación (Derecha) -->
            <div class="col-md-8">
                <div class="card p-4 shadow-sm">
                    <h5 class="fw-bold mb-3">Horarios Actuales en la Web</h5>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Horario</th>
                                    <th>Programa</th>
                                    <th>Locutor</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(mysqli_num_rows($programas) > 0): while($row = mysqli_fetch_assoc($programas)): ?>
                                <tr>
                                    <td class="fw-bold text-secondary"><?= htmlspecialchars($row['hora']) ?></td>
                                    <td><?= htmlspecialchars($row['programa']) ?></td>
                                    <td><span class="badge bg-info text-dark"><?= htmlspecialchars($row['locutor'] ?? 'No asignado') ?></span></td>
                                    <td class="text-center">
                                        <a href="?editar=<?= $row['id'] ?>" class="btn btn-warning btn-sm me-1">Editar</a>
                                        <a href="?eliminar=<?= $row['id'] ?>" onclick="return confirm('¿Seguro que quieres borrar este programa?')" class="btn btn-danger btn-sm">Borrar</a>
                                    </td>
                                </tr>
                                <?php endwhile; else: ?>
                                <tr><td colspan="4" class="text-center text-muted py-3">No hay programas cargados aún.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>