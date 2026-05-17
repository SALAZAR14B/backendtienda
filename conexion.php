<?php
$servername = "sql313.infinityfree.com";  // normalmente localhost
$username = "if0_41853790";         // tu usuario MySQL
$password = "RC6huSM6IVPLFWC";             // tu contraseña MySQL
$dbname = "if0_41853790_tienda";         // tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>