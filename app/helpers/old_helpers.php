<?php
//
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;
//use PHPMailer\PHPMailer\SMTP;
//
//// QUESTO FILE LO RICHIAMO NEL COMPOSER.JSON
//
///* SEND EMAIL FUNCTION USING PHPMAILER LIBRARY */
//if ( !function_exists('sendMail') )
//{
//    function sendMail($mailConfig)
//    {
////        dd($mailConfig);
//
//        require 'PHPMailer/src/Exception.php';
//        require 'PHPMailer/src/PHPMailer.php';
//        require 'PHPMailer/src/SMTP.php';
//
//        $mail = new PHPMailer(true);
//        $mail->SMTPDebug  = 0;
////        $mail->isSMTP();
//        $mail->Host = env('MAIL_HOST');
//        $mail->SMTPAuth = true;
//        $mail->Username = env('MAIL_USERNAME');
//        $mail->Host = env('MAIL_PASSWORD');
//        $mail->SMTPSecure = env('MAIL_ENCRYPTION');
//        $mail->Port = env('MAIL_PORT');
//        $mail->setFrom($mailConfig['mail_from_email'], $mailConfig['mail_from_name']);
//        $mail->addAddress($mailConfig['mail_recipient_email'], $mailConfig['mail_recipient_name']);
//        $mail->isHTML(true);
//        $mail->Subject = $mailConfig['mail_subject'];
//        $mail->Body = $mailConfig['mail_body'];
//
//        if ($mail->send()) return true;
//        else return false;
//
//
//    }
//}
//
