<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tickets</title>
</head>
<body>

<h2>Tickets</h2>

<?php if (!empty($mensaje)): ?>
    <div style="padding:10px;background:#d4edda;color:#155724;margin-bottom:12px;border-radius:6px;">
        <?= htmlspecialchars($mensaje) ?>
    </div>
<?php endif; ?>

<p>
    <a href="index.php?controller=ticket&action=crear">Crear Nuevo Ticket</a> |
    <a href="index.php?controller=admin&action=dashboard">Volver al panel</a>
</p>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Categoría</th>
        <th>Estado</th>
        <th>Prioridad</th>
        <th>Fecha</th>
        <?php if (isset($_SESSION['rol_id']) && (int)$_SESSION['rol_id'] === 1): ?>
            <th>Creador</th>
            <th>Asignado</th>
        <?php endif; ?>
        <th>Acciones</th>
    </tr>

    <?php foreach ($resultados as $t): ?>
        <tr>
            <td><?= $t['id'] ?></td>
            <td><?= htmlspecialchars($t['titulo']) ?></td>
            <td><?= htmlspecialchars($t['categoria_nombre'] ?? '-') ?></td>
            <td><?= ucfirst($t['estado']) ?></td>
            <td><?= ucfirst($t['prioridad']) ?></td>
            <td><?= date('d/m/Y H:i', strtotime($t['fecha_creacion'])) ?></td>
            <?php if (isset($_SESSION['rol_id']) && (int)$_SESSION['rol_id'] === 1): ?>
                <td><?= htmlspecialchars($t['creador'] ?? '-') ?></td>
                <td><?= htmlspecialchars($t['asignado'] ?? 'Sin asignar') ?></td>
            <?php endif; ?>
            <td>
                <a href="index.php?controller=ticket&action=ver&id=<?= $t['id'] ?>">Ver</a> |
                <a href="index.php?controller=ticket&action=editar&id=<?= $t['id'] ?>">Editar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
