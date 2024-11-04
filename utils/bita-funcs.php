<?php
require_once(__DIR__ . '/functions.php');


function updateBitacora($tree_id, $tam, $estado) {
    $conn = getConnection();

    if ($conn) {
        $query = "INSERT INTO bitacora_arbol (id_arbol, tam, estado, fecha_actualizacion) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iss", $tree_id, $tam, $estado);

        if ($stmt->execute()) {
            // Si la inserción en bitácora fue exitosa, actualizar el estado en la tabla arboles
            $updateQuery = "UPDATE arboles SET estado = ?, tam = ? WHERE id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("ssi", $estado, $tam, $tree_id);
            $updateStmt->execute();
            $updateStmt->close();
        }

        $stmt->close();
        $conn->close();
    }
}

// Verificar si se envió el formulario de actualización
if (isset($_POST['update_bitacora'])) {
    $tree_id = $_POST['tree_id'];
    $tam = $_POST['tam'];
    $estado = $_POST['estado'];

    updateBitacora($tree_id, $tam, $estado);

    // Redireccionar o mostrar un mensaje de éxito
    header("Location: /bitacora.php?success=1");
    exit();
}
?>