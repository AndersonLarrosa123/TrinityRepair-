<?php include_once 'views/templates/header.php'; ?>

<div class="container mt-5">
    <h1 class="mb-4 text-info"><i class="bi bi-chat-left-text-fill"></i> Consultas de Clientes</h1>

    <a href="index.php?controller=admin&action=dashboard" class="btn btn-primary mb-3">
        <i class="bi bi-speedometer2"></i> Volver al Panel Admin
    </a>

    <table class="table table-bordered table-striped">
        <thead class="table-info">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Modelo</th>
                <th>Asunto</th>
                <th>Mensaje</th>
                <th>Respuesta</th>
                <th>Acción</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($consultas as $c): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= htmlspecialchars($c['nombre']) ?></td>
                    <td><?= htmlspecialchars($c['email']) ?></td>
                    <td><?= htmlspecialchars($c['modelo']) ?></td>
                    <td><?= htmlspecialchars($c['asunto']) ?></td>
                    <td><?= nl2br(htmlspecialchars($c['mensaje'])) ?></td>
                    <td><?= nl2br(htmlspecialchars($c['respuesta'] ?? '')) ?></td>
                    <td>
                        <form method="post" action="index.php?controller=admin&action=responderConsulta">
                            <input type="hidden" name="id" value="<?= $c['id'] ?>">
                            <textarea name="respuesta" rows="2" class="form-control" placeholder="Escribe tu respuesta"></textarea>
                            <button type="submit" class="btn btn-success btn-sm mt-1">
                                <i class="bi bi-reply-fill"></i> Responder
                            </button>
                        </form>
                    </td>
                    <td><?= $c['fecha'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include_once 'views/templates/footer.php'; ?>
