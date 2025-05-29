<?php
    include_once '../funcoes/banco.php';
    $bd = conectar();
    session_start();
    $email = filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST,"senha",FILTER_SANITIZE_SPECIAL_CHARS);
    
    $sql = "SELECT nome,email,senha,cpf FROM `usuario` WHERE email='$email'";
 
    $resultado = $bd->query($sql);       
    $login = $resultado->fetch();
    $senha_bd = $login['senha_cliente'];
    if(password_verify($senha, $senha_bd)){
        $_SESSION['usuario'] = $login['nm_cliente'];
        $_SESSION['permissao'] = "usuario";
        $_SESSION['cpf'] = $login['cpf_cliente'];
        echo "<script>javascript:history.go(-1)</script>";
    }else{
        unset($_SESSION["usuario"]);
        unset($_SESSION["permissao"]);
        unset($_SESSION['cpf']); 
        //echo "<script>alert('Por favor, digite um email ou senha válido.');";
        //echo "javascript:history.go(-1)'</script>";
        header("location:../dashboard.php?erro=login");
    }  
$resultado = null;
$bd = null;    
