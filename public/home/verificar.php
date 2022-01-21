<?php
require_once("../../private/conexao.php");


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verificado</title>

    <link rel="stylesheet" href="estilosHome.css?version=4">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>



</head>

<body>

    <div style="position:absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); text-align: center;">

        <?php
        if (isset($_GET['vkey'])) {
            $vkey = $_GET['vkey'];

            $statement = $conecta->prepare("SELECT  verified, vkey FROM usuarios WHERE verified = 0 AND vkey = :vkey LIMIT 1 ");
            $statement->bindValue(':vkey', $vkey);
            $statement->execute();

            if ($statement->rowCount() == 1) {
                $statement_validar = $conecta->prepare("UPDATE usuarios SET verified = 1 WHERE vkey = :vkey_validar LIMIT 1");
                $statement_validar->bindValue(':vkey_validar', $vkey);
                if ($statement_validar->execute()) {
                    echo "<i class='bx bx-check bx-tada' style='font-size: 200px; color: #715aff'></i>";
                    echo "<h1>Seu email foi verificado!</h1>";
                    echo "<br><button onclick=" . "window.location='../'" . ">Fazer Login</button>'";

                } else {
                    echo "<i class='bx bx-error bx-tada' style='font-size: 200px; color: #715aff'></i>";
                    echo "<h1>Erro na validação</h1>";
                }
            } else {
                echo "<i class='bx bx-user-check bx-tada' style='font-size: 200px; color: #715aff'></i>";
                echo "<h1>Esta conta já está verificada</h1>";
                echo "<br><button onclick=" . "window.location='../'" . ">Fazer Login</button>'";

            }
        } else {
            die("Algo deu errado");
        }

        ?>
    </div>
</body>

</html>