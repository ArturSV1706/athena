<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="estilosHome.css?version=2">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

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
            <!-- image slider start -->
            <div class="slider">
                <div class="slides">
                    <!-- radio buttons start -->
                    <input type="radio" name="radio-btn" id="radio1">
                    <input type="radio" name="radio-btn" id="radio2">
                    <input type="radio" name="radio-btn" id="radio3">
                    <input type="radio" name="radio-btn" id="radio4">
                    <!-- radio buttons end -->
                    <!-- slide images start -->
                    <div class="slide first">
                        <img src="../assets/print1.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="../assets/print2.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="../assets/print3.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="../assets/print4.jpg" alt="">
                    </div>
                    <!-- slide images end -->
                    <!-- automatic navigation start-->
                    <div class="navigation_auto">
                        <div class="auto_btn1"> </div>
                        <div class="auto_btn2"> </div>
                        <div class="auto_btn3"> </div>
                        <div class="auto_btn4"> </div>
                    </div>
                    <!-- automatic navigation end-->
                </div>
                <!-- manual navigation start -->
                <div class="navigation_manual">
                    <label for="radio1" class="manual_btn"></label>
                    <label for="radio2" class="manual_btn"></label>
                    <label for="radio3" class="manual_btn"></label>
                    <label for="radio4" class="manual_btn"></label>
                </div>
                <!-- manual navigation end -->
            </div>
            <!-- image slider end -->
            <div class="texto">
                <h1 style="font-size:50px">O que é o Athena? </h1>
                <p>Athena é um software de gerenciamento de biblioteca poderoso e simples. Tenha total controle de todos os seus livros, leitores, empréstimos e estatísticas com um sistema muito intuitivo.</p>

            </div>
    </section>
    <script>
        var counter = 1;
        setInterval(function() {
            document.getElementById('radio' + counter).checked = true
            counter++;
            if (counter > 6) {
                counter = 1;
            }
        }, 4000)
    </script>
    <div class="fundo_background"></div>

</body>

</html>