<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Trinity Repair</title>
    <link rel="stylesheet" href="public/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>
<body>

<div class="form-container">
    <img src="public/css/img/logo_trinity.jpg" alt="Logo" class="logo">


    <h2>Iniciar Sesión</h2>

    <form action="index.php?controller=usuario&action=procesarLogin" method="post">
        <div class="input-group">
            <i class="fa fa-envelope"></i>
            <input type="email" name="email" placeholder="Correo electrónico" required>
        </div>

        <div class="input-group">
            <i class="fa fa-lock"></i>
            <input type="password" name="password" placeholder="Contraseña" required>
        </div>

        <input type="submit" value="Entrar">
    </form>

    <div class="login-link">
        ¿No tenés cuenta? <a href="index.php?controller=usuario&action=registro">Registrate</a>
    </div>
</div>

</body>
</html>
