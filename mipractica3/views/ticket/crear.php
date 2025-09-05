<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-success text-white text-center">
                    <h5 class="mb-0">Crear Nuevo Ticket</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="index.php?controller=ticket&action=guardar">
                        
                        <div class="mb-3">
                            <label class="form-label">Título</label>
                            <input type="text" class="form-control" name="titulo" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Cliente</label>
                            <select class="form-select" name="cliente_id" required>
                                <option value="">Selecciona un cliente</option>
                                <?php foreach ($clientes as $c): ?>
                                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Categoría</label>
                            <select class="form-select" name="categoria_id" required>
                                <option value="">Selecciona una categoría</option>
                                <?php foreach ($categorias as $c): ?>
                                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Prioridad</label>
                                <select class="form-select" name="prioridad">
                                    <option value="baja">Baja</option>
                                    <option value="media" selected>Media</option>
                                    <option value="alta">Alta</option>
                                    <option value="urgente">Urgente</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Estado</label>
                                <select class="form-select" name="estado" required>
                                    <?php
                                    $estados = ['Pendiente','Diagnóstico','Presupuesto','En Reparación','Finalizado','Cancelado'];
                                    foreach ($estados as $estado):
                                    ?>
                                        <option value="<?= $estado ?>"><?= $estado ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" rows="4" required></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php?controller=ticket&action=index" class="btn btn-secondary">Volver</a>
                            <button type="submit" class="btn btn-success">Crear Ticket</button>
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
