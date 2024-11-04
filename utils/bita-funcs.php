<?php
require_once(__DIR__ . '/functions.php');

/** 
 * Inserts a record into the log and updates the tree status in the database.
 */
function updateBitacora($tree_id, $tam, $estado) {
    $conn = getConnection();

    if ($conn) {
        $query = "INSERT INTO bitacora_arbol (id_arbol, tam, estado, fecha_actualizacion) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iss", $tree_id, $tam, $estado);

        if ($stmt->execute()) {
            // If the log insertion was successful, update the status in the trees table
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
// Check if the update form was submitted
if (isset($_POST['update_bitacora'])) {
    $tree_id = $_POST['tree_id'];
    $tam = $_POST['tam'];
    $estado = $_POST['estado'];

    updateBitacora($tree_id, $tam, $estado);

    // Redirect or show a success message
    header("Location: /bitacora.php?success=1");
    exit();
}
?>
