<?php
require __DIR__ . "../../vendor/autoload.php";

$client = new Google\Client;

$client->setClientId("1066806316509-5hhc9aro4vjqh0qve5taqk2oh4tjqlkj.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/ctrlfy/funcoes/cadastroUserGoogle.php");  

if(! isset($_GET["code"])){
  exit("Login failed");
}

$token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);


$client->setAccessToken($token["access_token"]);

$oauth = new Google\Service\Oauth2($client);

$userinfo = $oauth->userinfo->get();

/*var_dump(
    $userinfo->email,
    $userinfo->familyName,
    $userinfo->givenName,
    $userinfo->name
);*/

$email = $userinfo->email;
$nome = $userinfo->givenName;
$sobrenome = $userinfo->familyName;

include_once '../funcoes/banco.php';
$bd = conectar();
$sql = "insert into usuario (`id_usuario`, `nome`, `sobrenome`, `email`, `senha`, `telefone`, `nivel_acesso`, `cpf`) values "
. "(NULL, '$nome','$sobrenome' ,'$email', 'NULL', 'NULL', 'null','NULL')";

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
        $_SESSION['nome'] = $nome;
        $_SESSION['sobrenome'] = $sobrenome;
        $_SESSION['permissao'] = "usuario";
        $bd->commit();       
        header("location:../dashboard.php");
    }


$bd = null;
?>