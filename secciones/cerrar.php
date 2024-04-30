<?php
// Inicia la sesión para acceder a las variables de sesión
session_start();

// Destruye todas las variables de sesión
session_destroy();

// Redirige al usuario a la página de inicio
header('Location:../index.php');
?>