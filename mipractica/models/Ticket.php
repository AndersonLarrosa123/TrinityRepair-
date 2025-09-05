<?php
class Ticket {
    private $db;

    public function __construct() {
        $this->db = new mysqli("localhost", "root", "", "trinity_repair_test", 3306);
        if ($this->db->connect_error) {
            die("Error de conexión: " . $this->db->connect_error);
        }
        $this->db->set_charset("utf8mb4");
    }

    // Listar: si NO es admin, solo del usuario
    public function listar($usuario_id = null, $esAdmin = false) {
        $sql = "SELECT t.*,
                       c.nombre AS categoria_nombre,
                       u1.nombre AS creador,
                       u2.nombre AS asignado
                FROM tickets t
                LEFT JOIN categorias_ticket c ON t.categoria_id = c.id
                LEFT JOIN usuarios u1 ON t.usuario_id = u1.id
                LEFT JOIN usuarios u2 ON t.asignado_a = u2.id";

        if (!$esAdmin && $usuario_id !== null) {
            $sql .= " WHERE t.usuario_id = ?";
        }
        $sql .= " ORDER BY t.fecha_creacion DESC";

        if (!$esAdmin && $usuario_id !== null) {
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("i", $usuario_id);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } else {
            $res = $this->db->query($sql);
            return $res->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function crear($titulo, $descripcion, $categoria_id, $usuario_id, $prioridad = 'media') {
        $sql = "INSERT INTO tickets (titulo, descripcion, categoria_id, usuario_id, prioridad)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssiis", $titulo, $descripcion, $categoria_id, $usuario_id, $prioridad);
        return $stmt->execute();
    }

    public function buscarPorId($id) {
        $sql = "SELECT t.*,
                       c.nombre AS categoria_nombre,
                       u1.nombre AS creador,
                       u2.nombre AS asignado
                FROM tickets t
                LEFT JOIN categorias_ticket c ON t.categoria_id = c.id
                LEFT JOIN usuarios u1 ON t.usuario_id = u1.id
                LEFT JOIN usuarios u2 ON t.asignado_a = u2.id
                WHERE t.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function actualizar($id, $titulo, $descripcion, $categoria_id, $estado = null, $asignado_a = null, $prioridad = null) {
        // Build dinámico con params
        $campos = ["titulo = ?", "descripcion = ?", "categoria_id = ?"];
        $tipos  = "ssi";
        $vals   = [$titulo, $descripcion, $categoria_id];

        if ($estado !== null) {
            $campos[] = "estado = ?";
            $tipos   .= "s";
            $vals[]   = $estado;
        }
        if ($asignado_a !== null && $asignado_a !== "") {
            $campos[] = "asignado_a = ?";
            $tipos   .= "i";
            $vals[]   = (int)$asignado_a;
        } else {
            // permitir des-asignar
            $campos[] = "asignado_a = NULL";
        }
        if ($prioridad !== null) {
            $campos[] = "prioridad = ?";
            $tipos   .= "s";
            $vals[]   = $prioridad;
        }

        $sql = "UPDATE tickets SET " . implode(", ", $campos) . " WHERE id = ?";
        $tipos .= "i";
        $vals[] = (int)$id;

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($tipos, ...$vals);
        return $stmt->execute();
    }

    public function obtenerCategorias() {
        $sql = "SELECT * FROM categorias_ticket WHERE activo = TRUE ORDER BY nombre";
        $res = $this->db->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerUsuarios() {
        $sql = "SELECT id, nombre FROM usuarios ORDER BY nombre";
        $res = $this->db->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }
}
