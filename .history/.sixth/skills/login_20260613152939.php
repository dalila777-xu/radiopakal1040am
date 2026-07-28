<?php
include("db.php");
session_start();

// CORREGIDO: Si ya tiene una sesión activa, redirigir directo al panel de administración
if (isset($_SESSION['usuario'])) {
    header("Location: admin.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $password = $_POST['password']; 

    if (!empty($usuario) && !empty($password)) {
        // Buscamos al usuario en la base de datos
        $query = "SELECT * FROM usuarios WHERE usuario = '$usuario' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            
            // Verificación: Soporta tanto contraseñas con hash como texto plano
            if ($password === $user_data['password'] || password_verify($password, $user_data['password'])) {
                $_SESSION['usuario'] = $user_data['usuario'];
                $_SESSION['nombre'] = $user_data['nombre'] ?? $user_data['usuario'];
                $_SESSION['rol'] = $user_data['rol'] ?? 'Administrador'; // Previene errores de índices en admin.php
                
                header("Location: admin.php");
                exit();
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "El usuario no existe.";
        }
    } else {
        $error = "Por favor, llena todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Radio Pakal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #f8f5f0; display: flex; justify-content: center; align-items: center; height: 100vh; color: #1a1a2e; }
        .login-container { background: white; padding: 2.5rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); width: 100%; max-width: 400px; border-top: 4px solid #8B2C2D; }
        .text-center { text-align: center; margin-bottom: 1.5rem; }
        .text-center h2 { color: #6B1E1F; font-size: 1.6rem; margin-bottom: 0.3rem; }
        .text-center p { color: #777; font-size: 0.9rem; }
        
        /* Contenedor del Logotipo */
        .login-logo-container { margin-bottom: 1rem; }
        .login-logo-container img { max-width: 110px; height: auto; object-fit: contain; }

        .form-group { margin-bottom: 1.2rem; position: relative; }
        .form-group i { position: absolute; left: 12px; top: 38px; color: #8B2C2D; }
        label { display: block; margin-bottom: 0.4rem; font-weight: 600; font-size: 0.85rem; color: #444; }
        input[type="text"], input[type="password"] { width: 100%; padding: 0.75rem 0.75rem 0.75rem 2.2rem; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem; outline: none; transition: border 0.2s; }
        input[type="text"]:focus, input[type="password"]:focus { border-color: #8B2C2D; }
        .btn-submit { background: #8B2C2D; color: white; border: none; width: 100%; padding: 0.75rem; border-radius: 6px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: background 0.2s; margin-top: 0.5rem; }
        .btn-submit:hover { background: #6B1E1F; }
        .error-msg { background: #fde8e8; color: #e53e3e; padding: 0.75rem; border-radius: 6px; font-size: 0.85rem; margin-bottom: 1rem; text-align: center; border: 1px solid #f8b4b4; }
        .back-link { display: block; text-align: center; margin-top: 1.2rem; color: #8B2C2D; text-decoration: none; font-size: 0.85rem; font-weight: 500; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="login-container">
    <div class="text-center">
        <div class="login-logo-container">
            <img src="p.png" alt="Logo Radio Pakal" onerror="this.src='https://placehold.co/110x110?text=Radio+Pakal'">
        </div>
        <h2>Panel de Control</h2>
        <p>Radio Pakal 1040 AM</p>
    </div>

    <?php if(!empty($error)): ?>
        <div class="error-msg"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="usuario">Usuario</label>
            <i class="fas fa-user"></i>
            <input type="text" id="usuario" name="usuario" required placeholder="Ingresa tu usuario">
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <i class="fas fa-lock"></i>
            <input type="password" id="password" name="password" required placeholder="••••••••">
        </div>
        <button type="submit" class="btn-submit">Ingresar al Sistema</button>
    </form>

    <a href="index.php" class="back-link"><i class="fas fa-arrow-left"></i> Volver a la página web</a>
</div>

</body>
</html>