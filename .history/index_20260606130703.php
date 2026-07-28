<?php 
include 'db.php'; 
// Obtener programas ordenados
$parrilla = mysqli_query($conn, "SELECT * FROM programacion ORDER BY hora ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radio Pakal 1040 AM - En Vivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary-color: #d32f2f; --dark-bg: #121212; }
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .hero-radio { background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.85)), url('https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?q=80&w=1200') center/cover; color: white; padding: 60px 0; text-center: center; }
        .player-container { background: rgba(255,255,255,0.1); border-radius: 50px; padding: 15px 30px; display: inline-flex; align-items: center; gap: 20px; backdrop-filter: blur(5px); margin-top: 20px; max-width: 100%; }
        audio { filter: sepia(20%) saturate(70%) grayscale(1) invert(0.9) contrast(99%); }
        .social-btn { font-size: 1.5rem; transition: transform 0.2s; color: white; }
        .social-btn:hover { transform: scale(1.2); color: #ffc107; }
        .card-table { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        .table thead { background-color: var(--primary-color); color: white; }
    </style>
</head>
<body>

    <!-- Encabezado Principal y Reproductor -->
    <header class="hero-radio text-center">
        <div class="container">
            <span class="badge bg-danger mb-2 px-3 py-2 text-uppercase tracking-wider fw-bold"><i class="fas fa-circle-notch fa-spin me-2"></i> En el Aire</span>
            <h1 class="display-4 fw-bold m-0">Radio Pakal 1040 AM</h1>
            <p class="lead text-white-50 mt-1">La voz que te acompaña en Palenque y toda la región</p>
            
            <!-- CONTENEDOR DEL REPRODUCTOR STREAMING -->
            <div class="player-container shadow">
                <span class="fw-bold text-white small text-uppercase"><i class="fas fa-music me-2 text-warning"></i>Escuchar:</span>
                <!-- Reemplaza la URL de abajo por tu enlace streaming IP:PUERTO real -->
                <audio controls autoplay preload="none">
                    <source src="http://TU_IP_STREAMING:PUERTO/stream" type="audio/mpeg">
                    Tu navegador no soporta reproducción de audio.
                </audio>
            </div>

            <!-- Redes Sociales Integradas -->
            <div class="mt-4 d-flex justify-content-center gap-4">
                <a href="https://www.facebook.com/RadioPakalOficial" target="_blank" class="social-btn"><i class="fab fa-facebook"></i></a>
                <a href="#" target="_blank" class="social-btn"><i class="fab fa-whatsapp text-success"></i></a>
                <a href="#" target="_blank" class="social-btn"><i class="fab fa-youtube text-danger"></i></a>
            </div>
        </div>
    </header>

    <!-- Sección de la Parrilla de Programación -->
    <main class="container my-5" style="max-width: 900px;">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-dark"><i class="far fa-calendar-alt text-danger me-2"></i>Nuestra Programación</h3>
            <p class="text-muted">No te pierdas a tus locutores y programas favoritos a lo largo del día</p>
        </div>

        <div class="card card-table p-4 bg-white">
            <div class="table-responsive">
                <table class="table table-hover align-middle m-0">
                    <thead>
                        <tr>
                            <th scope="col" class="py-3 px-4 rounded-start" style="width: 25%;">Horario</th>
                            <th scope="col" class="py-3">Programa</th>
                            <th scope="col" class="py-3 px-4 rounded-end">Conducción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($parrilla) > 0): while($row = mysqli_fetch_assoc($parrilla)): ?>
                        <tr>
                            <td class="py-3 px-4 fw-bold text-danger"><i class="far fa-clock me-2"></i><?= htmlspecialchars($row['hora']) ?></td>
                            <td class="py-3 fw-semibold text-dark"><?= htmlspecialchars($row['programa']) ?></td>
                            <td class="py-3 px-4"><span class="badge bg-light text-secondary border px-3 py-2"><i class="fas fa-microphone me-1 text-warning"></i> <?= htmlspecialchars($row['locutor'] ?? 'Staff Pakal') ?></span></td>
                        </tr>
                        <?php endwhile; else: ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted py-5">
                                <i class="fas fa-radio fa-2x mb-2 text-black-50"></i><br>Programación en mantenimiento. ¡Sintonízanos al aire!
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white-50 text-center py-4 mt-5">
        <p class="m-0 small">&copy; <?= date('Y') ?> Radio Pakal 1040 AM. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>