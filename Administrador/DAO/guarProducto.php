<?php
include '../conexion.php';

// Recoger los datos del formulario
$codigo_producto = $_POST['codigo_producto'];
$nombre_producto = $_POST['nombre_producto'];
$marca_producto = $_POST['marca_producto'];
$precio_producto = $_POST['precio_producto'];
$socio = $_POST['socio'];
$cantidad_producto = $_POST['cantidad_producto'];
$precio_compra = $_POST['precio_compra'];
$precio_entrada = $_POST['precio_entrada'];

// Preparar la consulta SQL
$sql = "INSERT INTO addproductos (codProducto, nombProducto, marcProducto, precProducto, socio, precCompra, precEntrada) VALUES (?, ?, ?, ?, ?, ?,?)";

// Preparar la declaración
$stmt = $conn->prepare($sql);

// Vincular los parámetros con la cadena de definición de tipos 'sssd'
$stmt->bind_param('ssssdss', $codigo_producto, $nombre_producto, $marca_producto, $precio_producto, $socio, $precio_compra, $precio_entrada);

// Verificar errores en la preparación de la sentencia
if ($stmt->error) {
    die('Error en la preparación de la sentencia: ' . $stmt->error);
}

// Bandera para verificar si hubo algún error durante la ejecución
$errores = false;

// Ejecutar la declaración tantas veces como la cantidad especificada
for ($i = 0; $i < $cantidad_producto; $i++) {
    // Vincular el parámetro 'socio' en cada iteración
    $stmt->bind_param('sssdsss', $codigo_producto, $nombre_producto, $marca_producto, $precio_producto, $socio, $precio_compra, $precio_entrada);

    if (!$stmt->execute()) {
        echo "Error al guardar producto " . ($i + 1) . ": " . $stmt->error . "<br>";
        $errores = true;
    }
}

// Cerrar la sentencia preparada y la conexión
$stmt->close();
$conn->close();

// Mostrar alerta si no hubo errores
if (!$errores) {
    echo "<script>alert('Productos guardados exitosamente');window.location.href = '/Administrador/pages/AddProductos.php';</script>";
}
?>

