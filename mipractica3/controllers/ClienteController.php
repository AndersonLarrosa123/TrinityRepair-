<?php
require_once "models/Ticket.php";

class ClienteController {

    public function dashboard() {
        require_once "views/cliente/dashboard.php";
    }

    public function servicios() {
        require_once "views/cliente/servicios.php";
    }

    public function chequeo() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?controller=usuario&action=mostrarLogin');
            exit;
        }

        $ticketModel = new Ticket();
        $id_cliente = $_SESSION['usuario_id'];
        $tickets = $ticketModel->listar($id_cliente);

        // Cancelar ticket
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_ticket'])) {
            $ticket_id = $_POST['cancel_ticket'];
            $ticketModel->cambiarEstado($ticket_id, 'Cancelado');
            header('Location: index.php?controller=cliente&action=chequeo');
            exit;
        }

        require_once "views/cliente/chequeo.php";
    }

    public function consulta() {
        require_once "views/cliente/consulta.php";
    }

    public function locales() {
        require_once "views/cliente/local.php";
    }

    public function cursos() {
        require_once "views/cliente/cursos.php";
    }

    public function clientes() {
        require_once "views/cliente/experienciaclientes.php";
    }
}
?>
