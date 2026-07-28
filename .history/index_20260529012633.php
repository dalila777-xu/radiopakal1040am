<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Radio Pakal 1040 AM | La experiencia musical de Chiapas</title>
    <meta name="description" content="Radio Pakal 1040 AM - La emisora que conecta con la comunidad y comparte cultura. Música, noticias y entretenimiento en Chiapas.">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', 'Segoe UI', sans-serif;
            background: #0a0a0a;
            color: #ffffff;
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* ============ ANIMACIONES GLOBALES ============ */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes wave {
            0%, 100% {
                transform: rotate(0deg);
            }
            25% {
                transform: rotate(5deg);
            }
            75% {
                transform: rotate(-5deg);
            }
        }

        .animate-up {
            animation: fadeInUp 0.8s ease forwards;
        }

        .animate-left {
            animation: fadeInLeft 0.8s ease forwards;
        }

        .animate-right {
            animation: fadeInRight 0.8s ease forwards;
        }

        /* Scrollbar personalizada */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #1a1a1a;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #ff6b35, #ff8c5a);
            border-radius: 10px;
        }

        /* ============ HEADER ============ */
        header {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            transition: all 0.4s ease;
            background: transparent;
            padding: 1.5rem 2rem;
        }

        header.scrolled {
            background: rgba(10, 10, 10, 0.95);
            backdrop-filter: blur(10px);
            padding: 0.8rem 2rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-icon {
            font-size: 2.2rem;
            background: linear-gradient(135deg, #ff6b35, #ff8c5a);
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .logo-text h1 {
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .logo-text span {
            font-size: 0.7rem;
            opacity: 0.8;
            letter-spacing: 2px;
        }

        nav {
            display: flex;
            gap: 2rem;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
            position: relative;
        }

        nav a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(135deg, #ff6b35, #ff8c5a);
            transition: 0.3s;
        }

        nav a:hover::after {
            width: 100%;
        }

        .mobile-menu {
            display: none;
            font-size: 1.8rem;
            cursor: pointer;
        }

        /* ============ HERO SECTION ============ */
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, rgba(26, 71, 42, 0.9), rgba(13, 40, 24, 0.95)), url('https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at center, transparent 0%, rgba(0,0,0,0.3) 100%);
        }

        .hero-content {
            max-width: 900px;
            padding: 0 2rem;
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(255, 107, 53, 0.2);
            backdrop-filter: blur(10px);
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-size: 0.8rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 107, 53, 0.5);
            animation: pulse 2s infinite;
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #fff, #ff8c5a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff6b35, #ff8c5a);
            color: white;
            border: none;
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-primary:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.4);
        }

        .btn-secondary {
            background: transparent;
            border: 2px solid white;
            color: white;
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-secondary:hover {
            background: white;
            color: #1a472a;
            transform: translateY(-3px);
        }

        .hero-wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            z-index: 1;
        }

        /* ============ FRECUENCIAS ============ */
        .frecuencias {
            max-width: 1400px;
            margin: -60px auto 0;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            padding: 0 2rem;
            position: relative;
            z-index: 10;
        }

        .frecuencia-card {
            background: rgba(26, 26, 26, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.4s ease;
            border: 1px solid rgba(255, 107, 53, 0.2);
            cursor: pointer;
        }

        .frecuencia-card:hover {
            transform: translateY(-10px);
            border-color: #ff6b35;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .frecuencia-card span {
            font-size: 3rem;
            display: block;
            margin-bottom: 1rem;
            animation: float 3s infinite;
        }

        .frecuencia-card h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #ff6b35, #ff8c5a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* ============ SECCIONES GENERALES ============ */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 5rem 2rem;
        }

        .section {
            margin-bottom: 4rem;
        }

        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-icon {
            font-size: 2.5rem;
            display: inline-block;
            background: linear-gradient(135deg, #ff6b35, #ff8c5a);
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .section-header h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 1rem 0;
            background: linear-gradient(135deg, #fff, #ff8c5a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .section-header p {
            color: #aaa;
            max-width: 600px;
            margin: 0 auto;
        }

        /* ============ QUIÉNES SOMOS ============ */
        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .about-text h3 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: #ff6b35;
        }

        .about-text p {
            color: #ccc;
            margin-bottom: 1rem;
        }

        .about-stats {
            display: flex;
            gap: 3rem;
            margin-top: 2rem;
        }

        .stat {
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            background: linear-gradient(135deg, #ff6b35, #ff8c5a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .about-image {
            background: linear-gradient(135deg, #1a472a, #0d2818);
            border-radius: 30px;
            padding: 3rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .about-image::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,107,53,0.1) 0%, transparent 70%);
            animation: float 6s infinite;
        }

        .about-image span {
            font-size: 6rem;
            position: relative;
            z-index: 1;
        }

        /* ============ UBICACIÓN ============ */
        .ubicacion-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
        }

        .ubicacion-info {
            background: rgba(26, 26, 26, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            padding: 2rem;
            border: 1px solid rgba(255, 107, 53, 0.2);
        }

        .ubicacion-info h3 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: #ff6b35;
        }

        .direccion-item {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            align-items: center;
            padding: 0.8rem;
            border-radius: 12px;
            transition: 0.3s;
        }

        .direccion-item:hover {
            background: rgba(255, 107, 53, 0.1);
            transform: translateX(5px);
        }

        .direccion-item span {
            font-size: 1.8rem;
        }

        .mapa {
            border-radius: 25px;
            overflow: hidden;
            height: 350px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .mapa iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }

        /* ============ PROGRAMACIÓN ============ */
        .programacion-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .programa-card {
            background: rgba(26, 26, 26, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 1.5rem;
            display: flex;
            gap: 1.5rem;
            align-items: center;
            transition: all 0.4s ease;
            border: 1px solid rgba(255, 107, 53, 0.2);
            cursor: pointer;
        }

        .programa-card:hover {
            transform: translateX(10px);
            border-color: #ff6b35;
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.2);
        }

        .programa-hora {
            background: linear-gradient(135deg, #ff6b35, #ff8c5a);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 15px;
            font-weight: 600;
            font-size: 0.8rem;
            min-width: 110px;
            text-align: center;
        }

        .programa-info h3 {
            font-size: 1rem;
            margin-bottom: 0.3rem;
        }

        .programa-info p {
            color: #aaa;
            font-size: 0.85rem;
        }

        /* ============ REDES SOCIALES ============ */
        .redes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .red-card {
            background: rgba(26, 26, 26, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            text-decoration: none;
            transition: all 0.4s ease;
            border: 1px solid rgba(255, 107, 53, 0.2);
            position: relative;
            overflow: hidden;
        }

        .red-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: 0.5s;
        }

        .red-card:hover::before {
            left: 100%;
        }

        .red-card:hover {
            transform: translateY(-10px) scale(1.02);
        }

        .red-card span {
            font-size: 3rem;
            display: block;
            margin-bottom: 1rem;
        }

        .red-card h3 {
            margin-bottom: 0.5rem;
            font-size: 1.3rem;
        }

        .red-card p {
            font-size: 0.8rem;
            color: #aaa;
        }

        .red-card.facebook { border-top: 4px solid #1877f2; }
        .red-card.whatsapp { border-top: 4px solid #25d366; }
        .red-card.instagram { 
            border-top: 4px solid;
            border-image: linear-gradient(135deg, #feda77, #d62976, #962fbf, #4f5bd5);
            border-image-slice: 1;
        }
        .red-card.twitter { border-top: 4px solid #1da1f2; }

        /* ============ APP MÓVIL ============ */
        .app-card {
            background: linear-gradient(135deg, #1a472a, #0d2818);
            border-radius: 30px;
            padding: 3rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .app-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,107,53,0.1) 0%, transparent 70%);
        }

        .app-card span {
            font-size: 4rem;
            position: relative;
        }

        .app-card h2 {
            font-size: 2rem;
            margin: 1rem 0;
            position: relative;
        }

        .app-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 2rem;
            position: relative;
        }

        .btn-app {
            background: white;
            color: #1a472a;
            text-decoration: none;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
        }

        .btn-app:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        /* ============ FACEBOOK FEED ============ */
        .facebook-container {
            background: rgba(26, 26, 26, 0.8);
            border-radius: 25px;
            padding: 2rem;
            min-height: 500px;
            backdrop-filter: blur(10px);
        }

        /* ============ CONTACTO ============ */
        .contacto-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
        }

        .contacto-form {
            background: rgba(26, 26, 26, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            padding: 2rem;
            border: 1px solid rgba(255, 107, 53, 0.2);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 1rem;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255, 107, 53, 0.3);
            border-radius: 12px;
            font-family: inherit;
            color: white;
            transition: 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #ff6b35;
            box-shadow: 0 0 10px rgba(255, 107, 53, 0.3);
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: #888;
        }

        .btn-submit {
            background: linear-gradient(135deg, #ff6b35, #ff8c5a);
            color: white;
            border: none;
            padding: 1rem;
            width: 100%;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(255, 107, 53, 0.3);
        }

        /* ============ FOOTER ============ */
        footer {
            background: linear-gradient(135deg, #0a0a0a, #0d2818);
            text-align: center;
            padding: 3rem 2rem;
            border-top: 1px solid rgba(255, 107, 53, 0.2);
        }

        .footer-social {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .footer-social a {
            color: white;
            font-size: 1.5rem;
            transition: 0.3s;
        }

        .footer-social a:hover {
            color: #ff6b35;
            transform: translateY(-3px);
        }

        /* ============ RESPONSIVE ============ */
        @media (max-width: 992px) {
            .about-grid,
            .ubicacion-grid,
            .contacto-wrapper {
                grid-template-columns: 1fr;
            }
            
            .hero h1 {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            nav {
                display: none;
                position: absolute;
                top: 70px;
                left: 0;
                width: 100%;
                background: rgba(10, 10, 10, 0.95);
                backdrop-filter: blur(10px);
                flex-direction: column;
                padding: 1rem;
                text-align: center;
            }
            
            nav.show {
                display: flex;
            }
            
            .mobile-menu {
                display: block;
            }
            
            .hero h1 {
                font-size: 2rem;
            }
            
            .frecuencias {
                margin-top: -100px;
            }
            
            .programacion-grid {
                grid-template-columns: 1fr;
            }
            
            .section-header h2 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>

<header>
    <div class="header-container">
        <div class="logo">
            <div class="logo-icon">🎙️</div>
            <div class="logo-text">
                <h1>Radio Pakal</h1>
                <span>1040 AM</span>
            </div>
        </div>
        <nav>
            <a href="#inicio">Inicio</a>
            <a href="#quienes-somos">Nosotros</a>
            <a href="#programacion">Programación</a>
            <a href="#redes">Redes</a>
            <a href="#app">App</a>
            <a href="#contacto">Contacto</a>
        </nav>
        <div class="mobile-menu" onclick="document.querySelector('nav').classList.toggle('show')">
            <i class="fas fa-bars"></i>
        </div>
    </div>
</header>

<!-- HERO SECTION -->
<section id="inicio" class="hero">
    <div class="hero-content">
        <div class="hero-badge">
            <i class="fas fa-broadcast-tower"></i> EN VIVO 1040 AM
        </div>
        <h1 class="animate-up">La voz que conecta contigo</h1>
        <p class="animate-up">Música, cultura y entretenimiento para toda la familia chiapaneca</p>
        <div class="hero-buttons animate-up">
            <button class="btn-primary" onclick="alert('🎶 Próximamente: Stream en vivo. ¡Gracias por sintonizar Radio Pakal 1040 AM!')">
                <i class="fas fa-play"></i> Escúchanos en vivo
            </button>
            <a href="#quienes-somos" class="btn-secondary">Conócenos <i class="fas fa-arrow-down"></i></a>
        </div>
    </div>
    <div class="hero-wave">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#0a0a0a" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>

<!-- FRECUENCIAS -->
<div class="frecuencias">
    <div class="frecuencia-card animate-up">
        <span>📡</span>
        <h3>1040 AM</h3>
        <p>Todo el estado de Chiapas</p>
    </div>
    <div class="frecuencia-card animate-up" style="animation-delay: 0.2s">
        <span>💻</span>
        <h3>Online</h3>
        <p>En todo el mundo</p>
    </div>
    <div class="frecuencia-card animate-up" style="animation-delay: 0.4s">
        <span>📱</span>
        <h3>App Móvil</h3>
        <p>Descarga gratis</p>
    </div>
</div>

<div class="container">

    <!-- QUIÉNES SOMOS -->
    <section id="quienes-somos" class="section">
        <div class="section-header animate-up">
            <div class="section-icon">🎙️</div>
            <h2>Quiénes Somos</h2>
            <p>Conoce nuestra historia y misión</p>
        </div>
        <div class="about-grid">
            <div class="about-text animate-left">
                <h3>Radio Pakal 1040 AM</h3>
                <p>Somos una emisora comprometida con la difusión de la cultura, música y tradiciones de Chiapas. Fundada en 1995, hemos sido la voz de las comunidades chiapanecas durante más de 30 años.</p>
                <p>Nuestra programación incluye música regional, noticias, entrevistas y espacios educativos que fomentan la identidad cultural y el desarrollo comunitario.</p>
                <div class="about-stats">
                    <div class="stat">
                        <div class="stat-number">30+</div>
                        <p>Años de experiencia</p>
                    </div>
                    <div class="stat">
                        <div class="stat-number">24/7</div>
                        <p>Transmisión continua</p>
                    </div>
                    <div class="stat">
                        <div class="stat-number">10+</div>
                        <p>Programas exclusivos</p>
                    </div>
                </div>
            </div>
            <div class="about-image animate-right">
                <span>🎙️</span>
                <h3 style="margin-top: 1rem;">"La voz de Chiapas"</h3>
                <p>Conectando comunidades a través de la radio</p>
            </div>
        </div>
    </section>

    <!-- UBICACIÓN -->
    <section id="ubicacion" class="section">
        <div class="section-header animate-up">
            <div class="section-icon">📍</div>
            <h2>Nuestra Ubicación</h2>
            <p>Visítanos o envíanos un mensaje</p>
        </div>
        <div class="ubicacion-grid">
            <div class="ubicacion-info animate-left">
                <h3><i class="fas fa-map-marker-alt" style="color: #ff6b35;"></i> Dirección</h3>
                <div class="direccion-item">
                    <span>📍</span>
                    <div>
                        <strong>Av. Central Poniente 123</strong><br>
                        Centro Histórico<br>
                        Tuxtla Gutiérrez, Chiapas<br>
                        C.P. 29000
                    </div>
                </div>
                <div class="direccion-item">
                    <span>📞</span>
                    <div><strong>Teléfono:</strong> (961) 123 4567</div>
                </div>
                <div class="direccion-item">
                    <span>✉️</span>
                    <div><strong>Email:</strong> contacto@radiopakal.mx</div>
                </div>
                <div class="direccion-item">
                    <span>⏰</span>
                    <div><strong>Horario:</strong> Lunes a Viernes 9:00 - 18:00</div>
                </div>
            </div>
            <div class="mapa animate-right">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d122101.986561664!2d-93.164374!3d16.752966!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85ecd8b0a3b6322d%3A0x6b8e3e8a6f3b2e4b!2sTuxtla%20Guti%C3%A9rrez%2C%20Chis.!5e0!3m2!1ses!2smx!4v1700000000000!5m2!1ses!2smx" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </section>

    <!-- PROGRAMACIÓN -->
    <section id="programacion" class="section">
        <div class="section-header animate-up">
            <div class="section-icon">📅</div>
            <h2>Programación</h2>
            <p>Nuestros horarios y programas</p>
        </div>
        <div class="programacion-grid">
            <div class="programa-card animate-up">
                <div class="programa-hora">06:00 - 08:00 AM</div>
                <div class="programa-info">
                    <h3>Los Caminos del Sureste</h3>
                    <p><i class="fas fa-microphone-alt"></i> Carlos Méndez - Música y tradición chiapaneca</p>
                </div>
            </div>
            <div class="programa-card animate-up" style="animation-delay: 0.1s">
                <div class="programa-hora">08:00 - 10:00 AM</div>
                <div class="programa-info">
                    <h3>Noticiero Pakal</h3>
                    <p><i class="fas fa-newspaper"></i> Equipo Informativo - Información regional y nacional</p>
                </div>
            </div>
            <div class="programa-card animate-up" style="animation-delay: 0.2s">
                <div class="programa-hora">10:00 - 12:00 PM</div>
                <div class="programa-info">
                    <h3>Raíces Vivas</h3>
                    <p><i class="fas fa-leaf"></i> Laura Fuentes - Cultura y pueblos originarios</p>
                </div>
            </div>
            <div class="programa-card animate-up" style="animation-delay: 0.3s">
                <div class="programa-hora">12:00 - 02:00 PM</div>
                <div class="programa-info">
                    <h3>Voces de Chiapas</h3>
                    <p><i class="fas fa-users"></i> Javier Ruiz - Entrevistas y participación ciudadana</p>
                </div>
            </div>
            <div class="programa-card