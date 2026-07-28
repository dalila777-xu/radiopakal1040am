Aquí tienes todo el código integrado en **un solo archivo limpio (`index.php`)** para que solo tengas que copiar, pegar y ejecutar de inmediato.

He unificado la lógica de PHP, la estructura HTML y el diseño con **Tailwind CSS**.

```php
<?php
// =========================================================================
// LÓGICA BACKEND (PHP)
// Aquí puedes simular o jalar datos dinámicos (ej. de una base de datos)
// =========================================================================

// Datos dinámicos para las tarjetas de servicios/módulos
$servicios = [
    [
        'icono' => 'fa-layer-group',
        'titulo' => 'Panel de Control',
        'descripcion' => 'Administra todo el contenido, usuarios y reportes desde una interfaz centralizada y veloz.'
    ],
    [
        'icono' => 'fa-truck-fast',
        'titulo' => 'Monitoreo en Tiempo Real',
        'descripcion' => 'Sigue el estado de tus entregas y movimientos con actualizaciones instantáneas.'
    ],
    [
        'icono' => 'fa-wallet',
        'titulo' => 'Gestión de Créditos',
        'descripcion' => 'Controla liquidaciones, saldos y estados financieros de clientes de forma segura.'
    ]
];

// Año actual dinámico para el footer
$anio_actual = date('Y');
?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Sitio Web Moderno</title>
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">

    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <span class="text-xl font-extrabold tracking-tight bg-gradient-to-r from-sky-500 to-indigo-600 bg-clip-text text-transparent">
                        MI_MARCA
                    </span>
                </div>
                
                <div class="hidden md:flex items-center space-x-8 font-medium text-sm">
                    <a href="#" class="text-sky-600 border-b-2 border-sky-500 pb-1">Inicio</a>
                    <a href="#" class="text-slate-600 hover:text-sky-500 transition-colors">Servicios</a>
                    <a href="#" class="text-slate-600 hover:text-sky-500 transition-colors">Horarios</a>
                    <a href="#" class="text-slate-600 hover:text-sky-500 transition-colors">Contacto</a>
                </div>

                <div class="hidden md:flex items-center">
                    <a href="#" class="bg-gradient-to-r from-sky-500 to-indigo-600 text-white px-5 py-2 rounded-full text-sm font-semibold shadow-md shadow-sky-500/20 hover:opacity-95 transition-all transform hover:-translate-y-0.5">
                        Comenzar <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <header class="relative overflow-hidden bg-white pt-16 pb-24 lg:pt-24 lg:pb-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8 items-center">
                
                <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-600 mb-4 animate-pulse">
                        <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span> ¡Nueva actualización disponible!
                    </span>
                    <h1 class="text-4xl font-black tracking-tight text-slate-900 sm:text-5xl md:text-6xl space-y-2">
                        <span>Optimiza tus proyectos con</span>
                        <span class="block text-gradient bg-gradient-to-r from-sky-500 to-indigo-600 bg-clip-text text-transparent">
                            Sistemas Inteligentes
                        </span>
                    </h1>
                    <p class="mt-4 text-base text-slate-500 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl leading-relaxed">
                        Diseñamos interfaces dinámicas, paneles administrativos robustos y herramientas a la medida de tus necesidades operativas.
                    </p>
                    
                    <div class="mt-8 sm:max-w-lg sm:mx-auto sm:text-center lg:text-left lg:mx-0 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="#" class="bg-slate-900 text-white px-6 py-3 rounded-xl font-medium shadow-xl hover:bg-slate-800 transition-all text-center">
                            Explorar Módulos
                        </a>
                        <a href="#" class="bg-white text-slate-700 border border-slate-200 px-6 py-3 rounded-xl font-medium hover:bg-slate-50 transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-play text-xs text-slate-400"></i> Ver Demostración
                        </a>
                    </div>
                </div>

                <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 flex justify-center">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-72 h-72 bg-sky-300 rounded-full mix-blend-multiply filter blur-2xl opacity-30"></div>
                    <div class="absolute bottom-0 right-10 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-2xl opacity-30"></div>

                    <div class="relative bg-slate-900/95 p-6 rounded-2xl shadow-2xl border border-slate-800 w-full max-w-md transform lg:rotate-2 hover:rotate-0 transition-transform duration-500">
                        <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-4">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-red-500"></span>
                                <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                                <span class="w-3 h-3 rounded-full bg-green-500"></span>
                            </div>
                            <span class="text-xs text-slate-500 font-mono">admin_panel.php</span>
                        </div>
                        <div class="space-y-3">
                            <div class="h-4 bg-slate-800 rounded-sm w-3/4"></div>
                            <div class="h-8 bg-gradient-to-r from-sky-500/20 to-indigo-500/20 border border-sky-500/30 rounded-lg w-full flex items-center px-3 justify-between">
                                <span class="text-xs text-sky-400 font-semibold">Procesando Datos...</span>
                                <i class="fa-solid fa-circle-notch text-xs text-sky-400 animate-spin"></i>
                            </div>
                            
                            <div class="grid grid-cols-3 gap-2 pt-2">
                                <div class="h-16 bg-slate-800/50 rounded-lg p-2 flex flex-col justify-between">
                                    <span class="text-[10px] text-slate-400">Ventas</span>
                                    <span class="text-xs font-bold text-white">+84%</span>
                                </div>
                                <div class="h-16 bg-slate-800/50 rounded-lg p-2 flex flex-col justify-between">
                                    <span class="text-[10px] text-slate-400">Entregas</span>
                                    <span class="text-xs font-bold text-emerald-400">99.2%</span>
                                </div>
                                <div class="h-16 bg-slate-800/50 rounded-lg p-2 flex flex-col justify-between">
                                    <span class="text-[10px] text-slate-400">Créditos</span>
                                    <span class="text-xs font-bold text-amber-400">Activos</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <section class="bg-slate-100 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-extrabold text-slate-900 sm:text-4xl">
                    ¿Qué puedes gestionar con nuestro sistema?
                </h2>
                <p class="mt-4 text-lg text-slate-500">
                    Estructura sólida, control total de roles y flujos de trabajo optimizados.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php foreach ($servicios as $srv): ?>
                    <div class="bg-white p-8 rounded-2xl border border-slate-200/60 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                        <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-500 flex items-center justify-center text-xl font-semibold mb-6 group-hover:bg-gradient-to-r group-hover:from-sky-500 group-hover:to-indigo-600 group-hover:text-white transition-all duration-300">
                            <i class="fa-solid <?php echo $srv['icono']; ?>"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">
                            <?php echo htmlspecialchars($srv['titulo']); ?>
                        </h3>
                        <p class="text-slate-500 text-sm leading-relaxed">
                            <?php echo htmlspecialchars($srv['descripcion']); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <footer class="bg-white border-t border-slate-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-slate-400">
            <div>
                &copy; <?php echo $anio_actual; ?> MI_MARCA. Todos los derechos reservados.
            </div>
            <div class="flex gap-6">
                <a href="#" class="hover:text-slate-600 transition-colors">Términos</a>
                <a href="#" class="hover:text-slate-600 transition-colors">Privacidad</a>
                <a href="#" class="hover:text-slate-600 transition-colors">
                    <i class="fa-brands fa-whatsapp text-lg text-emerald-500"></i>
                </a>
            </div>
        </div>
    </footer>

</body>
</html>

```