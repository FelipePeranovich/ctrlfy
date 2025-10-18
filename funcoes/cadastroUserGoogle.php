<?php
require __DIR__ . "../../vendor/autoload.php";

$client = new Google\Client;

$client->setClientId("1066806316509-5hhc9aro4vjqh0qve5taqk2oh4tjqlkj.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/ctrlfy/funcoes/cadastroUserGoogle.php");  

if(! isset($_GET["code"])){
  echo "<script>alert('ERRO AO CADASTRAR! TENTE NOVAMENTE!');javascript:history.go(-1)</script>";
  die();
}

$token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);


$client->setAccessToken($token["access_token"]);

$oauth = new Google\Service\Oauth2($client);

$userinfo = $oauth->userinfo->get();

$email = $userinfo->email;
$nome = $userinfo->givenName;
$sobrenome = $userinfo->familyName;
$id = $userinfo->id;

include_once '../funcoes/banco.php';
$bd = conectar();

$verifica_id = "select * from usuario where id_oauth=$id";
$testeId = $bd->query($verifica_id);

if($testeId -> rowCount() == 0){
    //se não existe o id ele cadastra
    $verifica_email = "select * from usuario where email = '$email'";
    $teste = $bd->query($verifica_email);
    if($teste -> rowCount()!=0){
        echo "<script>alert('EMAIL INVÁLIDO! ESSE EMAIL JÁ POSSUI CADASTRO');javascript:history.go(-1)</script>";
        die();
    }
    $sql = "insert into usuario (`id_usuario`,`id_oauth` ,`nome`, `sobrenome`, `email`, `senha`, `telefone`, `nivel_acesso`, `cpf`) values "
    . "(NULL, $id ,'$nome','$sobrenome' ,'$email', 'NULL', 'NULL', 'null','NULL')";

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
            header("location:https://floppily-sightless-zayden.ngrok-free.dev/ctrlfy/dashboard.php");
        }
    }
$login = $testeId->fetch();
if($login['id_oauth'] == $id){
    session_start();
            $_SESSION['nome'] = $nome;
            $_SESSION['sobrenome'] = $sobrenome;
            $_SESSION['permissao'] = "usuario";      
            header("location:https://floppily-sightless-zayden.ngrok-free.dev/ctrlfy/dashboard.php");
}else{
    echo "<script>alert('ERRO AO ENTRAR! TENTE NOVAMENTE!');javascript:history.go(-1)</script>";
        die();
}

$bd = null;
?>