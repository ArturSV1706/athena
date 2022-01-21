<?php require_once("../../private/conexao.php"); ?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_REQUEST['id'];
    $nome = $_REQUEST['nome'];
    $email = $_REQUEST['email'];
    $telefone = $_REQUEST['telefone'];
    $subdominio = $_REQUEST['subdominio'];
    $ativado = $_REQUEST['ativado'];

    if ($nome !== "") {
        $statement = $conecta->prepare("UPDATE usuarios SET nome =:nome, email =:email, telefone =:telefone, subdominio =:subdominio, ativado =:ativado WHERE usuarios.usuariosId = :id");
        $statement->bindValue(':nome', $nome);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':telefone', $telefone);
        $statement->bindValue(':subdominio', $subdominio);
        $statement->bindValue(':ativado', $ativado);
        $statement->bindValue(':id', $id);
        
        $statement->execute();

        echo "<script>window.location='./index.php'</script>";
    }
}
