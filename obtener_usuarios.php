<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include 'conexion.php';

$result = $conn->query("SELECT id, nombre FROM usuarios");
$usuarios = [];

while ($row = $result->fetch_assoc()) {
    $usuarios[] = [
        'id' => (int)$row['id'],   // forzamos entero
        'nombre' => $row['nombre']
    ];
}

echo json_encode($usuarios);
$conn->close();
?>