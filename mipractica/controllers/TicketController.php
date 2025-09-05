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
        // En tu app: rol_id = 1 => Administrador
        return isset($_SESSION['rol_id']) && (int)$_SESSION['rol_id'] === 1;
    }

    // Listado
    public function index() {
        $this->verificarSesion();
        $ticket = new Ticket();
        $usuario_id = $_SESSION['usuario_id'];
        $resultados = $ticket->listar($usuario_id, $this->esAdmin());

        $mensaje = $_SESSION['mensaje'] ?? null;
        unset($_SESSION['mensaje']);

        require_once __DIR__ . '/../views/ticket/listar.php';
    }

    // Form crear
    public function crear() {
        $this->verificarSesion();
        $ticket = new Ticket();
        $categorias = $ticket->obtenerCategorias();
        require_once __DIR__ . '/../views/ticket/crear.php';
    }

    // Guardar
    public function guardar() {
        $this->verificarSesion();
        $ticket = new Ticket();

        $titulo       = trim($_POST['titulo'] ?? '');
        $descripcion  = trim($_POST['descripcion'] ?? '');
        $categoria_id = (int)($_POST['categoria_id'] ?? 0);
        $prioridad    = $_POST['prioridad'] ?? 'media';
        $usuario_id   = (int)$_SESSION['usuario_id'];

        if ($titulo === '' || $descripcion === '' || $categoria_id <= 0) {
            $_SESSION['mensaje'] = "Completa título, descripción y categoría.";
            header("Location: index.php?controller=ticket&action=crear");
            exit;
        }

        if ($ticket->crear($titulo, $descripcion, $categoria_id, $usuario_id, $prioridad)) {
            $_SESSION['mensaje'] = "Ticket creado exitosamente.";
            header("Location: index.php?controller=ticket&action=index");
        } else {
            $_SESSION['mensaje'] = "Error al crear el ticket.";
            header("Location: index.php?controller=ticket&action=crear");
        }
        exit;
    }

    // Ver
    public function ver() {
        $this->verificarSesion();
        $ticket = new Ticket();
        $id = (int)($_GET['id'] ?? 0);
        $datos = $ticket->buscarPorId($id);

        if (!$datos) {
            $_SESSION['mensaje'] = "Ticket no encontrado.";
            header("Location: index.php?controller=ticket&action=index");
            exit;
        }

        if (!$this->esAdmin() && (int)$datos['usuario_id'] !== (int)$_SESSION['usuario_id']) {
            $_SESSION['mensaje'] = "No tienes permisos para ver este ticket.";
            header("Location: index.php?controller=ticket&action=index");
            exit;
        }

        require_once __DIR__ . '/../views/ticket/ver.php';
    }

    // Form editar
    public function editar() {
        $this->verificarSesion();
        $ticket = new Ticket();
        $id = (int)($_GET['id'] ?? 0);
        $datos = $ticket->buscarPorId($id);

        if (!$datos) {
            $_SESSION['mensaje'] = "Ticket no encontrado.";
            header("Location: index.php?controller=ticket&action=index");
            exit;
        }

        if (!$this->esAdmin() && (int)$datos['usuario_id'] !== (int)$_SESSION['usuario_id']) {
            $_SESSION['mensaje'] = "No tienes permisos para editar este ticket.";
            header("Location: index.php?controller=ticket&action=index");
            exit;
        }

        $categorias = $ticket->obtenerCategorias();
        $usuarios   = $this->esAdmin() ? $ticket->obtenerUsuarios() : null;

        require_once __DIR__ . '/../views/ticket/editar.php';
    }

    // Actualizar
    public function actualizar() {
        $this->verificarSesion();
        $ticket = new Ticket();

        $id           = (int)($_POST['id'] ?? 0);
        $titulo       = trim($_POST['titulo'] ?? '');
        $descripcion  = trim($_POST['descripcion'] ?? '');
        $categoria_id = (int)($_POST['categoria_id'] ?? 0);

        $estado     = $this->esAdmin() ? ($_POST['estado'] ?? null)      : null;
        $asignado_a = $this->esAdmin() ? ($_POST['asignado_a'] ?? null)  : null;
        $prioridad  = $this->esAdmin() ? ($_POST['prioridad'] ?? null)   : null;

        if ($id <= 0) {
            $_SESSION['mensaje'] = "ID inválido.";
            header("Location: index.php?controller=ticket&action=index");
            exit;
        }

        $ok = $ticket->actualizar($id, $titulo, $descripcion, $categoria_id, $estado, $asignado_a, $prioridad);

        $_SESSION['mensaje'] = $ok ? "Ticket actualizado." : "Error al actualizar ticket.";
        header("Location: index.php?controller=ticket&action=ver&id=".$id);
        exit;
    }
}
