<?php
require __DIR__ . '/meliConfig.php';


if (!isset($_GET['code'])) {
    echo 'Autorização não concedida.';
    exit;
}

$code = $_GET['code'];

// Troca o "code" pelo access_token
$ch = curl_init('https://api.mercadolibre.com/oauth/token');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'grant_type' => 'authorization_code',
    'client_id' => MELI_CLIENT_ID,
    'client_secret' => MELI_CLIENT_SECRET,
    'code' => $code,
    'redirect_uri' => MELI_REDIRECT_URI,
]));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$data = json_decode($response, true);

if ($httpCode !== 200 || !isset($data['access_token'])) {
    echo '<h3>Erro ao obter token</h3>';
    echo '<pre>' . htmlspecialchars($response) . '</pre>';
    exit;
}

// Salva o token localmente
$data['obtained_at'] = time();
meli_save_tokens($data);

// Guarda sessão

$acess_token = $data['access_token'];
$id = $data['user_id'];
include_once '../funcoes/banco.php';
$bd = conectar();
$sql = "INSERT INTO `marketplace`(`id_marketplace`, `nome`, `status`, `acess_token`, `refresh_token`) 
VALUES ( null,'Mercado Livre','Ativo','$acess_token','$id')";


 $bd->beginTransaction();
        $i = $bd->exec($sql);  
            if ($i != 1){
                $bd->rollBack();
            }
        else {
            session_start();
            $_SESSION['meli_access_token'] = $data['access_token'];
            $_SESSION['meli_user_id'] = $data['user_id'];
            $bd->commit();       
            header('Location: https://floppily-sightless-zayden.ngrok-free.dev/ctrlfy/dashboard.php');
        }

exit;
