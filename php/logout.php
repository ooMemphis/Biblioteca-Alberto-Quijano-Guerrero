<?php
session_start();
session_unset(); // Eliminar todas las variables de sesión
session_destroy(); // Destruir la sesión

echo json_encode(["status" => "success", "message" => "Sesión cerrada correctamente"]);
exit;
?>
