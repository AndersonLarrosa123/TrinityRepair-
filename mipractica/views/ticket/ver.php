<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Ticket</title>
</head>
<body>

<h2>Detalle del Ticket #<?= $datos['id'] ?></h2>

<p><strong>Título:</strong> <?= htmlspecialchars($datos['titulo']) ?></p>
<p><strong>Categoría:</strong> <?= htmlspecialchars($datos['categoria_nombre'] ?? '-') ?></p>
<p><strong>Estado:</strong> <?= ucfirst($datos['estado']) ?></p>
<p><strong>Prioridad:</strong> <?= ucfirst($datos['prioridad']) ?></p>
<p><strong>Creador:</strong> <?= htmlspecialchars($datos['creador'] ?? '-') ?></p>
<p><strong>Asignado a:</strong> <?= htmlspecialchars($datos['asignado'] ?? 'Sin asignar') ?></p>
<p><strong>Descripción:</strong><br><?= nl2br(htmlspecialchars($datos['descripcion'])) ?></p>

<p>
    <a href="index.php?controller=ticket&action=editar&id=<?= $datos['id'] ?>">Editar</a> |
    <a href="index.php?controller=ticket&action=index">Volver</a>
</p>

</body>
</html>
