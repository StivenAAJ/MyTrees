<?php
// Importa las clases de PHPMailer en el espacio de nombres global
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Asegúrate de ajustar la ruta si necesitas
require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';


function enviarCorreoNotificacion($arboles) {
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP de Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Servidor SMTP de Gmail
        $mail->SMTPAuth = true; // Habilitar autenticación SMTP
        $mail->Username = 'esender33@gmail.com'; // Tu dirección de correo
        $mail->Password = 'cmwb zsfn cyog mtlk'; // Tu contraseña o contraseña de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Habilitar cifrado TLS
        $mail->Port = 587; // Puerto TCP para TLS

        // Configuración del mensaje
        $mail->setFrom('esender33@gmail.com', 'Notificación de Actualización');
        $mail->addAddress('stivenjim2005@gmail.com'); // Cambia esto al correo del administrador
        $mail->isHTML(true);
        $mail->Subject = 'Árboles desactualizados';
        
        // Crea el cuerpo del mensaje con los árboles desactualizados
        $cuerpo = "<h3>Los siguientes árboles no han sido actualizados desde hace más de 1 mes:</h3><ul>";
        foreach ($arboles as $arbol) {
            $cuerpo .= "<li>Árbol ID: {$arbol['id']}</li>";
        }
        $cuerpo .= "</ul>";
        
        $mail->Body = $cuerpo;

        // Enviar el correo
        $mail->send();
        echo "Correo enviado correctamente.";
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}
