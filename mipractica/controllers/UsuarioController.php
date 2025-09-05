<?php
class UsuarioController {

    // Mostrar formulario de login
    public function mostrarLogin() {
        require_once __DIR__ . '/../views/usuario/login.php';
    }

    // Mostrar formulario de registro
    public function registro() {
        require_once __DIR__ . '/../views/usuario/registro.php';
    }

    // Procesar registro (guardar nuevo usuario)
    public function guardar() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nombre = $_POST['nombre'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Por defecto rol cliente (3)
            $rol_id = 3;

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Si el usuario logueado es admin y envía rol_id, usar ese valor
            if (isset($_SESSION['rol_id']) && $_SESSION['rol_id'] == 1 && isset($_POST['rol_id'])) {
                $rol_id = (int) $_POST['rol_id'];
            }

            if ($nombre && $email && $password) {
                require_once __DIR__ . '/../models/Usuario.php';
                $usuario = new Usuario();

                if ($usuario->registrar($nombre, $email, $password, $rol_id)) {
                    if ($rol_id == 3) {
                        // Registro público: redirigir a login
                        header('Location: index.php?controller=usuario&action=mostrarLogin');
                        exit;
                    } else {
                        // Registro admin: mostrar mensaje y redirigir a dashboard admin
                        $_SESSION['mensaje'] = "Usuario registrado con éxito.";
                        header('Location: index.php?controller=admin&action=dashboard');
                        exit;
                    }
                } else {
                    echo "Error al registrar usuario.";
                }
            } else {
                echo "Faltan datos obligatorios.";
            }
        } else {
            echo "Método no permitido.";
        }
    }

    // Procesar login
    public function procesarLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($email && $password) {
                require_once __DIR__ . '/../models/Usuario.php';
                $usuarioModel = new Usuario();

                $usuario = $usuarioModel->login($email, $password);

                if ($usuario) {
                    session_start();
                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['usuario_nombre'] = $usuario['nombre'];
                    $_SESSION['rol_id'] = $usuario['rol_id'];

                    switch ($usuario['rol_id']) {
                        case 1:
                            header('Location: index.php?controller=admin&action=dashboard');
                            break;
                        case 2:
                            header('Location: index.php?controller=tecnico&action=dashboard');
                            break;
                        case 3:
                            header('Location: index.php?controller=cliente&action=dashboard');
                            break;
                        case 4:
                            header('Location: index.php?controller=supervisor&action=dashboard');
                            break;
                        default:
                            header('Location: index.php');
                            break;
                    }
                    exit;
                } else {
                    echo "Email o contraseña incorrectos.";
                }
            } else {
                echo "Complete todos los campos.";
            }
        } else {
            echo "Método no permitido.";
        }
    }
}
