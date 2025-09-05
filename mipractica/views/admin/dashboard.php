<?php include_once 'views/templates/header.php'; ?>

<h1>Panel de Administrador</h1>

<?php if (!empty($mensaje)): ?>
  <div class="alert alert-success"><?= htmlspecialchars($mensaje) ?></div>
<?php endif; ?>

<!-- Usuarios -->
<p><a href="index.php?controller=admin&action=listarUsuarios">Gestionar usuarios</a></p>
<p><a href="index.php?controller=admin&action=crearUsuario">Crear nuevo usuario</a></p>

<!-- Tickets -->
<h2>Gestión de Tickets</h2>
<p><a href="index.php?controller=ticket&action=index">Ver todos los tickets</a></p>
<p><a href="index.php?controller=ticket&action=crear">Crear nuevo ticket</a></p>

<form action="index.php?controller=admin&action=logout" method="post" style="margin-top:20px;">
  <button type="submit">Cerrar sesión</button>
</form>

<?php include_once 'views/templates/footer.php'; ?>
