<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    function enviarEmail($email, $asunto, $cuerpo): bool {
        require_once './config/config.php';
        require './vendor/autoload.php';

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;//SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'enriquetaboadamontiel.ipn@gmail.com';                     //SMTP username
            $mail->Password   = 'objnrgbmbskuhhio';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('enriquetaboadamontiel.ipn@gmail.com', 'ZAMAZOR store');
            $mail->addAddress($email);     //Add a recipient
            // $mail->addCC('cc@example.com');  enviar copias
            // $mail->addBCC('bcc@example.com');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $asunto;

            $mail->Body    = mb_convert_encoding($cuerpo, "ISO-8859-1", "UTF-8");
            $mail->setLanguage('es', '../vendor/phpmailer/phpmailer/language/phpmailer.lang-es.php');

            if($mail->send()) {
                return true;
            }
            else {
                return false;
            }
        } catch (Exception $e) {
            echo "No se pudo enviar el correo: {$mail->ErrorInfo}";
            return false;
        }
    }
}

?>