<?php require_once("../../private/conexao.php"); ?>

<?php

if (isset($_POST['meu_id'])) {
    $id = $_POST['meu_id'];

    $statement = $conecta->prepare("SELECT * FROM utilizadores WHERE id= :id");
    $statement->bindValue(':id', $id);
    $statement->execute();

    $html = "<div width='100%'>";
    $html .= "<i class='bx bx-x close' onclick='modalDeletarFechar()'></i>";
    $html .= "<form action='./deletar.php' method='POST' >";

    while ($dados_db = $statement->fetch(PDO::FETCH_ASSOC)) {

        $id = $dados_db['id'];
        $nome = $dados_db['nome'];
        $categoria = $dados_db['categoria'];
        $qtd_emprestimos_ativos = $dados_db['qtd_emprestimos_ativos'];
        $possui_livros_atrasados = $dados_db['possui_livros_atrasados'];
        $html .= "<h3 style='text-align: center;'>" . $nome . "</h3>";
        $html .= "<h4 style='text-align: center; color: #715aff'>" . $categoria . "</h3>";

        if(!isset($possui_livros_atrasados)){
            $possui_livros_atrasados = 0;
        }
    }

    $html .= "<input name='id' type='hidden' value='$id'>";
    $html .= "<input name='qtd_emprestimos_ativos' type='hidden' value='$qtd_emprestimos_ativos'>";
    $html .= "<input name='possui_livros_atrasados' type='hidden' value='$possui_livros_atrasados'>";
    $html .= "<button type='submit' style='margin-top: 10px' class='botao'>Sim, Excluir</button>";

    $html .= "</form>";
    $html .= "</div>";

    echo $html;

    exit;
}
