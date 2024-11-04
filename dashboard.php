<?php
// Starts the session and verifies the role
session_start();
require('utils/dashboard-funcs.php');
require('inc/header.php'); 

// Redirects to warning.php if the user is not an administrator
if ($_SESSION['user_role'] !== 'ADMIN') {
    header('Location: warning.php');
    exit;
}

// Gets the statistics
$amigosRegistrados = getCantidadAmigos();
$arbolesDisponibles = getCantidadArbolesDisponibles();
$arbolesVendidos = getCantidadArbolesVendidos();
?>
<body>
    <div class="dashboard-container">
        <h1>Panel de Administración</h1>
        <div class="stats">
            <div class="stat-item">
                <h2>Cantidad de Amigos Registrados</h2>
                <p><?php echo htmlspecialchars($amigosRegistrados); ?></p>
            </div>
            <div class="stat-item">
                <h2>Cantidad de Árboles Disponibles</h2>
                <p><?php echo htmlspecialchars($arbolesDisponibles); ?></p>
            </div>
            <div class="stat-item">
                <h2>Cantidad de Árboles Vendidos</h2>
                <p><?php echo htmlspecialchars($arbolesVendidos); ?></p>
            </div>
        </div>
    </div>
    <?php require('inc/footer.php'); ?>

