<?php
// ===== CONFIGURACIÓN DE NOTICIAS =====
$noticias = [
    [
        'id' => 1,
        'titulo' => 'Nueva programación en Radio Pakal 104.0',
        'descripcion' => 'Descubre los nuevos programas y horarios de la semana.',
        'resumen' => 'Descubre los nuevos programas y horarios de la semana.',
        'url' => 'noticia.php?id=1',
        'imagen' => 'https://via.placeholder.com/150x100?text=Noticia+1'
    ],
    [
        'id' => 2,
        'titulo' => 'Evento especial con la comunidad',
        'descripcion' => 'Conoce la próxima actividad cultural organizada por la radio.',
        'resumen' => 'Conoce la próxima actividad cultural organizada por la radio.',
        'url' => 'noticia.php?id=2',
        'imagen' => 'https://via.placeholder.com/150x100?text=Noticia+2'
    ],
    [
        'id' => 3,
        'titulo' => 'Entrevista exclusiva',
        'descripcion' => 'Escucha la conversación con nuestros invitados especiales.',
        'resumen' => 'Escucha la conversación con nuestros invitados especiales.',
        'url' => 'noticia.php?id=3',
        'imagen' => 'https://via.placeholder.com/150x100?text=Noticia+3'
    ]
];

// ===== FUNCIONES AUXILIARES =====
function obtenerImagenPublicacion($publicacion) {
    return $publicacion['imagen'] ?? '';
}

function obtenerUrlPublicacion($publicacion) {
    if (!empty($publicacion['url'])) {
        return $publicacion['url'];
    }
    if (!empty($publicacion['id'])) {
        return 'noticia.php?id=' . urlencode($publicacion['id']);
    }
    return 'noticia.php';
}

