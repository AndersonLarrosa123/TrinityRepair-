<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Trinity Repair - Cliente</title>
  <link rel="icon" href="public/css/img/logo_trinity.jpg" type="image/jpeg">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="public/css/cliente_dashboard.css">
</head>
<body>

<!-- Splash Screen -->
<div id="splash">
  <img src="public/css/img/logo_trinity.jpg" alt="Logo Trinity">
  <h1>Trinity Repair</h1>
</div>

<!-- Navbar -->
<nav class="navbar">
  <div class="logo-container">
    <img src="public/css/img/logo_trinity.jpg" alt="Logo Trinity" />
    <div class="logo-text">Trinity Repair</div>
  </div>
  <ul class="menu">
    <a href="#">Servicios</a>
    <a href="#">Chequeo</a>
    <a href="#">Consulta</a>
    <a href="#">Locales</a>
    <a href="#">Cursos</a>
    <a href="#">Clientes</a>
  </ul>
  <div style="display: flex; align-items: center; gap: 10px;">
    <a href="index.php?controller=cliente&action=logout" class="btn-llamanos">Cerrar sesión</a>
    <button class="theme-toggle" id="toggleTheme">🌙</button>
  </div>
</nav>

<!-- Video principal -->
<section class="hero">
  <div class="hero-video-container">
    <video autoplay muted loop playsinline>
      <source src="public/css/video/company1.mp4" type="video/mp4">
      Tu navegador no soporta el video.
    </video>
  </div>
</section>

<!-- Galería -->
<section>
  <h2>Galería de trabajos</h2>
  <div class="galeria">
    <img src="public/css/img/reparacion-cel1.jpg" alt="Trabajo 1">
    <img src="public/css/img/reparacionpcq11.jpg" alt="Trabajo 2">
    <img src="public/css/img/111.jpg" alt="Trabajo 3">
  </div>
</section>

<!-- Testimonios -->
<section class="testimonios">
  <h2>Lo que dicen nuestros clientes</h2>
  <blockquote>"Excelente servicio, mi celular quedó como nuevo. ¡Gracias Trinity Repair!" - Carla G.</blockquote>
  <blockquote>"Muy profesionales y rápidos. Me solucionaron un problema de software que nadie podía." - Mateo R.</blockquote>
  <blockquote>"Me encantó la atención, los recomiendo 100%." - Lucía D.</blockquote>
</section>

<!-- Mapa de ubicación -->
<section>
  <h2 style="margin-bottom: 20px;">Nuestra ubicación</h2>
  <iframe src="https://www.google.com/maps/embed?pb=!1m18..." allowfullscreen="" loading="lazy"></iframe>
</section>

<!-- Footer -->
<footer>
  <p>&copy; 2025 Trinity Repair - Todos los derechos reservados.</p>
  <p>Seguinos en: Facebook | Instagram | YouTube</p>
</footer>

<!-- JS externo -->
<script src="public/js/cliente_dashboard.js"></script>
</body>
</html>
