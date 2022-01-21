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
    echo $ativado;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Livros</title>
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
    require_once("../Misc/sidebar2.php");
    require_once("../Misc/telaDeCarregamento.php");
    ?>

    <div class="bg-modal-nosso" id="modal-novo">
        <div class="modal-nosso">
            <i class='bx bx-x close' onclick="modalNovoFechar()"></i>
            <?php require_once("./modal_novo.php");
            ?>
        </div>
    </div>

    <div class="bg-modal-nosso" id="modal-visualizar">
        <div class="modal-nosso" id="modal-nosso-visualizar"></div>
    </div>

    <div class="bg-modal-nosso" id="modal-editar">
        <div class="modal-nosso" id="modal-nosso-editar"></div>
    </div>

    <div class="bg-modal-nosso" id="modal-deletar">
        <div class="modal-nosso" id="modal-nosso-deletar"></div>
    </div>
    <div class="home_content">

        <div class="emprestimos_content">

            <div style="display: flex; flex-direction:row; width: 95%">
                <div class="emprestimos_header">
                    <h1> <i class='bx bxs-bookmarks'></i> Leitores</h1>
                </div>
                <div class="emprestimos_header">
                    <?php echo "<h1>" . "<i class='bx bxs-user' ></i>" . $alunos  . "</h1>" . "<p> Alunos </p>"; ?>
                </div>
                <div class="emprestimos_header">
                    <?php echo "<h1>" . "<i class='bx bxs-user-badge' ></i>" . $servidores  . "</h1>" . "<p> Servidores </p>"; ?>
                </div>
                <div class="emprestimos_header">
                    <?php echo "<h1>" . "<i class='bx bx-world' ></i>" . $terceiros  . "</h1>" . "<p> Terceiros </p>"; ?>
                </div>
            </div>

            <div id="tabela_emprestimos">

                <button class="botao" id="modal-novo" onclick="modalNovoAbrir()"><i class='bx bxs-user-plus bx-sm'></i>Novo leitor</button>

                <div id="spacer"></div>
                <table id="listar-utilizadores" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Quantidade de empréstimos ativos</th>
                            <th>Possui livros em atraso?</th>
                            <th>Ações</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php


                        $statement = $conecta->prepare('SELECT * FROM utilizadores ');
                        $statement->execute();

                        while ($dados_db = $statement->fetch(PDO::FETCH_ASSOC)) {
                            $id = $dados_db["id"];
                            $nome = $dados_db["nome"];
                            $categoria = $dados_db["categoria"];
                            $qtd_emprestimos_ativos = $dados_db["qtd_emprestimos_ativos"];
                            $possui_livros_atrasados = $dados_db["possui_livros_atrasados"];

                            $statement_emprestimo = $conecta->prepare("SELECT * FROM emprestimos WHERE utilizador_id = :id");
                            $statement_emprestimo->bindValue(':id', $id);
                            $statement_emprestimo->execute();

                            while ($dados_db = $statement_emprestimo->fetch(PDO::FETCH_ASSOC)) {
                                $data_emprestimo = $dados_db['data_emprestimo'];
                                $data_emprestimo_convertida = new DateTime();
                                $data_termino = $dados_db['data_termino'];
                                $data_termino_convertida = new DateTime($data_termino);
                                $data_termino_convertida->modify('+2 days');
                                $codigo_de_barras = $dados_db['codigo_de_barras'];

                                $dias_restantes = ($data_emprestimo_convertida)->diff($data_termino_convertida)->format("%r%a");


                                if ($dias_restantes <= 0 && $qtd_emprestimos_ativos > 0) {
                                    $possui_livros_atrasados = 1;
                                    $statement_update = $conecta->prepare('UPDATE utilizadores SET possui_livros_atrasados = 1 WHERE id=:id2');
                                    $statement_update->bindValue(':id2', $id);
                                    $statement_update->execute();
                                } else {
                                    $possui_livros_atrasados = 0;
                                    $statement_update_limpa = $conecta->prepare('UPDATE utilizadores SET possui_livros_atrasados = 0 WHERE id=:id2');
                                    $statement_update_limpa->bindValue(':id2', $id);
                                    $statement_update_limpa->execute();
                                }
                            }

                            if (strlen($nome) > 30) {
                                $str = substr($nome, 0, 30) . '...';
                                echo "<td>" . $str . "</td>";
                            } else {
                                echo "<td>" . $nome . "</td>";
                            }
                            echo "<td>" . $categoria . "</td>";

                            echo "<td>" . $qtd_emprestimos_ativos . "</td>";

                            if ($possui_livros_atrasados >= 1) {
                                echo "<td style='color: #ff2957; font-size: 1.2rem'>" . "POSSUI PENDENCIAS!" . "</td>";
                            } else {
                                echo "<td style='color: #29c770; font-size: 1.2rem'>" . "EM DIA"   . "</td>";
                            }

                            echo "<td><span class='container_acoes'><button id='visualizar'data-id=$id type='button' class='botao_tabela' style='margin-right:10px'><i class='bx bx-show-alt' style='font-size:1.5rem'></i></button>";
                            echo "<button id='editar' data-id=$id type='button' class='botao_tabela' style='margin-right:10px'><i class='bx bx-edit-alt' style='font-size:1.5rem'></i></button>";
                            echo "<button id='deletar' data-id=$id  type='button' class='botao_tabela'><i class='bx bxs-trash' style='font-size:1.5rem'></i></button></span></td></tr>";
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

    function modalEditarFechar() {
        document.getElementById('modal-editar').style.top = "200%";
    }

    function modalDeletarFechar() {
        document.getElementById('modal-deletar').style.top = "200%";
    }


    $(document).ready(function() {
        $('.btn-visualizar').click(function() { //se clicou no botão respectivo
            var meu_id = $(this).data('id'); //pega o id que o botão passou
            $.ajax({
                url: 'modal_visualizar.php', //indica o arquivo que vai adicionar conteúdo ao modal
                type: 'post',
                data: {
                    meu_id: meu_id //passa o id do registro clicado para o arquivo chamado acima
                },
                success: function(response) {
                    $('#modal-nosso-visualizar').html(response);
                    document.getElementById('modal-visualizar').style.top =
                        "0";
                }
            });
        });

        $('.btn-editar').click(function() { //se clicou no botão respectivo
            var meu_id = $(this).data('id'); //pega o id que o botão passou
            $.ajax({
                url: 'modal_editar.php', //indica o arquivo que vai adicionar conteúdo ao modal
                type: 'post',
                data: {
                    meu_id: meu_id //passa o id do registro clicado para o arquivo chamado acima
                },
                success: function(response) {
                    $('#modal-nosso-editar').html(response);
                    document.getElementById('modal-editar').style.top = "0";
                }
            });
        });

        $('.btn-deletar').click(function() { //se clicou no botão respectivo
            var meu_id = $(this).data('id'); //pega o id que o botão passou
            $.ajax({
                url: 'modal_deletar.php', //indica o arquivo que vai adicionar conteúdo ao modal
                type: 'post',
                data: {
                    meu_id: meu_id //passa o id do registro clicado para o arquivo chamado acima
                },
                success: function(response) {
                    $('#modal-nosso-deletar').html(response);
                    document.getElementById('modal-deletar').style.top =
                        "0";
                }
            });
        });
    })
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