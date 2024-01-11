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

            // Obtener los artículos asociados a este socio
            $query_articulos = "SELECT codProducto, nombProducto, marcProducto, precProducto, precCompra FROM addproductos WHERE socio = '$nombSocio'";
            $result_articulos = $conn->query($query_articulos);

            // Mostrar la tabla solo si hay artículos asociados al socio
            if ($result_articulos->num_rows > 0) {
                echo "<br><h4 style='margin-left: 10px;'>Artículos de: $nombSocio</h4>";
                echo "<table border='2' style='margin-left: 10px;'>";
                echo "<tr><th>#</th><th>&nbsp&nbspCódigo</th><th>&nbsp&nbspNombre</th><th>&nbsp&nbspMarca</th><th>&nbsp&nbspPrecio Venta</th><th>&nbsp&nbspPrecio Compra</th><th>&nbsp&nbspAcciones</th></tr>";
                $contador = 1;
                while ($row_articulos = $result_articulos->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $contador . "</td>";
                    echo "<td>&nbsp&nbsp" . $row_articulos['codProducto'] . "</td>";
                    echo "<td>&nbsp&nbsp" . $row_articulos['nombProducto'] . "</td>";
                    echo "<td>&nbsp&nbsp" . $row_articulos['marcProducto'] . "</td>";
                    echo "<td>&nbsp&nbsp" . $row_articulos['precProducto'] . "</td>";
                    echo "<td>&nbsp&nbsp" . $row_articulos['precCompra'] . "</td>";
                    // Agrega enlace para editar y eliminar
                    echo "<td>&nbsp&nbsp<a href='editar.php?idSocio=$idSocio&codProducto=" . $row_articulos['codProducto'] . "'>Editar</a> | <a href='eliminar.php?idSocio=$idSocio&codProducto=" . $row_articulos['codProducto'] . "'>Eliminar</a></td>";
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
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Editar Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editForm">
          <div class="form-group">
            <label for="codProducto">Código</label>
            <input type="text" class="form-control" id="codProducto" name="codProducto">
          </div>
          <div class="form-group">
            <label for="nombProducto">Nombre</label>
            <input type="text" class="form-control" id="nombProducto" name="nombProducto">
          </div>
          <div class="form-group">
            <label for="marcProducto">Marca</label>
            <input type="text" class="form-control" id="marcProducto" name="marcProducto">
          </div>
          <div class="form-group">
            <label for="precProducto">Precio Venta</label>
            <input type="text" class="form-control" id="precProducto" name="precProducto">
          </div>
          <div class="form-group">
            <label for="precCompra">Precio Compra</label>
            <input type="text" class="form-control" id="precCompra" name="precCompra">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="saveButton">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
  // Evento click para el enlace "Editar"
  $('a[href^="editar.php"]').click(function(e) {
    e.preventDefault();

    // Obtén los datos actuales del producto
    var codProducto = $(this).parent().prev().prev().prev().prev().prev().text();
    var nombProducto = $(this).parent().prev().prev().prev().prev().text();
    var marcProducto = $(this).parent().prev().prev().prev().text();
    var precProducto = $(this).parent().prev().prev().text();
    var precCompra = $(this).parent().prev().text();

    // Llena los campos del formulario con los datos actuales
    $('#codProducto').val(codProducto);
    $('#nombProducto').val(nombProducto);
    $('#marcProducto').val(marcProducto);
    $('#precProducto').val(precProducto);
    $('#precCompra').val(precCompra);

    // Abre el modal
    $('#editModal').modal('show');
  });

  // Evento click para el botón "Guardar cambios"
  $('#saveButton').click(function() {
    // Obtén los datos del formulario
    var codProducto = $('#codProducto').val();
    var nombProducto = $('#nombProducto').val();
    var marcProducto = $('#marcProducto').val();
    var precProducto = $('#precProducto').val();
    var precCompra = $('#precCompra').val();

    // Envía los datos al servidor con AJAX
    $.ajax({
        url: 'C:/Users/fabian/Documents/SisVentasGemelos/Administrador/DAO/editar_producto.php', // Cambia esto por la ruta a tu archivo PHP que maneja la actualización
        type: 'POST',
        data: {
            codProducto: codProducto,
            nombProducto: nombProducto,
            marcProducto: marcProducto,
            precProducto: precProducto,
            precCompra: precCompra
        },
        success: function(response) {
            // Aquí puedes manejar la respuesta del servidor
            // Por ejemplo, puedes cerrar el modal y actualizar la tabla de productos
            $('#editModal').modal('hide');
            location.reload(); // Esto recarga la página para ver los cambios
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Aquí puedes manejar los errores
            console.log(textStatus, errorThrown);
        }
    });
});

});
</script>
</html>



