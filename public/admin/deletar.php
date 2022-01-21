<?php require_once("../../private/conexao.php"); ?>

<?php

$html = "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU' crossorigin='anonymous'>";
$html .= "<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js' integrity='sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ' crossorigin='anonymous'></script>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $qtd_emprestimos_ativos = $_POST['qtd_emprestimos_ativos'];
    $possui_livros_atrasados = $_POST['possui_livros_atrasados'];

    if ($qtd_emprestimos_ativos == 0 && $possui_livros_atrasados == 0) {
        $statement = $conecta->prepare("DELETE FROM utilizadores WHERE id= :id");
        $statement->bindValue(':id', $id); 
        $statement->execute();

        echo "<script>window.location='./index.php'</script>";
    } else {
        $html .= "<script> alert('Não é possível apagar um leitor com empréstimos ativos')</script>;";
        $html .= "<script>window.location='./index.php'</script>";
        echo $html;
    }
}
