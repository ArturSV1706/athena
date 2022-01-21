<?php require_once("../../private/conexao.php"); 
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilosHome.css?version=8" />
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <title>Document</title>
</head>

<body>
    <div class="loader" id="loader">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <script>
        var loader = document.getElementById("loader");
        window.onload = function() {
            loader.style.display = 'none';
        }
    </script>
   
   <div class="navBar">
        <div class="logo_home">
            <a href="index.php"><img src="../assets/athena.svg" class="logo"></a>
        </div>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class='bx bx-menu'></i>
        </label>
       
    </div>

    <form method='POST' onsubmit="return checarSenha();">
        <div class="logo_home">
            <img src="../assets/athena_escuro.svg" class="logo">
        </div>
        <label for='nome'><strong>Nome*</strong></label>
        <input name='nome' autocomplete="off" type='text' class='form-control' required>

        <label for='email'><strong>Email*</strong></label>
        <input name='email' type='email' class='form-control'>

        <label for='telefone'><strong>Telefone*</strong></label>
        <input name='telefone' type='number' class='form-control'>

        <label for='senha'><strong>Senha*</strong></label>
        <input name='senha' id="senha" type='password'>

        <label for='confirmarSenha'><strong>Confirmar senha*</strong></label>
        <input name='confirmarSenha' id="confirmarSenha" type='password'>

       
            <div id="mensagem"></div>

        <div class="g-recaptcha" id="captcha" data-sitekey="6Le6U_UdAAAAAEu-Pr_T02vxrtGfyyu6NJnizQUQ"></div>

        <button type='submit' name='submit' onclick="checarSenha()" style='margin-top: 10px' class='botao'>Salvar Alterações</button>
    </form>
    <?php
    require_once "../PHPMailer/PHPMailer.php";
    require_once "../PHPMailer/SMTP.php";
    require_once "../PHPMailer/Exception.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    $mail = new PHPMailer(true);

    if (isset($_POST['submit'])) {

        $secretKey = "6Le6U_UdAAAAAEvGjaNe59U0fyjFKF2KFeaAfy88";
        $responseKey = $_POST['g-recaptcha-response'];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey";

        $response = file_get_contents($url);
        $response = json_decode($response);

        if ($response->success) {

            $nome = $_POST["nome"];
            $nome = htmlspecialchars($nome);

            $email = $_POST["email"];
            $email = htmlspecialchars($email);
            unset($_SESSION['email']);
            $_SESSION['email'] = $email;


            $telefone = $_POST["telefone"];
            $telefone = htmlspecialchars($telefone);

            $senha = $_POST["senha"];
            $senha = htmlspecialchars($senha);

            $senha = password_hash($senha, PASSWORD_DEFAULT);

            //  Gerador da Vkey
            $vkey = md5(time() . $nome);

            $statement_email_repetido = $conecta->prepare("SELECT email, verified FROM usuarios WHERE email=:email_verificar");
            $statement_email_repetido->bindValue(':email_verificar', $email);
            $statement_email_repetido->execute();

            if ($statement_email_repetido->rowCount() == 0) {
                $statement = $conecta->prepare("INSERT INTO usuarios (nome, email, telefone, senha, vkey) VALUES (:nome, :email, :telefone, :p, :vkey)");
                $statement->bindValue(':nome', $nome);
                $statement->bindValue(':email', $email);
                $statement->bindValue(':telefone', $telefone);
                $statement->bindValue(':p', $senha);
                $statement->bindValue(':vkey', $vkey);
                $statement->execute();

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
                    $mail->Subject = 'Confirmar Email';
                    $mail->Body    = "Olá <b>$nome</b> Por favor confirme seu email: ";
                    $mail->Body    .= "<a href='http://localhost/Biblioteca/biblioteca/public/home/verificar.php?vkey=$vkey'> Confirmar Email </a>";

                    $mail->send();

                    echo "<script>window.location='emailEnviado.php'</script>";
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "<script>
                let mensagem = document.getElementById('mensagem');mensagem.textContent = 'Este email já está em uso, selecione outro';
                </script>";
            }
        } else {
            if(!isset($_POST['submit']))
            echo "erro no captcha";
        }
    }


    ?>

    <script>
        function checarSenha() {
            let senha = document.getElementById("senha").value;
            let confirmarSenha = document.getElementById("confirmarSenha").value;
            let mensagem = document.getElementById("mensagem");

            if (senha != confirmarSenha) {
                mensagem.textContent = "Senhas diferentes";
                return false;
            }
            const isWhitespace = /^(?=.*\s)/;
            if (isWhitespace.test(senha)) {
                mensagem.textContent = "Senhas não podem conter espaços em branco";
                return false;
            }


            const isContainsUppercase = /^(?=.*[A-Z])/;
            if (!isContainsUppercase.test(senha)) {
                mensagem.textContent = "Senhas precisam conter pelo menos um caractere maiúsculo";
                return false;
            }


            const isContainsLowercase = /^(?=.*[a-z])/;
            if (!isContainsLowercase.test(senha)) {
                mensagem.textContent = "Senhas precisam conter pelo menos um caractere minúsculo";
                return false;
            }


            const isContainsNumber = /^(?=.*[0-9])/;
            if (!isContainsNumber.test(senha)) {
                mensagem.textContent = "Senhas precisam conter pelo menos um número";
                return false;
            }


            const isContainsSymbol =
                /^(?=.*[~`!@#$%^&*()--+={}\[\]|\\:;"'<>,.?/_₹])/;
            if (!isContainsSymbol.test(senha)) {
                mensagem.textContent = "Senhas precisam conter pelo menos um símbolo ( #, *, &, ...)";
                return false;
            }

            const isValidLength = /^.{8,16}$/;
            if (!isValidLength.test(senha)) {
                mensagem.textContent = "Senhas precisam entre 8 e 16 characteres";
                return false;
            }

            return true;

        }
    </script>
</body>

</html>