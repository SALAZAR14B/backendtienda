<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "sql313.infinityfree.com";
$username = "if0_41853790";
$password = "RC6huSM6IVPLFWC";
$dbname = "if0_41853790_tienda";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
} else {
    echo "¡Conexión OK!";
}
?>