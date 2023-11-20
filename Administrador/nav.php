<?php $current_page = basename($_SERVER['PHP_SELF']); ?>

<div class="divContainer">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <a type="button" href="/Administrador/pages/Vender.php" class="btn btn-primary m-2<?php if($current_page == 'Vender.php'){echo 'active';}?>">Vender</a>
                    <a type="button" href="/Administrador/pages/Servicios.php" class="btn btn-secondary m-2<?php if($current_page == 'Servicios.php'){echo 'active';}?>">Servicios</a>
                    <a type="button" href="/Administrador/pages/AddProductos.php" class="btn btn-success m-2<?php if($current_page == 'AddProductos.php'){echo 'active';}?>">Agregar Productos</a>
                    <a type="button" href="/Administrador/pages/Informe.php" class="btn btn-info m-2<?php if($current_page == 'Informe.php'){echo 'active';}?>">Informe</a>
                    <a type="button" href="/Administrador/pages/Clientes.php" class="btn btn-warning m-2<?php if($current_page == 'Clientes.php'){echo 'active';}?>">Clientes</a>
                    <a type="button" href="/Administrador/pages/Stock.php" class="btn btn-dark m-2<?php if($current_page == 'Stock.php'){echo 'active';}?>">Stock</a>
                    <a type="button" href="/Administrador/pages/Reset.php" class="btn btn-danger m-2<?php if($current_page == 'Reset.php'){echo 'active';}?>">Reset</a>
                </ul>
            </div>
        </div>
        <a type="button" href="/Login/login.html" class="btn btn-danger m-2 btn-salir">Salir</a>
    </nav>
</div>
