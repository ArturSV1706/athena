<?php
session_start();
ob_start();
unset($_SESSION["id"], $_SESSION["nome"]);
header("location: index.php");
