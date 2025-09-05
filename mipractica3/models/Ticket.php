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

    // Listado general de tickets
    public function listar($usuario_id = null, $esAdmin = false, $esTecnico = false) {
        $sql = "SELECT t.*, 
                       c.nombre AS categoria_nombre,
                       cli.nombre AS cliente_nombre,
                       tec.nombre AS tecnico_nombre,
                       adm.nombre AS admin_nombre
                FROM tickets t
                LEFT JOIN categorias_ticket c ON t.categoria_id = c.id
                LEFT JOIN usuarios cli ON t.cliente_id = cli.id
                LEFT JOIN usuarios tec ON t.tecnico_id = tec.id
                LEFT JOIN usuarios adm ON t.admin_id = adm.id";

        if (!$esAdmin) {
            if ($esTecnico && $usuario_id !== null) {
                $sql .= " WHERE t.tecnico_id = ?";
            } elseif ($usuario_id !== null) {
                $sql .= " WHERE t.cliente_id = ?";
            }
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

    // Listar tickets aprobados por cliente (historial para admin)
    public function listarAprobados() {
        $sql = "SELECT t.*, cli.nombre AS cliente_nombre
                FROM tickets t
                LEFT JOIN usuarios cli ON t.cliente_id = cli.id
                WHERE t.aprobado_cliente = 1
                ORDER BY t.fecha_creacion DESC";
        $res = $this->db->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    // Crear ticket
    public function crear($titulo, $descripcion, $categoria_id, $cliente_id, $admin_id, $prioridad = 'media') {
        $sql = "INSERT INTO tickets (titulo, descripcion, categoria_id, cliente_id, admin_id, prioridad, estado, fecha_creacion)
                VALUES (?, ?, ?, ?, ?, ?, 'Pendiente', NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("siiiss", $titulo, $descripcion, $categoria_id, $cliente_id, $admin_id, $prioridad);
        return $stmt->execute();
    }

    // Obtener ticket por ID
    public function obtenerPorIdConAdmin(int $id) {
        $stmt = $this->db->prepare("SELECT t.*, 
                                           c.nombre AS categoria_nombre, 
                                           cli.nombre AS cliente_nombre, 
                                           tec.nombre AS tecnico_nombre,
                                           adm.nombre AS admin_nombre
                                    FROM tickets t
                                    LEFT JOIN categorias_ticket c ON t.categoria_id = c.id
                                    LEFT JOIN usuarios cli ON t.cliente_id = cli.id
                                    LEFT JOIN usuarios tec ON t.tecnico_id = tec.id
                                    LEFT JOIN usuarios adm ON t.admin_id = adm.id
                                    WHERE t.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function obtenerPorId($id) {
        return $this->obtenerPorIdConAdmin($id);
    }

    // Actualizar ticket
    public function actualizar($id, $titulo, $descripcion, $categoria_id, $estado = null, $tecnico_id = null, $prioridad = null, $presupuesto = null, $aprobado_cliente = 0) {
        $campos = ["titulo = ?", "descripcion = ?", "categoria_id = ?"];
        $tipos  = "ssi";
        $vals   = [$titulo, $descripcion, $categoria_id];

        if ($estado !== null) { $campos[] = "estado = ?"; $tipos.="s"; $vals[]=$estado; }
        if ($tecnico_id === "" || $tecnico_id === null) { $campos[] = "tecnico_id = NULL"; } 
        else { $campos[] = "tecnico_id = ?"; $tipos.="i"; $vals[]=(int)$tecnico_id; }
        if ($prioridad !== null) { $campos[] = "prioridad = ?"; $tipos.="s"; $vals[]=$prioridad; }
        if ($presupuesto === "" || $presupuesto === null) { $campos[] = "presupuesto = NULL"; } 
        else { $campos[] = "presupuesto = ?"; $tipos.="d"; $vals[]=$presupuesto; }
        $campos[]="aprobado_cliente = ?"; $tipos.="i"; $vals[]=$aprobado_cliente;

        $sql = "UPDATE tickets SET ".implode(", ", $campos)." WHERE id = ?";
        $tipos.="i"; $vals[]=(int)$id;

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($tipos,...$vals);
        return $stmt->execute();
    }

    // Cambiar estado y marcar aprobado_cliente
    public function cambiarEstado($id, $estado, $presupuesto=null, $aprobado_cliente=0) {
        $sql = "UPDATE tickets SET estado = ?, aprobado_cliente=?";
        $tipos="si"; 
        $vals=[$estado,$aprobado_cliente];

        if($presupuesto!==null && $presupuesto!==""){ 
            $sql.=", presupuesto=?"; 
            $tipos.="d"; 
            $vals[]=$presupuesto; 
        } else { 
            $sql.=", presupuesto=NULL"; 
        }

        $sql.=" WHERE id=?"; 
        $tipos.="i"; 
        $vals[]=$id;

        $stmt=$this->db->prepare($sql);
        $stmt->bind_param($tipos,...$vals);
        return $stmt->execute();
    }

    public function asignarTecnico($ticket_id, $tecnico_id) {
        $stmt = $this->db->prepare("UPDATE tickets SET tecnico_id=? WHERE id=?");
        $stmt->bind_param("ii",$tecnico_id,$ticket_id);
        return $stmt->execute();
    }

    public function eliminar($id) {
        $stmt=$this->db->prepare("DELETE FROM tickets WHERE id=?");
        $stmt->bind_param("i",$id);
        return $stmt->execute();
    }

    public function obtenerCategorias() {
        $sql="SELECT * FROM categorias_ticket WHERE activo=TRUE ORDER BY nombre";
        $res=$this->db->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerUsuarios() {
        $sql="SELECT id,nombre FROM usuarios ORDER BY nombre";
        $res=$this->db->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerTecnicos() {
        $sql="SELECT id,nombre,email FROM usuarios WHERE rol_id=2";
        $res=$this->db->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }
}
?>
