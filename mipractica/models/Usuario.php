<?php
class Usuario {
    private $conexion;

    public function __construct() {
        $this->conexion = new mysqli("localhost", "root", "", "trinity_repair_test", 3306);
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    // Registro de usuario
    public function registrar($nombre, $email, $password, $rol_id = 3) {
        $stmt = $this->conexion->prepare("INSERT INTO usuarios (nombre, email, password, rol_id, estado) VALUES (?, ?, ?, ?, 'Activo')");
        $stmt->bind_param("sssi", $nombre, $email, $password, $rol_id);
        return $stmt->execute();
    }

    // Login
    public function login($email, $password) {
        $stmt = $this->conexion->prepare("SELECT * FROM usuarios WHERE email = ? AND password = ?");
        if (!$stmt) {
            die("Error en la consulta: " . $this->conexion->error);
        }
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            return $resultado->fetch_assoc();
        } else {
            return false;
        }
    }

    // Obtener todos los usuarios
    public function obtenerTodos() {
        $usuarios = [];
        $query = "SELECT * FROM usuarios ORDER BY id DESC";
        $resultado = $this->conexion->query($query);

        if ($resultado) {
            while ($fila = $resultado->fetch_assoc()) {
                $usuarios[] = $fila;
            }
        }
        return $usuarios;
    }

    // Cambiar estado (Activo/Inactivo)
    public function cambiarEstado($id, $estado) {
        $stmt = $this->conexion->prepare("UPDATE usuarios SET estado = ? WHERE id = ?");
        $stmt->bind_param("si", $estado, $id);
        return $stmt->execute();
    }

    // Obtener un usuario por ID
    public function obtenerPorId($id) {
        $stmt = $this->conexion->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Actualizar usuario
   public function actualizar($id, $nombre, $email, $rol_id, $estado) {
    $stmt = $this->conexion->prepare("UPDATE usuarios SET nombre = ?, email = ?, rol_id = ?, estado = ? WHERE id = ?");
    $stmt->bind_param("ssisi", $nombre, $email, $rol_id, $estado, $id);
    return $stmt->execute(); // Devuelve true si se ejecutó correctamente
}


    // Eliminar usuario
   public function eliminar($id) {
    $stmt = $this->conexion->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute(); // Devuelve true si se ejecutó correctamente
}

}
