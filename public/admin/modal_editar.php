<?php require_once("../../private/conexao.php"); ?>

<?php

if (isset($_POST['meu_id'])) {

    $id = $_POST['meu_id'];

    $statement = $conecta->prepare("SELECT * FROM usuarios WHERE usuariosId= :id");
    $statement->bindValue(':id', $id);
    $statement->execute();

    $html = "<div width='100%'>";
    $html .= "<i class='bx bx-x close' onclick='modalEditarFechar()'></i>";
    $html .= "<form action='./editar.php' method='POST'>";
    $html .= "<div class='form-group'>";

    while ($dados_db = $statement->fetch(PDO::FETCH_ASSOC)) {
        $id = $dados_db['usuariosId'];
        $nome = $dados_db['nome'];
        $email = $dados_db['email'];
        $telefone = $dados_db['telefone'];
        $subdominio = $dados_db['subdominio'];
        $ativo = $dados_db['ativado'];

        $html .= "<input name='id' type='hidden' class='form-control' value='$id'>";

        $html .= "<label for='nome'><strong>Nome:*</strong></label>";
        $html .= "<input name='nome' type='text' class='form-control' value='$nome' required>";

        $html .= "<label for='email'><strong>Email:*</strong></label>";
        $html .= "<input name='email' type='text' class='form-control' value='$email' required>";

        $html .= "<label for='telefone'><strong>Telefone:*</strong></label>";
        $html .= "<input name='telefone' type='text' class='form-control' value='$telefone' required>";
        
        $html .= "<label for='subdominio'><strong>Sub-domínio:*</strong></label>";
        $html .= "<input name='subdominio' type='text' class='form-control' value='$subdominio' >";

        $html .= "<label for='licença'><strong>Licença:*</strong></label>";
        $html .= "<select name='ativado' class='form-select' aria-label='select'  required>";

        if ($ativo == 1) {
            $ativo_nome = "Ativo";
        } else {
            $ativo_nome = "Inativo";
        }

        $html .= "<option disabled selected value>" . $ativo_nome . "</option>";

        $html .= "<option value='0'>Inativo</option>'";
        $html .= "<option value='1'>Ativo</option>'";

        $html .= "</select>";

        $html .= "<button type='submit' style='margin-top: 10px' class='botao'>Salvar Alterações</button>";
    }

    $html .= "</div>";
    $html .= "</form>";
    $html .= "</div>";


    echo $html;
    exit;
}
