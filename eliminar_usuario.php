<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include 'conexion.php';

// Obtener los datos enviados por Angular en JSON
$input = file_get_contents('php://input');
$data = json_decode($input, true);

$nombre = $data['nombre'] ?? '';

if (!$nombre) {
    echo json_encode(["success" => false, "mensaje" => "Falta el nombre del usuario"]);
    exit;
}

// Preparar la consulta de eliminación
$stmt = $conn->prepare("DELETE FROM usuarios WHERE nombre = ?");
if (!$stmt) {
    echo json_encode(["success" => false, "mensaje" => "Error en preparación de consulta: " . $conn->error]);
    exit;
}

$stmt->bind_param("s", $nombre);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true, "mensaje" => "Usuario eliminado correctamente"]);
    } else {
        echo json_encode(["success" => false, "mensaje" => "No se encontró un usuario con ese nombre"]);
    }
} else {
    echo json_encode(["success" => false, "mensaje" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>