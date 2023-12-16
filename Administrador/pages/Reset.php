<!DOCTYPE html>
<html lang="en">

<?php include '../head.php'; ?>
<body>
    <?php include '../nav.php'; ?>

    <div>
        <h2>Resetear Registros</h2>

        <?php
        include '../conexion.php';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['reset_addproductos'])) {
                // Borrar registros de la tabla "addproductos"
                $sql = "DELETE FROM addproductos";
                $result = mysqli_query($conexion, $sql);
                if ($result) {
                    echo "Registros de 'addproductos' borrados correctamente.";
                } else {
                    echo "Error al borrar registros: " . mysqli_error($conexion);
                }
            } elseif (isset($_POST['reset_clientes'])) {
                // Borrar registros de la tabla "clientes"
                $sql = "DELETE FROM clientes";
                $result = mysqli_query($conexion, $sql);
                if ($result) {
                    echo "Registros de 'clientes' borrados correctamente.";
                } else {
                    echo "Error al borrar registros: " . mysqli_error($conexion);
                }
            } elseif (isset($_POST['reset_servi'])) {
                // Borrar registros de la tabla "servi"
                $sql = "DELETE FROM servi";
                $result = mysqli_query($conexion, $sql);
                if ($result) {
                    echo "Registros de 'servi' borrados correctamente.";
                } else {
                    echo "Error al borrar registros: " . mysqli_error($conexion);
                }
            } elseif (isset($_POST['reset_socios'])) {
                // Borrar registros de la tabla "socios"
                $sql = "DELETE FROM socios";
                $result = mysqli_query($conexion, $sql);
                if ($result) {
                    echo "Registros de 'socios' borrados correctamente.";
                } else {
                    echo "Error al borrar registros: " . mysqli_error($conexion);
                }
            }
        }
        ?>

        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <button type="submit" name="reset_addproductos">Resetear addproductos</button>
            <button type="submit" name="reset_clientes">Resetear clientes</button>
            <button type="submit" name="reset_servi">Resetear servi</button>
            <button type="submit" name="reset_socios">Resetear socios</button>
        </form>
    </div>

</body>

</html>
