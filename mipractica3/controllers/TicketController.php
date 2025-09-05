<?php
require_once __DIR__ . '/../models/Ticket.php';

class TicketController {

    private function verificarSesion() {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?controller=usuario&action=mostrarLogin");
            exit;
        }
    }

    private function esAdmin(): bool {
        return isset($_SESSION['rol_id']) && (int)$_SESSION['rol_id'] === 1;
    }

    private function esTecnico(): bool {
        return isset($_SESSION['rol_id']) && (int)$_SESSION['rol_id'] === 2;
    }

    public function index() {
        $this->verificarSesion();
        $ticketModel = new Ticket();
        $usuario_id = $_SESSION['usuario_id'];
        $resultados = $ticketModel->listar($usuario_id, $this->esAdmin(), $this->esTecnico());

        $mensaje = $_SESSION['mensaje'] ?? null;
        unset($_SESSION['mensaje']);

        require_once __DIR__ . '/../views/ticket/listar.php';
    }

    public function crear() {
        $this->verificarSesion();
        $ticketModel = new Ticket();
        $categorias = $ticketModel->obtenerCategorias();
        $clientes = $this->esAdmin() ? $ticketModel->obtenerUsuarios() : null;

        $mensaje = $_SESSION['mensaje'] ?? null;
        unset($_SESSION['mensaje']);
        require_once __DIR__ . '/../views/ticket/crear.php';
    }

    public function guardar() {
        $this->verificarSesion();
        $ticketModel = new Ticket();

        $titulo       = trim($_POST['titulo'] ?? '');
        $descripcion  = trim($_POST['descripcion'] ?? '');
        $categoria_id = (int)($_POST['categoria_id'] ?? 0);
        $prioridad    = $_POST['prioridad'] ?? 'media';
        $cliente_id   = $this->esAdmin() ? (int)($_POST['cliente_id'] ?? 0) : (int)$_SESSION['usuario_id'];
        $admin_id     = $this->esAdmin() ? $_SESSION['usuario_id'] : null;

        if ($titulo === '' || $descripcion === '' || $categoria_id <= 0 || $cliente_id <= 0) {
            $_SESSION['mensaje'] = "Completa todos los campos obligatorios.";
            header("Location: index.php?controller=ticket&action=crear");
            exit;
        }

        if ($ticketModel->crear($titulo, $descripcion, $categoria_id, $cliente_id, $admin_id, $prioridad)) {
            $_SESSION['mensaje'] = "Ticket creado exitosamente.";
            header("Location: index.php?controller=ticket&action=index");
        } else {
            $_SESSION['mensaje'] = "Error al crear el ticket.";
            header("Location: index.php?controller=ticket&action=crear");
        }
        exit;
    }

    public function ver() {
        $this->verificarSesion();
        $ticketModel = new Ticket();
        $id = (int)($_GET['id'] ?? 0);
        $ticket = $ticketModel->obtenerPorIdConAdmin($id);

        if (!$ticket) {
            $_SESSION['mensaje'] = "Ticket no encontrado.";
            header("Location: index.php?controller=ticket&action=index");
            exit;
        }

        if (!$this->esAdmin() && !$this->esTecnico() && (int)$ticket['cliente_id'] !== (int)$_SESSION['usuario_id']) {
            $_SESSION['mensaje'] = "No tienes permisos para ver este ticket.";
            header("Location: index.php?controller=ticket&action=index");
            exit;
        }

        require_once __DIR__ . '/../views/ticket/ver.php';
    }

    public function editar() {
        $this->verificarSesion();
        $ticketModel = new Ticket();
        $id = (int)($_GET['id'] ?? 0);
        $ticket = $ticketModel->obtenerPorId($id);

        if (!$ticket) {
            $_SESSION['mensaje'] = "Ticket no encontrado.";
            header("Location: index.php?controller=ticket&action=index");
            exit;
        }

        if (!$this->esAdmin() && !($this->esTecnico() && $ticket['tecnico_id'] == $_SESSION['usuario_id'])) {
            $_SESSION['mensaje'] = "No tienes permisos para editar este ticket.";
            header("Location: index.php?controller=ticket&action=index");
            exit;
        }

        $categorias = $ticketModel->obtenerCategorias();
        $tecnicos   = $this->esAdmin() ? $ticketModel->obtenerTecnicos() : null;

        require_once __DIR__ . '/../views/ticket/editar.php';
    }

    public function actualizar() {
        $this->verificarSesion();
        $ticketModel = new Ticket();

        $id           = (int)($_POST['id'] ?? 0);
        $titulo       = trim($_POST['titulo'] ?? '');
        $descripcion  = trim($_POST['descripcion'] ?? '');
        $categoria_id = (int)($_POST['categoria_id'] ?? 0);

        $estado       = $this->esAdmin() ? ($_POST['estado'] ?? null) : null;
        $tecnico_id   = $this->esAdmin() ? ($_POST['tecnico_id'] ?? null) : null;
        $prioridad    = $this->esAdmin() ? ($_POST['prioridad'] ?? null) : null;
        $presupuesto  = $this->esAdmin() ? ($_POST['presupuesto'] ?? null) : null;
        $aprobado_cliente = $this->esAdmin() ? ($_POST['aprobado_cliente'] ?? 0) : 0;

        if ($id <= 0 || $titulo === '' || $descripcion === '' || $categoria_id <= 0) {
            $_SESSION['mensaje'] = "Datos incompletos.";
            header("Location: index.php?controller=ticket&action=editar&id=".$id);
            exit;
        }

        $ok = $ticketModel->actualizar($id, $titulo, $descripcion, $categoria_id, $estado, $tecnico_id, $prioridad, $presupuesto, $aprobado_cliente);

        $_SESSION['mensaje'] = $ok ? "Ticket actualizado correctamente." : "Error al actualizar ticket.";
        header("Location: index.php?controller=ticket&action=ver&id=".$id);
        exit;
    }

    public function eliminar() {
        $this->verificarSesion();
        $ticketModel = new Ticket();
        $id = (int)($_GET['id'] ?? 0);

        if ($id > 0) {
            $ok = $ticketModel->eliminar($id);
            $_SESSION['mensaje'] = $ok ? "Ticket eliminado correctamente." : "Error al eliminar ticket.";
        } else {
            $_SESSION['mensaje'] = "ID de ticket no especificado.";
        }

        header("Location: index.php?controller=ticket&action=index");
        exit;
    }

    public function asignar() {
        $this->verificarSesion();
        if (!$this->esAdmin()) {
            $_SESSION['mensaje'] = "No tienes permisos para asignar técnicos.";
            header("Location: index.php?controller=ticket&action=index");
            exit;
        }

        $id = (int)($_GET['id'] ?? 0);
        $ticketModel = new Ticket();
        $ticket = $ticketModel->obtenerPorId($id);

        if (!$ticket) {
            $_SESSION['mensaje'] = "Ticket no encontrado.";
            header("Location: index.php?controller=ticket&action=index");
            exit;
        }

        $tecnicos = $ticketModel->obtenerTecnicos();
        require_once __DIR__ . '/../views/ticket/asignar.php';
    }

    public function guardarAsignacion() {
        $this->verificarSesion();
        if (!$this->esAdmin()) {
            $_SESSION['mensaje'] = "No tienes permisos para asignar técnicos.";
            header("Location: index.php?controller=ticket&action=index");
            exit;
        }

        $ticket_id = (int)($_POST['ticket_id'] ?? 0);
        $tecnico_id = (int)($_POST['tecnico_id'] ?? 0);

        $ticketModel = new Ticket();
        $ok = $ticketModel->asignarTecnico($ticket_id, $tecnico_id);

        $_SESSION['mensaje'] = $ok ? "Técnico asignado correctamente." : "Error al asignar técnico.";
        header("Location: index.php?controller=ticket&action=ver&id=".$ticket_id);
        exit;
    }
}
?>
