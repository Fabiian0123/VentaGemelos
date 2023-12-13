<?php
include '../conexion.php'; // Incluye el archivo de conexión

// Verifica si se reciben los datos del cliente
if (isset($_POST['nombre_cliente']) && isset($_POST['numero_celular'])) {
    // Obtén los datos del cliente
    $nombreCliente = $_POST['nombre_cliente'];
    $numeroCelular = $_POST['numero_celular'];

    // Prepara la consulta SQL para insertar el cliente en la base de datos
    $sql = "INSERT INTO clientes (nombreCliente, numeroCelular) VALUES ('$nombreCliente', '$numeroCelular')";

    // Ejecuta la consulta
    if ($conn->query($sql) === TRUE) {
        echo "Cliente guardado exitosamente.";
    } else {
        echo "Error al guardar el cliente: " . $conn->error;
    }
} else {
    echo "Datos del cliente no recibidos.";
}

// Cierra la conexión
$conn->close();

?>
