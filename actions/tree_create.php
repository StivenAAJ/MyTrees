<?php
require_once '../utils/functions.php';
require_once '../utils/trees-funcs.php';
require_once '../utils/especies-funcs.php';

// Verificar si se han enviado los datos necesarios
if (isset($_POST['especie'], $_POST['ubicacion'], $_POST['estado'], $_POST['precio']) && isset($_FILES['foto'])) {
    $especieId = $_POST['especie'];
    $ubicacion = $_POST['ubicacion'];
    $estado = $_POST['estado'];
    $precio = $_POST['precio'];
    $tam = $_POST['tam'];

    // Procesar la imagen
    $fotoName = basename($_FILES['foto']['name']);
    $fotoPath = '../images/' . $fotoName;
    
    if (move_uploaded_file($_FILES['foto']['tmp_name'], $fotoPath)) {
        // Guardar solo la URL relativa en la base de datos
        $fotoUrl = 'images/' . $fotoName;

        // Crear el árbol en la base de datos
        if (createTree($especieId, $ubicacion, $estado, $precio, $fotoUrl, $tam)) {
            header('Location: ../trees.php?success=1');
            exit;
        } else {
            echo "Error al crear el árbol en la base de datos.";
        }
    } else {
        echo "Error al subir la foto.";
    }
} else {
    echo "Datos incompletos. Por favor, completa todos los campos.";
}
?>
