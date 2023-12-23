<!DOCTYPE html>
<html lang="en">

<?php include '../head.php'; ?>

<body>
    <?php include '../nav.php'; ?>
    <div>
        <h2>Informe de Suma de Precios por Socio en la tabla addproductos</h2>
        <?php
        // Incluir el archivo de conexión
        include '../conexion.php';

        // Consultar la base de datos para obtener la suma de precios por socio en la tabla addproductos
        $consulta = "SELECT socio, SUM(precProducto) as totalPrecio FROM addproductos GROUP BY socio";

        $resultado = $conn->query($consulta);

        // Mostrar los datos en una tabla
        echo "<table border='1' class='tablaInforme'>
                <tr>
                    <th>Socio</th>
                    <th>&nbsp&nbsp&nbspSaldo del dia</th>
                </tr>";

        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>
                    <td>{$fila['socio']}</td>
                    <td>&nbsp&nbsp&nbsp{$fila['totalPrecio']}</td>
                  </tr>";
        }

        echo "</table>";

        // Cerrar la conexión
        $conn->close();
        ?>
    </div>
</body>

</html>

