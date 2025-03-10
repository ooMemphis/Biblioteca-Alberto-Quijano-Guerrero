<?php
$servername = "sql100.infinityfree.com"; 
$username = "if0_38413801"; 
$password = "Ch3m1c4Ltnt"; 
$dbname = "if0_38413801_db_baqg";

// Conectar a la base de datos
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Conexión fallida: " . $conn->connect_error]));
}
?>
