<!DOCTYPE html>
<html lang="en">
<?php include '../head.php'; ?>
<body>
    <?php include '../nav.php'; ?>

    <div class="container">
        <center><h2>Listado de Clientes</h2></center>
        
        <!-- Agregamos un campo de entrada para la búsqueda en tiempo real -->
        <input type="text" id="nombreClienteInput" placeholder="Buscar" class="inputBuscarClientes">

        <table class='table' id="clientesTable">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Número Celular</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include '../conexion.php';

                // Consulta SQL para obtener todos los clientes
                $sql = "SELECT * FROM clientes";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['nombreCliente']}</td>
                                <td>{$row['numeroCelular']}</td>
                              </tr>";
                    }
                }
                $conn->close();
                ?>
            </tbody>
        </table>

        <script>
            // Añadimos un evento de entrada al campo de búsqueda
            document.getElementById("nombreClienteInput").addEventListener("input", function() {
                // Obtenemos el valor del campo de búsqueda
                var nombreCliente = this.value.toLowerCase();

                // Filtramos las filas de la tabla en función del nombre del cliente
                var table = document.getElementById("clientesTable");
                var rows = table.getElementsByTagName("tr");

                for (var i = 1; i < rows.length; i++) {
                    var nombre = rows[i].getElementsByTagName("td")[0].innerText.toLowerCase();

                    // Mostramos o ocultamos la fila según coincida con la búsqueda
                    rows[i].style.display = nombre.includes(nombreCliente) ? "" : "none";
                }
            });
        </script>
    </div>
</body>
</html>
