<?php

function sendmail($body, $subject, $receiver, $receiver_name)
    {
        require 'PHPMailer/PHPMailerAutoload.php';

        $mail = new PHPMailer;

        //$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'haaziq.hashirbuksh@gmail.com';                 // SMTP username
        $mail->Password = 'Haaziqbhai1234!';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->setFrom('haaziq.hashirbuksh@gmail.com', 'Cafeteria Operating System');
        $mail->addAddress($receiver, $receiver_name);     // Add a recipient
        //$mail->addAddress('divneshr@gmail.com'); 
        //$mail->addAddress('haaziq.buksh@gmail.com'); 
        //$mail->addAddress('shimneetchand@gmail.com');             // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML

        //$body = '<p>No class this week</p>';
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = strip_tags($body);

        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }

?>