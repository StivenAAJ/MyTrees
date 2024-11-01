<?php
require_once 'functions.php';



function createTree($especieId, $ubicacion, $estado, $precio, $foto) {
    $conn = getConnection();
    $query = "INSERT INTO arboles (especie_comercial, ubicacion, estado, precio, foto_arbol) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'issds', $especieId, $ubicacion, $estado, $precio, $foto);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $success;
}

function getTrees(): array {
    $conn = getConnection();
    $trees = [];

    if ($conn) {
        $query = "
            SELECT arboles.id, arboles.ubicacion, arboles.estado, arboles.precio, arboles.foto_arbol,
                   especies.nombreComercial AS especie
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


function getTreeById($id) {
    $conn = getConnection();
    $query = "SELECT * FROM arboles WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $tree = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $tree;
}

function updateTree($id, $especieId, $ubicacion, $estado, $precio, $foto) {
    $conn = getConnection();
    $query = "UPDATE arboles SET especie_comercial = ?, ubicacion = ?, estado = ?, precio = ?, foto_arbol = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'issdsi', $especieId, $ubicacion, $estado, $precio, $foto, $id);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $success;
}

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
?>
