<?php
class ClienteController {

    public function dashboard() {
        require_once 'views/cliente/dashboard.php';
    }

    public function logout() {
        session_destroy();
        header("Location: index.php");
        exit();
    }
}
