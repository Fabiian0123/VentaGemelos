<!DOCTYPE html>
<html lang="en">
<?php include '../head.php'; ?>
<body>
    <?php include '../nav.php'; ?>

    <div class="container">
        <h2>Listado de Clientes</h2>
        <?php
        include '../conexion.php';

        // Consulta SQL para obtener todos los clientes
        $sql = "SELECT * FROM clientes";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='table'>
                     <thead>
                         <tr>
                             <th>Nombre</th>
                             <th>Número Celular</th>
                         </tr>
                     </thead>
                     <tbody>";

                     while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['nombreCliente']}</td>
                                <td>{$row['numeroCelular']}</td>
                              </tr>";
                    }
                    
            echo "</tbody></table>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
