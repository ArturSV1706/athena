<?php require_once("../../private/conexao.php"); ?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_REQUEST['id'];
    $nome = $_REQUEST['nome'];
    $categoria = $_REQUEST['categoria'];

    if ($nome !== "") {
        $statement = $conecta->prepare("UPDATE utilizadores SET nome =:nome, categoria =:categoria WHERE utilizadores.id = :id");
        $statement->bindValue(':nome', $nome);
        $statement->bindValue(':categoria', $categoria);
        $statement->bindValue(':id', $id);
        
        $statement->execute();

        echo "<script>window.location='./index.php'</script>";
    }
}
echo "<script>window.location='./index.php'</script>";

