<?php require_once("../../private/conexao.php"); ?>

<?php

if (isset($_POST['meu_id'])) {
    $id = $_POST['meu_id'];
    $livro_id = $_POST['livro_id'];
    $utilizador_id = $_POST['utilizador_id'];

    $statement_livro = $conecta->prepare("SELECT qtd_emprestimos_ativos FROM utilizadores WHERE id= :utilizador_id");
    $statement_livro->bindValue(':utilizador_id', $utilizador_id);
    $statement_livro->execute();

    while ($dados_db_emprestimos = $statement_livro->fetch(PDO::FETCH_ASSOC)) {
        $qtd_emprestimos_ativos = $dados_db_emprestimos["qtd_emprestimos_ativos"];
    }

    $html = "<div width='100%''>";
    $html .= "<i class='bx bx-x close' onclick='modalDeletarFechar()'></i>";
    $html .= "<h1  style='text-align:center'>Retornar livro?</h1>";

    $html .= "<form action='./deletar.php' method='POST' >";

    $html .= "<input name='id' type='hidden' value='$id'>";
    $html .= "<input name='utilizador_id' type='hidden' value='$utilizador_id'>";
    $html .= "<input name='livro_id' type='hidden' value='$livro_id'>";
    $html .= "<input name='qtd_emprestimos_ativos' type='hidden' value='$qtd_emprestimos_ativos'>";

    $html .= "<button type='submit' style='margin-top: 10px' class='botao'>Sim, retornar</button>";

    $html .= "</form></div>";

    echo $html;
    exit;
}
