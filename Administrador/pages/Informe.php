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
                    <th>&nbsp&nbspSocio</th>
                    <th>&nbsp&nbspSaldo del día</th>
                    <th>&nbsp&nbspVenta del día</th>
                </tr>";

        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>
                    <td>&nbsp&nbsp{$fila['socio']}</td>
                    <td>&nbsp&nbsp{$fila['totalPrecio']}</td>";

            // Obtener el saldo inicial actual de la tabla saldos
            $socioInfo = $fila['socio'];
            $consultaSaldoInicial = "SELECT saldoInicial FROM saldos WHERE socioInfo = '{$socioInfo}'";
            $resultadoSaldoInicial = $conn->query($consultaSaldoInicial);
            $filaSaldoInicial = $resultadoSaldoInicial->fetch_assoc();
            $saldoInicial = $filaSaldoInicial['saldoInicial'];

            // Calcular la venta del día
            $ventaDia = $saldoInicial - $fila['totalPrecio'];

            // Mostrar la venta del día en la tabla
            echo "<td>&nbsp&nbsp{$ventaDia}</td>
                  </tr>";

            // Calcular el saldo final
            $saldoFinal = $saldoInicial - $fila['totalPrecio'];

            // Actualizar o insertar la información en la tabla saldos
            $actualizarSaldos = "INSERT INTO saldos (socioInfo, saldoInicial, saldoFinal)
                                VALUES ('{$socioInfo}', '{$fila['totalPrecio']}', '{$saldoFinal}')
                                ON DUPLICATE KEY UPDATE saldoInicial = '{$fila['totalPrecio']}', saldoFinal = '{$saldoFinal}'";

            $conn->query($actualizarSaldos);
        }

        echo "</table>";

        // Cerrar la conexión
        $conn->close();
        ?>
    </div>
</body>
</html>









