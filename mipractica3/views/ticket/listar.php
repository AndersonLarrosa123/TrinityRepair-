<?php include_once 'views/templates/header.php'; ?>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<?php
// Contar tickets por estado
$totalTickets = count($resultados);
$pendientes = count(array_filter($resultados, fn($t) => $t['estado'] === 'Pendiente'));
$enReparacion = count(array_filter($resultados, fn($t) => $t['estado'] === 'En Reparación'));
$finalizados = count(array_filter($resultados, fn($t) => $t['estado'] === 'Finalizado'));

// Calcular porcentajes para las barras
$pendientesPct = $totalTickets ? round(($pendientes / $totalTickets) * 100) : 0;
$enReparacionPct = $totalTickets ? round(($enReparacion / $totalTickets) * 100) : 0;
$finalizadosPct = $totalTickets ? round(($finalizados / $totalTickets) * 100) : 0;
?>

<div class="container mt-4">

    <!-- Resumen rápido -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h6 class="text-muted">Total Tickets</h6>
                    <h3 class="fw-bold"><?= $totalTickets ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Pendientes</h6>
                    <h4 class="fw-bold"><?= $pendientes ?></h4>
                    <div class="progress mt-2" style="height:8px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $pendientesPct ?>%;" aria-valuenow="<?= $pendientesPct ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">En Reparación</h6>
                    <h4 class="fw-bold"><?= $enReparacion ?></h4>
                    <div class="progress mt-2" style="height:8px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: <?= $enReparacionPct ?>%;" aria-valuenow="<?= $enReparacionPct ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Finalizados</h6>
                    <h4 class="fw-bold"><?= $finalizados ?></h4>
                    <div class="progress mt-2" style="height:8px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?= $finalizadosPct ?>%;" aria-valuenow="<?= $finalizadosPct ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Listado de Tickets -->
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-ticket-perforated"></i> Listado de Tickets</h5>
            <form method="GET" action="index.php" class="d-flex">
                <input type="hidden" name="controller" value="ticket">
                <input type="hidden" name="action" value="index">
                <input type="text" class="form-control form-control-sm me-2" name="buscar" placeholder="Buscar tickets..." value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>">
                <button class="btn btn-sm btn-light" type="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>

        <div class="card-body">

            <!-- Mensaje -->
            <?php if (!empty($mensaje)): ?>
                <div class="alert alert-success d-flex align-items-center mb-3">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?= htmlspecialchars($mensaje) ?>
                </div>
            <?php endif; ?>

            <!-- Tabla de tickets -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-success text-center">
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Categoría</th>
                            <th>Cliente</th>
                            <th>Admin</th>
                            <th>Técnico</th>
                            <th>Estado</th>
                            <th>Prioridad</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php if (!empty($resultados)): ?>
                            <?php foreach ($resultados as $t): ?>
                                <?php
                                $estado_badge = match($t['estado']) {
                                    'Pendiente' => 'bg-warning text-dark',
                                    'Diagnóstico' => 'bg-info text-dark',
                                    'Presupuesto' => 'bg-primary text-white',
                                    'En Reparación' => 'bg-secondary text-white',
                                    'Finalizado' => 'bg-success text-white',
                                    'Cancelado' => 'bg-danger text-white',
                                    default => 'bg-light text-dark',
                                };
                                $prioridad_badge = match($t['prioridad']) {
                                    'alta' => 'bg-danger text-white',
                                    'media' => 'bg-warning text-dark',
                                    'baja' => 'bg-info text-dark',
                                    'urgente' => 'bg-dark text-white',
                                    default => 'bg-secondary text-white',
                                };
                                ?>
                                <tr>
                                    <td><span class="badge bg-dark"><?= $t['id'] ?></span></td>
                                    <td class="fw-semibold"><?= htmlspecialchars($t['titulo']) ?></td>
                                    <td><?= htmlspecialchars($t['categoria_nombre'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($t['cliente_nombre'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($t['admin_nombre'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($t['tecnico_nombre'] ?? 'Sin asignar') ?></td>
                                    <td><span class="badge <?= $estado_badge ?> px-2"><?= $t['estado'] ?></span></td>
                                    <td><span class="badge <?= $prioridad_badge ?>"><?= ucfirst($t['prioridad']) ?></span></td>
                                    <td><?= date('d/m/Y H:i', strtotime($t['fecha_creacion'])) ?></td>
                                    <td class="d-flex flex-wrap gap-1 justify-content-center">
                                        <a class="btn btn-primary btn-sm" href="index.php?controller=ticket&action=ver&id=<?= $t['id'] ?>"><i class="bi bi-eye"></i></a>
                                        <a class="btn btn-warning btn-sm" href="index.php?controller=ticket&action=editar&id=<?= $t['id'] ?>"><i class="bi bi-pencil-square"></i></a>
                                        <?php if ($this->esAdmin()): ?>
                                            <a class="btn btn-danger btn-sm" href="index.php?controller=ticket&action=eliminar&id=<?= $t['id'] ?>" onclick="return confirm('¿Eliminar este ticket?');"><i class="bi bi-trash"></i></a>
                                            <a class="btn btn-info btn-sm text-white" href="index.php?controller=ticket&action=asignar&id=<?= $t['id'] ?>"><i class="bi bi-person-gear"></i></a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="text-center text-muted"><i class="bi bi-inbox"></i> No hay tickets disponibles.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Botón volver -->
            <div class="mt-3 text-end">
                <a href="index.php?controller=admin&action=dashboard" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left-circle"></i> Volver al Panel</a>
            </div>
        </div>
    </div>
</div>

<?php include_once 'views/templates/footer.php'; ?>
