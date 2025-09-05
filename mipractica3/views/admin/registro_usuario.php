<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario - Panel Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h2 class="mb-4 text-center">Crear Usuario (Admin)</h2>

            <?php if (!empty($mensaje_exito)): ?>
                <div class="alert alert-success" role="alert">
                    <?= $mensaje_exito ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($mensaje_error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $mensaje_error ?>
                </div>
            <?php endif; ?>

            <form action="index.php?controller=admin&action=crearUsuario" method="post" class="card p-4 shadow-sm">
                <div class="mb-3">
                    <label class="form-label">Nombre:</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rol:</label>
                    <select name="rol_id" class="form-select" required>
                        <option value="1">Administrador</option>
                        <option value="2">Técnico</option>
                        <option value="3" selected>Cliente</option>
                        <option value="4">Supervisor</option>
                    </select>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Crear Usuario</button>
                </div>
            </form>

            <div class="mt-3 text-center">
                <a href="index.php?controller=admin&action=dashboard" class="btn btn-link">Volver al Panel Admin</a>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
