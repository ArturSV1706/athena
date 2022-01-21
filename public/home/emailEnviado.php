<?php
require_once("../../private/conexao.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilosHome.css?version=4">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

    <title>Email Enviado!</title>
</head>

<body>
<div class="navBar">
        <div class="logo_home">
            <a href="index.php"><img src="../assets/athena.svg" class="logo"></a>
        </div>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class='bx bx-menu'></i>
        </label>
       
    </div>
    <div style="position:absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); text-align: center;">
        <i class='bx bx-mail-send bx-tada' style="font-size: 200px; color: #715aff"></i>
        <h1 style="font-size: 30px; font-weight: 100;">Um email de confirmação foi enviado para: <br>
            <b><?php echo $_SESSION["email"]; ?></b>
        </h1>
    </div>
</body>

</html>