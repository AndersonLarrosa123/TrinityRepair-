<h2>Editar Usuario</h2>
<form method="post" action="index.php?controller=admin&action=editarUsuario">
    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
    
    <label>Nombre:</label><br>
    <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required><br><br>
    
    <label>Email:</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required><br><br>
    
    <label>Rol:</label><br>
    <select name="rol_id" required>
        <option value="1" <?= $usuario['rol_id'] == 1 ? 'selected' : '' ?>>Administrador</option>
        <option value="2" <?= $usuario['rol_id'] == 2 ? 'selected' : '' ?>>Técnico</option>
        <option value="3" <?= $usuario['rol_id'] == 3 ? 'selected' : '' ?>>Cliente</option>
        <option value="4" <?= $usuario['rol_id'] == 4 ? 'selected' : '' ?>>Supervisor</option>
    </select><br><br>
    
    <label>Estado:</label><br>
<select name="estado" required>
    <option value="Activo" <?= $usuario['estado'] === 'Activo' ? 'selected' : '' ?>>Activo</option>
    <option value="Inactivo" <?= $usuario['estado'] === 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
</select><br><br>

    <button type="submit">Guardar cambios</button>
</form>
