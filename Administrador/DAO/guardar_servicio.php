<?php
include '../conexion.php';

// Obtener los datos del formulario
$descripcion_servicio = $_POST['descripcion_servicio'];
$precio_servicio = $_POST['precio_servicio'];

// Preparar la consulta SQL
$sql = "INSERT INTO servi (servicio, precServicio) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $descripcion_servicio, $precio_servicio);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo "Nuevo registro creado exitosamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
