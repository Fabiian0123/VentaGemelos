<?php
// Iniciar sesión
session_start();

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Verificar las credenciales
    if ($username == "gemelo" && $password == "pass") {
        // Iniciar sesión
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;

        // Redirigir al usuario a la página de administrador
        header("location: /Administrador/pages/Vender.php");
    } else {
        echo '<script>alert("Usuario o contraseña incorrectos");window.location = "login.html";</script>';
    }
}
?>


