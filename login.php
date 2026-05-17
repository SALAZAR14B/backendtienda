<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization, Accept");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

// Habilitar errores para depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

$nombre = $data['nombre'] ?? '';
$password = $data['password'] ?? '';

if (!$nombre || !$password) {
    echo json_encode(["success" => false, "mensaje" => "Faltan datos"]);
    exit;
}

$stmt = $conn->prepare("SELECT id, nombre, password FROM usuarios WHERE nombre = ?");
$stmt->bind_param("s", $nombre);
$stmt->execute();

/* 🔥 CAMBIO IMPORTANTE: NO get_result() */
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo json_encode(["success" => false, "mensaje" => "Usuario no encontrado"]);
    exit;
}

$stmt->bind_result($id, $db_nombre, $db_password);
$stmt->fetch();

if (password_verify($password, $db_password)) {
    echo json_encode([
        "success" => true,
        "mensaje" => "Inicio de sesión correcto",
        "usuario" => [
            "id" => $id,
            "nombre" => $db_nombre
        ]
    ]);
} else {
    echo json_encode(["success" => false, "mensaje" => "Contraseña incorrecta"]);
}

$stmt->close();
$conn->close();
?>