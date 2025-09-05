<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Técnico</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px; }
        h1, h2 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; background: #fff; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background: #4CAF50; color: white; }
        tr:nth-child(even) { background: #f2f2f2; }
        .mensaje { padding: 10px; border-radius: 6px; margin-bottom: 12px; }
        .mensaje.exito { background: #d4edda; color: #155724; }
        .mensaje.error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

<h1>Panel del Técnico</h1>
<h2>🔔 Notificaciones (<?= $noLeidas ?> sin leer)</h2>
<?php if (empty($notificaciones)): ?>
    <p>No tienes notificaciones.</p>
<?php else: ?>
    <ul>
        <?php foreach ($notificaciones as $n): ?>
            <li style="<?= $n['leida'] ? 'color:gray;' : 'font-weight:bold;' ?>">
                <?= htmlspecialchars($n['mensaje']) ?> - <?= date('d/m/Y H:i', strtotime($n['fecha'])) ?>
                <?php if (!$n['leida']): ?>
                    <form method="POST" action="index.php?controller=tecnico&action=leerNotificacion" style="display:inline;">
                        <input type="hidden" name="id" value="<?= (int)$n['id'] ?>">
                        <button type="submit">Marcar leída</button>
                    </form>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>


<?php if (!empty($mensaje)): ?>
    <div class="mensaje <?= strpos($mensaje, 'Error') === false ? 'exito' : 'error' ?>">
        <?= htmlspecialchars($mensaje) ?>
    </div>
<?php endif; ?>

<h2>Reparaciones asignadas</h2>

<?php if (empty($tickets)): ?>
    <p>No tenés tickets asignados por el momento.</p>
<?php else: ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Categoría</th>
            <th>Estado</th>
            <th>Prioridad</th>
            <th>Fecha</th>
            <th>Creador</th>
        </tr>
        <?php foreach ($tickets as $t): ?>
            <tr>
                <td><?= (int)$t['id'] ?></td>
                <td><?= htmlspecialchars($t['titulo']) ?></td>
                <td><?= htmlspecialchars($t['categoria_nombre'] ?? '-') ?></td>
                <td style="background: 
                    <?= $t['estado'] == 'Resuelto' ? '#d4edda' : ($t['estado'] == 'En proceso' ? '#fff3cd' : ($t['estado']=='Abierto'? '#cce5ff':'#f8d7da')) ?>;">
                    <form method="POST" action="index.php?controller=tecnico&action=cambiarEstado" style="margin:0;">
                        <input type="hidden" name="id" value="<?= (int)$t['id'] ?>">
                        <select name="estado">
                            <option value="Pendiente" <?= ($t['estado'] == "Pendiente") ? "selected" : "" ?>>Pendiente</option>
                            <option value="En proceso" <?= ($t['estado'] == "En proceso") ? "selected" : "" ?>>En proceso</option>
                            <option value="Resuelto" <?= ($t['estado'] == "Resuelto") ? "selected" : "" ?>>Resuelto</option>
                            <option value="Abierto" <?= ($t['estado'] == "Abierto") ? "selected" : "" ?>>Abierto</option>
                        </select>
                        <button type="submit">Actualizar</button>
                    </form>
                </td>
                <td><?= htmlspecialchars(ucfirst($t['prioridad'])) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($t['fecha_creacion'])) ?></td>
                <td><?= htmlspecialchars($t['creador'] ?? '-') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<a href="index.php?controller=tecnico&action=chat&ticket_id=<?= $t['id'] ?>" class="btn btn-primary">Chat</a>

</body>
</html>
