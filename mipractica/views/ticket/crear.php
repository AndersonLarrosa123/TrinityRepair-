<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Ticket</title>
</head>
<body>

<h2>Crear Nuevo Ticket</h2>

<form method="POST" action="index.php?controller=ticket&action=guardar">
    <label>Título:</label><br>
    <input type="text" name="titulo" required><br><br>

    <label>Categoría:</label><br>
    <select name="categoria_id" required>
        <option value="">Selecciona una categoría</option>
        <?php foreach ($categorias as $c): ?>
            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Prioridad:</label><br>
    <select name="prioridad">
        <option value="baja">Baja</option>
        <option value="media" selected>Media</option>
        <option value="alta">Alta</option>
        <option value="urgente">Urgente</option>
    </select><br><br>

    <label>Descripción:</label><br>
    <textarea name="descripcion" rows="5" required></textarea><br><br>

    <input type="submit" value="Crear Ticket">
</form>

<p><a href="index.php?controller=ticket&action=index">Volver al listado</a></p>

</body>
</html>
