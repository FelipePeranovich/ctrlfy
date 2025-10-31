<?php
// Dados da Shopee
define('SHOPEE_PARTNER_ID', 'SEU_PARTNER_ID');
define('SHOPEE_PARTNER_KEY', 'SUA_PARTNER_KEY');
define('SHOPEE_SHOP_ID', 'SEU_SHOP_ID'); // ID da loja

// Função para gerar assinatura
function shopee_signature($path, $params) {
    $base_string = $path . json_encode($params);
    return hash_hmac('sha256', $base_string, SHOPEE_PARTNER_KEY);
}

// Função para requisição
function shopee_get($endpoint, $params = []) {
    $url = "https://partner.shopeemobile.com/api/v2/$endpoint";

    // Adicionar partner_id, shop_id, timestamp
    $params['partner_id'] = SHOPEE_PARTNER_ID;
    $params['shopid'] = SHOPEE_SHOP_ID;
    $params['timestamp'] = time();

    // Gerar signature
    $sign = shopee_signature("/api/v2/$endpoint", $params);
    $params['sign'] = $sign;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $resp = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ['http_code' => $http_code, 'body' => json_decode($resp, true)];
}