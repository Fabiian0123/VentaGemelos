<!DOCTYPE html>
<html lang="en">

<?php include '../head.php'; ?>

<body class="fondoInforme">
    <?php include '../nav.php'; ?>
    <div>
        <center><h2>Informe de ventas diarias por socio</h2></center>
        <?php
// Incluir el archivo de conexión
include '../conexion.php';
// Consultar la base de datos para obtener la suma de precios y precCompra por socio en la tabla addproductos
$consulta = "SELECT socio, SUM(precProducto) as totalPrecio, SUM(precCompra) as totalCompra, SUM(precEntrada) as totalEntrada FROM addproductos GROUP BY socio";
$resultado = $conn->query($consulta);
// Mostrar los datos en una tabla
echo "<table border='1' class='tablaInforme'>
        <tr>
            <th>&nbspSocio</th>
            <th> &nbspSaldo del día</th>
            <th> &nbspVenta del día</th>
            <th> &nbspGanancia total</th>
            <th> &nbspGanancia del dia</th>
            <th> &nbspPrecio de entrada</th>
        </tr>";
while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>
            <td> {$fila['socio']}</td>
            <td>  {$fila['totalPrecio']}</td>";
    // Obtener el saldo inicial actual de la tabla saldos
    $socioInfo = $fila['socio'];
    $consultaSaldoInicial = "SELECT saldoInicial, saldoFinal FROM saldos WHERE socioInfo = '{$socioInfo}'";
    $resultadoSaldoInicial = $conn->query($consultaSaldoInicial);
    $filaSaldoInicial = $resultadoSaldoInicial->fetch_assoc();
    $saldoInicial = $filaSaldoInicial['saldoInicial'];
    // Calcular la venta del día si no existe en la base de datos
    if (isset($filaSaldoInicial['saldoFinal'])) {
        $ventaDia = $filaSaldoInicial['saldoFinal'] + ($saldoInicial - $fila['totalPrecio']);
    } else {
        $ventaDia = $saldoInicial - $fila['totalPrecio'];
    }
    // Mostrar la venta del día y la ganancia total en la tabla
    echo "<td>  {$ventaDia}</td>
          <td>  {$fila['totalCompra']}</td>";
    // Consultar la ganancia total anterior de la tabla saldos
    $consultaGananciaTotalAnterior = "SELECT saldoInGal, ganDia FROM saldos WHERE socioInfo = '{$socioInfo}'";
    $resultadoGananciaTotalAnterior = $conn->query($consultaGananciaTotalAnterior);
    $filaGananciaTotalAnterior = $resultadoGananciaTotalAnterior->fetch_assoc();
    $gananciaTotalAnterior = $filaGananciaTotalAnterior['saldoInGal'];
    // Calcular la ganancia del día si no existe en la base de datos
    if (isset($filaGananciaTotalAnterior['ganDia'])) {
        $gananciaDia = $filaGananciaTotalAnterior['ganDia'] + ($gananciaTotalAnterior - $fila['totalCompra']);
    } else {
        $gananciaDia = $gananciaTotalAnterior - $fila['totalCompra'];
    }
    // Mostrar la ganancia del día en la tabla
    echo "<td>  {$gananciaDia}</td>
            <td>&nbsp&nbsp{$fila['totalEntrada']}</td>
          </tr>";
    // Calcular el saldo final
    $saldoFinal = $saldoInicial - $fila['totalPrecio'];
    // Actualizar o insertar la información en la tabla saldos
    $actualizarSaldos = "INSERT INTO saldos (socioInfo, saldoInicial, saldoFinal, saldoInGal, ganDia)
                        VALUES ('{$socioInfo}', '{$fila['totalPrecio']}', '{$ventaDia}', '{$fila['totalCompra']}', '{$gananciaDia}')
                        ON DUPLICATE KEY UPDATE saldoInicial = '{$fila['totalPrecio']}', saldoFinal = '{$ventaDia}', saldoInGal = '{$fila['totalCompra']}', ganDia = '{$gananciaDia}'";
    $conn->query($actualizarSaldos);
    // Verificar si se hizo clic en el botón de restablecer
    if (isset($_POST['resetColumns'])) {
    // Consultar para restablecer las columnas ganDia y saldoFinal a cero
    $resetQuery = "UPDATE saldos SET ganDia = 0, saldoFinal = 0";
    $conn->query($resetQuery);
    
}


}
echo "</table>";
// Cerrar la conexión
$conn->close();
?>  
<form method="post" id="myForm">
    <input type="submit" name="reset" value="Generar Informe" class="btn btn-success m-2">
</form>

</div>

<!-- Botón para restablecer las columnas ganDia y saldoFinal a cero -->
<form method="post" id="resetForm">
    <input type="submit" name="resetColumns" value="Restablecer Informe" id="resetColumnsBtn" class="btn btn-danger m-2" disabled>
</form>

<!-- Include the html2pdf library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    // Get the form element
    var form = document.getElementById('myForm');
    // Get the form elements
    var resetColumnsBtn = document.getElementById('resetColumnsBtn');

    form.addEventListener('submit', function (e) {
    e.preventDefault();
    
    // Crear un nuevo elemento div para el título
    var titleDiv = document.createElement('div');
    
    titleDiv.innerHTML = '<h4>Informe Diario de Ventas y Ganancias por Socios</h4>';
    titleDiv.style.textAlign = 'center';
    titleDiv.style.marginBottom = '20px';

    // Obtener el elemento HTML que deseas convertir a PDF
    var element = document.querySelector('.tablaInforme');

    // Crear un contenedor para el título y la tabla
    var container = document.createElement('div');
    container.appendChild(titleDiv);
    container.appendChild(element.cloneNode(true));

    // Obtener la fecha y hora actual
    var currentDate = new Date();
    var formattedDate = currentDate.getDate() + "." + (currentDate.getMonth() + 1) + "." + currentDate.getFullYear();
    var formattedTime = currentDate.getHours() + ';' + currentDate.getMinutes() + ';' + currentDate.getSeconds();
    var fileName = 'informe_' + formattedDate + '_' + formattedTime + '.pdf';

    // Usar html2pdf para convertir el contenedor y guardar con el nombre de archivo generado
    html2pdf().from(container).save(fileName);

    // Habilitar el botón resetColumns después de generar el informe
    resetColumnsBtn.removeAttribute('disabled');
});

</script>
</body>
</html>







