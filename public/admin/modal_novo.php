<?php require_once("../../private/conexao.php"); ?>

<div width='100%'>
    <form method='POST' action='./novo.php'>
        <label for='nome'><strong>Nome:*</strong></label>
        <input name='nome' type='text' class='form-control' required>
        
        <label for='utilizadores_dropdown'>Categoria:*</label>
        <select name='categoria' class='form-select' aria-label='select' required>
        <option disabled selected value> -- Selecione uma categoria -- </option>
            <option value="aluno">Aluno</option>
            <option value="servidor">Servidor</option>
            <option value="terceiro">Terceiro</option>

        </select>
        <button type='submit' style='margin-top: 10px' class='botao'>Cadastrar</button>
    </form>
</div>