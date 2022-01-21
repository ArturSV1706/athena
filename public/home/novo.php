<?php require_once("../../private/conexao.php"); ?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_REQUEST['titulo'];
    $titulo = htmlspecialchars($titulo);
    $isbn = $_REQUEST['isbn'];
    $codigo_de_barras = $_REQUEST['codigo_de_barras'];
    $paginas = $_REQUEST['paginas'];
    $qnt = $_REQUEST['quantidade'];
    $categoria = $_REQUEST['categoria'];

    if ($_REQUEST['autores'] === "") {
        $autores = "(não informado)";
        $autores = htmlspecialchars($autores);

    } else {
        $autores = $_REQUEST['autores'];
        $autores = htmlspecialchars($autores);

    }

    if ($_REQUEST['editora'] === "") {
        $editora = "(não informado)";
        $editora = htmlspecialchars($editora);

    } else {
        $editora = $_REQUEST['editora'];
        $editora = htmlspecialchars($editora);

    }

    if ($_REQUEST['isbn'] === "") {
        $isbn = "(não informado)";
    } else {
        $isbn = $_REQUEST['isbn'];
    }
    if ($_REQUEST['codigo_de_barras'] === "") {
        $codigo_de_barras = "(não informado)";
    } else {
        $codigo_de_barras = $_REQUEST['codigo_de_barras'];
    }
    if ($_REQUEST['ano'] === "") {
        $ano = "(não informado)";
    } else {
        $ano = $_REQUEST['ano'];
    }

    $statement = $conecta->prepare("INSERT INTO livros (titulo, editora, autores, isbn, codigo_de_barras, ano, paginas, quantidade, categoria_id) VALUES (:titulo, :editora, :autores, :isbn, :codigo_de_barras, :ano, :paginas, :qnt, :categoria)");
    $statement->bindValue(':titulo', $titulo);
    $statement->bindValue(':editora', $editora);
    $statement->bindValue(':autores', $autores);
    $statement->bindValue(':isbn', $isbn);
    $statement->bindValue(':codigo_de_barras', $codigo_de_barras);
    $statement->bindValue(':ano', $ano);
    $statement->bindValue(':paginas', $paginas);
    $statement->bindValue(':qnt', $qnt);
    $statement->bindValue(':categoria', $categoria);
    $statement->execute();

         echo "<script>window.location='./index.php'</script>";
    
}