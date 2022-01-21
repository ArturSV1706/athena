<?php
session_start();
ob_start();
require_once("../private/conexao.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Athena - Entrar</title>
    <link rel="icon" href="assets/favicon.svg" sizes="any" type="image/svg+xml">

    <link rel="stylesheet" type="text/css" href="estilosLogin.css?version=2">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>


</head>

<body>
    <?php require_once("Misc/telaDeCarregamento.php")?>

    <img class="wave" src="assets/waveLogin.svg">
    <div class="container">
        <div class="img">
            <img src="assets/fundoLogin.svg">
        </div>
        <div class="login-content">
            <form action="#" method="post"">
				<img src=" assets/athena.svg">
                <!-- <h2 class="title">Bem Vindo</h2> -->
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>Email</h5>
                        <input type="email" name="email" class="input" />
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Senha</h5>
                        <input type="password" name="senha" class="input" />
                    </div>
                </div>
                <a href='home/novaSenha.php'>Esqueceu sua senha?</a>
                <div class="g-recaptcha" id="captcha" data-sitekey="6Le6U_UdAAAAAEu-Pr_T02vxrtGfyyu6NJnizQUQ"></div>
                <p id="mensagem" style="color: #ff2957"></p>

                <button type="submit" name="submit" class="btn">Entrar</button>

                <a href="home/" style="text-align: center;">Voltar para a página principal</a>
            </form>

            <?php

            if (isset($_POST['submit'])) {
                $secretKey = "6Le6U_UdAAAAAEvGjaNe59U0fyjFKF2KFeaAfy88";
                $responseKey = $_POST['g-recaptcha-response'];
                $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey";

                $response = file_get_contents($url);
                $response = json_decode($response);

                $email = $_POST["email"];
                $email = htmlspecialchars($email);
                $_SESSION["email"] = $email;

                $senha = $_POST["senha"];
                $senha = htmlspecialchars($senha);

                if ($response->success) {

                    $statement = $conecta->prepare("SELECT usuariosId, nome, email, senha, verified FROM usuarios WHERE email=:email LIMIT 1");
                    $statement->bindValue(':email', $email);
                    $statement->execute();

                    if (($statement) && ($statement->rowCount() != 0)) {
                        $dados_db = $statement->fetch(PDO::FETCH_ASSOC);
                        $verified = $dados_db["verified"];
                        if ($verified == 1) {
                            if (password_verify($senha, $dados_db["senha"])) {
                                $_SESSION["userID"] = $dados_db["usuariosId"];
                                $_SESSION["nome"] = $dados_db["nome"];
                                header("location: Painel/");
                            } else {
                                echo "<script>
                                let mensagem = document.getElementById('mensagem');mensagem.textContent = 'Email ou senha inválida';
                                </script>";
                            }
                        } else {
                            echo "<script>
                            let mensagem = document.getElementById('mensagem');mensagem.textContent = 'Verifique seu email no endereço: " . $email . "';
                            </script>";
                        }
                    } else {
                        echo "<script>
                let mensagem = document.getElementById('mensagem');mensagem.textContent = 'Email ou senha inválida';
                </script>";
                    }
                } else {
                    echo "<script>
                let mensagem = document.getElementById('mensagem');mensagem.textContent = 'Erro no captcha';
                </script>";
                }
            }
            ?>

        </div>
    </div>
    <script type="text/javascript" src="loginFoco.js"></script>


</body>

</html>