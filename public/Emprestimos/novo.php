<?php require_once("../../private/conexao.php"); ?>

<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $utilizador = $_REQUEST['utilizadores'];
    $utilizador = htmlspecialchars($utilizador);

    $livro = $_REQUEST['livros'];
    $livro = htmlspecialchars($livro);

    $data_emprestimo = new DateTime();
    $data_termino = new DateTime();
    $data_termino->modify('+29 days');


    $statement = $conecta->prepare("SELECT * FROM livros WHERE titulo=:livro");
    $statement->bindValue(':livro', $livro);
    $statement->execute();
    
    $statement_u = $conecta->prepare("SELECT * FROM utilizadores WHERE nome=:utilizador");
    $statement_u->bindValue(':utilizador', $utilizador);
    $statement_u->execute();
    
    while ($dados_db_livros = $statement->fetch(PDO::FETCH_ASSOC)) {
        $codigo_de_barras = $dados_db_livros["codigo_de_barras"];
        $livro_id = $dados_db_livros["id"];
        $quantidade  = $dados_db_livros["quantidade"];
        $quantidade_emp  = $dados_db_livros["quantidade_emp"];
    }


    while ($dados_db_utilizadores = $statement_u->fetch(PDO::FETCH_ASSOC)) {
        $utilizador_id = $dados_db_utilizadores["id"];
        $qtd_emprestimos =  $dados_db_utilizadores["qtd_emprestimos_ativos"];
    }

        $statement_e = $conecta->prepare("INSERT INTO emprestimos (data_emprestimo, data_termino, titulo, codigo_de_barras, livro_id, utilizador_id) VALUES (:data_emprestimo, :data_termino, :livro, :codigo_de_barras, :livro_id, :utilizador_id)");
        $statement_e->bindValue(':data_emprestimo', $data_emprestimo->format('Y-m-d H:i:s'));
        $statement_e->bindValue(':data_termino', $data_termino->format('Y-m-d'));
        $statement_e->bindValue(':livro', $livro);
        $statement_e->bindValue(':codigo_de_barras', $codigo_de_barras);
        $statement_e->bindValue(':livro_id', $livro_id);
        $statement_e->bindValue(':utilizador_id', $utilizador_id);
        $statement_e->execute();

        $qnt_emprestimos_atualizado = $qtd_emprestimos + 1;
        $quantidade_emp = $quantidade_emp + 1;

        $statement_ae = $conecta->prepare("UPDATE utilizadores SET qtd_emprestimos_ativos = :qnt_emprestimos_atualizado WHERE utilizadores.id = :utilizador_id2");
        $statement_ae->bindParam(':qnt_emprestimos_atualizado', $qnt_emprestimos_atualizado);
        $statement_ae->bindValue(':utilizador_id2', $utilizador_id);
        $statement_ae->execute();


        $statement_asl = $conecta->prepare("UPDATE livros SET status = 'emprestado', quantidade_emp = :quantidade_emp WHERE livros.id = :livro_id2");
        $statement_asl->bindValue(':livro_id2', $livro_id);
        $statement_asl->bindValue(':quantidade_emp', $quantidade_emp);
        $statement_asl->execute();
    }
    echo "<script>window.location='./index.php'</script>";

