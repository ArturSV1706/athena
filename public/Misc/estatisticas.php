<?php $statement_qnt = $conecta->prepare("SELECT COUNT(quantidade) as quantidade FROM livros ");
$statement_qnt->execute();

while ($dados_db = $statement_qnt->fetch(PDO::FETCH_ASSOC)) {
    $quantidade = $dados_db['quantidade'];
}


$statement_soma = $conecta->prepare("SELECT SUM(quantidade) as soma FROM livros ");
$statement_soma->execute();

while ($dados_db = $statement_soma->fetch(PDO::FETCH_ASSOC)) {
    $soma = $dados_db['soma'];
}


$statement_qnt_emp = $conecta->prepare("SELECT COUNT(id) as quantidade_emp FROM emprestimos ");
$statement_qnt_emp->execute();

while ($dados_db = $statement_qnt_emp->fetch(PDO::FETCH_ASSOC)) {
    $quantidade_emprestimos = $dados_db['quantidade_emp'];
}

$statement_alunos = $conecta->prepare("SELECT COUNT(categoria) as alunos FROM utilizadores WHERE categoria = 'aluno'");
$statement_alunos->execute();

while ($dados_db = $statement_alunos->fetch(PDO::FETCH_ASSOC)) {
    $alunos = $dados_db['alunos'];
}
$statement_servidor = $conecta->prepare("SELECT COUNT(categoria) as servidor FROM utilizadores WHERE categoria = 'servidor'");
$statement_servidor->execute();

while ($dados_db = $statement_servidor->fetch(PDO::FETCH_ASSOC)) {
    $servidores = $dados_db['servidor'];
}
$statement_terceiro = $conecta->prepare("SELECT COUNT(categoria) as terceiro FROM utilizadores WHERE categoria = 'terceiro'");
$statement_terceiro->execute();

while ($dados_db = $statement_terceiro->fetch(PDO::FETCH_ASSOC)) {
    $terceiros = $dados_db['terceiro'];
}

$statement_admin_clientes = $conecta->prepare("SELECT COUNT(usuariosID) as clientes FROM usuarios");
$statement_admin_clientes->execute();

while ($dados_db = $statement_admin_clientes->fetch(PDO::FETCH_ASSOC)) {
    $clientes = $dados_db['clientes'];
}

$statement_admin_clientes_ativos = $conecta->prepare("SELECT COUNT(usuariosID) as clientes_ativos FROM usuarios WHERE ativado = 1");
$statement_admin_clientes_ativos->execute();

while ($dados_db = $statement_admin_clientes_ativos->fetch(PDO::FETCH_ASSOC)) {
    $clientes_ativos = $dados_db['clientes_ativos'];
}

$statement_admin_clientes_inativos = $conecta->prepare("SELECT COUNT(usuariosID) as clientes_inativos FROM usuarios WHERE ativado = 0");
$statement_admin_clientes_inativos->execute();

while ($dados_db = $statement_admin_clientes_inativos->fetch(PDO::FETCH_ASSOC)) {
    $clientes_inativos = $dados_db['clientes_inativos'];
}
?>