<?php
session_start(); // Start the session if it is not already started

// Destroy all session variables
$_SESSION = array();

// If you want to completely destroy the session, you can also delete the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"], $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Redirect the user to the homepage
header("Location: /index.php");
exit();
?>
