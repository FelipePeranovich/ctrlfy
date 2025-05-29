<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

 function conectar(){
    $user ='root';
    $pass ="";
    $dsn= "mysql:host=localhost;dbname=ctrlfy";
    $connection = "";
    try{
        $connection = new PDO($dsn,$user,$pass);
        $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e){
        echo erros($e);
        
    }
    return $connection;
}
