<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Obtener controlador y acción desde URL, con valores por defecto
$controllerName = isset($_GET['controller']) ? strtolower($_GET['controller']) : 'usuario';
$actionName = isset($_GET['action']) ? $_GET['action'] : 'mostrarLogin';

// Construir ruta y nombre de clase del controlador
$controllerFile = __DIR__ . '/controllers/' . ucfirst($controllerName) . 'Controller.php';
$controllerClass = ucfirst($controllerName) . 'Controller';

// Verificar que el archivo del controlador exista
if (!file_exists($controllerFile)) {
    die("Controlador '$controllerName' no encontrado en '$controllerFile'.");
}

// Incluir archivo del controlador
require_once $controllerFile;

// Verificar que la clase exista
if (!class_exists($controllerClass)) {
    die("Clase controlador '$controllerClass' no encontrada.");
}

// Instanciar controlador
$controller = new $controllerClass();

// **Permitir método POST para logout**
if ($controllerName === 'admin' && $actionName === 'logout' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Método no permitido para logout.");
}

// Verificar que el método (acción) exista
if (!method_exists($controller, $actionName)) {
    die("Acción '$actionName' no encontrada en controlador '$controllerClass'.");
}

// Ejecutar acción
$controller->$actionName();
