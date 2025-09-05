<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario - Panel Admin</title>
</head>
<body>

<h2>Crear Usuario (Admin)</h2>
<form action="index.php?controller=usuario&action=guardar" method="post">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Contraseña:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Rol:</label><br>
    <select name="rol_id" required>
        <option value="1">Administrador</option>
        <option value="2">Técnico</option>
        <option value="3" selected>Cliente</option>
        <option value="4">Supervisor</option>
    </select><br><br>

    <button type="submit">Crear Usuario</button>
</form>

<p><a href="index.php?controller=admin&action=dashboard">Volver al Panel Admin</a></p>

</body>
</html>
