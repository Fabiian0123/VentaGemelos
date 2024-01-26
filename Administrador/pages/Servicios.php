<!DOCTYPE html>
<html lang="en">

<?php include '../head.php';?>

<body class="fonfoServicios">
    <?php include '../nav.php'; ?>
    <h3 class="titleServicios">Venda servicios aqui!</h3>
    <form id="form_servicio" class="inBusqueda">
        Descripción del servicio:<br>
        <input class="descServicio" type="text" name="descripcion_servicio" id="descripcion_servicio"><br><br>
        Precio del servicio:<br>
        <input type="number" name="precio_servicio" id="precio_servicio" class="precServicio"><br><br>
        <button type="button" id="guardar_servicio" class="venderButton">Vender</button><br><br>
        <button type="button" class="btnCobrarServic" id="cobrarServ" disabled>Cobrar</button><br>
    </form>
    <script src="../js/jquery-3.7.1.min.js"></script>
    <script>
    total_servicios = 0;
    $('#guardar_servicio').on('click', function () {
    // Obtener los valores de los campos de entrada
    var descripcion_servicio = $('#descripcion_servicio').val();
    var precio_servicio = parseInt($('#precio_servicio').val());
    if (descripcion_servicio.trim() === '' || isNaN(precio_servicio) || precio_servicio <= 0) {
        alert('Por favor, complete todos los campos correctamente.');
        return;
    }
    // Agregar una nueva fila a la tabla con la información del servicio
    var numero = $('#tabla_resultados_2 tr').length + 1;
    var nueva_fila = '<tr><td>' + numero + '</td><td>'+'Servicio'+' '+' '+'</td><td>' + precio_servicio + '</td></tr>';
    $('#tabla_resultados_2').append(nueva_fila);
    // Realizar la consulta AJAX para guardar los datos en la base de datos
    $.ajax({
        type: 'POST',
        url: '../DAO/guardar_servicio.php',
        data: { 
            descripcion_servicio: descripcion_servicio,
            precio_servicio: precio_servicio
        },
        success: function (data) {
            // Puedes manejar la respuesta del servidor aquí
            alert('Servicio agregado exitosamente.');
            // Habilitar el botón "Cobrar"
            $('#cobrarServ').prop('disabled', false);
        }
    });
});
$('#cobrarServ').on('click', function () {
    // Obtener los valores de los campos de entrada
    var descripcion_servicio = $('#descripcion_servicio').val();
    var precio_servicio = $('#precio_servicio').val();

    // Abre una nueva ventana para mostrar el recibo antes de imprimir
    var ventana = window.open('', '_blank');

    // Agrega la imagen antes del título "Recibo de Venta"
    var imagenURL = '/Login/img/logoMellosRecibo.png'; // Reemplaza con la URL de tu imagen
    ventana.document.write('<img src="' + imagenURL + '" alt="Logo">');
    ventana.document.write('<h4>Nit: 1093776587</h4>');

    // Obtiene la fecha y hora actual
    var fechaHoraActual = new Date();
    var fechaHoraString = 'Fecha y Hora: ' + fechaHoraActual.toLocaleString();
    ventana.document.write('<p>' + fechaHoraString + '</p>'); // Agrega la fecha y hora

    ventana.document.write('<h2>Recibo de Venta de servicio</h2>');
    
    // Agrega los divs de descripción_servicio y precio_servicio al recibo
    ventana.document.write('<p>Descripción del servicio: ' + descripcion_servicio + '</p>');
    ventana.document.write('<p>Precio del servicio: ' + precio_servicio + '</p>');
    ventana.document.write('</body></html>');

    ventana.document.close();

    // Espera un breve momento antes de llamar a la función de impresión
    setTimeout(function () {
        ventana.print();
        ventana.onafterprint = function () {
            // Cierra la ventana después de la impresión
            ventana.close();
        };
    }, 1000);
});


    </script>
</body>
</html>
