<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radio Pakal 1040 AM | La Voz del Sureste</title>
    <style>
        :root {
            --primary: #0f4c3a; /* Verde Selva Maya */
            --secondary: #1d7a5c;
            --accent: #d4ac0d; /* Oro Maya / Naranja Cálido */
            --dark: #111a16;
            --light: #f4f7f5;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--light);
            color: #2c3e50;
            scroll-behavior: smooth;
        }

        /* ==================== VISTA PÚBLICA ==================== */
        .public-view {
            max-width: 100%;
            margin: 0 auto;
            background: white;
        }

        header {
            background: var(--primary);
            color: white;
            padding: 1.2rem 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.6rem;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .logo span {
            background: var(--accent);
            color: var(--dark);
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 0.9rem;
            font-weight: 800;
        }

        nav ul {
            display: flex;
            gap: 1.8rem;
            list-style: none;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        nav a:hover {
            color: var(--accent);
        }

        /* Hero / Banner */
        .hero {
            background: linear-gradient(rgba(15, 76, 58, 0.7), rgba(17, 26, 22, 0.85)), url('https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            height: 480px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            padding: 0 1rem;
        }

        .hero-content h1 {
            font-size: 3.2rem;
            margin-bottom: 0.8rem;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
        }

        .hero-content p {
            font-size: 1.4rem;
            margin-bottom: 2rem;
            font-style: italic;
            color: #e0f2f1;
        }

        .btn-vivo {
            background: var(--accent);
            color: var(--dark);
            border: none;
            padding: 1.1rem 2.5rem;
            font-size: 1.2rem;
            border-radius: 50px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s ease;
            box-shadow: 0 4px 20px rgba(212, 172, 13, 0.4);
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-vivo:hover {
            transform: scale(1.05);
            background: #f1c40f;
            box-shadow: 0 6px 25px rgba(212, 172, 13, 0.6);
        }

        /* Contenedores y Secciones */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 4rem 2rem;
        }

        section {
            margin-bottom: 5rem;
        }

        h2 {
            font-size: 2.2rem;
            margin-bottom: 2rem;
            color: var(--primary);
            border-left: 6px solid var(--accent);
            padding-left: 1rem;
        }

        /* Tabla de Programación */
        .table-responsive {
            overflow-x: auto;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            min-width: 600px;
        }

        th, td {
            padding: 1.2rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background: var(--primary);
            color: white;
            font-weight: 600;
        }

        tr:hover {
            background: #f1f8f5;
        }

        /* Grid de Noticias */
        .noticias-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
        }

        .noticia-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: 0.3s;
            border: 1px solid #eaf2ee;
        }

        .noticia-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.12);
        }

        .noticia-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .noticia-card h3 {
            padding: 1.2rem 1.2rem 0.5rem;
            color: var(--primary);
            font-size: 1.3rem;
        }

        .noticia-card p {
            padding: 0 1.2rem 1.5rem;
            color: #666;
            line-height: 1.5;
        }

        /* Simulación de Facebook */
        .facebook-feed {
            background: #ffffff;
            padding: 2.5rem;
            border-radius: 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            border: 1px solid #e1e8ed;
        }

        .fb-frame {
            background: #f0f2f5;
            padding: 2rem;
            border-radius: 16px;
            margin-bottom: 1.5rem;
        }

        .fb-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1rem;
        }

        .fb-avatar {
            width: 45px;
            height: 45px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .fb-post-text {
            font-size: 1.1rem;
            margin-bottom: 1rem;
            color: #1c1e21;
        }

        .fb-interacciones {
            display: flex;
            gap: 1rem;
            border-top: 1px solid #ced4da;
            border-bottom: 1px solid #ced4da;
            padding: 0.6rem 0;
            margin-top: 1rem;
        }

        .fb-btn {
            background: transparent;
            color: #65676b;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: 0.2s;
        }

        .fb-btn:hover {
            background: rgba(0,0,0,0.05);
        }

        .fb-btn.liked {
            color: #1877f2;
        }

        .fb-comments-section {
            margin-top: 1rem;
            max-height: 200px;
            overflow-y: auto;
        }

        .comment-item {
            background: #e4e6eb;
            padding: 8px 12px;
            border-radius: 12px;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        /* Formulario de Contacto */
        .contacto-form {
            background: white;
            padding: 3rem;
            border-radius: 24px;
            box-shadow: 0 4px 25px rgba(0,0,0,0.06);
            border: 1px solid #eaf2ee;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        input, textarea, select {
            width: 100%;
            padding: 1rem;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-family: inherit;
            font-size: 1rem;
            outline: none;
            transition: 0.3s;
        }

        input:focus, textarea:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(29, 122, 92, 0.15);
        }

        button[type="submit"] {
            background: var(--primary);
            color: white;
            padding: 1rem 2.5rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1rem;
            transition: 0.3s;
        }

        button[type="submit"]:hover {
            background: var(--secondary);
        }

        .contacto-iconos {
            margin-top: 2.5rem;
            display: flex;
            gap: 2rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .icono {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: var(--primary);
            font-weight: bold;
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            background: #f0f7f4;
            transition: 0.3s;
        }

        .icono:hover {
            background: var(--primary);
            color: white;
        }

        footer {
            background: var(--dark);
            color: #a0aec0;
            text-align: center;
            padding: 3rem 2rem;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 2.5rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            transition: 0.3s;
        }

        .footer-links a:hover {
            color: var(--accent);
        }

        /* Separador de Administración */
        .separator {
            text-align: center;
            padding: 3rem 1rem;
            background: #1a202c;
            color: #edf2f7;
            font-size: 1.2rem;
            font-weight: bold;
            letter-spacing: 2px;
            border-top: 4px dashed var(--accent);
        }

        /* ==================== PANEL DE CONTROL (ADMIN) ==================== */
        .admin-panel {
            max-width: 1300px;
            margin: 4rem auto;
            background: #0f172a;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.25);
            color: #e2e8f0;
        }

        .admin-header {
            background: #1e293b;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            border-bottom: 1px solid #334155;
        }

        .admin-content {
            padding: 2.5rem;
        }

        .badge {
            background: #334155;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            border: 1px solid #475569;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: #1e293b;
            padding: 1.5rem;
            border-radius: 16px;
            text-align: center;
            border: 1px solid #334155;
        }

        .stat-card strong {
            font-size: 2rem;
            color: var(--accent);
            display: block;
            margin: 0.5rem 0;
        }

        .admin-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .admin-form-box {
            background: #1e293b;
            padding: 2rem;
            border-radius: 16px;
            border: 1px solid #334155;
        }

        .admin-form-box h3 {
            margin-bottom: 1.5rem;
            color: white;
            border-bottom: 2px solid #334155;
            padding-bottom: 0.5rem;
        }

        .admin-form-box input, .admin-form-box textarea, .admin-form-box select {
            background: #0f172a;
            color: white;
            border: 1px solid #475569;
            margin-bottom: 1rem;
        }

        .admin-table-box {
            background: #1e293b;
            padding: 2rem;
            border-radius: 16px;
            border: 1px solid #334155;
            margin-bottom: 2rem;
            overflow-x: auto;
        }

        .admin-table-box h3 {
            margin-bottom: 1.5rem;
            color: white;
        }

        .admin-table {
            width: 100%;
            background: #0f172a;
            border-radius: 10px;
            overflow: hidden;
        }

        .admin-table th {
            background: #334155;
            color: white;
        }

        .admin-table td {
            border-bottom: 1px solid #1e293b;
            color: #cbd5e1;
        }

        .btn-action {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            margin-right: 5px;
        }

        /* Responsive general */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 1.2rem;
            }
            nav ul {
                gap: 1rem;
                flex-wrap: wrap;
                justify-content: center;
            }
            .hero-content h1 {
                font-size: 2.2rem;
            }
            .admin-grid {
                grid-template-columns: 1fr;
            }
            .contacto-form {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <!-- ============================================ -->
    <!-- ============ VISTA PÚBLICA DE LA WEB ============ -->
    <!-- ============================================ -->
    <div class="public-view">
        <header>
            <div class="header-container">
                <div class="logo">
                    📻 RADIO PAKAL <span>1040 AM</span>
                </div>
                <nav>
                    <ul>
                        <li><a href="#inicio">Inicio</a></li>
                        <li><a href="#programacion">Programación</a></li>
                        <li><a href="#noticias">Noticias</a></li>
                        <li><a href="#contacto">Contacto</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Banner Principal -->
        <section id="inicio">
            <div class="hero">
                <div class="hero-content">
                    <h1>La Voz del Sureste, Conectada Contigo</h1>
                    <p>Transmitiendo la cultura, magia e información desde Palenque, Chiapas</p>
                    <button class="btn-vivo" id="btnPlay">
                        <span id="playIcon">▶️</span> <span id="playText">ESCUCHAR EN VIVO</span>
                    </button>
                    <!-- Reproductor nativo oculto / simulado -->
                    <audio id="audioRadio" src="https://stream.zeno.fm/f9780g7wewzuv" preload="none"></audio>
                </div>
            </div>
        </section>

        <div class="container">
            <!-- Sección Programación -->
            <section id="programacion">
                <h2>📅 Nuestra Programación</h2>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Horario</th>
                                <th>Programa de Hoy</th>
                                <th>Locución</th>
                            </tr>
                        </thead>
                        <tbody id="publicSchedule">
                            <tr>
                                <td>06:00 - 08:00 AM</td>
                                <td><strong>Los Caminos del Sureste</strong></td>
                                <td>Carlos Méndez</td>
                            </tr>
                            <tr>
                                <td>08:00 - 10:00 AM</td>
                                <td><strong>Noticiero Chiapas al Día</strong></td>
                                <td>Equipo Informativo Pakal</td>
                            </tr>
                            <tr>
                                <td>10:00 - 12:00 PM</td>
                                <td><strong>Raíces Vivas (Cultura Maya)</strong></td>
                                <td>Laura Fuentes</td>
                            </tr>
                            <tr>
                                <td>12:00 - 02:00 PM</td>
                                <td><strong>Voces de Nuestra Tierra</strong></td>
                                <td>Javier Ruiz</td>
                            </tr>
                            <tr>
                                <td>02:00 - 04:00 PM</td>
                                <td><strong>Marimba y Tradición</strong></td>
                                <td>Mariana Paz</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Sección Noticias -->
            <section id="noticias">
                <h2>📰 Últimas Noticias de la Región</h2>
                <div class="noticias-grid" id="publicNews">
                    <div class="noticia-card">
                        <img class="noticia-img" src="https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Festival Palenque">
                        <h3>🎤 Festival Cultural Pakal 2026</h3>
                        <p>Arrancan los preparativos para el magno evento folclórico que reunirá a artistas de todo el estado de Chiapas.</p>
                    </div>
                    <div class="noticia-card">
                        <img class="noticia-img" src="https://images.unsplash.com/photo-1590602847861-f357a9332bbc?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Cabina Radio">
                        <h3>📻 Radio Pakal moderniza su señal</h3>
                        <p>Mejoramos nuestros transmisores para ofrecerte una mayor cobertura en la frecuencia 1040 AM y audio HD online.</p>
                    </div>
                    <div class="noticia-card">
                        <img class="noticia-img" src="https://images.unsplash.com/photo-1544644181-1484b3fdfc62?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Premio periodismo">
                        <h3>🏆 Nominados a la Excelencia Radial</h3>
                        <p>Nuestra cobertura comunitaria del sureste mexicano ha sido nominada al galardón nacional de periodismo social.</p>
                    </div>
                </div>
            </section>

            <!-- Redes Sociales Interactivas -->
            <section>
                <h2>📱 Interacción en Facebook</h2>
                <div class="facebook-feed">
                    <div class="fb-frame">
                        <div class="fb-header">
                            <div class="fb-avatar">RP</div>
                            <div>
                                <strong>Radio Pakal 1040 AM Oficial</strong><br>
                                <small style="color: #65676b;">Hace 2 horas · Público 🌐</small>
                            </div>
                        </div>
                        <div class="fb-post-text">
                            🎉 ¡Sorteo Especial de Aniversario! Comenta aquí abajo cuál es tu programa favorito de la 1040 AM y participa por un receptor de radio digital de alta fidelidad. ¡Suerte a todos en Palenque y alrededores! 📻🎁
                        </div>
                        <div class="fb-interacciones">
                            <button class="fb-btn" id="fbLikeBtn">👍 Me gusta (<span id="likeCount">142</span>)</button>
                            <button class="fb-btn" onclick="document.getElementById('fbNewComment').focus()">💬 Comentar</button>
                        </div>
                        <div class="fb-comments-section" id="fbCommentsContainer">
                            <div class="comment-item"><strong>Manuel Mendoza:</strong> ¡Excelente! No me pierdo "Los Caminos del Sureste" todas las mañanas mientras voy al campo.</div>
                            <div class="comment-item"><strong>Ximena Cruz:</strong> Participo. Saludos a la conductora Mariana Paz de "Marimba y Tradición".</div>
                        </div>
                        <div style="display: flex; gap: 10px; margin-top: 1rem;">
                            <input type="text" id="fbNewComment" placeholder="Escribe un comentario público...">
                            <button onclick="addFbComment()" style="background: #1877f2; color: white; border: none; padding: 0 1rem; border-radius: 8px; cursor: pointer; font-weight: bold;">Publicar</button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sección Contacto -->
            <section id="contacto">
                <h2>✉️ Cabina y Sugerencias</h2>
                <div class="contacto-form">
                    <form id="mainContactForm" onsubmit="handleContactSubmit(event)">
                        <div class="form-group">
                            <input type="text" id="contactName" placeholder="Tu nombre completo" required>
                        </div>
                        <div class="form-group">
                            <input type="email" id="contactEmail" placeholder="Tu correo electrónico" required>
                        </div>
                        <div class="form-group">
                            <textarea id="contactMessage" rows="4" placeholder="Escribe tu saludo, denuncia o pide tu canción favorita aquí..." required></textarea>
                        </div>
                        <button type="submit">📨 Enviar a Cabina</button>
                    </form>
                    <div class="contacto-iconos">
                        <a href="tel:9161234567" class="icono">📞 Tel. Cabina: (916) 123 4567</a>
                        <a href="https://wa.me/529161234567?text=Hola%20Radio%20Pakal" target="_blank" class="icono">💬 WhatsApp Cabina</a>
                        <a href="#" class="icono">📷 Instagram</a>
                        <a href="#" class="icono">📘 Facebook</a>
                    </div>
                </div>
            </section>
        </div>

        <footer>
            <div class="footer-links">
                <a href="#inicio">Inicio</a>
                <a href="#programacion">Programación</a>
                <a href="#noticias">Noticias</a>
                <a href="#contacto">Contacto</a>
            </div>
            <p>📍 Dirección Corporativa: Av. Juárez No. 45, Col. Centro, Palenque, Chiapas, México</p>
            <p style="margin-top: 0.5rem;">&copy; 2026 Radio Pakal 1040 AM - Todos los derechos reservados.</p>
        </footer>
    </div>


    <!-- ========================================================= -->
    <!-- ============ ACCESO AL PANEL DE ADMINISTRACIÓN ============ -->
    <!-- ========================================================= -->
    <div class="separator">
        🔐 PANEL INTERNO DE CONTROL Y GESTIÓN RADIAL
    </div>

    <div class="admin-panel">
        <div class="admin-header">
            <h2>⚙️ CONTROL DE ESTACIÓN - RADIO PAKAL</h2>
            <div>
                <span class="badge" style="color: #58d68d;">● Servidor Online</span>
                <span class="badge">Usuario: admin_pakal@radio.mx</span>
            </div>
        </div>

        <div class="admin-content">
            <!-- Tarjetas de Métricas -->
            <div class="stats">
                <div class="stat-card">🎧 <br> <strong>1,482</strong> Oyentes Online</div>
                <div class="stat-card">✉️ <br> <strong id="adminMessageCount">3</strong> Mensajes en Cabina</div>
                <div class="stat-card">📰 <br> <strong>12</strong> Noticias Activas</div>
                <div class="stat-card">📈 <br> <strong>98.7%</strong> Estabilidad Streaming</div>
            </div>

            <!-- Formularios Dinámicos de Gestión -->
            <div class="admin-grid">
                <!-- Modificar Programación -->
                <div class="admin-form-box">
                    <h3>✏️ Modificar Programa Actual</h3>
                    <form onsubmit="updateSchedule(event)">
                        <label style="font-size: 0.85rem; color: #94a3b8;">Selecciona horario a editar:</label>
                        <select id="adminSchedIndex">
                            <option value="0">06:00 - 08:00 AM (Los Caminos del Sureste)</option>
                            <option value="1">08:00 - 10:00 AM (Noticiero Chiapas)</option>
                            <option value="2">10:00 - 12:00 PM (Raíces Vivas)</option>
                        </select>
                        <input type="text" id="adminProgName" placeholder="Nuevo nombre del programa" required>
                        <input type="text" id="adminLocutor" placeholder="Nombre del Locutor(a)" required>
                        <button type="submit" style="background: #27ae60; color: white; border: none; padding: 0.8rem 1.5rem; border-radius: 8px; cursor: pointer; width: 100%; font-weight: bold;">💾 Aplicar Cambios en Web</button>
                    </form>
                </div>

                <!-- Agregar Noticia -->
                <div class="admin-form-box">
                    <h3>📢 Publicar Alerta o Noticia Breve</h3>
                    <form onsubmit="addNews(event)">
                        <input type="text" id="adminNewsTitle" placeholder="Título impactante de la noticia" required>
                        <textarea id="adminNewsBody" rows="2" placeholder="Resumen o cuerpo de la nota..." required></textarea>
                        <button type="submit" style="background: #2980b9; color: white; border: none; padding: 0.8rem 1.5rem; border-radius: 8px; cursor: pointer; width: 100%; font-weight: bold;">🚀 Lanzar Noticia a la Web</button>
                    </form>
                </div>
            </div>

            <!-- Tabla de Mensajes Recibidos en Vivo -->
            <div class="admin-table-box">
                <h3>📥 Monitor de Mensajes de la Audiencia (Entrantes)</h3>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="padding: 10px;">Remitente</th>
                            <th style="padding: 10px;">Correo</th>
                            <th style="padding: 10px;">Petición / Mensaje</th>
                            <th style="padding: 10px;">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="adminMessagesTable">
                        <tr>
                            <td style="padding: 12px;">Juan Arcos</td>
                            <td style="padding: 12px;">juan.p@gmail.com</td>
                            <td style="padding: 12px;">Pidan un saludo para la familia Arcos en el barrio San Juan.</td>
                            <td style="padding: 12px;"><button class="btn-action" style="background: #e67e22; color:white;" onclick="alert('Enviado a monitor de locutor')">📣 Enviar a Cabina</button></td>
                        </tr>
                        <tr>
                            <td style="padding: 12px;">Dora María</td>
                            <td style="padding: 12px;">dora_m@outlook.com</td>
                            <td style="padding: 12px;">Me fascina el programa de cultura maya, muy educativo.</td>
                            <td style="padding: 12px;"><button class="btn-action" style="background: #27ae60; color:white;" onclick="alert('Mensaje guardado para archivo')">📁 Archivar</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- ============ CÓDIGO INTERACTIVO JAVASCRIPT ============ -->
    <!-- ============================================ -->
    <script>
        // 1. REPRODUCTOR DE AUDIO REAL / SIMULADO
        const audio = document.getElementById('audioRadio');
        const btnPlay = document.getElementById('btnPlay');
        const playIcon = document.getElementById('playIcon');
        const playText = document.getElementById('playText');

        btnPlay.addEventListener('click', () => {
            if (audio.paused) {
                audio.play().then(() => {
                    playIcon.innerText = "⏹️";
                    playText.innerText = "DETENER TRANSMISIÓN";
                    btnPlay.style.background = "#c0392b";
                    btnPlay.style.color = "white";
                }).catch(err => {
                    // Si el link de stream falla o expira, simula el proceso de manera elegante
                    playIcon.innerText = "⏸️";
                    playText.innerText = "REPRODUCIENDO (Señal de Prueba)";
                    btnPlay.style.background = "#27ae60";
                    btnPlay.style.color = "white";
                });
            } else {
                audio.pause();
                resetPlayButton();
            }
        });

        function resetPlayButton() {
            playIcon.innerText = "▶️";
            playText.innerText = "ESCUCHAR EN VIVO";
            btnPlay.style.background = "var(--accent)";
            btnPlay.style.color = "var(--dark)";
        }

        // 2. INTERACCIÓN MOCK DE FACEBOOK (Likes y Comentarios dinámicos)
        let likes = 142;
        let isLiked = false;
        const fbLikeBtn = document.getElementById('fbLikeBtn');
        const likeCountEl = document.getElementById('likeCount');

        fbLikeBtn.addEventListener('click', () => {
            if(!isLiked) {
                likes++;
                fbLikeBtn.classList.add('liked');
                fbLikeBtn.innerHTML = "👍 ¡Te gusta! (" + likes + ")";
                isLiked = true;
            } else {
                likes--;
                fbLikeBtn.classList.remove('liked');
                fbLikeBtn.innerHTML = "👍 Me gusta (" + likes + ")";
                isLiked = false;
            }
        });

        function addFbComment() {
            const input = document.getElementById('fbNewComment');
            const container = document.getElementById('fbCommentsContainer');
            if(input.value.trim() !== "") {
                const comment = document.createElement('div');
                comment.className = 'comment-item';
                comment.innerHTML = `<strong>Visitante Anónimo:</strong> ${input.value}`;
                container.appendChild(comment);
                input.value = "";
                container.scrollTop = container.scrollHeight;
            }
        }

        // 3. ENTRADA DE FORMULARIO DE CONTACTO HACIA PANEL DE ADMINISTRACIÓN
        let messageCount = 2;
        function handleContactSubmit(e) {
            e.preventDefault();
            const name = document.getElementById('contactName').value;
            const email = document.getElementById('contactEmail').value;
            const msg = document.getElementById('contactMessage').value;

            // Añadir el mensaje dinámicamente a la tabla del panel de administración
            const tableBody = document.getElementById('adminMessagesTable');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td style="padding: 12px;">${name}</td>
                <td style="padding: 12px;">${email}</td>
                <td style="padding: 12px;">${msg}</td>
                <td style="padding: 12px;"><span style="color:#27ae60; font-weight:bold;">🆕 Recibido</span></td>
            `;
            tableBody.insertBefore(newRow, tableBody.firstChild);

            // Actualizar contador del panel
            messageCount++;
            document.getElementById('adminMessageCount').innerText = messageCount;

            alert('✅ ¡Mensaje enviado con éxito! Tu petición ya aparece en tiempo real en la pantalla del Panel de Administración inferior.');
            document.getElementById('mainContactForm').reset();
        }

        // 4. ACTUALIZAR PROGRAMACIÓN DESDE EL PANEL ADMIN HACIA LA WEB PÚBLICA
        function updateSchedule(e) {
            e.preventDefault();
            const index = document.getElementById('adminSchedIndex').value;
            const newName = document.getElementById('adminProgName').value;
            const newLocutor = document.getElementById('adminLocutor').value;

            const publicTableBody = document.getElementById('publicSchedule');
            const row = publicTableBody.rows[index];
            
            // Actualizar celdas correspondientes
            row.cells[1].innerHTML = `<strong>${newName}</strong>`;
            row.cells[2].innerText = newLocutor;

            alert('💾 ¡Cambios guardados! Revisa la sección "Nuestra Programación" arriba para ver la actualización.');
        }

        // 5. AGREGAR NUEVAS NOTICIAS DESDE PANEL ADMIN
        function addNews(e) {
            e.preventDefault();
            const title = document.getElementById('adminNewsTitle').value;
            const body = document.getElementById('adminNewsBody').value;

            const publicNewsContainer = document.getElementById('publicNews');
            const newCard = document.createElement('div');
            newCard.className = 'noticia-card';
            newCard.innerHTML = `
                <img class="noticia-img" src="https://images.unsplash.com/photo-1495020689067-958852a6565d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Noticia urgente">
                <h3>🚨 ${title}</h3>
                <p>${body}</p>
            `;
            // Insertar al inicio de las noticias
            publicNewsContainer.insertBefore(newCard, publicNewsContainer.firstChild);

            alert('🚀 ¡Noticia publicada con éxito! Ya se visualiza en la sección de Noticias arriba.');
            document.getElementById('adminNewsTitle').value = "";
            document.getElementById('adminNewsBody').value = "";
        }
    </script>
</body>
</html>