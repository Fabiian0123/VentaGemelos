<!DOCTYPE html>
<html lang="en">

<?php include '../head.php'; ?>
<body>
    <?php include '../nav.php'; ?>

    <div>
        <center><h2>Borrar Registros</h2></center>

        <?php
        include '../conexion.php';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['reset_addproductos'])) {
                // Borrar registros de la tabla "addproductos"
                $sql = "DELETE FROM addproductos";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    echo "Registros de 'addproductos' borrados correctamente.";
                } else {
                    echo "Error al borrar registros: " . mysqli_error($conexion);
                }
            } elseif (isset($_POST['reset_clientes'])) {
                // Borrar registros de la tabla "clientes"
                $sql = "DELETE FROM clientes";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    echo "Registros de 'clientes' borrados correctamente.";
                } else {
                    echo "Error al borrar registros: " . mysqli_error($conexion);
                }
            } elseif (isset($_POST['reset_servi'])) {
                // Borrar registros de la tabla "servi"
                $sql = "DELETE FROM servi";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    echo "Registros de 'servi' borrados correctamente.";
                } else {
                    echo "Error al borrar registros: " . mysqli_error($conexion);
                }
            } elseif (isset($_POST['reset_socios'])) {
                // Borrar registros de la tabla "socios"
                $sql = "DELETE FROM socios";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    echo "Registros de 'socios' borrados correctamente.";
                } else {
                    echo "Error al borrar registros: " . mysqli_error($conexion);
                }
            }
        }
        ?>

        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <button type="submit" name="reset_addproductos">Borrar Productos</button>
            <button type="submit" name="reset_clientes">Borrar Clientes</button>
            <button type="submit" name="reset_servi">Borrar Servicios</button>
            <button type="submit" name="reset_socios">Borrar Socios</button>
        </form>
    </div>

</body>

</html>
