<?php
require_once("../../private/conexao.php");
require_once("../Misc/estatisticas.php");

session_start();
ob_start();
if (!isset($_SESSION['userID']) || !isset($_SESSION['nome'])) {
    header("Location: ../logout.php");
}
$userID = $_SESSION['userID'];
$statement_ativado = $conecta->prepare("SELECT * FROM usuarios WHERE usuariosId = :id");
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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Livros</title>
    <link rel="icon" href="images/favicon.svg" sizes="any" type="image/svg+xml">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/estilos.css?version=70" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>







</head>

<body class="preload-transitions" style="overflow: hidden!important">
    <?php require_once("../Misc/sidebar2.php");
    require_once("../Misc/telaDeCarregamento.php");

    ?>











    <div class="home_content" style="justify-content: center; overflow: hidden">
        <div class="container_principal">
            <div class="conteudo1">
                <div class="subConteudo1"> <?php echo "<h1>" . "<i class='bx bxs-book-alt'></i>" . $quantidade  . "</h1>" . "<p> Diferentes exemplares </p>"; ?></div>
                <div class="subConteudo2"> <?php echo "<h1>" . "<i class='bx bxs-book-bookmark'></i>" . $soma . "</h1>" . " <p> Total de livros</p> "; ?></div>
                <div class="subConteudo3"> <?php echo "<h1>" . "<i class='bx bxs-bookmarks'></i>" . $quantidade_emprestimos . "</h1>" . " <p> Empréstimos </p> "; ?></div>
            </div>
            <div class="conteudo2">
                <canvas id="roscachart"></canvas>
            </div>
            <div class="lateral">
                <h1>Últimos empréstimos</h1>
                <?php require_once("alertas.php") ?>
                <a href="../Emprestimos/">Ver todos</a>
            </div>
            <div class="principal">

                <canvas id="linechart"></canvas>
            </div>


            <!-- rosca -->
            <script>
                let ctx3 = document.getElementById('roscachart').getContext('2d');
                let roscachart = new Chart(ctx3, {
                    type: 'doughnut',
                    data: {
                        labels: ['Alunos', 'Servidores', 'Terceiros'],
                        datasets: [{
                            label: 'Leitores',
                            backgroundColor: ['rgba(255, 41, 87, .8)', 'rgba(253, 180, 69, .8)', 'rgba(41, 199, 112, .8)'],
                            borderColor: ['rgb(255, 41, 87)', 'rgba(253, 180, 69)', 'rgba(41, 199, 112)'],
                            borderWidth: 3,
                            data: [<?php echo $alunos ?>, <?php echo $servidores ?>, <?php echo $terceiros ?>],
                            fill: 'start',
                            cutout: '40%'
                        }]
                    },
                    options: {
                        tension: 0.3,
                        maintainAspectRatio: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Leitores',
                                color: 'rgb(117, 104, 240)',
                                font: {
                                    size: 19,
                                    family: 'Josefin Sans',
                                    weight: '200',
                                    lineHeight: 1.6,
                                }
                            },
                            legend: {
                                labels: {
                                    usePointStyle: true,
                                    color: 'rgb(117, 104, 240)',
                                    font: {
                                        size: 15,
                                        family: 'Josefin Sans',
                                        weight: '200',
                                        lineHeight: 1.6,
                                    }
                                },
                            },

                        }
                    }
                });
            </script>


            <!-- Line -->
            <!-- Código para arrumar datas e valores do gráfico -->
            <script>
                // Setup block
                var currentDate = new Date();

                var domingo = new Date(currentDate.setDate(currentDate.getDate() - currentDate.getDay())).toISOString().substring(0, 10);
                document.cookie = "domingo=" + domingo;

                var segunda = new Date(currentDate.setDate(currentDate.getDate() - currentDate.getDay() + 1)).toISOString().substring(0, 10);
                document.cookie = "segunda=" + segunda;

                var terca = new Date(currentDate.setDate(currentDate.getDate() - currentDate.getDay() + 2)).toISOString().substring(0, 10);
                document.cookie = "terca=" + terca;

                var quarta = new Date(currentDate.setDate(currentDate.getDate() - currentDate.getDay() + 3)).toISOString().substring(0, 10);
                document.cookie = "quarta=" + quarta;

                var quinta = new Date(currentDate.setDate(currentDate.getDate() - currentDate.getDay() + 4)).toISOString().substring(0, 10);
                document.cookie = "quinta=" + quinta;

                var sexta = new Date(currentDate.setDate(currentDate.getDate() - currentDate.getDay() + 5)).toISOString().substring(0, 10);
                document.cookie = "sexta=" + sexta;

                var sabado = new Date(currentDate.setDate(currentDate.getDate() - currentDate.getDay() + 6)).toISOString().substring(0, 10);
                document.cookie = "sabado=" + sabado;

                console.log(document.cookie);
            </script>

            <?php
            $statement_domingo = $conecta->prepare("SELECT COUNT(id) as domingo FROM emprestimos WHERE data_emprestimo LIKE :domingo");
            $statement_domingo->bindValue(':domingo', "%" . $_COOKIE['domingo'] . "%");
            $statement_domingo->execute();

            while ($dados_db = $statement_domingo->fetch(PDO::FETCH_ASSOC)) {
                $domingo = $dados_db['domingo'];
            }

            $statement_segunda = $conecta->prepare("SELECT COUNT(id) as segunda FROM emprestimos WHERE data_emprestimo LIKE :segunda");
            $statement_segunda->bindValue(':segunda', "%" . $_COOKIE['segunda'] . "%");
            $statement_segunda->execute();

            while ($dados_db = $statement_segunda->fetch(PDO::FETCH_ASSOC)) {
                $segunda = $dados_db['segunda'];
            }

            $statement_terca = $conecta->prepare("SELECT COUNT(id) as terca FROM emprestimos WHERE data_emprestimo LIKE :terca");
            $statement_terca->bindValue(':terca', "%" . $_COOKIE['terca'] . "%");
            $statement_terca->execute();

            while ($dados_db = $statement_terca->fetch(PDO::FETCH_ASSOC)) {
                $terca = $dados_db['terca'];
            }
            $statement_quarta = $conecta->prepare("SELECT COUNT(id) as quarta FROM emprestimos WHERE data_emprestimo LIKE :quarta");
            $statement_quarta->bindValue(':quarta', "%" . $_COOKIE['quarta'] . "%");
            $statement_quarta->execute();

            while ($dados_db = $statement_quarta->fetch(PDO::FETCH_ASSOC)) {
                $quarta = $dados_db['quarta'];
            }
            $statement_quinta = $conecta->prepare("SELECT COUNT(id) as quinta FROM emprestimos WHERE data_emprestimo LIKE :quinta");
            $statement_quinta->bindValue(':quinta', "%" . $_COOKIE['quinta'] . "%");
            $statement_quinta->execute();

            while ($dados_db = $statement_quinta->fetch(PDO::FETCH_ASSOC)) {
                $quinta = $dados_db['quinta'];
            }
            $statement_sexta = $conecta->prepare("SELECT COUNT(id) as sexta FROM emprestimos WHERE data_emprestimo LIKE :sexta");
            $statement_sexta->bindValue(':sexta', "%" . $_COOKIE['sexta'] . "%");
            $statement_sexta->execute();

            while ($dados_db = $statement_sexta->fetch(PDO::FETCH_ASSOC)) {
                $sexta = $dados_db['sexta'];
            }
            $statement_sabado = $conecta->prepare("SELECT COUNT(id) as sabado FROM emprestimos WHERE data_emprestimo LIKE :sabado");
            $statement_sabado->bindValue(':sabado', "%" . $_COOKIE['sabado'] . "%");
            $statement_sabado->execute();

            while ($dados_db = $statement_sabado->fetch(PDO::FETCH_ASSOC)) {
                $sabado = $dados_db['sabado'];
            }

            ?>
            <script>
                const data = {
                    datasets: [{
                        label: "Livros emprestados nesta semana",
                        backgroundColor: "rgba(117, 104, 240, 0.4)",
                        borderColor: "rgb(117, 104, 240)",
                        data: [{
                                x: domingo,
                                y: <?php echo $domingo ?>
                            }, {
                                x: segunda,
                                y: <?php echo $segunda ?>
                            },
                            {
                                x: terca,
                                y: <?php echo $terca ?>
                            },
                            {
                                x: quarta,
                                y: <?php echo $quarta ?>
                            },
                            {
                                x: quinta,
                                y: <?php echo $quinta ?>
                            },
                            {
                                x: sexta,
                                y: <?php echo $sexta ?>
                            },
                            {
                                x: sabado,
                                y: <?php echo $sabado ?>
                            },
                        ],
                        fill: "start",
                    }, ],
                };
                // config block
                const config = {
                    type: "line",
                    data,
                    options: {
                        scales: {
                            x: {
                                type: 'time',
                                time: {
                                    unit: 'day'
                                }
                            },
                            y: {
                                beingAtZero: true,
                            },
                        },
                        tension: 0.3,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                labels: {
                                    usePointStyle: true,
                                    color: 'rgb(117, 104, 240)',
                                    font: {
                                        size: 15,
                                        family: 'Josefin Sans',
                                        weight: '200',
                                        lineHeight: 1.6,
                                    }
                                },
                            },

                        }
                    },
                };

                // render / init
                const linechart = new Chart(
                    document.getElementById('linechart'),
                    config
                );
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

</body>

</html>