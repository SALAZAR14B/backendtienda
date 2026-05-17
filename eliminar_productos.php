<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include 'conexion.php';

// Obtener los datos enviados por Angular en JSON
$input = file_get_contents('php://input');
$data = json_decode($input, true);

$codigo = $data['codigo'] ?? '';

if (!$codigo) {
    echo json_encode(["success" => false, "mensaje" => "Falta el código del producto"]);
    exit;
}

// Preparar la consulta de eliminación
$stmt = $conn->prepare("DELETE FROM productos WHERE codigo = ?");
if (!$stmt) {
    echo json_encode(["success" => false, "mensaje" => "Error en preparación de consulta: " . $conn->error]);
    exit;
}

$stmt->bind_param("s", $codigo);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true, "mensaje" => "Producto eliminado correctamente"]);
    } else {
        echo json_encode(["success" => false, "mensaje" => "No se encontró el producto con ese código"]);
    }
} else {
    echo json_encode(["success" => false, "mensaje" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>