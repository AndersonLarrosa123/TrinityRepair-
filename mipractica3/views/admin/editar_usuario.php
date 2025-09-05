<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2 class="mb-4">Editar Usuario</h2>

    <form method="post" action="index.php?controller=admin&action=editarUsuario">
        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="rol_id" class="form-label">Rol:</label>
            <select class="form-select" id="rol_id" name="rol_id" required>
                <option value="1" <?= $usuario['rol_id'] == 1 ? 'selected' : '' ?>>Administrador</option>
                <option value="2" <?= $usuario['rol_id'] == 2 ? 'selected' : '' ?>>Técnico</option>
                <option value="3" <?= $usuario['rol_id'] == 3 ? 'selected' : '' ?>>Cliente</option>
                <option value="4" <?= $usuario['rol_id'] == 4 ? 'selected' : '' ?>>Supervisor</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado:</label>
            <select class="form-select" id="estado" name="estado" required>
                <option value="Activo" <?= $usuario['estado'] === 'Activo' ? 'selected' : '' ?>>Activo</option>
                <option value="Inactivo" <?= $usuario['estado'] === 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="index.php?controller=admin&action=listarUsuarios" class="btn btn-secondary ms-2">Volver al listado</a>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