// ===== VARIABLES GLOBALES =====
$publicaciones = $noticias;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radio Pakal - Noticias</title>
    <!-- Font Awesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ===== ESTILOS GENERALES ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* ===== SECCIÓN DE NOTICIAS ===== */
        .noticias-section {
            margin-top: 2rem;
        }

        .noticias-container {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1rem;
            background: #ffffff;
            padding: 1.5rem;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .noticias-container:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        /* ===== COLUMNA DE IMAGEN ===== */
        .noticias-imagen {
            flex: 1;
            min-width: 240px;
        }

        .noticias-imagen img {
            width: 100%;
            max-height: 260px;
            object-fit: cover;
            border-radius: 12px;
            transition: transform 0.3s ease;
        }

        .noticias-imagen img:hover {
            transform: scale(1.02);
        }

        .noticias-imagen-placeholder {
            width: 100%;
            height: 260px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            color: #6b7280;
            font-size: 1.2rem;
            font-weight: 500;
        }

        /* ===== COLUMNA DE CONTENIDO ===== */
        .noticias-contenido {
            flex: 1;
            min-width: 260px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 1rem;
        }

        .noticias-titulo {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .noticias-titulo i {
            color: #1d4ed8;
        }

        .noticias-descripcion {
            margin: 0;
            color: #6b7280;
            font-size: 1.05rem;
            line-height: 1.6;
        }

        /* ===== BOTÓN VER MÁS NOTICIAS ===== */
        .btn-ver-noticias {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.9rem 2rem;
            border-radius: 999px;
            background: #1d4ed8;
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.05rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(29, 78, 216, 0.2);
            width: fit-content;
        }

        .btn-ver-noticias:hover {
            background: #1e40af;
            transform: translateY(-2px);
            box-shadow: 0 8px 12px rgba(29, 78, 216, 0.3);
        }

        .btn-ver-noticias:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(29, 78, 216, 0.2);
        }

        .btn-ver-noticias i {
            font-size: 1.1rem;
        }

        /* ===== CONTADOR DE NOTICIAS ===== */
        .noticias-contador {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            font-size: 0.95rem;
        }

        .noticias-contador span {
            background: #1d4ed8;
            color: white;
            padding: 0.2rem 0.8rem;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .noticias-container {
                flex-direction: column;
                padding: 1rem;
            }

            .noticias-imagen {
                width: 100%;
                min-width: unset;
            }

            .noticias-imagen img {
                max-height: 200px;
            }

            .noticias-contenido {
                width: 100%;
                min-width: unset;
                align-items: center;
                text-align: center;
            }

            .noticias-titulo {
                font-size: 1.6rem;
            }

            .btn-ver-noticias {
                width: 100%;
                justify-content: center;
                padding: 0.9rem 1.5rem;
            }

            .noticias-contador {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .noticias-titulo {
                font-size: 1.3rem;
            }

            .noticias-descripcion {
                font-size: 0.95rem;
            }

            .btn-ver-noticias {
                font-size: 0.95rem;
                padding: 0.8rem 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- ===== SECCIÓN NOTICIAS ===== -->
        <section class="noticias-section" id="noticias">
            <div class="noticias-container">
                <!-- IMAGEN DESTACADA -->
                <div class="noticias-imagen">
                    <?php $imagenPrincipal = obtenerImagenPublicacion($publicaciones[0] ?? []); ?>
                    <?php if (!empty($imagenPrincipal)): ?>
                        <img 
                            src="<?php echo htmlspecialchars($imagenPrincipal); ?>" 
                            alt="Últimas noticias de Radio Pakal" 
                            loading="lazy"
                            onerror="this.onerror=null; this.src='https://placehold.co/600x400/1d4ed8/ffffff?text=Radio+Pakal+Noticias'"
                        >
                    <?php else: ?>
                        <div class="noticias-imagen-placeholder">
                            <i class="fas fa-newspaper" style="margin-right: 10px;"></i>
                            Últimas noticias
                        </div>
                    <?php endif; ?>
                </div>

                <!-- CONTENIDO -->
                <div class="noticias-contenido">
                    <h2 class="noticias-titulo">
                        <i class="fas fa-newspaper"></i>
                        Noticias
                    </h2>
                    
                    <p class="noticias-descripcion">
                        Mantente informado con las últimas noticias de Radio Pakal 104.0 FM. 
                        Conoce todos los eventos, programaciones y entrevistas exclusivas.
                    </p>

                    <!-- CONTADOR DE NOTICIAS DISPONIBLES -->
                    <div class="noticias-contador">
                        <i class="fas fa-circle" style="color: #22c55e; font-size: 0.6rem;"></i>
                        <span><?php echo count($publicaciones); ?></span> noticias disponibles
                    </div>

                    <!-- BOTÓN VER MÁS NOTICIAS - REDIRIGE A ver_noticia.php -->
                    <a href="ver_noticia.php" class="btn-ver-noticias">
                        <i class="fas fa-external-link-alt"></i>
                        Ver más noticias
                        <i class="fas fa-arrow-right" style="font-size: 0.9rem;"></i>
                    </a>
                </div>
            </div>
        </section>

        <!-- ===== INFORMACIÓN ADICIONAL (OPCIONAL) ===== -->
        <div style="margin-top: 2rem; padding: 1rem; text-align: center; color: #9ca3af; font-size: 0.9rem; border-top: 1px solid #e5e7eb;">
            <p>© <?php echo date('Y'); ?> Radio Pakal 104.0 FM - Todos los derechos reservados</p>
        </div>
    </div>

    <!-- ===== SCRIPT PARA MEJORAR LA EXPERIENCIA ===== -->
    <script>
        // Efecto de entrada suave al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            const section = document.querySelector('.noticias-container');
            if (section) {
                section.style.opacity = '0';
                section.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    section.style.transition = 'all 0.6s ease';
                    section.style.opacity = '1';
                    section.style.transform = 'translateY(0)';
                }, 100);
            }

            // Contador de noticias con animación
            const contador = document.querySelector('.noticias-contador span');
            if (contador) {
                const final = parseInt(contador.textContent);
                let current = 0;
                const interval = setInterval(() => {
                    if (current < final) {
                        current++;
                        contador.textContent = current;
                    } else {
                        clearInterval(interval);
                    }
                }, 50);
            }
        });

        // Efecto de seguimiento del mouse en el botón
        document.querySelector('.btn-ver-noticias')?.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            this.style.setProperty('--mouse-x', x + 'px');
            this.style.setProperty('--mouse-y', y + 'px');
        });
    </script>
</body>
</html>