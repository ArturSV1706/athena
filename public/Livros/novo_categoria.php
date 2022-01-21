<?php require_once("../../private/conexao.php"); ?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_REQUEST['nome'];
    $numero = $_REQUEST['numero'];

    $statement = $conecta->prepare("INSERT INTO categoria (nome, numero) VALUES (:nome, :numero)");
    $statement->bindValue(':nome', $nome);
    $statement->bindValue(':numero', $numero);
    $statement->execute();
 
    
}
echo "<script>window.location='./index.php'</script>";