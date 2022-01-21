<?php
try{
    $conecta   = new PDO("mysql:dbname=biblioteca;host=localhost","root","");
    }
catch (PDOException $e){
    echo "erro com banco de dados" .$e->getMessage();
}
catch(Exception $e){
    echo "erro generico" .$e->getMessage();
}

