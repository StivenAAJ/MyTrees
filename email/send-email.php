<?php
// Imports the PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';


function enviarCorreoNotificacion($arboles) {
    $mail = new PHPMailer(true);

    try {
        // Gmail SMTP server configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true; 
        $mail->Username = 'esender33@gmail.com';
        $mail->Password = 'cmwb zsfn cyog mtlk'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port = 587; 

         // Message configuration
        $mail->setFrom('esender33@gmail.com', 'Notificación de Actualización');
        $mail->addAddress('stivenjim2005@gmail.com'); 
        $mail->isHTML(true);
        $mail->Subject = 'Árboles desactualizados';
        
         // Create the message body with outdated trees
        $cuerpo = "<h3>Los siguientes árboles no han sido actualizados desde hace más de 1 mes:</h3><ul>";
        foreach ($arboles as $arbol) {
            $cuerpo .= "<li>Árbol ID: {$arbol['id']}</li>";
        }
        $cuerpo .= "</ul>";
        
        $mail->Body = $cuerpo;

        // Send the email
        $mail->send();
        echo "Correo enviado correctamente.";
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}
