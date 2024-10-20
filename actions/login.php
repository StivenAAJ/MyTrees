<?php
require(__DIR__ . '/../utils/functions.php');


if ($_POST) {
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    $user = authenticate($username, $password);

    if ($user) {
        session_start();
        $_SESSION['user'] = $user;
        header("Location: /mytrees/index.php");
    } else {
        header('Location: /mytrees/login.php?error=login');
    }
}