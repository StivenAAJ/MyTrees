<?php
require_once '../utils/functions.php';
require_once '../utils/trees-funcs.php';

session_start();
if ($_SESSION['user_role'] !== 'ADMIN') {
    header('Location: ../warning.php');
    exit;
}

// Verificar si el ID está presente en la URL
if (!isset($_GET['id'])) {
    header('Location: ../trees.php?error=missing_id');
    exit;
}

$treeId = $_GET['id'];

// Eliminar el árbol de la base de datos
if (deleteTree($treeId)) {
    header('Location: ../trees.php?status=deleted');
} else {
    header('Location: ../trees.php?status=error');
}
exit;
?>
