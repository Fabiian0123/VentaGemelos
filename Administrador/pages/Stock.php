<!DOCTYPE html>
<html lang="en">

<?php include '../head.php';?>

<body>
    <?php include '../nav.php'; ?>

    <?php
    include '../conexion.php';

    // Obtener la lista de socios
    $query_socios = "SELECT idSocio, nombSocio FROM socios";
    $result_socios = $conn->query($query_socios);

    if ($result_socios->num_rows > 0) {
        while ($row_socios = $result_socios->fetch_assoc()) {
            $idSocio = $row_socios['idSocio'];
            $nombSocio = $row_socios['nombSocio'];

            // Obtener los artículos asociados a este socio
            $query_articulos = "SELECT codProducto, nombProducto, marcProducto, precProducto FROM addproductos WHERE socio = '$nombSocio'";
            $result_articulos = $conn->query($query_articulos);

            // Mostrar la tabla solo si hay artículos asociados al socio
            if ($result_articulos->num_rows > 0) {
                echo "<h2>Artículos de $nombSocio</h2>";
                echo "<table border='1'>";
                echo "<tr><th>Código</th><th>Nombre</th><th>Marca</th><th>Precio</th></tr>";

                while ($row_articulos = $result_articulos->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row_articulos['codProducto'] . "</td>";
                    echo "<td>" . $row_articulos['nombProducto'] . "</td>";
                    echo "<td>" . $row_articulos['marcProducto'] . "</td>";
                    echo "<td>" . $row_articulos['precProducto'] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            }
        }
    } else {
        echo "No hay socios registrados.";
    }

    // Cierra la conexión
    $conn->close();
    ?>
    
</body>

</html>
