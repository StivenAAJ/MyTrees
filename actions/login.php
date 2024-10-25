<?php
require(__DIR__ . '/../utils/functions.php');

if ($_POST) {
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    $user = authenticate($username, $password);

    if ($user) {
        session_start();
        // Guardar los datos necesarios en variables de sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['rol'];
        header("Location: /index.php");
    } else {
        header('Location: /login.php?error=login');
    }
}