<?php
if (session_status() == PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Ticket.php';
require_once __DIR__ . '/../models/Consulta.php';

class AdminController {

    // Panel principal del admin
    public function dashboard() {
        $mensaje = $_SESSION['mensaje'] ?? null;
        unset($_SESSION['mensaje']);

        require_once __DIR__ . '/../views/admin/dashboard.php';
    }

    // Crear usuario desde el panel admin
    public function crearUsuario() {
        $usuarioModel = new Usuario();
        $mensaje_exito = '';
        $mensaje_error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $rol_id = $_POST['rol_id'] ?? 3;

            if ($nombre && $email && $password) {
                $exito = $usuarioModel->registrar($nombre, $email, $password, $rol_id);
                $mensaje_exito = $exito ? "Usuario creado con éxito." : "Error al crear el usuario.";
            } else {
                $mensaje_error = "Faltan datos obligatorios.";
            }
        }

        require_once __DIR__ . '/../views/admin/registro_usuario.php';
    }

    // Listar todos los usuarios
    public function listarUsuarios() {
        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->obtenerTodos();

        $mensaje = $_SESSION['mensaje'] ?? null;
        unset($_SESSION['mensaje']);

        require_once __DIR__ . '/../views/admin/lista_usuarios.php';
    }

    // Editar un usuario
    public function editarUsuario() {
        $usuarioModel = new Usuario();
        $mensaje_exito = '';
        $mensaje_error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $usuarioModel->actualizar(
                $_POST['id'],
                $_POST['nombre'],
                $_POST['email'],
                $_POST['rol_id'],
                $_POST['estado']
            );
            $mensaje_exito = $exito ? "Usuario actualizado correctamente." : "Error al actualizar el usuario.";
            $usuario = $usuarioModel->obtenerPorId($_POST['id']);
        } else {
            $usuario = $usuarioModel->obtenerPorId($_GET['id']);
        }

        require_once __DIR__ . '/../views/admin/editar_usuario.php';
    }

    // Eliminar un usuario
    public function eliminarUsuario() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $usuarioModel = new Usuario();
            $exito = $usuarioModel->eliminar($id);
            $_SESSION['mensaje'] = $exito ? "Usuario eliminado correctamente." : "Error al eliminar el usuario.";
        } else {
            $_SESSION['mensaje'] = "ID de usuario no especificado.";
        }

        header("Location: index.php?controller=admin&action=listarUsuarios");
        exit;
    }

    // Cerrar sesión del admin
    public function logout() {
        session_destroy();
        header('Location: index.php?controller=usuario&action=mostrarLogin');
        exit;
    }

    // Panel de tickets aprobados para continuar reparación
    public function continuarReparacionPanel() {
        if (!isset($_SESSION['rol_id']) || (int)$_SESSION['rol_id'] !== 1) {
            $_SESSION['mensaje'] = "No tienes permisos para esta acción.";
            header("Location: index.php?controller=admin&action=dashboard");
            exit;
        }

        $ticketModel = new Ticket();
        $ticketsAprobados = $ticketModel->listarAprobados();

        require_once __DIR__ . '/../views/admin/tickets_aprobados.php';
    }

    // Continuar la reparación
    public function continuarReparacion() {
        if (!isset($_SESSION['rol_id']) || (int)$_SESSION['rol_id'] !== 1) {
            $_SESSION['mensaje'] = "No tienes permisos para esta acción.";
            header("Location: index.php?controller=admin&action=dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ticket_id'])) {
            $ticket_id = (int)$_POST['ticket_id'];
            $ticketModel = new Ticket();
            $ticket = $ticketModel->obtenerPorId($ticket_id);

            if (!$ticket) {
                $_SESSION['mensaje'] = "Ticket no encontrado.";
            } elseif ($ticket['estado'] !== 'Presupuesto' || $ticket['aprobado_cliente'] != 1) {
                $_SESSION['mensaje'] = "El ticket no está aprobado para continuar.";
            } else {
                $ticketModel->cambiarEstado($ticket_id, 'En Reparación');
                $_SESSION['mensaje'] = "Reparación del Ticket #{$ticket_id} continuada. Cliente: {$ticket['cliente_nombre']}";
            }

            header("Location: index.php?controller=admin&action=dashboard");
            exit;
        }

        $_SESSION['mensaje'] = "No se recibió ticket para continuar.";
        header("Location: index.php?controller=admin&action=dashboard");
        exit;
    }

    // ================== CONSULTAS ==================

    // Ver todas las consultas de clientes
    public function verConsultas() {
        $consultaModel = new Consulta();
        $consultas = $consultaModel->obtenerTodas();

        require_once __DIR__ . '/../views/admin/consultas.php';
    }

    // Responder una consulta y enviar correo al cliente
    public function responderConsulta() {
        $consultaModel = new Consulta();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $respuesta = $_POST['respuesta'];

            if ($consultaModel->responder($id, $respuesta)) {
                $consulta = $consultaModel->obtenerPorId($id);
                $to = $consulta['email'];
                $subject = "Respuesta a tu consulta: " . $consulta['asunto'];
                $body = "Hola " . $consulta['nombre'] . ",\n\nTu consulta:\n" . $consulta['mensaje'] . "\n\nRespuesta:\n" . $respuesta;
                $headers = "From: admin@tusitio.com";

                mail($to, $subject, $body, $headers);
            }
        }

        header("Location: index.php?controller=admin&action=verConsultas");
        exit;
    }
}
?>
