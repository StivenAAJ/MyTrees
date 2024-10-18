<?php
include('../utils/functions.php');

$error_msg = ''; // Inicializar la variable de error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario y sanitizarlos
    $user['name'] = filter_var(trim($_REQUEST['name']), FILTER_SANITIZE_STRING);
    $user['lastName'] = filter_var(trim($_REQUEST['lastName']), FILTER_SANITIZE_STRING);
    $user['phone'] = filter_var(trim($_REQUEST['phone']), FILTER_SANITIZE_STRING);
    $user['email'] = filter_var(trim($_REQUEST['email']), FILTER_SANITIZE_EMAIL);
    $user['address'] = filter_var(trim($_REQUEST['address']), FILTER_SANITIZE_STRING);
    $user['country'] = filter_var(trim($_REQUEST['country']), FILTER_SANITIZE_STRING);
    $user['password'] = $_REQUEST['password']; // No se sanitiza ya que se encripta luego

    // Validación básica
    if (empty($user['name']) || empty($user['lastName']) || empty($user['phone']) || 
        !filter_var($user['email'], FILTER_VALIDATE_EMAIL) || empty($user['address']) || 
        empty($user['country']) || empty($user['password'])) {
        $error_msg = "Please fill in all fields correctly.";
    } else {
        // Guardar usuario
        if (saveUser($user)) {
            header("Location: index.php");
            exit();
        } else {
            $error_msg = "Could not save user. Please try again.";
        }
    }
}

require('../signup.php'); // Volver a mostrar el formulario con el mensaje de error
