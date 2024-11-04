<?php
require_once 'utils/functions.php';

function createPurchaseRequest($userId, $treeId) {
    $conn = getConnection(); 

    if ($conn) {

        $sql = "INSERT INTO soli_compra (id_user, id_arbol, fecha_soli, estado) VALUES (?, ?, NOW(), 'COMPLETADA')";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ii", $userId, $treeId);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                $updateSql = "UPDATE arboles SET estado = 'VENDIDO' WHERE id = ?";
                $updateStmt = mysqli_prepare($conn, $updateSql);

                if ($updateStmt) {
                    mysqli_stmt_bind_param($updateStmt, "i", $treeId);
                    if (mysqli_stmt_execute($updateStmt)) {
                        mysqli_stmt_close($updateStmt);
                        mysqli_close($conn);
                        return true; // Se completaron ambas consultas con éxito
                    } else {
                        die("Error al ejecutar la consulta de actualización: " . mysqli_stmt_error($updateStmt));
                    }
                } else {
                    die("Error al preparar la consulta de actualización: " . mysqli_error($conn));
                }
            } else {
                die("Error al ejecutar la consulta de inserción: " . mysqli_stmt_error($stmt));
            }
        } else {
            die("Error al preparar la consulta de inserción: " . mysqli_error($conn));
        }
        mysqli_close($conn);
    } else {
        die("Error al conectar a la base de datos.");
    }
    return false;
}

function getUserPurchasedTrees($userId) {
    $conn = getConnection();

    if ($conn) {
        $sql = "SELECT trees.id, trees.ubicacion, trees.estado, trees.precio, trees.foto_arbol, trees.tam,
                       especies.nombreComercial AS especie
                FROM soli_compra 
                JOIN arboles AS trees ON soli_compra.id_arbol = trees.id
                JOIN especies ON trees.especie_comercial = especies.idEspecie
                WHERE soli_compra.id_user = ? AND soli_compra.estado = 'COMPLETADA' AND trees.estado = 'VENDIDO'";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $userId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $purchasedTrees = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $purchasedTrees[] = $row;
            }

            mysqli_stmt_close($stmt);
            mysqli_close($conn);

            return $purchasedTrees; // Retornar los datos de los árboles comprados
        } else {
            die("Error al preparar la consulta: " . mysqli_error($conn));
        }
    } else {
        die("Error al conectar a la base de datos.");
    }

    return []; // Retornar un arreglo vacío en caso de error
}

?>
