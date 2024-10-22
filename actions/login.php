<?php
require(__DIR__ . '/../utils/functions.php');


if ($_POST) {
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    $user = authenticate($username, $password);

    if ($user) {
        session_start();
        $_SESSION['user'] = $user;
        header("Location: /index.php");
    } else {
        header('Location: /login.php?error=login');
    }
}