<?php
include '../conexion.php';

if (isset($_POST['nombreSocio'])) {
    $nombreSocio = $_POST['nombreSocio'];

    // Preparar la consulta SQL para insertar el nuevo socio en la tabla "socio"
    $sql = "INSERT INTO socios (nombSocio) VALUES (?)";

    // Preparar la declaración
    $stmt = $conn->prepare($sql);

    // Vincular el parámetro con la cadena de definición de tipo 's'
    $stmt->bind_param('s', $nombreSocio);

    // Ejecutar la declaración
    if ($stmt->execute()) {
        // Si la inserción es exitosa, puedes responder con un mensaje de éxito
        echo "Socio guardado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
    // Manejar el caso en el que no se proporcionó el nombre del socio
    echo "nombre del socio no proporcionado";
}
?>
