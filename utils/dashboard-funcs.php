<?php
require(__DIR__ . '/functions.php');

// Obtiene la cantidad de amigos registrados
function getCantidadAmigos() {
    $conn = getConnection();
    $sql = "SELECT COUNT(*) AS total FROM users WHERE rol = 'USER'";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();
    $conn->close();
    return $data['total'];
}

// Obtiene la cantidad de árboles disponibles
function getCantidadArbolesDisponibles() {
    $conn = getConnection();
    $sql = "SELECT COUNT(*) AS total FROM arboles WHERE estado = 'DISPONIBLE'";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();
    $conn->close();
    return $data['total'];
}

// Obtiene la cantidad de árboles vendidos
function getCantidadArbolesVendidos() {
    $conn = getConnection();
    $sql = "SELECT COUNT(*) AS total FROM arboles WHERE estado = 'VENDIDO'";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();
    $conn->close();
    return $data['total'];
}
?>
