<?php
require_once __DIR__ . '/../config/db.php';

class Notificacion {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function crear($tecnico_id, $mensaje) {
        $stmt = $this->db->prepare("INSERT INTO notificaciones (tecnico_id, mensaje, fecha) VALUES (?, ?, NOW())");
        $stmt->bind_param("is", $tecnico_id, $mensaje);
        return $stmt->execute();
    }

    public function obtenerPorTecnico($tecnico_id) {
        $stmt = $this->db->prepare("SELECT * FROM notificaciones WHERE tecnico_id = ? ORDER BY fecha DESC");
        $stmt->bind_param("i", $tecnico_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function contarNoLeidas($tecnico_id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM notificaciones WHERE tecnico_id = ? AND leida = 0");
        $stmt->bind_param("i", $tecnico_id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res['total'] ?? 0;
    }

    public function marcarLeida($id) {
        $stmt = $this->db->prepare("UPDATE notificaciones SET leida = 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

    