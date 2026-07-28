// Vista del Login
if (isset($_GET['page']) && $_GET['page'] === 'login') {
  ?>
  <!DOCTYPE html>
  <html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Radio Pakal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    *{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif}
    body{background:linear-gradient(135deg, #0d1b2a 0%, #1b3a5c 50%, #2a5f7a 100%);display:flex;justify-content:center;align-items:center;height:100vh;color:#1a1a2e}
    .login-container{background:rgba(255,255,255,0.95);backdrop-filter:blur(10px);padding:2.5rem;border-radius:16px;box-shadow:0 8px 32px rgba(0,0,0,0.3);width:100%;max-width:400px;border-top:4px solid #D4AF37;position:relative;overflow:hidden}
    .login-container::before{content:'';position:absolute;top:-50%;left:-50%;width:200%;height:200%;background:radial-gradient(circle at 30% 50%, rgba(212,175,55,0.05) 0%, transparent 60%);pointer-events:none}
    .login-logo{display:block;margin:0 auto 1rem;width:120px;height:auto}
    .text-center{text-align:center;margin-bottom:1.5rem}
    .text-center h2{color:#0d47a1;font-size:1.6rem;margin-bottom:.3rem;font-weight:700}
    .text-center p{color:#6b7280;font-size:0.9rem;font-weight:500;letter-spacing:1px}
    .text-center p span{color:#D4AF37}
    .form-group{margin-bottom:1.2rem;position:relative}
    .form-group i{position:absolute;left:14px;top:38px;color:#D4AF37;font-size:1rem;transition:all 0.3s ease}
    label{display:block;margin-bottom:.4rem;font-weight:600;font-size:.85rem;color:#1f2937}
    input[type=text],input[type=password]{width:100%;padding:.75rem .75rem .75rem 2.5rem;border:2px solid #e5e7eb;border-radius:8px;font-size:.95rem;transition:all 0.3s ease;background:#f9fafb}
    input[type=text]:focus,input[type=password]:focus{outline:none;border-color:#D4AF37;background:#ffffff;box-shadow:0 0 0 4px rgba(212,175,55,0.1)}
    input[type=text]:focus ~ i, input[type=password]:focus ~ i{color:#0d47a1}
    .btn-submit{background:linear-gradient(135deg, #0d47a1 0%, #1565c0 100%);color:white;border:none;width:100%;padding:.75rem;border-radius:8px;font-size:1rem;font-weight:600;cursor:pointer;transition:all 0.3s ease;box-shadow:0 4px 15px rgba(13,71,161,0.3)}
    .btn-submit:hover{transform:translateY(-2px);box-shadow:0 8px 25px rgba(13,71,161,0.4);background:linear-gradient(135deg, #0a3a7a 0%, #0d47a1 100%)}
    .btn-submit:active{transform:translateY(0)}
    .error-msg{background:#fde8e8;color:#dc2626;padding:.75rem;border-radius:8px;font-size:.85rem;margin-bottom:1rem;text-align:center;border:1px solid #f8b4b4}
    .back-link{display:block;text-align:center;margin-top:1.2rem;color:#0d47a1;text-decoration:none;font-size:.85rem;font-weight:500;transition:all 0.3s ease}
    .back-link:hover{color:#D4AF37;text-decoration:underline}
    .back-link i{transition:transform 0.3s ease}
    .back-link:hover i{transform:translateX(-4px)}
    .login-container::after{content:'📻';position:absolute;bottom:-20px;right:-10px;font-size:80px;opacity:0.05;pointer-events:none;transform:rotate(-15deg)}
    </style>
  </head>
  <body>
  <div class="login-container">
    <img src="pm.png" alt="Logo Radio Pakal" class="login-logo" onerror="this.src='https://placehold.co/80x80?text=Logo'">
    <div class="text-center">
        <h2>Panel de Control</h2>
        <p>Radio Pakal <span>1040 AM</span></p>
    </div>
    <?php if(!empty($login_error)): ?>
      <div class="error-msg"><?php echo htmlspecialchars($login_error); ?></div>
    <?php endif; ?>
    <form action="?page=login" method="POST">
      <input type="hidden" name="login_action" value="1">
      <div class="form-group">
          <label for="usuario"><i class="fas fa-user"></i> Usuario</label>
          <input type="text" id="usuario" name="usuario" required placeholder="Ingresa tu usuario">
      </div>
      <div class="form-group">
          <label for="password"><i class="fas fa-lock"></i> Contraseña</label>
          <input type="password" id="password" name="password" required placeholder="••••••••">
      </div>
      <button type="submit" class="btn-submit">Ingresar al Sistema</button>
    </form>
    <a href="index.php" class="back-link"><i class="fas fa-arrow-left"></i> Volver a la página web</a>
  </div>
  </body>
  </html>
  <?php
  exit();
}