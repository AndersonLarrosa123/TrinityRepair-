<?php
require_once __DIR__ . '/../config/db.php';

class Consulta {
    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function guardarConsulta($nombre, $email, $modelo, $asunto, $mensaje) {
        $stmt = $this->db->prepare("
            INSERT INTO consultas (nombre, email, modelo, asunto, mensaje, fecha) 
            VALUES (:nombre, :email, :modelo, :asunto, :mensaje, NOW())
        ");
        return $stmt->execute([
            ':nombre' => $nombre,
            ':email' => $email,
            ':modelo' => $modelo,
            ':asunto' => $asunto,
            ':mensaje' => $mensaje
        ]);
    }

    public function obtenerTodas() {
        $stmt = $this->db->query("SELECT * FROM consultas ORDER BY fecha DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function responder($id, $respuesta) {
        $stmt = $this->db->prepare("
            UPDATE consultas 
            SET respuesta = :respuesta, fecha_respuesta = NOW()
            WHERE id = :id
        ");
        return $stmt->execute([
            ':respuesta' => $respuesta,
            ':id' => $id
        ]);
    }

    public function obtenerPorId($id) {
        $stmt = $this->db->prepare("SELECT * FROM consultas WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerPorEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM consultas WHERE email = :email ORDER BY fecha DESC");
        $stmt->execute([':email' => $email]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
