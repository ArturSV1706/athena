<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilosHome.css?version=7">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <title>Document</title>
</head>

<body>
    <div class="loader" id="loader">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <script>
        var loader = document.getElementById("loader");
        window.onload = function() {
            loader.style.display = 'none';
        }
    </script>
    <div class="navBar">
        <div class="logo_home">
        <a href="index.php"><img src="../assets/athena.svg" class="logo"></a>
        </div>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class='bx bx-menu'></i>
        </label>
        <ul>
            <li><a href="">Home</a></li>
            <li><a href="demonstracao.php">O que é o athena?</a></li>
            <li><a href="sobre.php">Sobre nós</a></li>
            <li><a href="">Contato</a></li>
            <li><a href="../"><button>Entrar</button></a></li>
            <li><a href="novaConta.php"><button style="background-color: #d9d9d9;color: #715aff;">Criar conta</button></a></li>
        </ul>
    </div>

    <section class="about">
        <div class="content">
            <div class="texto" style="animation: esquerda 0.7s ease;">
                <h1 style="font-size: 50px">Athena, um Software moderno para gestão de bibliotecas</h1>
                <p>Tenha controle total de seus livros, leitores e empréstimos com uma ferramenta simples, intuititiva e poderosa.</p>
                <a href="novaConta.php"><button>Comece já</button></a>
            </div>
            <img src="../assets/meninaLendo.svg" alt="menina lendo" style="opacity: 100%;animation: direita 0.7s ease;">
        </div>
    </section>
    <div class="fundo_background"></div>

</body>

</html>