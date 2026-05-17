<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, OPTIONS");

include 'conexion.php';

// Obtener los datos enviados por Angular en JSON
$input = file_get_contents('php://input');
$data = json_decode($input, true); // true para obtener array asociativo

$nombre = $data['nombre'] ?? '';
$password = $data['password'] ?? '';

if (!$nombre || !$password) {
    echo json_encode(["success"]);
    exit;
}

// Preparar consulta
$stmt = $conn->prepare("INSERT INTO usuarios (nombre, password) VALUES (?, ?)");
if (!$stmt) {
    echo json_encode(["success" => false, "mensaje" => "Error en preparación de consulta: " . $conn->error]);
    exit;
}

// Hashear la contraseña
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Enviar parámetros
$stmt->bind_param("ss", $nombre, $password_hash);

if($stmt->execute()){
    echo json_encode(["success" => true, "mensaje" => "Usuario agregado correctamente"]);
} else {
    echo json_encode(["success" => false, "mensaje" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>