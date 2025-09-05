<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2 class="mb-4">Lista de Usuarios</h2>

    <?php
    $mensaje = $_SESSION['mensaje'] ?? null;
    $tipo = $_SESSION['mensaje_tipo'] ?? 'exito';
    unset($_SESSION['mensaje'], $_SESSION['mensaje_tipo']);
    ?>

    <?php if ($mensaje): ?>
        <div class="alert <?= $tipo === 'error' ? 'alert-danger' : 'alert-success' ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($mensaje) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Barra de búsqueda -->
    <div class="mb-3">
        <input type="text" id="buscarUsuario" class="form-control" placeholder="Buscar usuario por nombre, email o rol...">
    </div>

    <!-- Tabla vacía, se llenará dinámicamente -->
    <table class="table table-striped table-bordered align-middle d-none" id="tablaUsuarios">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <!-- Se llenará con JS -->
        </tbody>
    </table>

    <div class="mt-3">
        <a href="index.php?controller=admin&action=crearUsuario" class="btn btn-success me-2">Crear nuevo usuario</a>
        <a href="index.php?controller=admin&action=dashboard" class="btn btn-secondary">Volver al panel</a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const input = document.getElementById('buscarUsuario');
    const tabla = document.getElementById('tablaUsuarios');
    const tbody = tabla.getElementsByTagName('tbody')[0];

    // Datos de usuarios desde PHP
    const usuarios = <?php echo json_encode($usuarios); ?>;

    input.addEventListener('keyup', function() {
        const filtro = input.value.toLowerCase();

        // Limpiar tabla
        tbody.innerHTML = '';

        if (filtro.trim() === '') {
            tabla.classList.add('d-none');
            return;
        }

        // Filtrar usuarios
        const filtrados = usuarios.filter(u => 
            u.nombre.toLowerCase().includes(filtro) ||
            u.email.toLowerCase().includes(filtro) ||
            u.rol_id.toString().includes(filtro)
        );

        if (filtrados.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center">No se encontraron usuarios</td></tr>';
        } else {
            filtrados.forEach(u => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${u.id}</td>
                    <td>${u.nombre}</td>
                    <td>${u.email}</td>
                    <td>${u.rol_id}</td>
                    <td>${u.estado}</td>
                    <td>
                        <a href="index.php?controller=admin&action=editarUsuario&id=${u.id}" class="btn btn-sm btn-primary me-1 mb-1">Editar</a>
                        <a href="index.php?controller=admin&action=eliminarUsuario&id=${u.id}" 
                           onclick="return confirm('¿Seguro que quieres eliminar este usuario?')" 
                           class="btn btn-sm btn-danger mb-1">Eliminar</a>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        tabla.classList.remove('d-none');
    });
</script>

</body>
</html>
