<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
include 'conexion.php';

// Obtener los datos enviados por Angular en JSON
$input = file_get_contents('php://input');
$data = json_decode($input, true); // true para obtener array asociativo

$codigo = $data['codigo'] ?? '';
$nombre = $data['nombre'] ?? '';
$precio = $data['precio'] ?? '';

if (!$codigo || !$nombre || !$precio) {
    echo json_encode(["success" => false, "mensaje" => "Faltan datos"]);
    exit;
}

$sql = "INSERT INTO productos (codigo, nombre, precio) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssd", $codigo, $nombre, $precio);

if($stmt->execute()){
    echo json_encode(["success" => true, "mensaje" => "Producto agregado"]);
} else {
    echo json_encode(["success" => false, "mensaje" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>