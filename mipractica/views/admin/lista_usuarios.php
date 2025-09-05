<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios</title>
</head>
<body>

<h2>Lista de Usuarios</h2>

<?php
// No necesitamos session_start() aquí porque ya se inició en index.php
$mensaje = $_SESSION['mensaje'] ?? null;
$tipo = $_SESSION['mensaje_tipo'] ?? 'exito'; // por defecto éxito
unset($_SESSION['mensaje'], $_SESSION['mensaje_tipo']);
?>

<?php if ($mensaje): ?>
    <div style="padding:10px; margin-bottom:10px; border-radius:5px; 
                <?php
                    if ($tipo === 'error') {
                        echo 'background:#f8d7da; color:#721c24; border:1px solid #f5c6cb;';
                    } else {
                        echo 'background:#d4edda; color:#155724; border:1px solid #c3e6cb;';
                    }
                ?>">
        <?= htmlspecialchars($mensaje) ?>
    </div>
<?php endif; ?>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Rol</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($usuarios as $u): ?>
    <tr>
        <td><?= $u['id'] ?></td>
        <td><?= htmlspecialchars($u['nombre']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td><?= htmlspecialchars($u['rol_id']) ?></td>
        <td><?= $u['estado'] ?></td>
        <td>
            <a href="index.php?controller=admin&action=editarUsuario&id=<?= $u['id'] ?>">Editar</a> | 
            <a href="index.php?controller=admin&action=eliminarUsuario&id=<?= $u['id'] ?>" 
               onclick="return confirm('¿Seguro que quieres eliminar este usuario?')">Eliminar</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<p><a href="index.php?controller=admin&action=crearUsuario">Crear nuevo usuario</a></p>
<p><a href="index.php?controller=admin&action=dashboard">Volver al panel</a></p>

</body>
</html>
