<?php include_once 'views/templates/header.php'; ?>

<div class="container mt-5">
    <h1 class="mb-4 text-primary"><i class="bi bi-chat-left-text-fill"></i> Consultas de Clientes</h1>

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
                <th>Fecha</th>
                <th>Acción</th>
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
                    <td><?= $c['fecha'] ?></td>
                    <td>
                        <form action="index.php?controller=admin&action=responderConsulta" method="post">
                            <input type="hidden" name="id" value="<?= $c['id'] ?>">
                            <textarea name="respuesta" rows="2" placeholder="Escribe tu respuesta" required></textarea>
                            <button type="submit" class="btn btn-success btn-sm mt-1">
                                <i class="bi bi-reply-fill"></i> Responder
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="index.php?controller=admin&action=dashboard" class="btn btn-primary mt-3">
        <i class="bi bi-speedometer2"></i> Volver al Panel
    </a>
</div>

<?php include_once 'views/templates/footer.php'; ?>
