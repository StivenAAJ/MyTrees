<?php
require '../utils/functions.php'; 
require 'send-email.php';

/**
 * Checks if there are outdated trees in the database.
 * Queries the table to find records that have not been
 * updated in the last minute. If it finds outdated trees,
 * it sends an email.
 */
function verificarArbolesDesactualizados() {
    $conn = getConnection();
    $arbolesDesactualizados = [];

    if ($conn) {
        $query = "SELECT id FROM bitacora_arbol WHERE fecha_actualizacion <= DATE_SUB(NOW(), INTERVAL 1 MINUTE)";
        $result = $conn->query($query);
        if ($result === false) {
            echo "Error en la consulta: " . $conn->error;
            return;
        }
        
        while ($row = $result->fetch_assoc()) {
            $arbolesDesactualizados[] = $row;
        }
        
    }

    // If there are outdated trees, send an email notification
    if (!empty($arbolesDesactualizados)) {
        echo "Se encontraron " . count($arbolesDesactualizados) . " árboles desactualizados. Enviando notificación.";
        enviarCorreoNotificacion($arbolesDesactualizados);
    } else {
        echo "No se encontraron árboles desactualizados.";
    }
    
}

// Executes the function
verificarArbolesDesactualizados();
