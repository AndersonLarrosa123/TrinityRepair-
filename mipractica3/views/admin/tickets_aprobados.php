<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../models/Ticket.php';

// Instancia del modelo Ticket
$ticketModel = new Ticket();

// Traer todos los tickets que el cliente aprobó y continuó
$ticketsAprobados = $ticketModel->listarAprobados(); // devuelve estado 'Presupuesto' o 'En Reparación' con aprobado_cliente=1
?>

<?php include_once 'views/templates/header.php'; ?>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<div class="container mt-5">
    <h1 class="mb-4 text-primary"><i class="bi bi-check2-circle"></i> Tickets Aprobados por Clientes</h1>

    <?php if (!empty($ticketsAprobados)): ?>
        <div class="row g-4">
            <?php foreach($ticketsAprobados as $ticket): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-header bg-primary text-white fw-bold d-flex justify-content-between align-items-center">
                            Ticket #<?= $ticket['id']; ?>
                            <span class="badge bg-light text-primary"><?= htmlspecialchars($ticket['cliente_nombre']); ?></span>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">
                                <i class="bi bi-cash-stack me-1"></i>
                                <strong>Presupuesto:</strong> 
                                <span class="text-success fw-bold">$<?= number_format($ticket['presupuesto'], 2); ?></span>
                            </p>
                            <p class="mb-0">
                                <i class="bi bi-info-circle me-1"></i>
                                <strong>Estado:</strong> 
                                <?php
                                $estado_badge = match($ticket['estado']) {
                                    'Presupuesto' => 'bg-info text-dark',
                                    'En Reparación' => 'bg-warning text-dark',
                                    default => 'bg-secondary text-white',
                                };
                                ?>
                                <span class="badge <?= $estado_badge ?> px-3 py-1"><?= $ticket['estado'] ?></span>
                            </p>
                        </div>
                        <div class="card-footer text-end bg-light">
                            <a href="index.php?controller=ticket&action=ver&id=<?= $ticket['id'] ?>" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye-fill"></i> Ver Detalles
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center mt-4">
            <i class="bi bi-inbox"></i> No hay tickets aprobados por clientes.
        </div>
    <?php endif; ?>

    <div class="mt-4 text-end">
        <a href="index.php?controller=admin&action=dashboard" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Volver al Dashboard
        </a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php include_once 'views/templates/footer.php'; ?>
