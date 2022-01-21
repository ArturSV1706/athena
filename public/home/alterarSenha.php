<?php
require_once("../../private/conexao.php");
session_start();
ob_start();
if (!isset($_GET['email']) || !isset($_GET['vkey'])) {
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
    <form method='POST' onsubmit="return checarSenha();">
        <div class="logo_home">
            <img src="../assets/athena_escuro.svg" class="logo">
        </div>

        <label for='senha'><strong>Nova Senha*</strong></label>
        <input name='senha' id="senha" type='password'>

        <label for='confirmarSenha'><strong>Confirmar nova senha*</strong></label>
        <input name='confirmarSenha' id="confirmarSenha" type='password'>


        <div id="mensagem"></div>


        <button type='submit' name='submit' onclick="checarSenha()" style='margin-top: 10px' class='botao'>Salvar Alterações</button>
    </form>

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

    <?php

    $email = $_GET["email"];
    $vkey = $_GET["vkey"];

    $statement = $conecta->prepare("SELECT usuariosID, vkey FROM usuarios WHERE email=:email LIMIT 1");
    $statement->bindValue(':email', $email);
    $statement->execute();

    // if ($statement->rowCount() == 0) {
    //     echo "<script>window.location='../'</script>";
    // }

    $dados_db = $statement->fetch(PDO::FETCH_ASSOC);
    $vkey_db = $dados_db["vkey"];

    if ($vkey = $vkey_db) {
        if (isset($_POST['submit'])) {

            $senha = $_POST["senha"];
            $senha = htmlspecialchars($senha);
            $senha = password_hash($senha, PASSWORD_DEFAULT);

            $statement_update = $conecta->prepare("UPDATE usuarios SET senha=:senha WHERE email=:email_");
            $statement_update->bindValue(':email_', $email);
            $statement_update->bindValue(':senha', $senha);
            $statement_update->execute();
            unset($_GET['email'], $_GET['email']);
            header("Location: ../");

            // echo "<script>window.location='../'</script>";
        }
    } else {
        // echo "<script>window.location='../'</script>";
    }

    ?>

</body>

</html>