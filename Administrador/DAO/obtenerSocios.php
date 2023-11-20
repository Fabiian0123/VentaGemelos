<?php
include '../conexion.php';

// Realiza una consulta para obtener la lista de socios
$query = "SELECT nombSocio FROM socios";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($row['nombSocio']) . '">' . htmlspecialchars($row['nombSocio']) . '</option>';
    }
}

// Cierra la conexión
$conn->close();
?>
