<?php require_once("../../private/conexao.php"); ?>

<?php

$response = "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU' crossorigin='anonymous'>";
$response .= "<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js' integrity='sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ' crossorigin='anonymous'></script>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $livro_id = $_POST['id'];
    $status = $_POST['status'];

    if ($status === "disponivel") {

        $statement = $conecta->prepare("DELETE FROM livros WHERE id= :livro_id");
        $statement->bindValue(':livro_id', $livro_id);
        $statement->execute();
      
            echo "<script>window.location='./index.php'</script>";
    
    } else {
        $html = "<script> alert('Não é possível apagar um livro que esteja emprestado!')</script>;";
        $html .= "<script>window.location='./index.php'</script>";
        echo $html;
    }
}
echo "<script>window.location='./index.php'</script>";

