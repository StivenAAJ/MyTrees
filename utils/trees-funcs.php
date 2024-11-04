<?php
require_once 'functions.php';



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

function getTrees(): array {
    $conn = getConnection();
    $trees = [];

    if ($conn) {
        $query = "
            SELECT arboles.id, arboles.ubicacion, arboles.estado, arboles.precio, arboles.foto_arbol, arboles.tam,
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
    $query = "SELECT arboles.*, especies.nombreComercial AS especie 
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
