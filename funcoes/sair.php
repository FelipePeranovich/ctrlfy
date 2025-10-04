<?php
    session_start();
    unset($_SESSION['nome']);
    unset($_SESSION['sobrenome']);
    unset($_SESSION['permissao']);
    unset($_SESSION['cpf']);
    header("location:../index.php");
?>