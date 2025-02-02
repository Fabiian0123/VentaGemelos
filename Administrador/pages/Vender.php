<!DOCTYPE html>
<html lang="en">

<?php include '../head.php';?>
<body class="fondoVender">
    <?php include '../nav.php'; ?>

    <form class="inBusqueda">
        Codigo, marca o nombre del producto:<br>
        <input class="inBusqueda2" type="text" name="buscar_producto" id="buscar_producto">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#servicioModal">
            Agregar Servicio
        </button>
        <button type="button" class="btn btn-warning m-2" data-toggle="modal" data-target="#guardar_cliente">
            Agregar Cliente
        </button>
    </form>
    <!-- Modal -->
    <div class="modal fade" id="servicioModal" tabindex="-1" role="dialog" aria-labelledby="servicioModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header ModHeaderAggServ">
            <h5 class="modal-title ModTitleAggServ" id="servicioModalLabel">Agregar Servicio</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <!-- Aquí va tu formulario -->
            <form id="form_servicio" class="inBusqueda">
                Descripción del servicio:<br>
                <input type="text" name="descripcion_servicio" id="descripcion_servicio" class="inDescServ"><br>
                Precio del servicio:<br>
                <input type="number" name="precio_servicio" id="precio_servicio"><br><br>
                <button type="button" id="guardar_servicio" class="btn btn-success">Agregar Servicio</button>
            </form>
        </div>
        </div>
    </div>
    </div>
    <!--fin del modal-->
    <!-- Modal para agregar cliente -->
    <div class="modal fade" id="guardar_cliente" tabindex="-1" role="dialog" aria-labelledby="guardarClienteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header ModalHeaderAggClient">
                    <h5 class="modal-title ModTitleAggClient" id="guardarClienteLabel">Agregar Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para ingresar nombre y número de contacto del cliente -->
                    <form id="form_cliente">
                        Nombre del Cliente:<br>
                        <input type="text" name="nombre_cliente" id="nombre_cliente" class="inNombCliente"><br>
                        Número de Contacto:<br>
                        <input type="text" name="contacto_cliente" id="contacto_cliente"><br><br>
                        <button type="button" id="guardar_cliente_btn" class="btn btn-success">Guardar Cliente</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Fin del modal para agregar cliente -->
    <br>
    <div class="tablaResultados precio" id="tabla_resultados"></div>
    <div class="botonesVender">
        <a type="button" class="btn btn-success m-2" id="btn_derecha">--></a>
    </div>
    <div class="tablaResultados2" id="tabla_resultados_2">
        <tr>
            <th><b>&nbspCódigo&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b></th>
            <th><b>Producto&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<br></b></th>
        </tr>
    </div>
    <div class="totalPrecio" id="total_precios"></div>
    <div class="totalServicios" id="total_servicios"></div>
    <a type="button" class="btn btn-success cobrar" id="cobrar">Cobrar</a>
    <div class="totalGeneral" id="total_general"></div>
    <script src="../js/jquery-3.7.1.min.js"></script>
    <script>
    var total_precios = 0;
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
    total_precios=0;
    $('#btn_derecha').on('click', function () {
    if (fila_seleccionada_1) {
        // Identificar la fila seleccionada (fila_seleccionada_1)
        // Obtener el código del producto de la fila seleccionada
        var codigoProducto = fila_seleccionada_1.find('td:first').text();
        // Realizar la eliminación en la base de datos mediante AJAX
        $.ajax({
            type: 'POST',
            url: '../DAO/eliminar_producto.php', // Debes crear este archivo
            data: { codigo_producto: codigoProducto },
            success: function (data) {
                // Manejar la respuesta del servidor
                alert('Producto vendido exitosamente y eliminado de la base de datos.');
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
                // Limpiar la fila seleccionada
                fila_seleccionada_1 = null;
                // Agregar un número al principio de la fila
                var numero = $('#tabla_resultados_2 tr').length;
                fila_a_mover.prepend('<tr><td>' + '<br></td></tr>');
                // Eliminar la columna 'cant' de la fila a mover
                fila_a_mover.find('.cant').remove();
                // Mover la fila a la tabla 2
                $('#tabla_resultados_2').append(fila_a_mover);
                // Sumar el precio del producto movido al total
                total_precios += parseFloat(fila_a_mover.find('.precio').text());
                // Mostrar el total de precios debajo de los botones
                $('#total_precios').text('Total Productos: ' + total_precios);
            },
            error: function (xhr, status, error) {
                // Manejar errores
                alert('Error al vender el producto: ' + error);
            }
        });
    }
});

