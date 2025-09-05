<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?> 

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Trinity Repair - Cliente</title>
  <link rel="icon" href="public/css/img/logo_trinity.jpg" type="image/jpeg">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="public/css/cliente_dashboard.css">
</head>
<body>

<!-- Splash -->
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
    <a href="index.php?controller=cliente&action=servicios">Arreglos 360°</a>
    <a href="index.php?controller=cliente&action=chequeo">Mi Reparación</a>
    <a href="index.php?controller=cliente&action=consulta">Tu Consulta Aquí</a>
    <a href="index.php?controller=cliente&action=locales">Visítanos</a>
    <a href="index.php?controller=cliente&action=clientes">Confían en Nosotros</a>
  </ul>

  <div style="display: flex; align-items: center; gap: 10px;">
    <?php if (isset($_SESSION['usuario_id'])): ?>
      <div class="mini-perfil">
        <button id="btnPerfil" class="btn-perfil">
          <i class="fa-solid fa-user"></i> <?= htmlspecialchars($_SESSION['usuario_nombre']); ?>
        </button>
        <div id="infoPerfil" class="info-perfil">
          <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['usuario_email'] ?? 'No disponible'); ?></p>
          <a href="index.php?controller=usuario&action=logout" class="btn-logout">Cerrar sesión</a>
        </div>
      </div>
    <?php else: ?>
      <a href="index.php?controller=usuario&action=mostrarLogin" class="btn-login">Iniciar sesión</a>
      <a href="index.php?controller=usuario&action=registro" class="btn-registro">Registrarse</a>
    <?php endif; ?>
  </div>
</nav>

<!-- Hero Video (vertical, centrado) -->
<section class="hero">
  <div class="hero-video-container">
    <video autoplay muted loop playsinline>
      <source src="public/css/video/company1.mp4" type="video/mp4">
      Tu navegador no soporta el video.
    </video>
  </div>

  <!-- Botón flotante debajo de Trinity Repair -->
  <a href="index.php?controller=cliente&action=chatTecnico" class="btn-chat-hero">
    <i class="fa-solid fa-comments"></i> Tu Chat con el Técnico
  </a>
</section>

<!-- Ubicación -->
<section>
  <h2 style="margin-bottom: 20px; text-align:center;">Nuestra ubicación</h2>
  <iframe src="https://www.google.com/maps/embed?pb=!1m18..." allowfullscreen="" loading="lazy"></iframe>
</section>

<!-- Footer -->
<footer>
  <p>&copy; 2025 Trinity Repair - Todos los derechos reservados.</p>
  <p>Seguinos en: Facebook | Instagram | YouTube</p>
</footer>

<script src="public/js/cliente_dashboard.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const btnPerfil = document.getElementById('btnPerfil');
  const infoPerfil = document.getElementById('infoPerfil');
  if (btnPerfil) {
    btnPerfil.addEventListener('click', (e) => {
      e.stopPropagation();
      infoPerfil.style.display = (infoPerfil.style.display === 'block') ? 'none' : 'block';
    });
    document.addEventListener('click', () => infoPerfil.style.display = 'none');
  }
});
</script>
</body>
</html>
