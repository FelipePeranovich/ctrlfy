<?php

$email = filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL);
$senha = filter_input(INPUT_POST,"senha",FILTER_SANITIZE_SPECIAL_CHARS);
$cpf = filter_input(INPUT_POST,"cpf",FILTER_SANITIZE_SPECIAL_CHARS);
$telefone = filter_input(INPUT_POST,"telefone",FILTER_SANITIZE_SPECIAL_CHARS);
$nome = filter_input(INPUT_POST,"nome",FILTER_SANITIZE_SPECIAL_CHARS);
$sobrenome = filter_input(INPUT_POST,"sobrenome",FILTER_SANITIZE_SPECIAL_CHARS);

$senhaHash = password_hash($senha,PASSWORD_DEFAULT);
include_once '../funcoes/banco.php';
$bd = conectar();
$sql = "insert into usuario (`id_usuario`, `nome`, `sobrenome`, `email`, `senha`, `telefone`, `nivel_acesso`, `cpf`) values "
. "(NULL, '$nome','$sobrenome' ,'$email', '$senhahash', '$telefone', 'null','$cpf')";

echo $sql;

$verifica_cpf ="select * from usuario where cpf = '$cpf'";
$res = $bd->query($verifica_cpf);
if($res->rowCount()!=0){
    echo "<script>alert('CPF INVÁLIDO! ESSE CPF JÁ POSSUI CADASTRO');javascript:history.go(-1)</script>";
    die();
}
$verifica_email = "select * from usuario where email = '$email'";
$teste = $bd->query($verifica_email);
if($teste -> rowCount()!=0){
    echo "<script>alert('EMAIL INVÁLIDO! ESSE EMAIL JÁ POSSUI CADASTRO');javascript:history.go(-1)</script>";
    die();
}
$bd->beginTransaction();

    $i = $bd->exec($sql);  
        if ($i != 1){
            $bd->rollBack();
        }
    else {
        session_start();
        $_SESSION['usuario'] = $nome;
        $_SESSION['permissao'] = "usuario";
        $_SESSION['cpf'] = $cpf;
        $bd->commit();       
        header("location:../index.php");
    }


$bd = null;
?>
