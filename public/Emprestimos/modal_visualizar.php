<?php require_once("../../private/conexao.php"); ?>

<?php

if (isset($_POST['meu_id'])) {
    $id = $_POST['meu_id'];


    $statement = $conecta->prepare("SELECT * FROM emprestimos WHERE id= :id");
    $statement->bindValue(':id', $id);
    $statement->execute();


    $html = "<div width='100%'>";
    $html .= "<i class='bx bx-x close' onclick='modalVisualizarFechar()'></i>";

    while ($dados_db = $statement->fetch(PDO::FETCH_ASSOC)) {

        $id = $dados_db['id'];
        $data_emprestimo = $dados_db['data_emprestimo'];
        $data_termino = $dados_db['data_termino'];
        $titulo = $dados_db['titulo'];
        $codigo_de_barras = $dados_db['codigo_de_barras'];
        $livro_id = $dados_db['livro_id'];
        $utilizador_id = $dados_db['utilizador_id'];

        $data_emprestimo = date("d/m/Y H:i", strtotime($data_emprestimo));
        $data_termino = strtotime($data_termino) + (14 * 24 * 60 * 60);
        $data_termino = date("d/m/Y H:i", $data_termino);

        $html .= "<div style='display:flex'>";
        $html .= "<div style='padding-right: 1rem'>";
        
        $html .= "<p><strong>Data do empréstimo</strong>: " . $data_emprestimo . "</p>";
        $html .= "<p><strong>Data de vencimento</strong>: " . $data_termino . "</p>";

        $html .= "<hr>";

        $statement_utilizadores = $conecta->prepare("SELECT * FROM utilizadores WHERE id= :utilizador_id");
        $statement_utilizadores->bindValue(':utilizador_id', $utilizador_id);
        $statement_utilizadores->execute();

        while ($dados_db_utilizador = $statement_utilizadores->fetch(PDO::FETCH_ASSOC)) {
            $utilizador_nome = $dados_db_utilizador['nome'];
            $utilizador_qtd_ativos = $dados_db_utilizador['qtd_emprestimos_ativos'];

            $html .= "<p><strong>Nome do solicitante</strong>: " . $utilizador_nome . "</p>";
            $html .= "<p><strong>Quantidades de livros emprestados ativos</strong>: " . $utilizador_qtd_ativos . "</p>";
        }

        $html .= "<hr>";

        $statement_livro = $conecta->prepare("SELECT * FROM livros WHERE id= :livro_id");
        $statement_livro->bindValue(':livro_id', $livro_id);
        $statement_livro->execute();

        while ($dados_db_livros = $statement_livro->fetch(PDO::FETCH_ASSOC)) {
            $id_livro = $dados_db_livros['id'];
            $titulo_livro = $dados_db_livros['titulo'];
            $editora_livro = $dados_db_livros['editora'];
            $autores_livro = $dados_db_livros['autores'];
            $isbn_livro = $dados_db_livros['isbn'];
            $codigo_de_barras_livro = $dados_db_livros['codigo_de_barras'];
            $ano_livro = $dados_db_livros['ano'];
            $paginas_livro = $dados_db_livros['paginas'];
            $status_livro = $dados_db_livros['status'];


            $html .= "<p><strong>Livro</strong>: " . $titulo_livro . "</p>";
            $html .= "<p><strong>Autores</strong>: " . $autores_livro . "</p>";
            $html .= "</div>";
            $html .= "<div style='padding-left: 1rem'>";
            $html .= "<p><strong>Editora</strong>: " . $editora_livro . "</p>";
            $html .= "<p><strong>ISBN</strong>: " . $isbn_livro . "</p>";
            $html .= "<p><strong>Código de Barras</strong>: " . $codigo_de_barras_livro . "</p>";
            $html .= "<p><strong>Ano</strong>: " . $ano_livro . "</p>";
            $html .= "<p><strong>Páginas</strong>: " . $paginas_livro . "</p>";
            $html .= "<p><strong>Status</strong>: " . $status_livro . "</p>";
            $html .= "</div>";
        }

        $html .= "</div>";
    }

    $html .= "</div>";

    echo $html;
    exit;
}
