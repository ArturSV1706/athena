<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" id="myForm">
        <h2>enviar email</h2>

        <label for="nome">Nome</label>
        <input id="nome" type="text">

        <label for="email">email</label>
        <input id="email" type="text">

        <label for="assunto">assunto</label>
        <input id="assunto" type="text">

        <p>Message</p>
        <textarea id="body" rows="5"></textarea>
        <button type="submit" onclick="sendEmail()" value="send an Email">enviar</button>
    </form>
    <?php

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    require_once "./PHPMailer.php";
    require_once "./SMTP.php";
    require_once "./Exception.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;



    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'artursv1706@gmail.com';                     //SMTP username
        $mail->Password   = 'daysofdemonhunter';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('artursv1706@gmail.com', 'Mailer');
        $mail->addAddress('artursv1706@gmail.com', 'Joe User');     //Add a recipient

        // //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Oporra';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }


    ?>
</body>

</html>