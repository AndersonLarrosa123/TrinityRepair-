<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController {

    // Mostrar login
    public function mostrarLogin() {
        require __DIR__ . '/../views/usuario/login.php';
    }

    // Mostrar registro
    public function registro() {
        require __DIR__ . '/../views/usuario/registro.php';
    }

    // Guardar registro
    public function guardar($admin = false) {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nombre = trim($_POST['nombre'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $rol_id = $_POST['rol_id'] ?? 3; // Cliente por defecto

            if ($nombre && $email && $password) {
                $usuario = new Usuario();
                $exito = $usuario->registrar($nombre, $email, $password, $rol_id);

                if ($exito) {
                    if (!$admin) {
                        // Registro público: iniciar sesión
                        $_SESSION['usuario_id'] = $usuario->getLastInsertId();
                        $_SESSION['usuario_nombre'] = $nombre;
                        $_SESSION['usuario_email'] = $email;
                        $_SESSION['rol_id'] = $rol_id;
                        $_SESSION['usuario_foto'] = 'public/img/default-avatar.png';

                        header('Location: index.php?controller=cliente&action=dashboard');
                        exit;
                    } else {
                        $mensaje_exito = "✅ Usuario creado con éxito.";
                        require __DIR__ . '/../views/admin/registro_usuario.php';
                        exit;
                    }
                } else {
                    $mensaje_error = "❌ Error al registrar usuario.";
                    $view = $admin ? __DIR__ . '/../views/admin/registro_usuario.php' : __DIR__ . '/../views/usuario/registro.php';
                    require $view;
                    exit;
                }
            } else {
                $mensaje_error = "⚠️ Faltan datos obligatorios.";
                $view = $admin ? __DIR__ . '/../views/admin/registro_usuario.php' : __DIR__ . '/../views/usuario/registro.php';
                require $view;
                exit;
            }
        }
    }

    // Procesar login
    public function procesarLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($email && $password) {
                $usuarioModel = new Usuario();
                $usuario = $usuarioModel->login($email, $password);

                if ($usuario) {
                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['usuario_nombre'] = $usuario['nombre'];
                    $_SESSION['usuario_email'] = $usuario['email'];
                    $_SESSION['rol_id'] = $usuario['rol_id'];
                    $_SESSION['usuario_foto'] = $usuario['foto'] ?? 'public/img/default-avatar.png';

                    // Redirección según rol
                    switch ($usuario['rol_id']) {
                        case 1: header('Location: index.php?controller=admin&action=dashboard'); break;
                        case 2: header('Location: index.php?controller=tecnico&action=dashboard'); break;
                        case 3: header('Location: index.php?controller=cliente&action=dashboard'); break;
                        case 4: header('Location: index.php?controller=supervisor&action=dashboard'); break;
                        default: header('Location: index.php'); break;
                    }
                    exit;
                } else {
                    $mensaje_error = "❌ Email o contraseña incorrectos.";
                    require __DIR__ . '/../views/usuario/login.php';
                    exit;
                }
            } else {
                $mensaje_error = "⚠️ Debes ingresar email y contraseña.";
                require __DIR__ . '/../views/usuario/login.php';
                exit;
            }
        }
    }

    // Logout
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
