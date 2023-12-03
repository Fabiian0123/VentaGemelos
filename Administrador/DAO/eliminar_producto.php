<?php
include '../conexion.php';

if (isset($_POST['codigo_producto'])) {
    $codigo_producto = $_POST['codigo_producto'];

    // Preparar la consulta SQL para eliminar el producto
    $sql = "DELETE FROM addproductos WHERE codProducto = ? LIMIT 1";
    
    // Preparar la declaración
    $stmt = $conn->prepare($sql);

    // Vincular los parámetros con la cadena de definición de tipos 's' (cadena)
    $stmt->bind_param('s', $codigo_producto);

    // Verificar errores en la preparación de la sentencia
    if ($stmt->error) {
        die('Error en la preparación de la sentencia: ' . $stmt->error);
    }

    // Ejecutar la declaración
    if ($stmt->execute()) {
        echo "Producto eliminado exitosamente";
    } else {
        echo "Error al eliminar el producto: " . $stmt->error;
    }

    // Cerrar la sentencia preparada y la conexión
    $stmt->close();
    $conn->close();
} else {
    echo "No se proporcionó el código del producto.";
}
?>
