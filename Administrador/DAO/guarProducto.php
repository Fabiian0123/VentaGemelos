<?php
include '../conexion.php';

// Recoger los datos del formulario
$codigo_producto = $_POST['codigo_producto'];
$nombre_producto = $_POST['nombre_producto'];
$marca_producto = $_POST['marca_producto'];
$precio_producto = $_POST['precio_producto'];
$socio = $_POST['socio'];
$cantidad_producto = $_POST['cantidad_producto'];

// Preparar la consulta SQL
$sql = "INSERT INTO addproductos (codProducto, nombProducto, marcProducto, precProducto, socio) VALUES (?, ?, ?, ?, ?)";

// Preparar la declaración
$stmt = $conn->prepare($sql);

// Vincular los parámetros con la cadena de definición de tipos 'sssd'
$stmt->bind_param('ssssd', $codigo_producto, $nombre_producto, $marca_producto, $precio_producto, $socio);

// Verificar errores en la preparación de la sentencia
if ($stmt->error) {
    die('Error en la preparación de la sentencia: ' . $stmt->error);
}

// Ejecutar la declaración tantas veces como la cantidad especificada
for ($i = 0; $i < $cantidad_producto; $i++) {
    // Vincular el parámetro 'socio' en cada iteración
    $stmt->bind_param('sssds', $codigo_producto, $nombre_producto, $marca_producto, $precio_producto, $socio);

    if ($stmt->execute()) {
        echo "Producto " . ($i + 1) . " guardado exitosamente<br>";
    } else {
        echo "Error al guardar producto " . ($i + 1) . ": " . $stmt->error . "<br>";
    }
}

// Cerrar la sentencia preparada y la conexión
$stmt->close();
$conn->close();
?>
