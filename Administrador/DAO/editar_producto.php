<?php
include '../conexion.php';

// Obtén los datos del formulario
$codProducto = $_POST['codProducto'];
$nombProducto = $_POST['nombProducto'];
$marcProducto = $_POST['marcProducto'];
$precProducto = $_POST['precProducto'];
$precCompra = $_POST['precCompra'];

// Prepara la consulta SQL para actualizar el producto
$sql = "UPDATE addproductos SET nombProducto = ?, marcProducto = ?, precProducto = ?, precCompra = ? WHERE codProducto = ?";

// Prepara la declaración
$stmt = $conn->prepare($sql);

// Vincula los parámetros
$stmt->bind_param("ssdds", $nombProducto, $marcProducto, $precProducto, $precCompra, $codProducto);

// Ejecuta la declaración
if ($stmt->execute()) {
    echo "Producto actualizado con éxito";
} else {
    echo "Error: " . $stmt->error;
}

// Cierra la declaración y la conexión
$stmt->close();
$conn->close();
?>
