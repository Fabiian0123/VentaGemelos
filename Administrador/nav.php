<?php $current_page = basename($_SERVER['PHP_SELF']); ?>

<div class="divContainer">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <a type="button" href="/Administrador/pages/Vender.php" class="btn btn-primary m-2<?php if($current_page == 'Vender.php'){echo 'active';}?>">Vender</a>
                    <a type="button" href="/Administrador/pages/Servicios.php" class="btn btn-secondary m-2<?php if($current_page == 'Servicios.php'){echo 'active';}?>">Servicios</a>
                    <a type="button" href="/Administrador/Secure/secureAggProductos.php" class="btn btn-success m-2<?php if($current_page == 'AddProductos.php'){echo 'active';}?>">Agregar Productos</a>
                    <a type="button" href="/Administrador/pages/Informe.php" class="btn btn-info m-2<?php if($current_page == 'Informe.php'){echo 'active';}?>">Informe</a>
                    <a type="button" href="/Administrador/pages/Clientes.php" class="btn btn-warning m-2<?php if($current_page == 'Clientes.php'){echo 'active';}?>">Clientes</a>
                    <a type="button" href="/Administrador/Secure/secureStock.php" class="btn btn-dark m-2<?php if($current_page == 'Stock.php'){echo 'active';}?>">Stock</a>
                    <a type="button" href="/Administrador/Secure/secureReset.php" class="btn btn-danger m-2<?php if($current_page == 'Reset.php'){echo 'active';}?>">Reset</a>
                </ul>
            </div>
        </div>
        <a type="button" href="#" class="btn btn-danger m-2 btn-salir" onclick="confirmarSalir()">Salir</a>
    </nav>
    <script>
    function confirmarSalir() {
        // Muestra un cuadro de diálogo de confirmación
        var confirmacion = confirm("¿Estás seguro de que deseas cerrar la sesión?");
        
        // Si la respuesta es afirmativa, redirige al login, de lo contrario, no hace nada
        if (confirmacion) {
            window.location.href = "/Login/login.html";
        }
    }
</script>
</div>
