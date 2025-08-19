<?php
$host = '127.0.0.1';
$dbname = 'trinity_repair_test';
$user = 'root';
$pass = '';

try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>
