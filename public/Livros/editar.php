<?php require_once("../../private/conexao.php"); ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_REQUEST['id'];
    $titulo = $_REQUEST['titulo'];
    $titulo = htmlspecialchars($titulo);
    $codigo_de_barras = $_REQUEST['codigo_de_barras'];
    $isbn = $_REQUEST['isbn'];
    $paginas = $_REQUEST['paginas'];
    $quantidade = $_REQUEST['quantidade'];
    $categoria = $_REQUEST['categoria'];

    if ($_REQUEST['autores'] === "" || $_REQUEST['autores'] === "(não informado)") {
        $autores = "(não informado)";
        $autores = htmlspecialchars($autores);

    } else {
        $autores = $_REQUEST['autores'];
        $autores = htmlspecialchars($autores);

    }

    if ($_REQUEST['editora'] === "" || $_REQUEST['editora'] === "(não informado)") {
        $editora = "(não informado)";
        $editora = htmlspecialchars($editora);

    } else {
        $editora = $_REQUEST['editora'];
        $editora = htmlspecialchars($editora);

    }

    if ($_REQUEST['ano'] === "" || $_REQUEST['ano'] === "(não informado)") {
        $ano = "(não informado)";
    } else {
        $ano = $_REQUEST['ano'];
    }

    $statement = $conecta->prepare("UPDATE livros SET titulo=:titulo, editora=:editora, autores=:autores, isbn=:isbn, codigo_de_barras=:codigo_de_barras, ano=:ano, paginas=:paginas, quantidade=:quantidade, categoria_id=:categoria WHERE id=:id");
    $statement->bindValue(':titulo', $titulo);
    $statement->bindValue(':editora', $editora);
    $statement->bindValue(':autores', $autores);
    $statement->bindValue(':isbn', $isbn);
    $statement->bindValue(':codigo_de_barras', $codigo_de_barras);
    $statement->bindValue(':ano', $ano);
    $statement->bindValue(':paginas', $paginas);
    $statement->bindValue(':categoria', $categoria);
    $statement->bindValue(':quantidade', $quantidade);
    $statement->bindValue(':id', $id);
    $statement->execute();

    
}

echo "<script>window.location='./index.php'</script>";