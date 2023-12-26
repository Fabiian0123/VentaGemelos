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
                    <th>  &nbspSaldo del día</th>
                    <th>  &nbspVenta del dia</th>
                </tr>";

        while ($fila = $resultado->fetch_assoc()) {
            // Consultar la base de datos para obtener el saldo inicial del día
            $consultaSaldoInicial = "SELECT saldoInicial FROM saldos WHERE socioInfo = '{$fila['socio']}'";
            $resultadoSaldoInicial = $conn->query($consultaSaldoInicial);

            // Inicializar la variable para almacenar el saldo inicial
            $saldoInicial = 0;

            // Check if the query returned any results
            if ($resultadoSaldoInicial->num_rows > 0) {
                $filaSaldoInicial = $resultadoSaldoInicial->fetch_assoc();

                // Almacenar el saldo inicial en la variable
                $saldoInicial = $filaSaldoInicial['saldoInicial'];
            }

            // Calcular la venta del día
            $ventaDelDia = $saldoInicial - $fila['totalPrecio'];

            echo "<tr>
                    <td>{$fila['socio']}</td>
                    <td>   {$fila['totalPrecio']}</td>
                    <td>   {$ventaDelDia}</td>
                  </tr>";

            // Actualizar o insertar el saldo inicial en la tabla saldos
            $actualizarSaldo = "REPLACE INTO saldos (socioInfo, saldoInicial) VALUES ('{$fila['socio']}', '{$saldoInicial}')";
            $conn->query($actualizarSaldo);
        }

        echo "</table>";

        // Cerrar la conexión
        $conn->close();
        ?>
    </div>
</body>

</html>



















