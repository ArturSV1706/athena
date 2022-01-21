<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>


    <link rel="stylesheet" href="estilosHome.css?version=4">
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
            <li><a href="index.php">Home</a></li>
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
                <h1>Sobre nós</h1>
                <h5>Artur de Souza Vieira</h5>
                <p>Técnico e professor de informática, experiência com Web design, desenvolvimento Front-end e Back-end. Na escola que lecionei recebi o desafio de criar um sistema de gestão de bibliotecas, então, junto com meu irmão decidimos criar o <b>Athena</b>.</p>
            </div>
            <img src="../assets/foto site artur.png" alt="Foto do criador" class="fotos" style="animation: direita 0.2s ease;">
        </div>
        <div class="content">
            <img src="../assets/foto site victor.png" alt="Foto do criador" class="fotos" style="animation: esquerda 0.2s ease;">
            <div class="texto" style="animation: direita 0.7s ease;">
                <h1>Sobre nós</h1>
                <h5>Victor de Souza Vieira</h5>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae vero nemo consequuntur et praesentium excepturi. Nesciunt nisi asperiores, qui tempore obcaecati quibusdam? Quas, ad consequuntur? Quae odio alias officiis nemo!</p>
            </div>

        </div>



    </section>
    <div class="fundo_background"></div>
</body>

</html>