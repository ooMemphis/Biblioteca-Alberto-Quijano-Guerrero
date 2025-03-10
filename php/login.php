<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json; charset=UTF-8');

// Datos de conexión a la base de datos
$servername = "sql100.infinityfree.com";
$username = "if0_38413801";
$password = "Ch3m1c4Ltnt";
$dbname = "if0_38413801_db_baqg";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Error de conexión: " . $conn->connect_error]);
    exit();
}

// Asegurarse de que la conexión está usando el charset correcto
$conn->set_charset("utf8mb4");

// Recibir datos del formulario
$codigo_uni = trim($_POST['universityCode'] ?? '');
$contrasena = $_POST['password'] ?? '';
$tipo_usuario = $_POST['userType'] ?? '';

if (empty($codigo_uni) || empty($contrasena) || empty($tipo_usuario)) {
    echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios."]);
    exit();
}

// Verificar usuario en la base de datos
$sql = $conn->prepare("SELECT cod_universidad, contraseña, tipo FROM persona WHERE cod_universidad = ? AND tipo = ?");
$sql->bind_param("ss", $codigo_uni, $tipo_usuario);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Depuración
    error_log("Contraseña ingresada: " . $contrasena);
    error_log("Contraseña almacenada: " . $user['contraseña']);

    // Verificar la contraseña encriptada
    if (password_verify($contrasena, $user['contraseña'])) {
        $_SESSION['user'] = $codigo_uni;
        $_SESSION['userType'] = $tipo_usuario;

        echo json_encode(["status" => "success", "message" => "Inicio de sesión exitoso", "redirect" => ($tipo_usuario == "admin") ? "admin.html" : "user.html"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Contraseña incorrecta."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Usuario no encontrado o tipo incorrecto."]);
}

$sql->close();
$conn->close();
?>
