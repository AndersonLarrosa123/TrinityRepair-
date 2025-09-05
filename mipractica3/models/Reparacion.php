<?php
require_once __DIR__ . '/../config/db.php';

class Reparacion {
    private $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }

    // Obtener tickets/reparaciones de un técnico
    public function obtenerPorTecnico($tecnico_id) {
        $sql = "SELECT t.*, u.nombre AS cliente
                FROM tickets t
                INNER JOIN usuarios u ON t.usuario_id = u.id
                WHERE t.asignado_a = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $tecnico_id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    // Cambiar estado de un ticket asignado al técnico
    public function actualizarEstado($id, $estado, $tecnico_id) {
        $sql = "UPDATE tickets SET estado = ?
                WHERE id = ? AND asignado_a = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sii", $estado, $id, $tecnico_id);
        return $stmt->execute();
    }

    // Crear nuevo ticket desde el lado técnico
    public function crear($descripcion, $cliente_id, $tecnico_id) {
        $estado = 'Pendiente';
        $sql = "INSERT INTO tickets (descripcion, usuario_id, asignado_a, estado)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("siss", $descripcion, $cliente_id, $tecnico_id, $estado);
        return $stmt->execute();
    }
}
