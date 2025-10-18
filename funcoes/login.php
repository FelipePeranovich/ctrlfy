<?php
    include_once '../funcoes/banco.php';
    $bd = conectar();
    session_start();
    $email = filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST,"senha",FILTER_SANITIZE_SPECIAL_CHARS);
    

    $sql = "SELECT nome,sobrenome,email,senha,cpf FROM `usuario` WHERE email='$email'";
 
    $resultado = $bd->query($sql);       
    $login = $resultado->fetch();
    $senha_bd = $login['senha'];

    if(password_verify($senha, $senha_bd)){   
        $_SESSION['nome'] = $login['nome'];
        $_SESSION['sobrenome'] = $login['sobrenome'];
        $_SESSION['permissao'] = "usuario";
        $_SESSION['cpf'] = $login['cpf'];
        header("location:../dashboard.php");
    }else{
        unset($_SESSION["usuario"]);
        unset($_SESSION["permissao"]);
        unset($_SESSION['cpf']); 
        //echo "<script>alert('Por favor, digite um email ou senha válido.');";
        //echo "javascript:history.go(-1)'</script>";
        header("location:../index.php");
    }  
$resultado = null;
$bd = null;    
