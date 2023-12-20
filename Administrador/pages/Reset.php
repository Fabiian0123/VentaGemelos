<!DOCTYPE html>
<html lang="en">

<?php include '../head.php'; ?>
<body>
    <?php include '../nav.php'; ?>

    <div>
        <center><h2>Borrar Registros</h2></center>

        <?php
        include '../conexion.php';
        $message = '';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['reset_addproductos'])) {
                // Borrar registros de la tabla "addproductos"
                $sql = "DELETE FROM addproductos";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $message = "Productos borrados correctamente.";
                } else {
                    $message = "Error al borrar registros: " . mysqli_error($conexion);
                }
            } elseif (isset($_POST['reset_clientes'])) {
                // Borrar registros de la tabla "clientes"
                $sql = "DELETE FROM clientes";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $message = "Clientes borrados correctamente.";
                } else {
                    $message = "Error al borrar registros: " . mysqli_error($conexion);
                }
            } elseif (isset($_POST['reset_servi'])) {
                // Borrar registros de la tabla "servi"
                $sql = "DELETE FROM servi";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $message = "Servicios borrados correctamente.";
                } else {
                    $message = "Error al borrar registros: " . mysqli_error($conexion);
                }
            }
        }
        ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="formReset">
            <button type="submit" name="reset_addproductos" class="btn btn-danger m-4" onclick="return confirm('¿Estás seguro de que quieres borrar todos los productos?');">Borrar Productos</button>
            <button type="submit" name="reset_clientes" class="btn btn-danger m-4" onclick="return confirm('¿Estás seguro de que quieres borrar todos los clientes?');">Borrar Clientes</button>
            <button type="submit" name="reset_servi" class="btn btn-danger m-4" onclick="return confirm('¿Estás seguro de que quieres borrar todos los servicios?');">Borrar Servicios</button>
        </form>
    </div>
    <center><h4 class="alertaReset">Alerta!, si borras cualquier registro, no se podra recuperar despues</h4><center>
    <a type="button" href="/Administrador/pages/Vender.php" class="btn btn-danger m-2">Terminar</a>

    <?php if (!empty($message)) : ?>
        <script>
            alert("<?php echo $message; ?>");
        </script>
    <?php endif; ?>

</body>

</html>


