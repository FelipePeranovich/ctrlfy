<?php
require __DIR__ . '/meliHelper.php';

$erroToken = null;

$access_token = meli_get_valid_token();
if (!$access_token) {
   $erroToken = "<h5>Conecte a um Marketplece e suas vendas aparecerão aqui! <a href='marketplace.php'>Conectar agora</a></h5>";
}

$tokens = meli_load_tokens();
$user_id = $tokens['user_id'] ?? null;

if (!$user_id) {
     $erroToken = "<h5>Conecte a um Marketplece e suas vendas aparecerão aqui! <a href='marketplace.php'>Conectar agora</a></h5>";
}

// Busca pedidos pagos e prontos para envio
$ordersResp = meli_get("https://api.mercadolibre.com/orders/search?seller=$user_id&order.status=paid&shipping.status=ready_to_ship&sort=date_desc", $access_token);
$ordersResp2 = meli_get("https://api.mercadolibre.com/orders/search?seller=$user_id&order.status=paid&sort=date_desc", $access_token);
$orderItem = meli_get("https://api.mercadolibre.com/users/{$user_id}/items/search?limit=50&offset=0", $access_token);

?>