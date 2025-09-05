<?php include_once 'views/templates/header.php'; ?>

<div class="container mt-5">
    <div class="card shadow rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="bi bi-ticket-perforated"></i> Ticket #<?= $ticket['id'] ?></h3>
            <span class="badge 
                <?= match($ticket['estado']) {
                    'Pendiente' => 'bg-warning text-dark',
                    'Diagnóstico' => 'bg-info text-dark',
                    'Presupuesto' => 'bg-primary text-white',
                    'En Reparación' => 'bg-secondary text-white',
                    'Finalizado' => 'bg-success text-white',
                    'Cancelado' => 'bg-danger text-white',
                    default => 'bg-light text-dark',
                } ?> fs-6 px-3 py-1">
                <?= ucfirst($ticket['estado']) ?>
            </span>
        </div>

        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <h5 class="text-muted">Detalles del Ticket</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Título:</strong> <?= htmlspecialchars($ticket['titulo']) ?></li>
                        <li class="list-group-item"><strong>Descripción:</strong> <?= nl2br(htmlspecialchars($ticket['descripcion'])) ?></li>
                        <li class="list-group-item"><strong>Categoría:</strong> <?= htmlspecialchars($ticket['categoria_nombre'] ?? '-') ?></li>
                        <li class="list-group-item"><strong>Cliente:</strong> <?= htmlspecialchars($ticket['cliente_nombre'] ?? '-') ?></li>
                    </ul>
                </div>

                <div class="col-md-6">
                    <h5 class="text-muted">Información de Administración</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Admin:</strong> <?= htmlspecialchars($ticket['admin_nombre'] ?? '-') ?></li>
                        <li class="list-group-item"><strong>Técnico asignado:</strong> <?= htmlspecialchars($ticket['tecnico_nombre'] ?? 'Sin asignar') ?></li>
                        <li class="list-group-item"><strong>Prioridad:</strong> 
                            <span class="badge 
                                <?= $ticket['prioridad'] === 'alta' ? 'bg-danger' : 
                                   ($ticket['prioridad'] === 'media' ? 'bg-warning text-dark' : 'bg-info text-dark') ?> px-3 py-1">
                                <?= ucfirst($ticket['prioridad']) ?>
                            </span>
                        </li>
                        <li class="list-group-item"><strong>Fecha creación:</strong> <?= date('d/m/Y H:i', strtotime($ticket['fecha_creacion'])) ?></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-end gap-2 bg-light">
            <a href="index.php?controller=ticket&action=index" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Volver al listado
            </a>
            <?php if ($this->esAdmin() || ($this->esTecnico() && $ticket['tecnico_id'] == $_SESSION['usuario_id'])): ?>
                <a href="index.php?controller=ticket&action=editar&id=<?= $ticket['id'] ?>" class="btn btn-warning">
                    <i class="bi bi-pencil-square"></i> Editar
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS y Bootstrap Icons -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<?php include_once 'views/templates/footer.php'; ?>
