<?php
header('Content-Type: application/json; charset=utf-8');
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombres = trim($_POST['nombres'] ?? '');
    $apellidos = trim($_POST['apellidos'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');

    if (empty($nombres) || empty($apellidos) || empty($correo) || empty($telefono) || empty($mensaje)) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
        exit;
    }

    $stmt = $conexion->prepare("INSERT INTO contactos (nombres, apellidos, correo, telefono, mensaje) VALUES (?, ?, ?, ?, ?)");
    
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta: ' . $conexion->error]);
        exit;
    }

    $stmt->bind_param("sssss", $nombres, $apellidos, $correo, $telefono, $mensaje);
    $resultado = $stmt->execute();

    if ($resultado) {
        echo json_encode(['success' => true, 'message' => '¡Mensaje enviado correctamente!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al guardar los datos: ' . $stmt->error]);
    }

    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>
