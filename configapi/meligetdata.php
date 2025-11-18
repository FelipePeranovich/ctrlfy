<?php

require __DIR__ . '/meliHelper.php';
include_once __DIR__ . "/melicache.php";

$erroToken = null;

/* ============================================
   OBTÉM TOKEN VÁLIDO
============================================ */
$access_token = meli_get_valid_token();

if (!$access_token) {
    $erroToken = "<h5>Conecte a um Marketplece e suas vendas aparecerão aqui! 
                  <a href='marketplace.php'>Conectar agora</a></h5>";
}

/* ============================================
   CARREGA USER_ID DO JSON → SESSÃO → FALLBACK
============================================ */
$tokens = meli_load_tokens();

if (!empty($tokens['user_id'])) {
    $user_id = $tokens['user_id'];
    $_SESSION['meli_user_id'] = $user_id;
} else {
    $user_id = $_SESSION['meli_user_id'] ?? null;
}

if (!$user_id) {
    $erroToken = "<h5>Conecte a um Marketplece e suas vendas aparecerão aqui! 
                  <a href='marketplace.php'>Conectar agora</a></h5>";
}

/* ============================================
   SE NÃO HOUVER TOKEN OU USER, NÃO CHAMA A API
============================================ */
if (!$access_token || !$user_id) {
    return;
}

/* ============================================
   BUSCAS COM CACHE (30 min para ORDERS)
============================================ */
$ordersResp = meli_cached_get(
    "https://api.mercadolibre.com/orders/search?seller=$user_id&order.status=paid&shipping.status=ready_to_ship&sort=date_desc",
    $access_token,
    1800
);

$ordersResp2 = meli_cached_get(
    "https://api.mercadolibre.com/orders/search?seller=$user_id&order.status=paid&sort=date_desc",
    $access_token,
    1800
);

/* ============================================
   ITENS À VENDA COM CACHE (1 hora)
============================================ */
$orderItem = meli_cached_get(
    "https://api.mercadolibre.com/users/$user_id/items/search?limit=50&offset=0",
    $access_token,
    3600
);

?>
