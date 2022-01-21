<?php


function campoVazio($email, $senha)
{
    $resultado = false;

    if (empty($email) || empty($senha)) {
        $resultado = true;
    } else {
        $resultado = false;
    }
    return $resultado;
}

function emailExiste($conecta, $email)
{
 
    $statement = $conecta->prepare("SELECT * FROM usuarios WHERE email = :email");
    $statement->bindValue(':email', $email);
    $statement->execute();


    if ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        return $row;
    } else {
        $resultado = false;
        return $resultado;
    }
}

function loginUser($conecta, $email, $senha)
{
    $emailExiste = emailExiste($conecta, $email);

    if ($emailExiste === false) {
        header("location: ../public/index.php?erro=loginErrado");
        exit();
    }

    $pwdHashed = $emailExiste["senha"];
    $checkPwd = password_verify($senha, $pwdHashed);

    if ($pwdHashed !== $senha) {
        header("location: ../public/index.php?erro=loginErrado(senha)$senha");
        exit();
    } else{
        session_start();
        $_SESSION["usuarioId"] = $emailExiste["usuarioId"];
        header("location: ../public/Livros/");
        exit();
    }
}
