<!DOCTYPE html>
<html lang="en">

<?php include '../head.php'; ?>
<body>
    <?php include '../nav.php'; ?>
    <div>
        <center><h2>Informe de ventas diarias por socio</h2></center>
        <?php
        // Incluir el archivo de conexión
        include '../conexion.php';
        // Incluir las bibliotecas necesarias
        require 'C:/Users/fabian/Documents/SisVentasGemelos/vendor/autoload.php';
        require 'C:/Users/fabian/Documents/SisVentasGemelos/vendor/phpmailer/phpmailer/src/PHPMailer.php';
        // Si se hace clic en el botón, actualizar la columna saldoFinal a cero
        if (isset($_POST['reset'])) {
            $reset = "UPDATE saldos SET saldoFinal = 0";
            $conn->query($reset);
            // Crear una nueva instancia de PDF
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            // Establecer los márgenes del PDF
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            // Establecer el encabezado y el pie de página
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            // Establecer la fuente por defecto
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // Establecer el encabezado y el pie de página
            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);
            $pdf->setFooterData(array(0,64,0), array(0,64,128));
            // Establecer los márgenes del PDF
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            // Establecer el salto de página automático
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            // Establecer la relación de escala de imagen
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            // Establecer la fuente
            $pdf->SetFont('helvetica', '', 10);
            // Añadir una página
            $pdf->AddPage();
            // Obtener la fecha actual
            $fechaActual = date('Y-m-d');
            // Contenido del PDF
            $html = "<h2>Informe de ventas diarias por socio - $fechaActual</h2>";
            // Contenido del PDF
            // Generar el código HTML de la tabla
            $html .= "<table border='1' class='tablaInforme'>
            <tr>
                <th> &nbspSocio</th>
                <th> &nbspSaldo del día</th>
                <th> &nbspVenta del día</th>
            </tr>";
            while ($fila = $resultado->fetch_assoc()) {
            $html .= "<tr>
                <td>  {$fila['socio']}</td>
                <td>  {$fila['totalPrecio']}</td>
                <td>  {$ventaDia}</td>
            </tr>";
            }
            $html .= "</table>";
            // Imprimir el texto usando writeHTML()
            $pdf->writeHTML($html, true, false, true, false, '');
            // Cerrar y generar el PDF
            $pdf->lastPage();
            $pdf->Output(__DIR__ . '/informe.pdf', 'F');
            echo "PDF generado en: " . __DIR__ . '/informe.pdf';
            sleep(5);
            // Crear una nueva instancia de PHPMailer
            $mail = new PHPMailer\PHPMailer\PHPMailer;
            // Adjuntar el PDF
            // Configurar PHPMailer para usar SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.office365.com'; // o 'smtp.live.com' para cuentas antiguas
            $mail->SMTPAuth = true;
            $mail->Username = 'pruebapy0@hotmail.com';
            $mail->Password = 'Fabiian0123';
            $mail->SMTPSecure = 'tls'; // Puede ser 'ssl' también
            $mail->Port = 587; // o 465 para SSL
            // Configurar el correo
            $mail->setFrom('pruebapy0@hotmail.com', 'Sistema Ventas Gemelos');
            $mail->addAddress('santanderf333@gmail.com', 'Sebastian');
            $mail->addAttachment(__DIR__ . '/informe.pdf');
            $mail->isHTML(true);
            // Contenido del correo
            $mail->Subject = 'Informe diario de ventas por socios';
            $mail->Body    = 'Este es el cuerpo en HTML del mensaje <b>en negrita!</b>';
            $mail->AltBody = 'Este es el cuerpo en texto plano para clientes de correo no HTML';
            // Enviar el correo
            if(!$mail->send()) {
                echo 'El mensaje no pudo ser enviado.';
                echo 'Error de correo: ' . $mail->ErrorInfo;
            } else {
                echo 'Mensaje enviado.';
            }
        }
        // Consultar la base de datos para obtener la suma de precios por socio en la tabla addproductos
        $consulta = "SELECT socio, SUM(precProducto) as totalPrecio FROM addproductos GROUP BY socio";
        $resultado = $conn->query($consulta);
        // Mostrar los datos en una tabla
        echo "<table border='1' class='tablaInforme'>
                <tr>
                    <th> &nbspSocio</th>
                    <th> &nbspSaldo del día</th>
                    <th> &nbspVenta del día</th>
                </tr>";
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>
                    <td>  {$fila['socio']}</td>
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
            // Mostrar la venta del día en la tabla
            echo "<td>  {$ventaDia}</td>
                  </tr>";
            // Calcular el saldo final
            $saldoFinal = $saldoInicial - $fila['totalPrecio'];
            // Actualizar o insertar la información en la tabla saldos
            $actualizarSaldos = "INSERT INTO saldos (socioInfo, saldoInicial, saldoFinal)
                                VALUES ('{$socioInfo}', '{$fila['totalPrecio']}', '{$ventaDia}')
                                ON DUPLICATE KEY UPDATE saldoInicial = '{$fila['totalPrecio']}', saldoFinal = '{$ventaDia}'";
            $conn->query($actualizarSaldos);
        }
        echo "</table>";
        // Cerrar la conexión
        $conn->close();
        ?>
        <!-- Botón para restablecer la columna saldoFinal a cero -->
        <form method="post">
            <input type="submit" name="reset" value="Enviar Informe">
        </form>
    </div>
</body>
</html>

