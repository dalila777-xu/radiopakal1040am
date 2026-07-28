<?php
// ==========================================
// index.php - RADIO PAKAL 1040 AM
// ==========================================

require_once 'db.php';
session_start();
date_default_timezone_set('America/Mexico_City');

// ==========================================
// FUNCIONES
// ==========================================

/**
 * Obtiene el indicador LED para programas en vivo
 */
function obtenerIndicadorTransmision($diaPrograma, $horaPrograma, $nombrePrograma) {
    $diasSemana = [
        1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 
        4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo'
    ];
    
    $diaActualNum = (int)date('N');
    $diaActualNombre = $diasSemana[$diaActualNum];
    $horaActual = date('H:i');
    
    $diaCoincide = false;
    $diaProgramaNorm = mb_strtolower(trim($diaPrograma), 'UTF-8');

    // Validar días complejos
    if ($diaProgramaNorm == 'lunes a viernes' && $diaActualNum >= 1 && $diaActualNum <= 5) {
        $diaCoincide = true;
    } elseif ($diaProgramaNorm == 'miércoles a viernes' && $diaActualNum >= 3 && $diaActualNum <= 5) {
        $diaCoincide = true;
    } elseif ($diaProgramaNorm == 'lunes a martes' && $diaActualNum >= 1 && $diaActualNum <= 2) {
        $diaCoincide = true;
    } elseif ($diaProgramaNorm == 'lunes a domingo' && $diaActualNum >= 1 && $diaActualNum <= 7) {
        $diaCoincide = true;
    } elseif (strpos($diaProgramaNorm, mb_strtolower($diaActualNombre, 'UTF-8')) !== false) {
        $diaCoincide = true;
    }

    if (!$diaCoincide) return ''; 

    // Validar rango horario
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

// ==========================================
// CONSULTAS A LA BASE DE DATOS
// ==========================================

// Programación
$query_programacion = "SELECT programa, dia, hora FROM programacion ORDER BY id";
$result_programacion = mysqli_query($conn, $query_programacion);

// Redes Sociales
$query_redes = "SELECT nombre, url, icono FROM redes_sociales WHERE activo = 1";
$result_redes = mysqli_query($conn, $query_redes);

// Carrusel
$query_carrusel = "SELECT ruta_imagen, titulo FROM carrusel WHERE activo = 1 ORDER BY orden ASC";
$result_carrusel = mysqli_query($conn, $query_carrusel);

// ==========================================
// INICIO DEL HTML
// ==========================================
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radio Pakal 1040 AM - Oficial</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* ... estilos ... */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #ffffff; }
        /* ... más estilos ... */
        
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
            animation: parpadeo 1s infinite ease-in-out;
        }
        
        .luz-noticias {
            background-color: #ef4444;
            box-shadow: 0 0 8px #ef4444;
            animation: parpadeo 1s infinite ease-in-out;
        }
        
        /* ... más estilos ... */
    </style>
</head>
<body>

<!-- ==========================================
HEADER
========================================== -->
<header>
    <img src="pm.png" alt="Logo Radio Pakal" class="logo">
    <h1>Radio Pakal 1040 AM</h1>
    <p>Palenque, Chiapas</p>
</header>

<!-- ==========================================
NAVEGACIÓN
========================================== -->
<nav>
    <a href="#quienes"><i class="fas fa-users"></i> Quiénes Somos</a>
    <a href="#ubicacion"><i class="fas fa-map-marker-alt"></i> Ubicación</a>
    <a href="#programacion"><i class="fas fa-calendar-alt"></i> Programación</a>
    <a href="#redes"><i class="fas fa-share-alt"></i> Redes Sociales</a>
    <a href="#app"><i class="fas fa-mobile-alt"></i> App Móvil</a>
    <?php if (isset($_SESSION['usuario'])): ?>
        <a href="admin.php"><i class="fas fa-user-cog"></i> Panel</a>
    <?php else: ?>
        <a href="?page=login"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</a>
    <?php endif; ?>
</nav>

