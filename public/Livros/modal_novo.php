<?php require_once("../../private/conexao.php"); ?>

<div width='100%' height="100%">
    <form method='POST'  action='./novo.php'>

        <label for='titulo'><strong>Título:*</strong></label>
        <input name='titulo' autocomplete="off" type='text' class='form-control' required>

        <label for='autores'><strong>Autores:</strong></label>
        <input name='autores' type='text' class='form-control'>

        <label for='editora'><strong>Editora:</strong></label>
        <input name='editora' type='text' class='form-control'>

        <label for='categoria'><strong>Categoria:</strong></label>
        <select name='categoria' class='form-select' aria-label='select' required>
        <option disabled selected value> -- Selecione uma categoria -- </option>

            <?php
            $statement = $conecta->prepare("SELECT * FROM categoria");
            $statement->execute();

            while ($dados_db_categoria = $statement->fetch(PDO::FETCH_ASSOC)) {
                $nome_categoria = $dados_db_categoria["nome"];
                $num_categoria = $dados_db_categoria["numero"];
                $opcao = "$nome_categoria - ";
                $opcao .= "$num_categoria ";
                echo "<option value='$num_categoria'>" .
                    $opcao . "</option>'";
            }
            ?>
        </select>

        <label for='isbn'><strong>ISBN:</strong></label>
        <input name='isbn' type='number' class='form-control'>
        <div style='display:flex;'>
            <div style='padding-right: 0.25rem'>
                <label for='codigo_de_barras'><strong>Código de Barras:</strong></label>
                <input name='codigo_de_barras' type='number' class='form-control'>

                <label for='ano'><strong>Ano:</strong></label>
                <input name='ano' type='number' class='form-control'>
            </div>
            <div style='padding-left: 0.25rem'>
                <label for='paginas'><strong>Páginas:</strong></label>
                <input name='paginas' type='number' class='form-control'>

                <label for='quantidade'><strong>Quantidade:*</strong></label>
                <input name='quantidade' type='number' class='form-control' required>

            </div>
        </div>
        <button type='submit' style='margin-top: 10px' class='botao'>Salvar Alterações</button>
    </form>
</div>