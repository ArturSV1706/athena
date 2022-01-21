<?php

if (isset($_POST["submit"])) {

    $email = $_POST["email"];
    $senha = $_POST["senha"];

    require_once('conexao.php');
    require_once 'funcoes.php';

    if(campoVazio($email, $senha) !== false){
        header("location: ../public/?erro=camposvazios");
        exit();
    }

    loginUser($conecta, $email, $senha);

}else{
    header("location: ../public/");
    exit();
}


