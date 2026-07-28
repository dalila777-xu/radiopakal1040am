// Vista del Login
if (isset($_GET['page']) && $_GET['page'] === 'login') {
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
    *{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif}
    body{background:#f8f5f0;display:flex;justify-content:center;align-items:center;height:100vh;color:#1a1a2e}
    .login-container{background:white;padding:2.5rem;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,0.05);width:100%;max-width:400px;border-top:4px solid #1a56db}
    .login-logo{display:block;margin:0 auto 1rem;width:120px;height:auto}
    .text-center{text-align:center;margin-bottom:1.5rem}
    .text-center h2{color:#1a56db;font-size:1.6rem;margin-bottom:.3rem}
    .text-center p{color:#D4AF37;font-weight:600;font-size:0.9rem}
    .form-group{margin-bottom:1.2rem;position:relative}
    .form-group i{position:absolute;left:12px;top:38px;color:#1a56db}
    label{display:block;margin-bottom:.4rem;font-weight:600;font-size:.85rem;color:#444}
    input[type=text],input[type=password]{width:100%;padding:.75rem .75rem .75rem 2.2rem;border:2px solid #e5e7eb;border-radius:6px;font-size:.95rem;transition:border-color 0.3s ease}
    input[type=text]:focus,input[type=password]:focus{outline:none;border-color:#1a56db;box-shadow:0 0 0 3px rgba(26,86,219,0.1)}
    .btn-submit{background:#1a56db;color:white;border:none;width:100%;padding:.75rem;border-radius:6px;font-size:1rem;font-weight:600;cursor:pointer;margin-top:.5rem;transition:background 0.3s ease}
    .btn-submit:hover{background:#0d3a9e}
    .error-msg{background:#fde8e8;color:#e53e3e;padding:.75rem;border-radius:6px;font-size:.85rem;margin-bottom:1rem;text-align:center;border:1px solid #f8b4b4}
    .back-link{display:block;text-align:center;margin-top:1.2rem;color:#1a56db;text-decoration:none;font-size:.85rem;font-weight:500;transition:color 0.3s ease}
    .back-link:hover{color:#0d3a9e}
    .back-link i{color:#D4AF37;margin-right:4px}
    </style>
  </head>
  <body>
  <div class="login-container">
    <img src="pm.png" alt="Logo Radio Pakal" class="login-logo" onerror="this.src='https://placehold.co/80x80?text=Logo'">
    <div class="text-center"><h2>Panel de Control</h2><p>Radio Pakal 1040 AM</p></div>
    <?php if(!empty($login_error)): ?>
      <div class="error-msg"><?php echo htmlspecialchars($login_error); ?></div>
    <?php endif; ?>
    <form action="?page=login" method="POST">
      <input type="hidden" name="login_action" value="1">
      <div class="form-group"><label for="usuario"><i class="fas fa-user" style="position:static;margin-right:6px;"></i> Usuario</label><input type="text" id="usuario" name="usuario" required placeholder="Ingresa tu usuario"></div>
      <div class="form-group"><label for="password"><i class="fas fa-lock" style="position:static;margin-right:6px;"></i> Contraseña</label><input type="password" id="password" name="password" required placeholder="••••••••"></div>
      <button type="submit" class="btn-submit"><i class="fas fa-sign-in-alt"></i> Ingresar al Sistema</button>
    </form>
    <a href="index.php" class="back-link"><i class="fas fa-arrow-left"></i> Volver a la página web</a>
  </div>
  </body>
  </html>
  <?php
  exit();
}