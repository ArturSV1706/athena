<?php require_once("../../private/conexao.php"); ?>

<?php

if (isset($_POST['meu_id'])) {
    $id = $_POST['meu_id'];

    $statement = $conecta->prepare("SELECT * FROM utilizadores WHERE id= :id");
    $statement->bindValue(':id', $id);
    $statement->execute();
    

    $html = "<div width='100%'>";
    $html .= "<i class='bx bx-x close' onclick='modalVisualizarFechar()'></i>";


    while ($dados_db = $statement->fetch(PDO::FETCH_ASSOC)){
        $id = $dados_db["id"];
        $nome = $dados_db['nome'];
        $categoria = $dados_db['categoria'];
        $qtd_emprestimos_ativos = $dados_db['qtd_emprestimos_ativos'];
    }

    $html .= "<h3 style='text-align: center;'>" . $nome . "</h3>";
    $html .= "<h4 style='text-align: center; color: #715aff'>" . $categoria . "</h3>";
    $html .= "<p>Quantidade de empréstimos ativos: <strong>" . $qtd_emprestimos_ativos . "</strong></p>";

    if(!isset($possui_livros_atrasados)){
        $possui_livros_atrasados = 0;
    }

    switch ($possui_livros_atrasados) {
        case 0:
            $html .= "<p>Possui pendências? <strong style='color: #29c770'>Não possui. Está tudo em dia.</strong></p>";
            break;
        case 1:
            $html .= "<p>Possui pendências? <strong style='color: #ff2957'>Possui pendências! Favor verificar como este utilizador o quanto antes!</strong></p>";
            break;
        default:
            echo "<p>Error</p>";
            break;
    }

    $html .= "</div>";

    echo $html;
    exit;
}
