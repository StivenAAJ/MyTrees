<?php
require(__DIR__ . '/functions.php');

// Gets the number of registered friends
function getCantidadAmigos() {
    $conn = getConnection();
    $sql = "SELECT COUNT(*) AS total FROM users WHERE rol = 'USER'";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();
    $conn->close();
    return $data['total'];
}

// Gets the number of available trees
function getCantidadArbolesDisponibles() {
    $conn = getConnection();
    $sql = "SELECT COUNT(*) AS total FROM arboles WHERE estado = 'DISPONIBLE'";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();
    $conn->close();
    return $data['total'];
}

// Gets the number of sold trees
function getCantidadArbolesVendidos() {
    $conn = getConnection();
    $sql = "SELECT COUNT(*) AS total FROM arboles WHERE estado = 'VENDIDO'";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();
    $conn->close();
    return $data['total'];
}
?>
