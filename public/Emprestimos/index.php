<?php
require_once("../../private/conexao.php");
require_once("../Misc/estatisticas.php");

session_start();
ob_start();
if (!isset($_SESSION['userID']) || !isset($_SESSION['nome'])) {
    header("Location: ../logout.php");
}
$userID = $_SESSION['userID'];
$statement_ativado = $conecta->prepare("SELECT * FROM usuarios WHERE usuariosID = :id");
$statement_ativado->bindValue(':id', $userID);
$statement_ativado->execute();
$dados_ativado = $statement_ativado->fetch(PDO::FETCH_ASSOC);
$ativado = $dados_ativado["ativado"];

if ($ativado != 1) {
    header("Location: ../ativeSuaConta.php");
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Empréstimos</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">


    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../css/estilos.css?version=3" />


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/c7a9fc13f5.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c7a9fc13f5.js" crossorigin="anonymous"></script>

    <!-- DataTables -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script src="dataTables.js"></script>

    <!-- Botões que imprimem tabelas -->
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
</head>

<body class="preload-transitions">


    <?php
    require_once("../Misc/telaDeCarregamento.php");
    require_once("../Misc/sidebar2.php");
    ?>


    <div class="bg-modal-nosso" id="modal-novo">
        <div class="modal-nosso">
            <i class='bx bx-x close' onclick="modalNovoFechar()"></i>
            <?php require_once("./modal_novo.php"); ?>
        </div>
    </div>

    <div class="bg-modal-nosso" id="modal-visualizar">
        <div class="modal-nosso" id="modal-nosso-visualizar"></div>
    </div>

    <div class="bg-modal-nosso" id="modal-deletar">
        <div class="modal-nosso" id="modal-nosso-deletar"></div>
    </div>

    <div class="home_content">
        <div class="emprestimos_content">
            <div style="display: flex; flex-direction:row; width: 95%">
                <div class="emprestimos_header">
                    <h1> <i class='bx bxs-bookmarks'></i> Empréstimos</h1>
                </div>
                <div class="emprestimos_header">
                    <?php echo "<h1>" . "<i class='bx bx-bookmarks' ></i>" . $quantidade_emprestimos  . "</h1>" . "<p> Empréstimos de livros </p>"; ?>
                </div>
            </div>



            <div id="tabela_emprestimos">
                <button class="botao" id="modal-novo" onclick="modalNovoAbrir()"><i class='bx bxs-bookmark-alt-plus bx-sm'></i> Novo Empréstimo</button>
                <div id="spacer"></div>
                <table id="listar-emprestimos" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Dias restantes</th>
                            <th>Solicitante</a></th>
                            <th>Título </a></th>
                            <th>Criação</a></th>
                            <th>Expira em</a></th>
                            <th>Cód. Barras</th>
                            <th>Status</a></th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $statement_emprestimo = $conecta->prepare("SELECT * FROM emprestimos");
                        $statement_emprestimo->execute();

                        while ($dados_db = $statement_emprestimo->fetch(PDO::FETCH_ASSOC)) {


                            $id = $dados_db["id"];
                            $utilizador_id = $dados_db["utilizador_id"];
                            $livro_id = $dados_db["livro_id"];
                            $titulo = $dados_db['titulo'];
                            $data_emprestimo = $dados_db['data_emprestimo'];
                            $data_emprestimo_convertida = new DateTime();
                            $data_termino = $dados_db['data_termino'];
                            $data_termino_convertida = new DateTime($data_termino);
                            $data_termino_convertida->modify('+2 days');
                            $codigo_de_barras = $dados_db['codigo_de_barras'];

                            $dias_restantes = ($data_emprestimo_convertida)->diff($data_termino_convertida)->format("%r%a");

                            $statement_utilizador = $conecta->prepare("SELECT * FROM utilizadores WHERE id= :utilizador_id");
                            $statement_utilizador->bindValue(':utilizador_id', $utilizador_id);
                            $statement_utilizador->execute();


                            while ($dados_db_utilizador = $statement_utilizador->fetch(PDO::FETCH_ASSOC)) {
                                $utilizador = $dados_db_utilizador['nome'];
                            }

                            if ($dias_restantes <= 0) {
                                echo "<tr><td style='color: #ff2957; font-size: 1.2rem'>" . "0" . "</td>";
                            } else if ($dias_restantes <= 10) {
                                echo "<tr><td style='color: #de8e45; font-size: 1.2rem'>" . $dias_restantes   . "</td>";
                            } else if ($dias_restantes > 10) {
                                echo "<tr><td style='color: #29c770; font-size: 1.2rem'>" . $dias_restantes   . "</td>";
                            }


                            echo "<td>" . $utilizador . "</td>";

                            //Função para restringir o tamanho de uma string
                            if (strlen($titulo) > 20) {
                                $str = substr($titulo, 0, 20) . '...';
                                echo "<td>" . htmlspecialchars($str) . "</td>";
                            } else {
                                echo "<td>" . htmlspecialchars($titulo) . "</td>";
                            }

                            //Trabalhando com datas no php
                            // $statement_termino = $conecta->prepare("UPDATE emprestimos SET data_termino=:data_termino_atualizada");
                            // $statement_termino->bindValue(':data_termino_atualizada', date('Y-m-d', strtotime($data_emprestimo . ' + 30 days')));
                            // $statement_termino->execute();

                            echo "<td>" . date('Y-m-d', strtotime($data_emprestimo))  . "</td>";
                            echo "<td>" .  date('Y-m-d', strtotime($data_termino)) .  "</td>";
                            echo "<td>$codigo_de_barras</td>";


                            if ($dias_restantes <= 0) {
                                echo "<td style='color: #e95354; font-size: 1.2rem'>" . "ATRASADO" . "</td>";
                            } else if ($dias_restantes <= 10) {
                                echo "<td style='color: #de8e45; font-size: 1.2rem'>" . "DEVOLUÇÃO PRÓXIMA"   . "</td>";
                            } else if ($dias_restantes > 10) {
                                echo "<td style='color: #29c770; font-size: 1.2rem'>" . "EM DIA"   . "</td>";
                            }


                            echo "<td><span class='container_acoes'><button id='visualizar' data-id=$id class='botao_tabela'><i class='bx bx-show-alt' style='font-size:1.5rem'></i></button>";
                            echo "<button id='devolver' data-id=$id data-livro_id=$livro_id data-utilizador_id=$utilizador_id class='botao_tabela' style='font-size:1.5rem'><i class='bx bx-share'></i></button></span>";
                            echo "</td></tr>";
                        }


                        require_once("../Misc/modais.php");

                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php require_once("../Misc/footer.php") ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>
</body>

<script type="text/javascript">
    function modalNovoAbrir() {
        document.getElementById('modal-novo').style.top = "0";
    }

    function modalNovoFechar() {
        document.getElementById('modal-novo').style.top = "200%";
    }

    function modalVisualizarFechar() {
        document.getElementById('modal-visualizar').style.top = "200%";
    }

    function modalDeletarFechar() {
        document.getElementById('modal-deletar').style.top = "200%";
    }

    $(document).ready(function() {
        $('.btn-visualizar').click(function() {
            var meu_id = $(this).data('id');
            $.ajax({
                url: 'modal_visualizar.php',
                type: 'post',
                data: {
                    meu_id: meu_id
                },
                success: function(response) {
                    $('#modal-nosso-visualizar').html(response);
                    document.getElementById('modal-visualizar').style.top = "0";
                }
            });
        });
    });

    $(document).ready(function() {
        $('.btn-devolver').click(function() {
            var meu_id = $(this).data('id');
            var livro_id = $(this).data('livro_id');
            var utilizador_id = $(this).data('utilizador_id');
            $.ajax({
                url: 'modal_deletar.php',
                type: 'post',
                data: {
                    meu_id: meu_id,
                    livro_id: livro_id,
                    utilizador_id: utilizador_id
                },
                success: function(response) {
                    $('#modal-nosso-deletar').html(response);
                    document.getElementById('modal-deletar').style.top = "0";
                }
            });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var delayInMilliseconds = 1000; //1 second

        setTimeout(function() {
            let node = document.querySelector('.preload-transitions');
            node.classList.remove('preload-transitions');
        }, delayInMilliseconds);
    });
</script>

</html>
</body>

</html>