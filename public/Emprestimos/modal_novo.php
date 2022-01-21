<?php require_once("../../private/conexao.php"); ?>

<div width='100%'>
    <form method='POST' action='./novo.php'>
        <label for='utilizadores_dropdown'><b>Quem solicita o empréstimo:</b></label>
        <select name='utilizadores' class='form-select' aria-label='select' required>
            <option disabled selected value> -- Selecione uma pessoa -- </option>


            <?php

            $statement_utilizadores = $conecta->prepare("SELECT * FROM utilizadores");
            $statement_utilizadores->execute();

            $statement_livros = $conecta->prepare("SELECT * FROM livros");
            $statement_livros->execute();

            while ($dados_db_utilizadores = $statement_utilizadores->fetch(PDO::FETCH_ASSOC)) {
                $nome_utilizador = $dados_db_utilizadores["nome"];
                $qtd_emprestimos_ativos = $dados_db_utilizadores["qtd_emprestimos_ativos"];
                $possui_livros_atrasados = $dados_db_utilizadores["possui_livros_atrasados"];

                if ($qtd_emprestimos_ativos < 3) {
                    if ($possui_livros_atrasados == 0) {
                        echo "<option value='$nome_utilizador'>" .
                            $nome_utilizador . "</option>'";
                    }
                }
            }
            ?>
        </select>
        <label for='livros_dropdown'><b>Selecione o livro:</b></label>
        <select name='livros' class='form-select' aria-label='select' required>
            <option disabled selected value> -- Selecione um livro -- </option>


            <?php
            while ($dados_db_livros = $statement_livros->fetch(PDO::FETCH_ASSOC)) {
                $titulo_livro = $dados_db_livros["titulo"];
                $status = $dados_db_livros['status'];
                $quantidade = $dados_db_livros['quantidade'];
                $quantidade_emp = $dados_db_livros['quantidade_emp'];

                if ($quantidade_emp < $quantidade) {
                    if (strlen($titulo_livro) > 40) {
                        $str = substr($titulo_livro, 0, 40) . '...';
                        echo "<option value='$titulo_livro'>" . $str . "</option>'";
                    } else {
                        echo "<option value='$titulo_livro'>" . $titulo_livro . "</option>'";
                    }
                }
            }
            ?>
        </select>

        <button type='submit' style='margin-top: 10px' class='botao'>Realizar Empréstimo</button>
    </form>
</div>