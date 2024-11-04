<?php
require_once '../utils/functions.php';
require_once '../utils/trees-funcs.php';
require_once '../utils/especies-funcs.php';

session_start();
if ($_SESSION['user_role'] !== 'ADMIN') {
    header('Location: ../warning.php');
    exit;
}

// Verificar que el ID y los datos del formulario están presentes
if (!isset($_GET['id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../trees.php?error=missing_data');
    exit;
}

$treeId = $_GET['id'];
$especieId = $_POST['especie'];
$ubicacion = $_POST['ubicacion'];
$estado = $_POST['estado'];
$precio = $_POST['precio'];
$tam = $_POST['tam'];

// Manejo de imagen si el usuario sube una nueva
$fotoUrl = getTreeById($treeId)['foto_arbol'];
if (isset($_FILES['foto']) && $_FILES['foto']['size'] > 0) {
    $fotoName = basename($_FILES['foto']['name']);
    $fotoPath = '../images/' . $fotoName;
    
    if (move_uploaded_file($_FILES['foto']['tmp_name'], $fotoPath)) {
        $fotoUrl = 'images/' . $fotoName;
    }
}

if (updateTree($treeId, $especieId, $ubicacion, $estado, $precio, $fotoUrl, $tam)) {
    header('Location: ../trees.php?status=updated');
} else {
    header('Location: ../trees.php?status=error');
}
exit;
?>
