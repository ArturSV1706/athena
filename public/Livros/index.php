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
    <title>Livros</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../css/estilos.css?version=7" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/c7a9fc13f5.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c7a9fc13f5.js" crossorigin="anonymous"></script>
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
    <div class="bg-modal-nosso" id="modal-novo-categoria">
        <div class="modal-nosso">
            <i class='bx bx-x close' onclick="modalNovoCategoriaFechar()"></i>
            <?php require_once("./modal_novo_categoria.php"); ?>
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
        <div class="emprestimos_content" id="emp">
            <div style="display: flex; flex-direction:row; width: 95%">
                <div class="emprestimos_header">
                    <h1> <i class='bx bxs-book-bookmark'></i> Livros</h1>
                </div>
                <div class="emprestimos_header">
                    <?php echo "<h1>" . "<i class='bx bxs-book-alt'></i>" . $quantidade  . "</h1>" . "<p> Diferentes exemplares </p>"; ?>
                </div>
                <div class="emprestimos_header">
                    <?php echo "<h1>" . "<i class='bx bxs-book-bookmark'></i>" . $soma . "</h1>" . " <p> Total de livros</p> "; ?>
                </div>
            </div>
            <div id="tabela_emprestimos">
                <div style="display: flex">
                    <button class="botao" id="modal-novo" onclick="modalNovoAbrir()"><i class='bx bx-plus bx-sm'></i>Adicionar Livro</button>
                    <button class="botao" id="modal-novo-categoria" onclick="modalNovoCategoriaAbrir()"><i class='bx bxs-layer-plus bx-sm'></i>Adicionar categoria</button>
                </div>
                <div id="spacer"></div>
                <div class="tabela">
                    <table id="listar-livros" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <!-- <th>#</th> -->
                                <th>Título</th>
                                <th>Autor(es)</th>
                                <th>Editora</th>
                                <th>Categoria</th>
                                <th>Ano</th>
                                <th>ISBN</th>
                                <th>Cód. Barras</th>
                                <th>Qnt.</th>
                                <th>Status</th>
                                <th>Ações</th>

                        </thead>
                        <tbody>
                            <?php

                            $statement_livros = $conecta->prepare('SELECT * FROM livros l INNER JOIN categoria c ON l.categoria_id = c.numero');
                            $statement_livros->execute();


                            while ($dados_db = $statement_livros->fetch(PDO::FETCH_ASSOC)) {
                                $id = $dados_db['id'];
                                $titulo = $dados_db['titulo'];
                                $editora = $dados_db['editora'];
                                $autores = $dados_db['autores'];
                                $isbn = $dados_db['isbn'];
                                $qnt = $dados_db['quantidade'];
                                $qnt_emp = $dados_db['quantidade_emp'];
                                $codigo_de_barras = $dados_db['codigo_de_barras'];
                                $ano = $dados_db['ano'];
                                $paginas = $dados_db['paginas'];
                                $status = $dados_db['status'];
                                $categoria = $dados_db['nome'];

                                // echo "<tr><td>$id</td>";


                                //Função para restringir o tamanho de uma string
                                if (strlen($titulo) > 40) {
                                    $str = substr($titulo, 0, 40) . '...';
                                    echo "<td>" . ($str) . "</td>";
                                } else {
                                    echo "<td>" . ($titulo) . "</td>";
                                }

                                switch ($autores) {
                                    case "(não informado)":
                                        echo "<td style='font-size: 12px;font-style: italic;color: grey;'>(não informado)</td>";
                                        break;
                                    default:
                                        echo "<td style='width: 100px; word-wrap: break-word;'>" . ($autores) . "</td>";
                                        break;
                                }

                                switch ($editora) {
                                    case "(não informado)":
                                        echo "<td style='font-size: 12px;font-style: italic;color: grey; width: 12px; word-wrap: break-word;'>(não informado)</td>";
                                        break;
                                    default:
                                        echo "<td style='width: 50px; word-wrap: break-word;'>" . ($editora) . "</td>";
                                        break;
                                }

                                echo "<td style='width: 50px; word-wrap: break-word;'>$categoria</td>";

                                switch ($ano) {
                                    case "(não informado)":
                                        echo "<td style='font-size: 12px;font-style: italic;color: grey;width: 12px; word-wrap: break-word;'>(não informado)</td>";
                                        break;
                                    default:
                                        echo "<td style='width: 50px; word-wrap: break-word;'>" . $ano . "</td>";
                                        break;
                                }



                                switch ($isbn) {
                                    case "(não informado)":
                                        echo "<td style='font-size: 12px;font-style: italic;color: grey;width: 12px; word-wrap: break-word;'>(não informado)</td>";
                                        break;
                                    default:
                                        echo "<td style='width: 50px; word-wrap: break-word;'>" . $isbn . "</td>";
                                        break;
                                }

                                switch ($codigo_de_barras) {
                                    case "(não informado)":
                                        echo "<td style='font-size: 12px;font-style: italic;color: grey;width: 12px; word-wrap: break-word;'>(não informado)</td>";
                                        break;
                                    default:
                                        echo "<td style='width: 50px; word-wrap: break-word;'>" . $codigo_de_barras . "</td>";
                                        break;
                                }
                                echo "<td style='width: 50px; word-wrap: break-word;'>$qnt Un.</td>";

                                switch ($status) {
                                    case "disponivel":
                                        echo "<td style='font-weight:bold;color: #29C770; width: 20px; word-wrap: break-word;'>DISPONÍVEL</td>";
                                        break;
                                    case "emprestado":
                                        echo "<td style='font-weight:bold;color: #ff2957; width: 20px; word-wrap: break-word;'>EMPRESTADO (" . $qnt_emp . "/" . $qnt . ")</td>";
                                        break;
                                    default:
                                        echo "<td style='font-weight:bold; width: 20px; word-wrap: break-word;'>SEM VALOR</td>";
                                        break;
                                }

                                echo "<td><span class='container_acoes'><button id='visualizar' data-id=$id type='button' class='botao_tabela' style='font-size:1.5rem'><i class='bx bx-show-alt'></i></button>" .
                                    "<button id='editar' id='editar' data-id=$id type='button' class='botao_tabela' style='font-size:1.5rem'><i class='bx bx-edit-alt' ></i></button>" .
                                    "<button id='deletar' id='deletar' data-id=$id  type='button' class='botao_tabela' style='font-size:1.5rem'><i class='bx bxs-trash'></i></button></span></td></tr>";
                            }

                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
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

    function modalNovoCategoriaAbrir() {
        document.getElementById('modal-novo-categoria').style.top = "0";
    }

    function modalNovoCategoriaFechar() {
        document.getElementById('modal-novo-categoria').style.top = "200%";
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