<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Técnico al Ticket #<?= $ticket['id'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <!-- Header -->
                <div class="card-header bg-primary text-white text-center rounded-top-4">
                    <h4 class="mb-0">👨‍🔧 Asignar Técnico</h4>
                </div>

                <!-- Body -->
                <div class="card-body p-4">
                    <!-- Datos del ticket -->
                    <div class="alert alert-info">
                        <p class="mb-1"><strong>🎫 Ticket #<?= $ticket['id'] ?></strong></p>
                        <p class="mb-1"><strong>Título:</strong> <?= htmlspecialchars($ticket['titulo']) ?></p>
                        <p class="mb-0"><strong>Estado:</strong> <?= htmlspecialchars(ucfirst($ticket['estado'])) ?></p>
                    </div>

                    <!-- Formulario -->
                    <form method="POST" action="index.php?controller=ticket&action=guardarAsignacion">
                        <input type="hidden" name="id" value="<?= $ticket['id'] ?>">

                        <div class="mb-3">
                            <label for="tecnico" class="form-label fw-bold">Seleccionar técnico:</label>
                            <select class="form-select" name="tecnico_id" id="tecnico" required>
                                <option value="">-- Selecciona un técnico --</option>
                                <?php foreach ($tecnicos as $tec): ?>
                                    <option value="<?= $tec['id'] ?>" <?= ($ticket['tecnico_id'] == $tec['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($tec['nombre']) ?> (<?= htmlspecialchars($tec['email']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-center gap-2 mt-4">
                            <button type="submit" class="btn btn-success px-4">
                                💾 Guardar
                            </button>
                            <a href="index.php?controller=ticket&action=index" class="btn btn-outline-secondary px-4">
                                ❌ Cancelar
                            </a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
