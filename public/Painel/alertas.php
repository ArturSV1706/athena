<?php

$statement_emprestimos = $conecta->prepare("SELECT * FROM emprestimos ORDER BY data_termino ASC LIMIT 4");
$statement_emprestimos->execute();

while ($dados_db = $statement_emprestimos->fetch(PDO::FETCH_ASSOC)) {
    $data_emprestimo = new DateTime();
    $data_termino = $dados_db['data_termino'];
    $data_termino_convertida = new DateTime($data_termino);
    $data_termino_convertida->modify('+1 days');
    $titulo = $dados_db['titulo'];
    $utilizador_id = $dados_db['utilizador_id'];
    
    if (strlen($titulo) > 40) {
        $str = substr($titulo, 0, 40) . '...';
        $titulo = $str;
    }
    $dias_restantes = ($data_emprestimo)->diff($data_termino_convertida)->format("%r%a");

    $statement_utilizadores = $conecta->prepare("SELECT nome FROM utilizadores WHERE id= :utilizador_id");
    $statement_utilizadores->bindValue(':utilizador_id', $utilizador_id);
    $statement_utilizadores->execute();

    while ($dados_db_nome = $statement_utilizadores->fetch(PDO::FETCH_ASSOC)) {
        $nome = $dados_db_nome['nome'];
if($dias_restantes <= 0){
    $dias_restantes = 'Atrasado';
    echo "<div class='alerta_emprestimo' style='text-align: start; border: 2px dashed #ff2957'><div>" . "$titulo" . "<br>"  . "<B>Leitor: </b>$nome </div>" . "<div style='text-align: center;color:#E95354'>" . "Data de entrega: " . date('Y-m-d', strtotime($data_termino)) . "<br>" . "$dias_restantes" . "</div></div>";
}else{
    echo "<div class='alerta_emprestimo' style='text-align: start; border: 2px dashed #7568F0'><div>" . "$titulo" . "<br>"  . "<B>Leitor: </b> $nome </div>" . "<div style='text-align: center;'>" . "Data de entrega: " . date('Y-m-d', strtotime($data_termino)) . "<br>" . "Dias restantes: $dias_restantes" . "</div></div>";
}
    }
}
