<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json; charset=UTF-8'); // Respuesta en JSON con UTF-8

// Datos de conexión a la base de datos (FreeHostia)
$servername = "sql100.infinityfree.com"; 
$username = "if0_38413801"; 
$password = "Ch3m1c4Ltnt"; 
$dbname = "if0_38413801_db_baqg"; 

// Conectar a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Error de conexión: " . $conn->connect_error]);
    exit();
}

// Asegurarse de que la conexión está usando el charset correcto
$conn->set_charset("utf8mb4");

// Recibir datos del formulario
$id_persona  = trim($_POST['idNumber'] ?? '');
$nombres     = trim($_POST['firstName'] ?? '');
$apellidos   = trim($_POST['lastName'] ?? '');
$email       = trim($_POST['email'] ?? '');
$celular     = trim($_POST['phone'] ?? '');
$direccion   = trim($_POST['address'] ?? '');
$codigo_uni  = trim($_POST['universityCode'] ?? '');
$contrasena  = $_POST['password'] ?? '';

// Validación de campos vacíos
if (empty($id_persona) || empty($nombres) || empty($apellidos) || empty($email) || empty($celular) || empty($direccion) || empty($codigo_uni) || empty($contrasena)) {
    echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios."]);
    exit();
}

// Encriptar contraseña
$contrasena = password_hash(trim($contrasena), PASSWORD_BCRYPT);

// Verificar si el usuario ya existe
$checkQuery = $conn->prepare("SELECT id_persona FROM persona WHERE id_persona = ?");
$checkQuery->bind_param("s", $id_persona);
$checkQuery->execute();
$checkQuery->store_result();

if ($checkQuery->num_rows > 0) {
    $checkQuery->close();
    $conn->close();
    echo json_encode(["status" => "error", "message" => "El usuario ya está registrado."]);
    exit();
}
$checkQuery->close();

// Insertar datos en la base de datos
$sql = $conn->prepare("INSERT INTO persona (id_persona, nombres, apellidos, email, celular, direccion, cod_universidad, contraseña) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$sql->bind_param("ssssssss", $id_persona, $nombres, $apellidos, $email, $celular, $direccion, $codigo_uni, $contrasena);

if ($sql->execute()) {
    echo json_encode(["status" => "success", "message" => "Registro exitoso"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error al registrar: " . $sql->error]);
}

$sql->close();
$conn->close();
?>
