<?php
require '../utils/functions.php'; 
require 'send-email.php';

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

    // Si hay árboles desactualizados, envía una notificación por correo
    if (!empty($arbolesDesactualizados)) {
        echo "Se encontraron " . count($arbolesDesactualizados) . " árboles desactualizados. Enviando notificación.";
        enviarCorreoNotificacion($arbolesDesactualizados);
    } else {
        echo "No se encontraron árboles desactualizados.";
    }
    
}

// Ejecuta la función
verificarArbolesDesactualizados();
