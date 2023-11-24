<!DOCTYPE html>
<html lang="en">

<?php include '../head.php';?>

<body>
    <?php include '../nav.php'; ?>

    <form class="inBusqueda">
        Codigo o nombre del producto:<br>
        <input class="inBusqueda2" type="text" name="buscar_producto" id="buscar_producto">
    </form>
    <form id="form_servicio" class="inBusqueda">
        Descripción del servicio:<br>
        <input type="text" name="descripcion_servicio" id="descripcion_servicio"><br>
        Precio del servicio:<br>
        <input type="text" name="precio_servicio" id="precio_servicio"><br>
        <button type="button" id="guardar_servicio">Agregar Servicio</button>
    </form>
    <br>
    <div class="tablaResultados" id="tabla_resultados"></div>
    <div class="botonesVender">
        <a type="button" class="btn btn-danger" id="btn_izquierda"><--</a>
        <a type="button" class="btn btn-success m-2" id="btn_derecha">--></a>
    </div>
    <div class="tablaResultados2" id="tabla_resultados_2">
        <tr>
            <th><b>&nbspItem&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b></th>
            <th><b>Producto&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b></th>
            <th><b>Precio<b></th>
        </tr>
    </div>
    <div id="total">Total: $0</div>
    <script src="../js/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function () {
    // Variables para almacenar las filas seleccionadas
    var fila_seleccionada_1, fila_seleccionada_2;

    // Detectar cambios en el campo de búsqueda
    $('#buscar_producto').on('input', function () {
        // Obtener el valor del campo de búsqueda
        var termino_busqueda = $(this).val();

        // Verificar si el campo de búsqueda está vacío
        if (termino_busqueda === '') {
            // Si está vacío, limpiar la tabla de resultados
            $('#tabla_resultados').empty();
            return;
        }

        // Realizar la consulta AJAX
        $.ajax({
            type: 'GET',
            url: '../DAO/buscar_producto.php',
            data: { buscar_producto: termino_busqueda },
            success: function (data) {
                // Actualizar la tabla de resultados
                $('#tabla_resultados').html(data);

                // Agregar controlador de eventos de clic a las filas de la tabla 1
                $('#tabla_resultados tr').on('click', function () {
                    // Eliminar la clase 'seleccionado' de todas las filas
                    $('#tabla_resultados tr').removeClass('seleccionado');

                    // Agregar la clase 'seleccionado' a la fila que se acaba de hacer clic
                    $(this).addClass('seleccionado');

                    // Almacenar la fila seleccionada
                    fila_seleccionada_1 = $(this);
                });
            }
        });
    });
    // Mover la fila seleccionada a la tabla 2 cuando se haga clic en el botón btn_derecha
    $('#btn_derecha').on('click', function () {
        if (fila_seleccionada_1) {
            // Clonar la fila seleccionada y eliminar la clase 'seleccionado'
            var fila_a_mover = fila_seleccionada_1.clone().removeClass('seleccionado');
            var cantidad_actual = parseInt(fila_seleccionada_1.find('.cant').text());
            // Verificar si hay suficientes productos para mover
            if (cantidad_actual > 0) {
                // Actualizar la cantidad en la tabla_resultados
                fila_seleccionada_1.find('.cant').text(cantidad_actual - 1);
            } else {
                // Si no hay suficientes productos, puedes manejarlo según tus requisitos
                alert('No hay suficientes productos disponibles.');
                return;
            }
            // Agregar un número al principio de la fila
            var numero = $('#tabla_resultados_2 tr').length + 1;
            fila_a_mover.prepend('<td>'+ numero +' '+' '+' '+' '+' '+' '+' '+' '+' '+' '+' '+' '+' '+' '+' '+'</td>');
    

            // Eliminar la columna 'cant' de la fila a mover
            fila_a_mover.find('.cant').remove();

            // Mover la fila a la tabla 2
            $('#tabla_resultados_2').append(fila_a_mover);

            // Limpiar la fila seleccionada
            fila_seleccionada_1 = null;
        }
    });
    // Mover la fila seleccionada a la tabla 1 cuando se haga clic en el botón btn_izquierda
    $('#btn_izquierda').on('click', function () {
        if (fila_seleccionada_2) {
            // Clonar la fila seleccionada y eliminar la clase 'seleccionado'
            var fila_a_mover = fila_seleccionada_2.clone().removeClass('seleccionado');

            // Mover la fila a la tabla 1
            $('#tabla_resultados').append(fila_a_mover);

            // Agregar controlador de eventos de clic a las filas de la tabla 1
            $('#tabla_resultados tr').on('click', function () {
                // Eliminar la clase 'seleccionado' de todas las filas
                $('#tabla_resultados tr').removeClass('seleccionado');

                // Agregar la clase 'seleccionado' a la fila que se acaba de hacer clic
                $(this).addClass('seleccionado');

                // Almacenar la fila seleccionada
                fila_seleccionada_1 = $(this);
            });

            // Eliminar la fila seleccionada de la tabla 2
            fila_seleccionada_2.remove();

            // Limpiar la fila seleccionada
            fila_seleccionada_2 = null;
        }
        
    });
});
$('#guardar_servicio').on('click', function () {
    // Obtener los valores de los campos de entrada
    var descripcion_servicio = $('#descripcion_servicio').val();
    var precio_servicio = $('#precio_servicio').val();

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
            alert('Servicio guardado exitosamente.');
        }
    });
});
function calcularTotal() {
    // Inicializar el total a 0
    var total = 0;

    // Sumar el precio de cada fila en la tabla 2
    $('#tabla_resultados_2 tr').each(function() {
        var precio = $(this).find('.precio').text();
        if (!isNaN(precio)) { // Verificar si el precio es un número
            total += parseFloat(precio);
        }
    });

    // Sumar el precio del servicio ingresado
    var precio_servicio = $('#precio_servicio').val();
    if (!isNaN(precio_servicio)) { // Verificar si el precio del servicio es un número
        total += parseFloat(precio_servicio);
    }

    // Actualizar el total en el HTML
    $('#total').text('Total: $' + total.toFixed(2));
}

// Llamar a calcularTotal() cuando se hace clic en los botones
$('#btn_derecha').on('click', calcularTotal);
$('#guardar_servicio').on('click', calcularTotal);


    </script>

    <style>
        .seleccionado {
            background-color: #008f39;
        }
        #tabla_resultados tr {
            cursor: pointer;
        }
        #tabla_resultados_2{
            cursor: pointer;
        }
    </style>
</body>

</html>






