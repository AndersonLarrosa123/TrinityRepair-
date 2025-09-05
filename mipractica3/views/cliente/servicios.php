<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Servicios - Trinity Repair</title>
  <link rel="stylesheet" href="public/css/servicios.css?v=15.0">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- Font Awesome 6.6.0 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar">
    <div class="logo-container">
      <img src="public/css/img/logo_trinity.jpg" alt="Logo Trinity">
      <div class="logo-text">Trinity Repair</div>
    </div>
    <div class="menu">
      <a href="http://localhost/mipractica3/index.php"><i class="fa-solid fa-house"></i> Inicio</a>
      <a href="http://localhost/mipractica3/index.php?controller=cliente&action=servicios"><i class="fa-solid fa-screwdriver-wrench"></i> Arreglos 360°</a>
      <a href="index.php?controller=cliente&action=chequeo"><i class="fa-solid fa-mobile-screen-button"></i> Mi Reparación</a>
      <a href="http://localhost/mipractica3/index.php?controller=cliente&action=consulta"><i class="fa-solid fa-comments"></i> Tu Consulta Aquí</a>
      <a href="http://localhost/mipractica3/index.php?controller=cliente&action=locales"><i class="fa-solid fa-map-location-dot"></i> Visítanos</a>
      <a href="http://localhost/mipractica3/index.php?controller=cliente&action=clientes"><i class="fa-solid fa-users"></i> Confían en Nosotros</a>
    </div>
  </nav>

  <!-- Sección de servicios -->
  <section class="servicios-container">
    <h1 class="titulo-seccion"><i class="fa-solid fa-cogs"></i> NUESTROS SERVICIOS</h1>
    <p class="descripcion-seccion">
      Realizamos Reparación de celulares, cambio de pantallas, baterías y mucho más.
    </p>

    <div class="servicios-grid">
      <!-- Servicio 1 -->
      <div class="card-servicio">
        <i class="fa-solid fa-mobile-screen-button icono"></i>
        <h2>Cambio de Pantalla</h2>
        <hr>
        <p>Reemplazamos tu pantalla táctil display de todas las marcas.</p>
        <a href="https://wa.me/59891938769" class="btn-cotizar">
          <i class="fa-brands fa-whatsapp"></i> Solicitar Cotización
        </a>
      </div>

      <!-- Servicio 2 -->
      <div class="card-servicio">
        <i class="fa-solid fa-battery-half icono"></i>
        <h2>Cambio de Batería</h2>
        <hr>
        <p>Cambiamos la batería de tu dispositivo, cualquiera que sea.</p>
        <a href="https://wa.me/59891938769" class="btn-cotizar">
          <i class="fa-brands fa-whatsapp"></i> Solicitar Cotización
        </a>
      </div>

      <!-- Servicio 3 -->
      <div class="card-servicio">
        <i class="fa-solid fa-motorcycle icono"></i>
        <h2>Servicio de Delivery</h2>
        <hr>
        <p>Retiramos tu celular y lo entregamos en Montevideo.</p>
        <a href="https://wa.me/59891938769" class="btn-cotizar">
          <i class="fa-brands fa-whatsapp"></i> Solicitar Cotización
        </a>
      </div>
    </div>
  </section>
</body>
</html>
