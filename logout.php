<?php
session_start(); // Iniciar la sesión si no está iniciada

// Destruir todas las variables de sesión
$_SESSION = array();

// Si se desea destruir la sesión completamente, también se puede eliminar la cookie de sesión
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"], $params["secure"], $params["httponly"]
    );
}

// Destruir la sesión
session_destroy();

// Redirigir al usuario a la página de inicio
header("Location: /index.php");
exit();
?>