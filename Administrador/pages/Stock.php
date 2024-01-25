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

            // Obtener todos los productos asociados a este socio
            $query_productos = "SELECT codProducto, nombProducto, marcProducto, precProducto, precCompra, COUNT(*) AS cantidad FROM addproductos WHERE socio = '$nombSocio' GROUP BY codProducto";
            $result_productos = $conn->query($query_productos);

            // Mostrar la tabla solo si hay productos asociados al socio
            if ($result_productos->num_rows > 0) {
                echo "<br><h4 style='margin-left: 10px;'>Artículos de: $nombSocio</h4>";
                echo "<table border='2' style='margin-left: 10px;'>";
                echo "<tr><th>#</th><th>&nbsp&nbspCódigo</th><th>&nbsp&nbspNombre</th><th>&nbsp&nbspMarca</th><th>&nbsp&nbspPrecio Venta</th><th>&nbsp&nbspPrecio Ganancia</th><th>&nbsp&nbspCantidad</th></tr>";

                $contador = 1;
                while ($row_producto = $result_productos->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>$contador</td>";
                    echo "<td>&nbsp&nbsp" . $row_producto['codProducto'] . "</td>";
                    echo "<td>&nbsp&nbsp" . $row_producto['nombProducto'] . "</td>";
                    echo "<td>&nbsp&nbsp" . $row_producto['marcProducto'] . "</td>";
                    echo "<td>&nbsp&nbsp" . $row_producto['precProducto'] . "</td>";
                    echo "<td>&nbsp&nbsp" . $row_producto['precCompra'] . "</td>";
                    echo "<td>&nbsp&nbsp" . $row_producto['cantidad'] . "</td>";
                    echo "</tr>";
                    $contador++;
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




