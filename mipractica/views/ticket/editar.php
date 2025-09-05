<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Ticket</title>
</head>
<body>

<h2>Editar Ticket #<?= $datos['id'] ?></h2>

<form method="POST" action="index.php?controller=ticket&action=actualizar">
    <input type="hidden" name="id" value="<?= $datos['id'] ?>">

    <label>Título:</label><br>
    <input type="text" name="titulo" value="<?= htmlspecialchars($datos['titulo']) ?>" required><br><br>

    <label>Categoría:</label><br>
    <select name="categoria_id" required>
        <?php foreach ($categorias as $c): ?>
            <option value="<?= $c['id'] ?>" <?= ($c['id'] == $datos['categoria_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($c['nombre']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Descripción:</label><br>
    <textarea name="descripcion" rows="5" required><?= htmlspecialchars($datos['descripcion']) ?></textarea><br><br>

    <?php if (isset($_SESSION['rol_id']) && (int)$_SESSION['rol_id'] === 1): ?>
        <label>Estado:</label><br>
        <select name="estado">
            <?php
              $estados = ['abierto','en_proceso','resuelto','cerrado'];
              foreach ($estados as $e):
            ?>
              <option value="<?= $e ?>" <?= ($datos['estado'] === $e) ? 'selected' : '' ?>>
                  <?= ucfirst($e) ?>
              </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Prioridad:</label><br>
        <select name="prioridad">
            <?php
              $prioridades = ['baja','media','alta','urgente'];
              foreach ($prioridades as $p):
            ?>
              <option value="<?= $p ?>" <?= ($datos['prioridad'] === $p) ? 'selected' : '' ?>>
                  <?= ucfirst($p) ?>
              </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Asignado a:</label><br>
        <select name="asignado_a">
            <option value="">Sin asignar</option>
            <?php if (!empty($usuarios)): ?>
              <?php foreach ($usuarios as $u): ?>
                <option value="<?= $u['id'] ?>" <?= ($datos['asignado_a'] == $u['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($u['nombre']) ?>
                </option>
              <?php endforeach; ?>
            <?php endif; ?>
        </select><br><br>
    <?php endif; ?>

    <input type="submit" value="Guardar cambios">
</form>

<p><a href="index.php?controller=ticket&action=ver&id=<?= $datos['id'] ?>">Volver</a></p>

</body>
</html>
