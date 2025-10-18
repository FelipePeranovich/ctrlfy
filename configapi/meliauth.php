<?php
require __DIR__ . '/meliconfig.php';

// Redireciona o usuário para o login do Mercado Livre
$authUrl = 'https://auth.mercadolivre.com.br/authorization'
    . '?response_type=code'
    . '&client_id=' . urlencode(MELI_CLIENT_ID)
    . '&redirect_uri=' . urlencode(MELI_REDIRECT_URI);

header('Location: ' . $authUrl);
exit;
