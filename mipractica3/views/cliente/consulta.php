<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Procesar formulario
$mensajeEnviado = false;
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $email = htmlspecialchars(trim($_POST['email']));
    $modelo = htmlspecialchars(trim($_POST['modelo']));
    $asunto = htmlspecialchars(trim($_POST['asunto']));
    $mensaje = htmlspecialchars(trim($_POST['mensaje']));

    if($nombre && $email && $modelo && $asunto && $mensaje){
        $to = "tucorreo@dominio.com"; // Cambia por tu correo
        $subject = "Consulta desde la web: $asunto";
        $body = "Nombre: $nombre\nE-mail: $email\nModelo: $modelo\nMensaje:\n$mensaje";
        $headers = "From: $email";

        if(mail($to, $subject, $body, $headers)){
            $mensajeEnviado = true;
        } else {
            $error = "Error al enviar el mensaje. Intenta más tarde.";
        }
    } else {
        $error = "Por favor completa todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Consulta - Trinity Repair</title>
  <link rel="stylesheet" href="public/css/consulta.css">
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
      <a href="http://localhost/mipractica3/index.php"><i class="fa-solid fa-house"></i> Inicio</a>
      <a href="http://localhost/mipractica3/index.php?controller=cliente&action=servicios"><i class="fa-solid fa-screwdriver-wrench"></i> Arreglos 360°</a>
      <a href="index.php?controller=cliente&action=chequeo"><i class="fa-solid fa-magnifying-glass"></i> Mi Reparación</a>
      <a href="index.php?controller=cliente&action=consulta" class="active"><i class="fa-solid fa-comments"></i> Tu Consulta Aquí</a>
      <a href="http://localhost/mipractica3/index.php?controller=cliente&action=locales"><i class="fa-solid fa-map-location-dot"></i> Visítanos</a>
      <a href="http://localhost/mipractica3/index.php?controller=cliente&action=clientes"><i class="fa-solid fa-users"></i> Confían en Nosotros</a>
      <button class="theme-toggle"><i class="fa-solid fa-moon"></i></button>
    </div>
  </nav>

  <!-- Formulario contacto -->
  <main class="main-container">
    <div class="form-card">
      <h1>Contáctanos</h1>

      <?php if($mensajeEnviado): ?>
        <div class="resultado">¡Muchas gracias! Tu mensaje ha sido enviado con éxito.</div>
      <?php elseif($error): ?>
        <div class="resultado" style="color:#ff5555;"><?=$error?></div>
      <?php endif; ?>

      <form action="" method="post">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="text" name="modelo" placeholder="Modelo del Celular" required>
        <input type="text" name="asunto" placeholder="Asunto" required>
        <textarea name="mensaje" rows="5" placeholder="Tu mensaje" required></textarea>
        <button type="submit">ENVIAR EMAIL</button>
      </form>
    </div>
  </main>
</body>
</html>
