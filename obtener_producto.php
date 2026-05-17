<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include 'conexion.php';

$result = $conn->query("SELECT id, codigo, nombre, precio FROM productos");
$productos = [];

while ($row = $result->fetch_assoc()) {
    $productos[] = [
        'id' => (int)$row['id'],              // forzamos entero
        'codigo' => $row['codigo'],
        'nombre' => $row['nombre'],
        'precio' => (float)$row['precio']     // forzamos número
    ];
}

echo json_encode($productos);
$conn->close();
?>