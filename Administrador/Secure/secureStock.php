<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticación</title>
</head>
<body>

<script>
    // Definir la contraseña correcta
    var passwordCorrecta = "1234";

    // Variable para almacenar la contraseña ingresada por el usuario
    var inputPassword;

    // Bucle para solicitar la contraseña hasta que sea correcta o se cancele
    while (true) {
        // Solicitar la contraseña al usuario
        inputPassword = prompt("Por favor, ingrese la contraseña:");

        // Verificar si se ingresó una contraseña
        if (inputPassword === null) {
            // El usuario presionó "Cancelar", redirigir a /Administrador/pages/Vender.php
            window.location.href = "/Administrador/pages/Vender.php";
            break; // Salir del bucle
        }

        // Verificar si la contraseña es correcta
        if (inputPassword === passwordCorrecta) {
            // Contraseña correcta, redirigir al usuario
            window.location.href = "/Administrador/pages/Stock.php";
            break; // Salir del bucle
        } else {
            // Contraseña incorrecta, mostrar mensaje de alerta
            alert("Contraseña incorrecta. Acceso denegado.");
        }
    }
</script>

</body>
</html>