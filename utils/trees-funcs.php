<?php
require_once 'functions.php';


/**
 * Inserts a new tree record into the database with the specified details.
 *
 */
function createTree($especieId, $ubicacion, $estado, $precio, $foto, $tam) {
    $conn = getConnection();
    $query = "INSERT INTO arboles (especie_comercial, ubicacion, estado, precio, foto_arbol, tam) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'issdss', $especieId, $ubicacion, $estado, $precio, $foto, $tam);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $success;
}

/**
 * Retrieves all tree records from the database with their species details.
 *
 * @return array Returns an array of tree records, each containing their details.
 */
function getTrees(): array {
    $conn = getConnection();
    $trees = [];

    if ($conn) {
        $query = "
            SELECT arboles.id, arboles.ubicacion, arboles.estado, arboles.precio, arboles.foto_arbol, arboles.tam,
                   especies.nombreComercial AS especie, especies.nombreCientifico AS nombre_cientifico
            FROM arboles
            JOIN especies ON arboles.especie_comercial = especies.idEspecie
        ";
        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $trees[] = $row;
            }
        }

        mysqli_close($conn);
    }

    return $trees;
}

/**
 * Retrieves a specific tree record by its ID, along with its species details.
 *
 * @param int $id The ID of the tree to retrieve.
 * @return array|null Returns the tree record if found, otherwise null.
 */
function getTreeById($id) {
    $conn = getConnection();
    $query = "SELECT arboles.*, especies.nombreComercial AS especie, especies.nombreCientifico AS nombre_cientifico
              FROM arboles 
              JOIN especies ON arboles.especie_comercial = especies.idEspecie 
              WHERE arboles.id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $tree = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $tree;
}

/**
 * Updates an existing tree record in the database with new details.
 */
function updateTree($id, $especieId, $ubicacion, $estado, $precio, $foto, $tam) {
    $conn = getConnection();
    $query = "UPDATE arboles SET especie_comercial = ?, ubicacion = ?, estado = ?, precio = ?, foto_arbol = ?, tam = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'issdssi', $especieId, $ubicacion, $estado, $precio, $foto, $tam, $id);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $success;
}

/**
 * Deletes a tree record from the database by its ID.
 */
function deleteTree($id) {
    $conn = getConnection();
    $query = "DELETE FROM arboles WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $success;
}

/**
 * Checks if a tree with the specified details already exists in the database.
 */
function treeExists( $especieId, $ubicacion, $estado, $precio, $foto, $tam): bool {
    $conn = getConnection();
    $exists = false;

    if ($conn) {
        $query = "SELECT COUNT(*) AS total FROM arboles WHERE especie_comercial = ?, ubicacion = ?, estado = ?, precio = ?, foto_arbol = ?, tam = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'issdss', $especieId, $ubicacion, $estado, $precio, $foto, $tam);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $exists = $row['total'] > 0;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }

    return $exists;
}
?>
