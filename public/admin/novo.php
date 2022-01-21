<?php require_once("../../private/conexao.php"); ?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_REQUEST['nome'];
    $nome = htmlspecialchars($nome);
    $categoria = $_REQUEST['categoria'];

    $statement = $conecta->prepare("INSERT INTO utilizadores (nome, categoria) VALUES (:nome, :categoria)");
    $statement->bindValue(':nome', $nome);
    $statement->bindValue(':categoria', $categoria);

    $statement->execute();

    echo "<script>window.location='./index.php'</script>";
}
