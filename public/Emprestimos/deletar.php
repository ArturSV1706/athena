<?php require_once("../../private/conexao.php"); ?>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $livro_id = $_POST['livro_id'];
    $utilizador_id = $_POST['utilizador_id'];
    $qtd_emprestimos_ativos = $_POST['qtd_emprestimos_ativos'];

    $statement = $conecta->prepare("SELECT * FROM livros WHERE id=:livro_id");
    $statement->bindValue(':livro_id', $livro_id);
    $statement->execute();

    while ($dados_db_livros = $statement->fetch(PDO::FETCH_ASSOC)) {
        $quantidade  = $dados_db_livros["quantidade"];
        $quantidade_emp  = $dados_db_livros["quantidade_emp"];
    }

    $statement_delete = $conecta->prepare("DELETE FROM emprestimos WHERE id=:id");
    $statement_delete->bindValue(':id', $id);
    $statement_delete->execute();

    $qtd_emprestimos_atualizado = $qtd_emprestimos_ativos - 1;
    $quantidade_emp = $quantidade_emp -1;

    $statement_emprestimos = $conecta->prepare("UPDATE utilizadores SET qtd_emprestimos_ativos = :qtd_emprestimos_atualizado WHERE utilizadores.id = :utilizador_id;");
    $statement_emprestimos->bindValue(':qtd_emprestimos_atualizado', $qtd_emprestimos_atualizado);
    $statement_emprestimos->bindValue(':utilizador_id', $utilizador_id);
    $statement_emprestimos->execute();
    
    if($quantidade_emp <= 0){
        $status = "disponivel";
    }else{
        $status = "emprestado";
    }

    $statement_livro = $conecta->prepare("UPDATE livros SET status = :_status, quantidade_emp = :quantidade_emp WHERE livros.id = :livro_id");
    $statement_livro->bindValue(':livro_id', $livro_id);
    $statement_livro->bindValue(':_status', $status);
    $statement_livro->bindValue(':quantidade_emp', $quantidade_emp);
    $statement_livro->execute();

    
}
echo "<script>window.location='./index.php'</script>";
