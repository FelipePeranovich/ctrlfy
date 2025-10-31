<?php
require __DIR__ . '/meliConfig.php';

// Garante que a constante do arquivo de token esteja definida
if (!defined('MELI_TOKEN_FILE')) {
    die('Erro: constante MELI_TOKEN_FILE não definida.');
}

// Remove o arquivo onde os tokens são salvos
if (file_exists(MELI_TOKEN_FILE)) {
    unlink(MELI_TOKEN_FILE);
    unset($_SESSION['meli_access_token']);
    unset($_SESSION['meli_user_id']);
    header('Location: https://floppily-sightless-zayden.ngrok-free.dev/ctrlfy/marketplace.php');
} else {
    echo "<spam>Nenhuma conta Mercado Livre conectada.<spam>";
}
