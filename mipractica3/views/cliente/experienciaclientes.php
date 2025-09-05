<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Experiencia de Nuestros Clientes - Trinity Repair</title>
  <link rel="stylesheet" href="public/css/experienciaclientes.css?v=2.0">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
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
      <a href="http://localhost/mipractica3/index.php">Inicio</a>
      <a href="http://localhost/mipractica3/index.php?controller=cliente&action=servicios">Arreglos 360°</a>
      <a href="index.php?controller=cliente&action=chequeo">Mi Reparación</a>
      <a href="http://localhost/mipractica3/index.php?controller=cliente&action=consulta">Tu Consulta Aquí</a>
      <a href="http://localhost/mipractica3/index.php?controller=cliente&action=locales">Visítanos</a>
      <a href="http://localhost/mipractica3/index.php?controller=cliente&action=clientes">Confían en Nosotros</a>
      <button class="theme-toggle">🌙</button>
    </div>
  </nav>

  <!-- Sección Clientes -->
  <section class="clientes-container">
    <h1 class="titulo-seccion">Confían en Nosotros</h1>
    <p class="descripcion-seccion">
      Conoce lo que opinan quienes confiaron en Trinity Repair para reparar sus celulares.
    </p>

    <!-- Carrusel -->
    <div class="slider">
      <div class="slide-track">
        <!-- Cliente 1 -->
        <div class="card-cliente">
          <img src="public/img/cliente1.jpg" alt="Cliente 1" class="cliente-img">
          <h2>María Fernández</h2>
          <p class="opinion">“Me cambiaron la pantalla en el mismo día, ¡quedó como nueva! Muy recomendados.”</p>
          <div class="estrellas">★★★★★</div>
        </div>
        <!-- Cliente 2 -->
        <div class="card-cliente">
          <img src="public/img/cliente2.jpg" alt="Cliente 2" class="cliente-img">
          <h2>Carlos Gómez</h2>
          <p class="opinion">“Excelente atención y el celular funciona perfecto. Además muy buen precio.”</p>
          <div class="estrellas">★★★★☆</div>
        </div>
        <!-- Cliente 3 -->
        <div class="card-cliente">
          <img src="public/img/cliente3.jpg" alt="Cliente 3" class="cliente-img">
          <h2>Lucía Rodríguez</h2>
          <p class="opinion">“Rápidos, confiables y amables. Ahora siempre recomiendo Trinity Repair.”</p>
          <div class="estrellas">★★★★★</div>
        </div>
        <!-- Cliente 4 -->
        <div class="card-cliente">
          <img src="public/img/cliente4.jpg" alt="Cliente 4" class="cliente-img">
          <h2>Diego López</h2>
          <p class="opinion">“Tenía la batería hinchada, me la cambiaron enseguida y todo quedó perfecto.”</p>
          <div class="estrellas">★★★★★</div>
        </div>
        <!-- Cliente 5 -->
        <div class="card-cliente">
          <img src="public/img/cliente5.jpg" alt="Cliente 5" class="cliente-img">
          <h2>Fernanda Silva</h2>
          <p class="opinion">“Buen servicio, confiable y muy atentos. ¡Mi celular quedó como nuevo!”</p>
          <div class="estrellas">★★★★☆</div>
        </div>
        <!-- Cliente 6 -->
        <div class="card-cliente">
          <img src="public/img/cliente6.jpg" alt="Cliente 6" class="cliente-img">
          <h2>Martín Pereira</h2>
          <p class="opinion">“Me salvaron, necesitaba mi celular urgente y lo entregaron en tiempo récord.”</p>
          <div class="estrellas">★★★★★</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <p>© 2025 Trinity Repair - Todos los derechos reservados.</p>
  </footer>
</body>
</html>
