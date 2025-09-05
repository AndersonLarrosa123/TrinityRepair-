<?php include_once 'views/templates/header.php'; ?>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<div class="container mt-5">
    <h1 class="mb-4 text-primary"><i class="bi bi-speedometer2"></i> Panel Admin</h1>

    <?php if (!empty($mensaje)): ?>
        <div class="alert alert-success d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2"></i> <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>

    <div class="row g-4">

        <!-- Tarjeta Usuarios -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-people-fill display-4 text-primary mb-3"></i>
                    <h5 class="card-title">Usuarios</h5>
                    <p class="card-text">Gestiona tus usuarios y roles dentro del sistema.</p>
                    <a href="index.php?controller=admin&action=listarUsuarios" class="btn btn-outline-primary me-2 mb-2">
                        <i class="bi bi-eye-fill"></i> Ver Usuarios
                    </a>
                    <a href="index.php?controller=admin&action=crearUsuario" class="btn btn-primary mb-2">
                        <i class="bi bi-person-plus-fill"></i> Crear Usuario
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjeta Tickets -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-ticket-perforated-fill display-4 text-success mb-3"></i>
                    <h5 class="card-title">Tickets</h5>
                    <p class="card-text">Gestiona todos los tickets y su progreso en reparación.</p>
                    <a href="index.php?controller=ticket&action=index" class="btn btn-outline-success me-2 mb-2">
                        <i class="bi bi-eye-fill"></i> Ver Tickets
                    </a>
                    <a href="index.php?controller=ticket&action=crear" class="btn btn-success mb-2">
                        <i class="bi bi-plus-circle-fill"></i> Crear Ticket
                    </a>
                    <a href="index.php?controller=admin&action=continuarReparacionPanel" class="btn btn-warning mb-2">
                        <i class="bi bi-check2-circle"></i> Tickets Aprobados
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjeta Consultas -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-chat-left-text-fill display-4 text-info mb-3"></i>
                    <h5 class="card-title">Consultas</h5>
                    <p class="card-text">Revisa los mensajes enviados por los clientes.</p>
                    <a href="index.php?controller=admin&action=verConsultas" class="btn btn-outline-info me-2 mb-2">
                        <i class="bi bi-eye-fill"></i> Ver Consultas
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjeta Cerrar sesión -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center">
                    <i class="bi bi-box-arrow-right display-4 text-danger mb-3"></i>
                    <h5 class="card-title">Salir</h5>
                    <p class="card-text">Cerrar sesión de manera segura.</p>
                    <form action="index.php?controller=admin&action=logout" method="post">
                        <button type="submit" class="btn btn-danger btn-lg">
                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php include_once 'views/templates/footer.php'; ?>
