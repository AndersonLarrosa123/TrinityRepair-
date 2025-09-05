<?php
class AdminController {

    public function dashboard() {
        $mensaje = $_SESSION['mensaje'] ?? null;
        unset($_SESSION['mensaje']);

        require_once __DIR__ . '/../views/admin/dashboard.php';
    }

    public function crearUsuario() {
        require_once __DIR__ . '/../models/Usuario.php';
        $usuarioModel = new Usuario();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $usuarioModel->registrar($_POST['nombre'], $_POST['email'], $_POST['password'], $_POST['rol_id']);

            $_SESSION['mensaje'] = $exito ? "Usuario creado correctamente." : "Error al crear el usuario.";
            header("Location: index.php?controller=admin&action=listarUsuarios");
            exit;
        } else {
            require_once __DIR__ . '/../views/admin/registro_usuario.php';
        }
    }

    public function listarUsuarios() {
        require_once __DIR__ . '/../models/Usuario.php';
        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->obtenerTodos();

        $mensaje = $_SESSION['mensaje'] ?? null;
        unset($_SESSION['mensaje']);

        require_once __DIR__ . '/../views/admin/lista_usuarios.php';
    }

    public function editarUsuario() {
        require_once __DIR__ . '/../models/Usuario.php';
        $usuarioModel = new Usuario();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $exito = $usuarioModel->actualizar($_POST['id'], $_POST['nombre'], $_POST['email'], $_POST['rol_id'], $_POST['estado']);
            $_SESSION['mensaje'] = $exito ? "Usuario actualizado correctamente." : "Error al actualizar el usuario.";
            header("Location: index.php?controller=admin&action=listarUsuarios");
            exit;
        } else {
            $usuario = $usuarioModel->obtenerPorId($_GET['id']);
            require_once __DIR__ . '/../views/admin/editar_usuario.php';
        }
    }

    public function eliminarUsuario() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            require_once __DIR__ . '/../models/Usuario.php';
            $usuarioModel = new Usuario();

            $exito = $usuarioModel->eliminar($id);
            $_SESSION['mensaje'] = $exito ? "Usuario eliminado correctamente." : "Error al eliminar el usuario.";
            header("Location: index.php?controller=admin&action=listarUsuarios");
            exit;
        } else {
            $_SESSION['mensaje'] = "ID de usuario no especificado.";
            header("Location: index.php?controller=admin&action=listarUsuarios");
            exit;
        }
    }

    public function logout() {
        session_destroy();
        header('Location: index.php?controller=usuario&action=mostrarLogin');
        exit;
    }
}
