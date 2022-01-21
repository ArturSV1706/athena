<?php require_once("../../private/conexao.php"); ?>

<?php

if (isset($_POST['meu_id'])) {

    $id = $_POST['meu_id'];

    $statement = $conecta->prepare("SELECT * FROM utilizadores WHERE id= :id");
    $statement->bindValue(':id', $id);
    $statement->execute();

    $html = "<div width='100%'>";
    $html .= "<i class='bx bx-x close' onclick='modalEditarFechar()'></i>";
    $html .= "<form action='./editar.php' method='POST'>";
    $html .= "<div class='form-group'>";

    while ($dados_db = $statement->fetch(PDO::FETCH_ASSOC)) {

        $nome = $dados_db['nome'];
        $categoria_atual = $dados_db['categoria'];
        $qtd_emprestimos_ativos = $dados_db['qtd_emprestimos_ativos'];
        if(!isset($possui_livros_atrasados)){
            $possui_livros_atrasados = 0;
        }

        $html .= "<input name='id' type='hidden' class='form-control' value='$id'>";
        $html .= "<input name='qtd_emprestimos_ativos' type='hidden' class='form-control' value='$qtd_emprestimos_ativos'>";
        $html .= "<input name='possui_livros_atrasados' type='hidden' class='form-control' value='$possui_livros_atrasados'>";

        $html .= "<label for='nome'><strong>Nome:*</strong></label>";
        $html .= "<input name='nome' type='text' class='form-control' value='$nome' required>";

        $html .= "<label for='utilizadores_dropdown'><strong>Categoria:*</strong></label>";
        $html .= "<select name='categoria' class='form-select' aria-label='select'  required>";


        $statement2 = $conecta->prepare("SELECT * FROM utilizadores WHERE id= :id");
        $statement2->bindValue(':id', $id);
        $statement2->execute();

        $dados_db_leitor = $statement2->fetch(PDO::FETCH_ASSOC);
        $categoria = $dados_db_leitor["categoria"];
        $html .= "<option disabled selected value>" . $categoria_atual . "</option>";

        $html .= "<option value='aluno'>Aluno</option>'";
        $html .= "<option value='servidor'>Servidor</option>'";
        $html .= "<option value='terceiro'>Terceiro</option>'";

        $html .= "</select>";

        $html .= "<button type='submit' style='margin-top: 10px' class='botao'>Salvar Alterações</button>";
    }

    $html .= "</div>";
    $html .= "</form>";
    $html .= "</div>";


    echo $html;
    exit;
}
