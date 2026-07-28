<?php
include("db.php");
session_start();

// Si ya tiene una sesión activa, redirigir directo al panel de administración
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
                $_SESSION['rol'] = $user_data['rol'] ?? 'colaborador';
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
    <title>Iniciar Sesión | Radio Pakal 1040 AM</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
            font-family: 'Inter', sans-serif; 
        }
        
        body { 
            background: linear-gradient(135deg, #8B2C2D 0%, #2C5F2D 100%);
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            color: #1a1a2e; 
            padding: 1rem;
        }
        
        .login-container { 
            background: white; 
            padding: 2.5rem; 
            border-radius: 20px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.15); 
            width: 100%; 
            max-width: 420px; 
            border-top: 5px solid #D4AF37;
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Logo */
        .logo-container {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .logo-img {
            width: 85px;
            height: 85px;
            object-fit: contain;
            margin-bottom: 0.8rem;
            border-radius: 50%;
            background: #f8f5f0;
            padding: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        
        .logo-container h2 { 
            color: #6B1E1F; 
            font-size: 1.6rem; 
            margin-bottom: 0.3rem; 
            font-weight: 700;
        }
        
        .logo-container p { 
            color: #777; 
            font-size: 0.85rem; 
        }
        
        .divider {
            height: 2px;
            background: linear-gradient(90deg, #D4AF37, #8B2C2D, #2C5F2D);
            width: 80px;
            margin: 0.8rem auto;
            border-radius: 2px;
        }
        
        /* Formulario */
        .form-group { 
            margin-bottom: 1.2rem; 
            position: relative; 
        }
        
        .form-group i { 
            position: absolute; 
            left: 12px; 
            top: 38px; 
            color: #8B2C2D; 
            font-size: 1rem;
        }
        
        label { 
            display: block; 
            margin-bottom: 0.4rem; 
            font-weight: 600; 
            font-size: 0.85rem; 
            color: #444; 
        }
        
        input[type="text"], 
        input[type="password"] { 
            width: 100%; 
            padding: 0.85rem 0.85rem 0.85rem 2.5rem; 
            border: 1px solid #e0e0e0; 
            border-radius: 10px; 
            font-size: 0.95rem; 
            outline: none; 
            transition: all 0.3s ease; 
            background: #fafafa;
        }
        
        input[type="text"]:focus, 
        input[type="password"]:focus { 
            border-color: #8B2C2D; 
            background: white;
            box-shadow: 0 0 0 3px rgba(139,44,45,0.1);
        }
        
        .btn-submit { 
            background: linear-gradient(135deg, #8B2C2D 0%, #6B1E1F 100%);
            color: white; 
            border: none; 
            width: 100%; 
            padding: 0.85rem; 
            border-radius: 10px; 
            font-size: 1rem; 
            font-weight: 600; 
            cursor: pointer; 
            transition: all 0.3s ease; 
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .btn-submit:hover { 
            background: linear-gradient(135deg, #6B1E1F 0%, #4a1415 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(139,44,45,0.3);
        }
        
        .error-msg { 
            background: #fde8e8; 
            color: #e53e3e; 
            padding: 0.75rem; 
            border-radius: 10px; 
            font-size: 0.85rem; 
            margin-bottom: 1rem; 
            text-align: center; 
            border-left: 3px solid #e53e3e;
        }
        
        .back-link { 
            display: block; 
            text-align: center; 
            margin-top: 1.5rem; 
            color: #8B2C2D; 
            text-decoration: none; 
            font-size: 0.85rem; 
            font-weight: 500; 
            transition: all 0.3s;
        }
        
        .back-link:hover { 
            color: #6B1E1F;
            text-decoration: underline; 
        }
        
        /* Info de roles */
        .info-roles {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
            text-align: center;
            font-size: 0.7rem;
            color: #999;
        }
        
        .info-roles p {
            margin: 5px 0;
        }
        
        .info-roles strong {
            color: #8B2C2D;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="logo-container">
        <!-- LOGOTIPO -->
        <img src="logo.png" alt="Radio Pakal Logo" class="logo-img" onerror="this.src='https://placehold.co/85x85?text=RP'">
        <h2><i class="fas fa-tower-broadcast"></i> Radio Pakal</h2>
        <p>1040 AM - La voz de Palenque</p>
        <div class="divider"></div>
        <p style="margin-top: 0.5rem; font-size: 0.8rem; color: #888;">Panel de Administración</p>
    </div>

    <?php if(!empty($error)): ?>
        <div class="error-msg">
            <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="usuario"><i class="fas fa-user-circle"></i> Usuario</label>
            <i class="fas fa-user"></i>
            <input type="text" id="usuario" name="usuario" required placeholder="Ingresa tu usuario">
        </div>
        <div class="form-group">
            <label for="password"><i class="fas fa-key"></i> Contraseña</label>
            <i class="fas fa-lock"></i>
            <input type="password" id="password" name="password" required placeholder="••••••••">
        </div>
        <button type="submit" class="btn-submit">
            <i class="fas fa-sign-in-alt"></i> Ingresar al Sistema
        </button>
    </form>

    <a href="index.php" class="back-link">
        <i class="fas fa-arrow-left"></i> Volver a la página web
    </a>
    
    <div class="info-roles">
        <p><i class="fas fa-user-shield"></i> <strong>Administrador:</strong> admin / admin123</p>
        <p><i class="fas fa-user-friends"></i> <strong>Colaborador:</strong> colaborador / colab123</p>
    </div>
</div>

</body>
</html>