<!-- ==========================================
CONTENIDO PRINCIPAL
========================================== -->
<div class="container">

    <!-- ==========================================
    SECCIÓN: QUIÉNES SOMOS
    ========================================== -->
    <section id="quienes">
        <h2><i class="fas fa-users"></i> Quiénes Somos</h2>
        <p><strong>Radio Pakal 1040 AM</strong> es una emisora comunitaria profundamente arraigada en Palenque, Chiapas. Promovemos la riqueza cultural, la música de nuestra región y la identidad de nuestra gente, transmitiendo con orgullo tanto en español como en nuestras valiosas lenguas originarias (Ch'ol y Tzeltal).</p>
        <p style="margin-top:0.8rem;">Somos parte del compromiso del Gobierno del Estado de Chiapas por llevar información, educación y entretenimiento a cada rincón de nuestra tierra.</p>

        <!-- CARRUSEL -->
        <div class="carrusel-container">
            <div class="carrusel">
                <div class="carrusel-track">
                    <?php if ($result_carrusel && mysqli_num_rows($result_carrusel) > 0): ?>
                        <?php while ($slide = mysqli_fetch_assoc($result_carrusel)): ?>
                            <div class="carrusel-slide">
                                <img src="<?php echo htmlspecialchars($slide['ruta_imagen']); ?>" alt="<?php echo htmlspecialchars($slide['titulo']); ?>">
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="carrusel-slide">
                            <img src="https://placehold.co/900x400?text=Radio+Pakal" alt="Radio Pakal">
                        </div>
                    <?php endif; ?>
                </div>
                <button class="carrusel-btn prev" id="prevBtn">❮</button>
                <button class="carrusel-btn next" id="nextBtn">❯</button>
            </div>
            <div class="carrusel-dots" id="dotsContainer"></div>
        </div>
    </section>

    <!-- ==========================================
    SECCIÓN: PROGRAMACIÓN
    ========================================== -->
    <section id="programacion">
        <h2><i class="fas fa-calendar-alt"></i> Programación Radio Pakal</h2>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th><i class="fas fa-microphone"></i> Programa</th>
                        <th><i class="fas fa-calendar-alt"></i> Día</th>
                        <th><i class="fas fa-clock"></i> Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result_programacion && mysqli_num_rows($result_programacion) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result_programacion)): ?>
                            <?php $luz = obtenerIndicadorTransmision($row['dia'], $row['hora'], $row['programa']); ?>
                            <tr>
                                <td><?php echo $luz . htmlspecialchars($row['programa']); ?></td>
                                <td><strong><?php echo htmlspecialchars($row['dia']); ?></strong></td>
                                <td><?php echo htmlspecialchars($row['hora']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="3" style="text-align:center;padding:1.5rem;">📻 No hay programación registrada.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- ==========================================
    SECCIÓN: REDES SOCIALES
    ========================================== -->
    <section id="redes">
        <h2><i class="fab fa-facebook"></i> Síguenos en Redes Sociales</h2>
        <div class="grid-buttons">
            <?php if ($result_redes && mysqli_num_rows($result_redes) > 0): ?>
                <?php while ($red = mysqli_fetch_assoc($result_redes)): ?>
                    <?php 
                        $nombre = strtolower($red['nombre']);
                        $clase = '';
                        $icono = '';
                        if (strpos($nombre, 'facebook') !== false) { 
                            $clase = 'facebook-btn'; 
                            $icono = 'fab fa-facebook-f'; 
                        } elseif (strpos($nombre, 'whatsapp') !== false) { 
                            $clase = 'whatsapp-btn'; 
                            $icono = 'fab fa-whatsapp'; 
                        } else { 
                            $clase = 'app-btn'; 
                            $icono = 'fas fa-share-alt'; 
                        }
                    ?>
                    <a href="<?php echo htmlspecialchars($red['url']); ?>" target="_blank" class="btn-card <?php echo $clase; ?>">
                        <i class="<?php echo $icono; ?>"></i> <?php echo htmlspecialchars($red['nombre']); ?>
                    </a>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No hay redes sociales configuradas.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- ==========================================
    SECCIÓN: APP
    ========================================== -->
    <section id="app">
        <h2><i class="fas fa-download"></i> Lleva la Radio en tu Bolsillo</h2>
        <div class="grid-buttons">
            <a href="#" class="btn-card app-btn"><i class="fas fa-qrcode"></i> Descargar Aplicación Android / iOS</a>
        </div>
        <p style="margin-top:1rem;font-size:0.8rem;color:#666;">
            <i class="fas fa-headphones"></i> Escúchanos en vivo, participa en encuestas y recibe notificaciones exclusivas.
        </p>
    </section>

    <!-- ==========================================
    SECCIÓN: UBICACIÓN
    ========================================== -->
    <section id="ubicacion">
        <h2><i class="fas fa-location-dot"></i> Nuestra Ubicación</h2>
        <p><i class="fas fa-map-pin"></i> <strong>Dirección:</strong> 3a. Avenida Sur Ote. 24 C.P. 29960 Palenque, Chiapas.</p>
        <p><i class="fas fa-phone-alt"></i> <strong>Contacto:</strong> (961) 617 0500 Ext. 57000</p>
        <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3809.916853245455!2d-91.98151892394017!3d17.50769400000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTfCsDMwJzI3LjciTiA5McKwNTgnNDQuMiJX!5e0!3m2!1ses-419!2smx!4v1718742000000!5m2!1ses-419!2smx" allowfullscreen="" loading="lazy"></iframe>
    </section>
</div>

<!-- ==========================================
FOOTER
========================================== -->
<footer>
    <p>© <?php echo date('Y'); ?> Radio Pakal 1040 AM — Palenque, Chiapas</p>
    <p>Conectando culturas, uniendo comunidades.</p>
    <p style="font-size:0.75rem;margin-top:0.5rem;">Sistema Chiapaneco de Radio, Televisión y Cinematografía | Humanismo que transforma</p>
</footer>

<!-- ==========================================
JAVASCRIPT - CARRUSEL Y NAVEGACIÓN
========================================== -->
<script>
    // Carrusel
    document.addEventListener('DOMContentLoaded', function() {
        const track = document.querySelector('.carrusel-track');
        const slides = track ? track.querySelectorAll('.carrusel-slide') : [];
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const dotsContainer = document.getElementById('dotsContainer');

        if (!track || slides.length === 0) return;

        let currentIndex = 0;

        function createDots() {
            dotsContainer.innerHTML = '';
            slides.forEach((_, index) => {
                const dot = document.createElement('button');
                dot.classList.add('carrusel-dot');
                if (index === currentIndex) dot.classList.add('active');
                dot.addEventListener('click', () => goToSlide(index));
                dotsContainer.appendChild(dot);
            });
        }

        function updateDots() {
            document.querySelectorAll('.carrusel-dot').forEach((dot, index) => {
                dot.classList.toggle('active', index === currentIndex);
            });
        }

        function goToSlide(index) {
            currentIndex = index;
            track.style.transform = 'translateX(' + (-currentIndex * 100) + '%)';
            updateDots();
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % slides.length;
            goToSlide(currentIndex);
        }

        function prevSlide() {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            goToSlide(currentIndex);
        }

        if (nextBtn) nextBtn.addEventListener('click', nextSlide);
        if (prevBtn) prevBtn.addEventListener('click', prevSlide);

        let autoPlay = setInterval(nextSlide, 5000);
        const container = document.querySelector('.carrusel-container');
        if (container) {
            container.addEventListener('mouseenter', () => clearInterval(autoPlay));
            container.addEventListener('mouseleave', () => {
                autoPlay = setInterval(nextSlide, 5000);
            });
        }

        createDots();
    });

    // Navegación activa
    document.addEventListener('scroll', function() {
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('nav a');
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 90;
            const sectionBottom = sectionTop + section.offsetHeight;
            if (window.scrollY >= sectionTop && window.scrollY < sectionBottom) {
                current = section.getAttribute('id');
            }
        });
        navLinks.forEach(link => {
            link.style.background = '';
            link.style.color = '';
            const icon = link.querySelector('i');
            if (link.getAttribute('href') === '#' + current) {
                link.style.background = '#8B2C2D';
                link.style.color = 'white';
                if (icon) icon.style.color = 'white';
            } else {
                if (icon) icon.style.color = '#8B2C2D';
            }
        });
    });
</script>

</body>
</html>