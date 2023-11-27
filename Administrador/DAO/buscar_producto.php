<?php
include '../conexion.php';

if (isset($_GET['buscar_producto'])) {
    $termino_busqueda = $_GET['buscar_producto'];

    $sql = "SELECT codProducto as Codigo, nombProducto as Producto, marcProducto as Marca, precProducto as Precio, COUNT(*) as cant FROM addproductos WHERE codProducto LIKE '%$termino_busqueda%' OR nombProducto LIKE '%$termino_busqueda%' OR marcProducto LIKE '%$termino_busqueda%' GROUP BY codProducto, nombProducto, marcProducto, precProducto";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<table border="0">
                <tr>
                    <th>Codigo&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
                    <th>Producto&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
                    <th>Marca&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
                    <th>Precio&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
                    <th>Cant.&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
                </tr>';
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['Codigo']}</td>";
            echo "<td>{$row['Producto']}</td>";
            echo "<td>{$row['Marca']}</td>";
            echo "<td class='precio'>{$row['Precio']}</td>";
            echo "<td class='cant'>{$row['cant']}</td>";
            echo "</tr>";
        }

        echo '</table>';
    } else {
        echo 'No se encontraron resultados.';
    }

    $result->free_result();
}

$conn->close();
?>
