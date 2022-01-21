<?php
require_once("../../private/conexao.php");
session_start();
ob_start();
if (!isset($_SESSION['email']) || $_SESSION['email'] == "") {
    header("Location: ../");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilosHome.css?version=4">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

    <title>Nova Senha</title>
</head>

<body>
    <div class="navBar">
        <div class="logo_home">
            <a href="index.php"><img src="../assets/athena.svg" class="logo"></a>
        </div>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class='bx bx-menu'></i>
        </label>

    </div>

    <div style="position:absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); text-align: center;">
        <i class='bx bx-lock bx-tada' style="font-size: 200px; color: #715aff"></i>
        <h1 style="font-size: 30px; font-weight: 100;">Alteração de senha foi enviada para: <br>
            <b><?php echo $_SESSION["email"]; ?></b>
        </h1>
    </div>

    <?php
    require_once "../PHPMailer/PHPMailer.php";
    require_once "../PHPMailer/SMTP.php";
    require_once "../PHPMailer/Exception.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    $mail = new PHPMailer(true);
    $email = $_SESSION["email"];

    $statement = $conecta->prepare("SELECT vkey FROM usuarios WHERE email=:email LIMIT 1");
    $statement->bindValue(':email', $email);
    if ($statement->execute()) {
        $dados_db = $statement->fetch(PDO::FETCH_ASSOC);
        $vkey = $dados_db["vkey"];

        // enviar email
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
            $mail->addAddress($email);     //Add a recipient

            // //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Nova senha';
            $mail->Body    = "Olá, Se você NÃO solicitou alteração de senha NÃO clique no link abaixo: <br> ";
            $mail->Body    .= "<a href='http://localhost/Biblioteca/biblioteca/public/home/alterarSenha.php?email=$email&vkey=$vkey'>Alterar minha senha</a>";

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "<script>window.location='../'</script>";
    }


    ?>

</body>

</html>