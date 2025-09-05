<?php 
if(session_status() === PHP_SESSION_NONE) session_start(); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Ticket #<?= $ticket['id'] ?? '' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg rounded-4 border-0">
        <div class="card-header bg-primary text-white text-center py-3 rounded-top-4">
            <h4 class="mb-0">✏️ Editar Ticket #<?= $ticket['id'] ?? '' ?></h4>
        </div>

        <div class="card-body p-4">
            <form method="POST" action="index.php?controller=ticket&action=actualizar">
                <input type="hidden" name="id" value="<?= $ticket['id'] ?? '' ?>">

                <div class="row g-4">
                    <!-- Columna izquierda -->
                    <div class="col-md-6">
                        <!-- Título -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Título</label>
                            <input type="text" class="form-control" name="titulo" 
                                   value="<?= htmlspecialchars($ticket['titulo'] ?? '') ?>" required>
                        </div>

                        <!-- Categoría -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Categoría</label>
                            <select class="form-select" name="categoria_id" required>
                                <option value="">-- Selecciona --</option>
                                <?php foreach ($categorias as $c): ?>
                                    <option value="<?= $c['id'] ?>" <?= ($ticket['categoria_id'] ?? 0) == $c['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($c['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Descripción</label>
                            <textarea class="form-control" name="descripcion" rows="6" required><?= htmlspecialchars($ticket['descripcion'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <!-- Columna derecha (solo admins) -->
                    <div class="col-md-6">
                        <?php if ($this->esAdmin() ?? false): ?>
                            <!-- Estado -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Estado</label>
                                <select class="form-select" name="estado">
                                    <?php
                                    $estados = ['Pendiente','Diagnóstico','Presupuesto','En Reparación','Finalizado','Cancelado'];
                                    foreach ($estados as $estado):
                                    ?>
                                        <option value="<?= $estado ?>" <?= ($ticket['estado'] ?? '') == $estado ? 'selected' : '' ?>>
                                            <?= $estado ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Prioridad -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Prioridad</label>
                                <select class="form-select" name="prioridad">
                                    <option value="baja" <?= ($ticket['prioridad'] ?? '') == 'baja' ? 'selected' : '' ?>>Baja</option>
                                    <option value="media" <?= ($ticket['prioridad'] ?? '') == 'media' ? 'selected' : '' ?>>Media</option>
                                    <option value="alta" <?= ($ticket['prioridad'] ?? '') == 'alta' ? 'selected' : '' ?>>Alta</option>
                                    <option value="urgente" <?= ($ticket['prioridad'] ?? '') == 'urgente' ? 'selected' : '' ?>>Urgente</option>
                                </select>
                            </div>

                            <!-- Asignado a -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Asignado a</label>
                                <select class="form-select" name="tecnico_id">
                                    <option value="">-- Sin asignar --</option>
                                    <?php foreach ($tecnicos as $tec): ?>
                                        <option value="<?= $tec['id'] ?>" <?= ($ticket['tecnico_id'] ?? 0) == $tec['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($tec['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Presupuesto -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Presupuesto</label>
                                <input type="number" step="0.01" class="form-control" name="presupuesto" 
                                       value="<?= htmlspecialchars($ticket['presupuesto'] ?? '') ?>">
                            </div>

                            <!-- Aprobado por cliente -->
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" name="aprobado_cliente" value="1" 
                                       <?= !empty($ticket['aprobado_cliente']) ? 'checked' : '' ?>>
                                <label class="form-check-label">Aprobado por cliente</label>
                            </div>

                            <!-- Admin -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Admin que creó el ticket</label>
                                <select class="form-select" name="admin_id" required>
                                    <option value="<?= $_SESSION['usuario_id'] ?>" selected>
                                        <?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Admin') ?>
                                    </option>
                                </select>
                                <div class="form-text">Este campo indica qué admin creó el ticket.</div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Botones -->
                <div class="d-flex justify-content-center mt-4">
                    <button type="submit" class="btn btn-success px-4 me-2">💾 Guardar cambios</button>
                    <a href="index.php?controller=ticket&action=index" class="btn btn-outline-secondary px-4">⬅ Volver</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
