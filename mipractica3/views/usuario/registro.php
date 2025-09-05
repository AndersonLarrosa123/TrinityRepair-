<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Trinity Repair</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/estilos.css">
</head>
<body>

<div class="form-container">
    <img src="public/css/img/logo_trinity.jpg" alt="Logo Trinity">
    <h2>Crear cuenta</h2>

    <form action="index.php?controller=usuario&action=guardar" method="post">
        <div class="input-group">
            <i class="fas fa-user"></i>    
            <input type="text" name="nombre" placeholder="Nombre completo" required>
        </div>
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder="Correo electrónico" required>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Contraseña" required>
        </div>

        <input type="submit" value="Registrarse">
    </form>

    <div class="login-link">
        ¿Ya tenés cuenta? 
        <a href="index.php?controller=usuario&action=mostrarLogin">Iniciá sesión</a>
    </div>
</div>

</body>
</html>
