<?php
require_once 'functions.php';

// Retrieves the stored data from species
function getEspecies(): array {
    $conn = getConnection();
    $especies = [];
    
    if ($conn) {
        $query = "SELECT idEspecie, nombreComercial, nombreCientifico FROM especies";
        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $especies[] = $row;
            }
        }

        mysqli_close($conn);
    }
    
    return $especies;
}

// Retrieves a species by its ID
function getEspecieById($id) {
    $conn = getConnection();
    $especie = null;

    if ($conn) {
        $query = "SELECT idEspecie, nombreComercial, nombreCientifico FROM especies WHERE idEspecie = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $especie = mysqli_fetch_assoc($result);
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }

    return $especie;
}

/**
 * Inserts a new species into the database with its commercial and scientific names.
 */
function createEspecie($nombreCo, $nombreCi) {
    $conn = getConnection();

    if ($conn) {
        $query = "INSERT INTO especies (nombreComercial, nombreCientifico) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ss', $nombreCo, $nombreCi);
        mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}

/**
 * Updates the data of a specific species in the database.
 */
function updateEspecie($id, $nombreCo, $nombreCi) {
    $conn = getConnection();

    if ($conn) {
        $query = "UPDATE especies SET nombreComercial = ?, nombreCientifico = ? WHERE idEspecie = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ssi', $nombreCo, $nombreCi, $id);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}

/**
 * Deletes a species from the database using its ID.
 */
function deleteEspecie($id) {
    $conn = getConnection();

    if ($conn) {
        $query = "DELETE FROM especies WHERE idEspecie = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}

/**
 * Checks if there is at least one species in the database.
 * Returns `true` if there are species, `false` otherwise.
 */
function verifySpeciesExist(): bool {
    $conn = getConnection();
    $exists = false;

    if ($conn) {
        $query = "SELECT COUNT(*) AS total FROM especies";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $exists = $row['total'] > 0; // Verifica si hay al menos una especie
        }

        mysqli_close($conn);
    }

    return $exists;
}

/**
 * Checks if a species with the commercial name or scientific name already exists in the database.
 * Returns `true` if it exists, `false` if not.
 */
function especieExists($nombreCo, $nombreCi): bool {
    $conn = getConnection();
    $exists = false;

    if ($conn) {
        $query = "SELECT COUNT(*) AS total FROM especies WHERE nombreComercial = ? OR nombreCientifico = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ss', $nombreCo, $nombreCi);
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

