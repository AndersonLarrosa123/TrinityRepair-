<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Visítanos - Trinity Repair</title>
  <link rel="stylesheet" href="public/css/local.css">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar">
    <div class="logo-container">
      <img src="public/css/img/logo_trinity.jpg" alt="Logo Trinity">
      <div class="logo-text">Trinity Repair</div>
    </div>
    <div class="menu">
      <a href="index.php"><i class="fa-solid fa-house"></i> Inicio</a>
      <a href="index.php?controller=cliente&action=servicios"><i class="fa-solid fa-screwdriver-wrench"></i> Arreglos 360°</a>
      <a href="index.php?controller=cliente&action=chequeo"><i class="fa-solid fa-magnifying-glass"></i> Mi Reparación</a>
      <a href="index.php?controller=cliente&action=consulta"><i class="fa-solid fa-comments"></i> Tu Consulta Aquí</a>
      <a href="index.php?controller=cliente&action=locales" class="active"><i class="fa-solid fa-map-location-dot"></i> Visítanos</a>
      <a href="index.php?controller=cliente&action=clientes"><i class="fa-solid fa-users"></i> Confían en Nosotros</a>
      <button class="theme-toggle"><i class="fa-solid fa-moon"></i></button>
    </div>
  </nav>

  <!-- Sección local -->
  <main class="main-container">
    <div class="local-card">
      <h1>Nuestro Local</h1>
      <p>¡Visítanos y deja tu dispositivo en manos expertas!<br>
      Dirección: Av. Principal 123, Ciudad, País<br>
      Horario: Lunes a Viernes 09:00 - 18:00</p>

      <!-- Carrusel de imágenes -->
      <div class="carousel-container">
        <div class="carousel-slide">
          <img src="./public/css/img/locall.png" alt="Local 1">
          <img src="./public/css/img/fachada_trinity1.png" alt="Local 2">
          <img src="./public/css/img/poradentro.png" alt="Local 3">
        </div>
        <button class="prev"><i class="fa-solid fa-chevron-left"></i></button>
        <button class="next"><i class="fa-solid fa-chevron-right"></i></button>
      </div>
    </div>
  </main>

  <footer>
    © <?=date("Y")?> Trinity Repair. Todos los derechos reservados.
  </footer>

  <!-- Script Carrusel Automático -->
  <script>
    const carouselSlide = document.querySelector('.carousel-slide');
    const images = document.querySelectorAll('.carousel-slide img');
    const prevBtn = document.querySelector('.prev');
    const nextBtn = document.querySelector('.next');
    let counter = 0;

    function updateCarousel() {
      const size = images[0].clientWidth;
      carouselSlide.style.transform = 'translateX(' + (-size * counter) + 'px)';
    }

    nextBtn.addEventListener('click', () => {
      counter = (counter + 1) % images.length;
      updateCarousel();
    });

    prevBtn.addEventListener('click', () => {
      counter = (counter - 1 + images.length) % images.length;
      updateCarousel();
    });

    setInterval(() => {
      counter = (counter + 1) % images.length;
      updateCarousel();
    }, 3000);

    window.addEventListener('resize', updateCarousel);
  </script>
</body>
</html>
