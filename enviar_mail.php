<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require 'vendor/autoload.php';
$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = SMTP::DEBUG_OFF;
$mail->Host = 'smtp.gmail.com';

$mail->SMTPAuth = true;
$mail->Username = 'gestio.encarrec.noreply@gmail.com';
$mail->Password = 'gestio1234';
$name='Gestió Encàrrec Docent';
$name = utf8_decode($name);
$mail->setFrom('gestio-encarrec@no-reply.com', $name);

$mail->addAddress($email_envia, $nom_envia);
$subject = 'Permís per escollir grups';
$subject = utf8_decode($subject);
$mail->Subject = $subject;
$mail->CharSet = 'UTF-8';

$message  = '';
$message .= 'Benvolgut/da professor/a,' . "<br><br>";
$message .= 'Ja pot escollir els grups als quals vol impartir classe durant el següent curs acadèmic a través del següent link: http://google.com. La contrasenya és el seu DNI. Un cop tanqui sessió se li demanarà si les dades ja es poden validar o no, en cas afirmatiu, el següent professor a la llista de prioritats rebrà el mateix correu i també podrà escollir. El fet de validar les dades, no impedeix que pugui seguir modificant els grups escollits.'. "<br><br><br><br>";
$message .= "Aquest correu s'ha generat de forma automàtica. No respondre.";

$mail->msgHTML($message,__DIR__);

if (!$mail->send()) {
    echo 'Mailer Error: '. $mail->ErrorInfo;
} else{
    
    echo "<script type='text/javascript'> window.alert('Validat! El següent professor a la llista de prioritats ja té permís per escollir, rebrà un email de notificació. Pots seguir modificant els grups escollits.')</script>";
}


 ?>
