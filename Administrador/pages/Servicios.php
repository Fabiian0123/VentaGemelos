<!DOCTYPE html>
<html lang="en">

<?php include '../head.php';?>

<body>
    <?php include '../nav.php'; ?>
    <h3>Venda servicios aqui</h3>
    <form id="form_servicio" class="inBusqueda">
        Descripción del servicio:<br>
        <input type="text" name="descripcion_servicio" id="descripcion_servicio"><br>
        Precio del servicio:<br>
        <input type="number" name="precio_servicio" id="precio_servicio"><br>
        <button type="button" id="guardar_servicio">Vender</button>
    </form>
    <script src="../js/jquery-3.7.1.min.js"></script>
    <script>
    total_servicios = 0;
    $('#guardar_servicio').on('click', function () {
    // Obtener los valores de los campos de entrada
    var descripcion_servicio = $('#descripcion_servicio').val();
    var precio_servicio = parseInt($('#precio_servicio').val());
    
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
        }
    });
});

    </script>
    
</body>

</html>