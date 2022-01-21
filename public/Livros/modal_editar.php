<?php require_once("../../private/conexao.php"); ?>

<?php

if (isset($_POST['meu_id'])) {

    $id = $_POST['meu_id'];

    $statement_join = $conecta->prepare("SELECT * FROM livros l INNER JOIN categoria c ON l.categoria_id = c.numero WHERE id= :id");
    $statement_join->bindValue(':id', $id);
    $statement_join->execute();

    $html = "<div width='100%'>";
    $html .= "<i class='bx bx-x close' onclick='modalEditarFechar()'></i>";
    $html .= "<form action='./editar.php' method='POST'>";
    $html .= "<div class='form-group'>";

    while ($dados_db = $statement_join->fetch(PDO::FETCH_ASSOC)) {

        $titulo = $dados_db['titulo'];
        $titulo = htmlspecialchars($titulo);
        $editora = $dados_db['editora'];
        $titulo = htmlspecialchars($titulo);
        $autores = $dados_db['autores'];
        $autores = htmlspecialchars($autores);
        $isbn = $dados_db['isbn'];
        $qnt = $dados_db['quantidade'];
        $codigo_de_barras = $dados_db['codigo_de_barras'];
        $ano = $dados_db['ano'];
        $paginas = $dados_db['paginas'];
        $categoria = $dados_db['nome'];
        $categoriaNum = $dados_db['numero'];

        $html .= "<input name='id' type='hidden' class='form-control' value='$id'>";

        $html .= "<label for='titulo'><strong>Título:*</strong></label>";
        $html .= "<input name='titulo' type='text' class='form-control' value='" . htmlspecialchars($titulo) . "'required>";

        $html .= "<label for='autores'><strong>Autores:</strong></label>";
        $html .= "<input name='autores' type='text' class='form-control' value='" . htmlspecialchars($autores) . "'>";

        $html .= "<label for='editora'><strong>Editora:</strong></label>";
        $html .= "<input name='editora' type='text' class='form-control' value='" . htmlspecialchars($editora) . "'>";

        $html .= "<div style='display:flex;'>";
        $html .= "<div style='padding-right: 0.25rem'>";

        $html .= "<label for='isbn'><strong>ISBN:*</strong></label>";
        $html .= "<input name='isbn' type='number' class='form-control' value='$isbn' >";

        $html .= "<label for='quantidade'><strong>Quantidade:*</strong></label>";
        $html .= "<input name='quantidade' type='number' class='form-control' value='$qnt' required>";



        $html .= "<label for='codigo_de_barras'><strong>Código de Barras:*</strong></label>";
        $html .= "<input name='codigo_de_barras' type='number' class='form-control' value='$codigo_de_barras' >";

        $html .= "</div>";

        $html .= "<div style='padding-left: 0.25rem'>";

        $html .= "<label for='ano'><strong>Ano:</strong></label>";
        $html .= "<input name='ano' type='number' class='form-control' value='$ano'>";

        $html .= "<label for='paginas'><strong>Páginas:*</strong></label>";
        $html .= "<input name='paginas' type='number' class='form-control' value='$paginas' >";

        $html .= "<label for='categoria'><strong>Categoria:</strong></label>";
        $html .= "<select name='categoria' class='form-select' aria-label='select' value=$categoriaNum required>";
        $html .= "<option selected disabled value = $categoriaNum> $categoria" . ' - ' . $categoriaNum . "</option>";
        $html .= "<option selected hidden value = $categoriaNum> $categoria" . ' - ' . $categoriaNum . "</option>";

        $statement_categoria = $conecta->prepare("SELECT * FROM categoria");
        $statement_categoria->execute();

        while ($dados_db_categoria = $statement_categoria->fetch(PDO::FETCH_ASSOC)) {
            $nome_categoria = $dados_db_categoria["nome"];
            $num_categoria = $dados_db_categoria["numero"];
            $opcao = "$nome_categoria - ";
            $opcao .= "$num_categoria ";
            $html .= "<option value='$num_categoria'>" . $opcao . "</option>'";
        }

        $html .= "</select>";
        $html .= "</div>";

        $html .= "</div>";
        $html .= "</div>";
        $html .= "<div class='botoes_modal'> <button type='submit' style='background: #29C770' class='botao'>Salvar Alterações</button>";
    }

    $html .= "</form><button type='button' onclick='modalEditarFechar()' style='background: #ff2957' class='botao'>Cancelar</button></div>";

    echo $html;
    exit;
}
