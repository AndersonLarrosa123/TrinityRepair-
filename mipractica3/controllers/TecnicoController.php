<?php
require_once __DIR__ . '/../models/Reparacion.php';
require_once __DIR__ . '/../models/Ticket.php';
require_once __DIR__ . '/../models/Notificacion.php'; // <- AGREGAR ESTO

class TecnicoController
{
    // Verificar sesión de técnico
    private function verificarSesionTecnico() {
        if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['rol_id']) || (int)$_SESSION['rol_id'] !== 2) {
            header('Location: index.php?controller=usuario&action=mostrarLogin');
            exit;
        }
    }

    // Dashboard principal
    public function dashboard() {
        $this->verificarSesionTecnico();

        $ticketModel = new Ticket();
        $notiModel   = new Notificacion();
        $tecnicoId   = (int)$_SESSION['usuario_id'];

        $tickets        = $ticketModel->listarAsignados($tecnicoId);
        $notificaciones = $notiModel->obtenerPorTecnico($tecnicoId);
        $noLeidas       = $notiModel->contarNoLeidas($tecnicoId);

        $mensaje = $_SESSION['mensaje'] ?? null;
        unset($_SESSION['mensaje']);

        require_once __DIR__ . '/../views/tecnico/dashboard.php';
    }

    // Cambiar estado de un ticket asignado
    public function cambiarEstado() {
        $this->verificarSesionTecnico();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id         = (int)$_POST['id'];
            $estado     = $_POST['estado'] ?? '';
            $tecnico_id = (int)$_SESSION['usuario_id'];

            $reparacion = new Reparacion();

            if ($reparacion->actualizarEstado($id, $estado, $tecnico_id)) {
                $_SESSION['mensaje'] = "Estado actualizado correctamente.";
            } else {
                $_SESSION['mensaje'] = "Error al actualizar el estado.";
            }

            header("Location: index.php?controller=tecnico&action=dashboard");
            exit;
        }
    }

    // Marcar notificación como leída
    public function leerNotificacion() {
        $this->verificarSesionTecnico();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $notiModel = new Notificacion();
            $notiModel->marcarLeida((int)$_POST['id']);
        }
        header("Location: index.php?controller=tecnico&action=dashboard");
        exit;
    }

    public function chat() {
    $this->verificarSesionTecnico();
    $ticket_id = (int)($_GET['ticket_id'] ?? 0);

    $ticketModel = new Ticket();
    $ticket = $ticketModel->buscarPorId($ticket_id);

    if (!$ticket || (int)$ticket['asignado_a'] !== (int)$_SESSION['usuario_id']) {
        $_SESSION['mensaje'] = "No tenés acceso a este chat.";
        header("Location: index.php?controller=tecnico&action=dashboard");
        exit;
    }

    require_once __DIR__ . '/../models/Chat.php';
    $chatModel = new Chat();

    // Enviar mensaje si se recibe POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['mensaje'])) {
        $chatModel->enviarMensaje($ticket_id, $_SESSION['usuario_id'], trim($_POST['mensaje']));
    }

    $mensajes = $chatModel->obtenerMensajesPorTicket($ticket_id);
    $chatModel->marcarLeido($ticket_id, $_SESSION['usuario_id']);

    require_once __DIR__ . '/../views/tecnico/chat.php';
}

}
