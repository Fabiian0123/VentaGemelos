<!DOCTYPE html>
<html lang="en">

<?php 
include '../conexion.php';
include '../head.php';
?>

<body>
    <?php include '../nav.php'; ?>
    <div class="form-addproducto">
        <form action="../DAO/guarProducto.php" method="post" class="formAggProductos">
            Código del producto:<br>
            <input class="in1" type="text" name="codigo_producto" required>
            <br>
            Nombre del producto:<br>
            <input class="in1" type="text" name="nombre_producto" required>
            <br>
            Marca del producto:<br>
            <input class="in1" type="text" name="marca_producto" required>
            <br>
            Precio del producto:<br>
            <input class="in1" type="number" name="precio_producto" required>
            <br>
            Socio:<br>
            <select class="in1" name="socio" id="socio" required>
            <option value="opcion0">Seleccione</option>
            <?php
                include '../conexion.php';

                // Realiza una consulta para obtener la lista de socios
                $query = "SELECT nombSocio FROM socios";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['nombSocio'] . '">' . $row['nombSocio'] . '</option>';
                    }
                }

                // Cierra la conexión
                $conn->close();
            ?>
        </select>
            <br>
            Cantidad de articulos:<br>
            <input class="in1" type="number" name="cantidad_producto" required>
            <br>
            Precio de compra:<br>
            <input class="in1" type="number" name="precio_compra" required>
            <br>
            <div class="btng">
                <input type="submit" class="btn btn-success m-2" value="Guardar Producto">
            </div>
        </form> 
    </div>
    <button onclick="mostrarAlertaConNombre()" class="btn btn-secondary m-2">Agregar Socio</button>
    <script>
        function mostrarAlertaConNombre() {
            var nombre = prompt("Por favor, escriba el nombre del socio:");
            if (nombre !== null) {
                // Enviar el nombre del nuevo socio al servidor a través de Ajax
                agregarNuevoSocio(nombre);
            }
        }
        function agregarNuevoSocio(nombreSocio) {
            if (!nombreSocio) {
            alert("Por favor, completa el campo.");
            mostrarAlertaConNombre();
            return;
    }
            // Crear una instancia de XMLHttpRequest (Ajax)
            var xhr = new XMLHttpRequest();

            // Definir la URL a "guarSocio.php" (debes crear este archivo)
            var url = "../DAO/guarSocio.php";

            // Definir el tipo de solicitud, la URL y si es asíncrona
            xhr.open("POST", url, true);

            // Configurar el encabezado de la solicitud
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // Definir la función que se ejecutará cuando se complete la solicitud
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                    // Socio agregado exitosamente, actualizar la lista de socios en el <select>
                    actualizarListaSocios();
                    alert("Socio agregado exitosamente");
                }else {
                alert("Error al agregar socio. Por favor, inténtalo de nuevo.");
                }
            }
            };

            // Enviar los datos al servidor
            xhr.send("nombreSocio=" + encodeURIComponent(nombreSocio));

        }
        function actualizarListaSocios() {
            // Crear una nueva instancia de XMLHttpRequest para obtener la lista actualizada de socios
            var xhr = new XMLHttpRequest();
            var url = "../DAO/obtenerSocios.php"; // Debes crear este archivo para obtener la lista actualizada

            xhr.open("GET", url, true);

            xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Actualizar el contenido del <select> con la lista de socios actualizada
                document.getElementById("socio").innerHTML = xhr.responseText;
            }
        };

    xhr.send();
}
    </script>
    <a type="button" href="/Administrador/pages/Vender.php" class="btn btn-danger m-2">Terminar</a>
</body>

</html>