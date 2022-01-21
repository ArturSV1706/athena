<?php require_once("../../private/conexao.php"); ?>

<?php

if (isset($_POST['meu_id'])) {
    $id = $_POST['meu_id'];

    $statement = $conecta->prepare("SELECT * FROM livros l INNER JOIN categoria c ON l.categoria_id = c.numero WHERE id= :id");
    $statement->bindValue(':id', $id);
    $statement->execute();

    $html = "<div width='100%'>";
    $html .= "<i class='bx bx-x close' onclick='modalVisualizarFechar()'></i>";

    while ($dados_db = $statement->fetch(PDO::FETCH_ASSOC)) {

        $id = $dados_db['id'];
        $titulo = $dados_db['titulo'];
        $editora = $dados_db['editora'];
        $autores = $dados_db['autores'];
        $categoria = $dados_db['nome'];
        $num_categoria = $dados_db['numero'];
        $isbn = $dados_db['isbn'];
        $codigo_de_barras = $dados_db['codigo_de_barras'];
        $ano = $dados_db['ano'];
        $paginas = $dados_db['paginas'];
        $status = $dados_db['status'];
        $qnt = $dados_db['quantidade'];

        $html .= "<h3>" . htmlspecialchars($titulo) . "</h3>";
        $html .= "<h5>" . htmlspecialchars($autores) . "</h5>";

        $html .= "<p>Editora: <strong>" . htmlspecialchars($editora) . "</strong></p>";
        $html .= "<p>Categoria: <strong>" . $categoria . " - " . $num_categoria . "</strong></p>";

        $html .= "<p>ISBN: <strong>" . $isbn . "</strong></p>";
        $html .= "<p>Código de Barras: <strong>" . $codigo_de_barras . "</strong></p>";
        $html .= "<p>Ano: <strong>" . $ano . "</strong></p>";
        $html .= "<p>Páginas: <strong>" . $paginas . "</strong></p>";
        $html .= "<p>Status: <strong>" . $status . "</strong></p>";
        $html .= "<p>Quantidade: <strong>" . $qnt . " un.</strong></p>";
    }

    $html .= "</div>";

    echo $html;
    exit;
} else {
    echo "Não tem isset";
}