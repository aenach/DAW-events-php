<?php

require_once('class.phpmailer.php');

function send_email($to, $subject, $message, $setReplyTo = 'proiectproiect61@gmail.com') {
    $mail = new PHPMailer(true);

    $mail->IsSMTP();

    try {
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host       = "smtp.gmail.com";
        $mail->Port       = 465;
        $mail->Username   = 'alexandru.c.enache@gmail.com';
        $mail->Password   = 'oasj dgne grtd sshr';

        $mail->AddAddress($to);

        $mail->SetFrom('proiectproiect61@gmail.com', 'Daw Project');
        if (is_string($setReplyTo)) {
            $mail->AddReplyTo($setReplyTo, 'Daw Project');
        }


        $mail->Subject = $subject;
        $mail->AltBody = 'To view this message, please use an HTML compatible email viewer!';
        $mail->MsgHTML($message);
        $mail->Send();

        return true; // Message sent successfully
    } catch (phpmailerException $e) {
        return $e->errorMessage(); // Error from PHPMailer
    } catch (Exception $e) {
        return $e->getMessage(); // Error from anything else
    }
}