total_servicios = 0;
$('#guardar_servicio').on('click', function () {
    // Obtener los valores de los campos de entrada
    var descripcion_servicio = $('#descripcion_servicio').val();
    var precio_servicio = parseInt($('#precio_servicio').val());
    // Validar que los campos no estén vacíos y que el precio sea un número válido
    if (descripcion_servicio.trim() === '' || isNaN(precio_servicio) || precio_servicio <= 0) {
        alert('Por favor, complete todos los campos correctamente.');
        return;
    }
    // Agregar una nueva fila a la tabla con la información del servicio
    var numero = $('#tabla_resultados_2 tr').length;
    var nueva_fila = '<br>'+'<tr><td>'+'</td><td>'+'Servicio:'+'</td><td>' + precio_servicio + '</td></tr><br>';
    $('#tabla_resultados_2').append(nueva_fila);
    // Sumar el precio del servicio al total de servicios
    total_servicios += parseFloat(precio_servicio);
    // Mostrar el total de servicios
    $('#total_servicios').text('Total Servicios: ' + total_servicios);
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
// Agregar evento al botón "Guardar Cliente"
$('#guardar_cliente_btn').on('click', function () {
        // Obtener los valores del formulario
        var nombreCliente = $('#nombre_cliente').val();
        var numeroCelular = $('#contacto_cliente').val(); // Renombrar la variable para reflejar el cambio de nombre
        if (nombreCliente.trim() === '' || isNaN(numeroCelular) || numeroCelular <= 0) {
        alert('Por favor, complete todos los campos correctamente.');
        return;
        }
        // Añadir una nueva fila a la tabla_resultados_2 con el nombre del cliente
        var numeroFila = $('#tabla_resultados_2 tr').length + 1;
        var nuevaFilaCliente = '<tr><td>' + 'Cliente:'+'&nbsp'+ '</td><td>' + nombreCliente + '</td><td></td></tr>';
        $('#tabla_resultados_2').append(nuevaFilaCliente);
        // Realizar la consulta AJAX para guardar los datos en la base de datos
        $.ajax({
            type: 'POST',
            url: '../DAO/guardar_cliente.php', // Ajusta la ruta según tu estructura de archivos
            data: {
                nombre_cliente: nombreCliente,
                numero_celular: numeroCelular // Renombrar la variable para reflejar el cambio de nombre
            },
            success: function (data) {
                // Manejar la respuesta del servidor
                alert('Cliente guardado exitosamente.');

                // Puedes realizar acciones adicionales aquí, como cerrar el modal, recargar la página, etc.

                // Cerrar el modal
                $('#guardar_cliente').modal('hide');
            },
            error: function (xhr, status, error) {
                // Manejar errores
                alert('Error al guardar el cliente: ' + error);
            }
        });
    });
    $('#cobrar').on('click', function () {
    if ($('#tabla_resultados_2 tr').length === 0) {
        alert('Error: No hay productos ni servicios para cobrar.');
        return;
    }
    
    // Calcula el total general sumando total_precios y total_servicios
    var total_general = total_precios + total_servicios;

    // Obtiene la fecha y hora actual
    var fechaHoraActual = new Date();
    var fechaHoraString = 'Fecha y Hora: ' + fechaHoraActual.toLocaleString();

    // Clona la tabla para evitar modificar la original en la página
    var tablaClonada = $('#tabla_resultados_2').clone();
    // Clona los divs de totalPrecio y totalServicios
    var totalPrecioClonado = $('#total_precios').clone();
    var totalServiciosClonado = $('#total_servicios').clone();
    // Elimina cualquier clase 'seleccionado' que pueda haber en la tabla clonada
    tablaClonada.find('.seleccionado').removeClass('seleccionado');
    // Abre una nueva ventana para mostrar el recibo antes de imprimir
    var ventana = window.open('', '_blank');
    
    // Agrega la imagen antes del título "Recibo de Venta"
    ventana.document.write('<h1>LUBRIREPUESTOS QUINTANA</h1>');
    ventana.document.write('<h4>Nit: 1093776587</h4>');
    ventana.document.write('<p>' + fechaHoraString + '</p>'); // Agrega la fecha y hora
    ventana.document.write('<h2>Recibo de Venta</h2>');
    ventana.document.write(tablaClonada.html());
    // Agrega los divs de totalPrecio y totalServicios al recibo
    ventana.document.write('<br>');
    ventana.document.write('<br>');
    ventana.document.write('<div class="totalPrecio" id="total_precios_clonado">');
    ventana.document.write(totalPrecioClonado.html());
    ventana.document.write('</div>');
    ventana.document.write('<div class="totalServicios" id="total_servicios_clonado">');
    ventana.document.write(totalServiciosClonado.html());
    ventana.document.write('</div>');
    ventana.document.write('<br>');
    ventana.document.write('<div class="totalGeneral" id="total_general_clonado">');
    ventana.document.write('Total Venta: ' + total_general);
    ventana.document.write('</div>');
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






