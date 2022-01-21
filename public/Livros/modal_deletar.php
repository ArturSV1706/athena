<?php require_once("../../private/conexao.php"); ?>

<?php

if (isset($_POST['meu_id'])) {
    $id = $_POST['meu_id'];

    $statement = $conecta->prepare("SELECT * FROM livros WHERE id= :id");
    $statement->bindValue(':id', $id);
    $statement->execute();

    $html = "<div width='100%'>";
    $html .= "<i class='bx bx-x close' onclick='modalDeletarFechar()'></i>";
    $html .= "<h1>Deseja realmente excluir este livro?</h1>";
    $html .= "<form action='./deletar.php' method='POST' >";
    

    while ($dados_db = $statement->fetch(PDO::FETCH_ASSOC)) {

        $id = $dados_db['id'];
        $titulo = $dados_db['titulo'];
        $status = $dados_db['status'];

        $html .= "<h5 style='text-align:center'>" . $titulo . "</h5>";
    }

    $html .= "<input name='id' type='hidden' value='$id'>";
    $html .= "<input name='status' type='hidden' value='$status'>";
    $html .= "<div class='botoes_modal'><button type='submit' style='margin-top: 10px' class='botao'>Sim, Excluir</button>";
    $html .= "</form>";

    // $html .= "<button onclick='modalDeletarFechar()' style='margin-top: 10px' class='botao'>Cancelar</button>";
    $html .= "</div></div>";

    echo $html;
    exit;
}