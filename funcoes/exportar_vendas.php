<?php
session_start();

// ==============================================
// VERIFICA LOGIN
// ==============================================
if (empty($_SESSION['nome'])) {
    header("location:index.php");
    exit;
}

// ==============================================
// IMPORTA APENAS O NECESSÁRIO
// (mas impede qualquer saída antes do CSV)
// ==============================================
ob_clean(); // limpa qualquer saída acidental

require_once('../configapi/meliHelper.php');  // contém meli_get_valid_token()
require_once('../configapi/meliCache.php');    // contém meli_load_tokens()

// ==============================================
// TOKEN + USER_ID
// ==============================================
$access_token = meli_get_valid_token();
if (!$access_token) {
    die("Token inválido. Refaça a conexão com o Mercado Livre.");
}

$tokens = meli_load_tokens();
$user_id = $tokens['user_id'] ?? null;

if (!$user_id) {
    die("Erro: user_id não encontrado. Refaça a conexão com o Mercado Livre.");
}

// ==============================================
// FUNÇÃO DE CHAMADA DIRETA (SEM CACHE)
// ==============================================
function ml_call($url, $token) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $token"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $body = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    return [
        "code" => $code,
        "body" => json_decode($body, true)
    ];
}

// ==============================================
// BUSCA TODAS AS VENDAS SEM CACHE
// ==============================================
$limite = 50;
$offset = 0;
$todas = [];

do {
    $url = "https://api.mercadolibre.com/orders/search?seller={$user_id}"
         . "&sort=date_desc&limit={$limite}&offset={$offset}";

    $resp = ml_call($url, $access_token);

    if ($resp["code"] !== 200) {
        break;
    }

    $lista = $resp["body"]["results"] ?? [];
    $todas = array_merge($todas, $lista);

    $total = $resp["body"]["paging"]["total"] ?? 0;
    $offset += $limite;

} while ($offset < $total);

// ==============================================
// GERA CSV
// ==============================================
$arquivo = "vendas_" . date("Y-m-d_H-i") . ".csv";

header("Content-Type: text/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=\"$arquivo\"");
header("Pragma: no-cache");
header("Expires: 0");

// CSV direto pro navegador
$fp = fopen("php://output", "w");

// Excel UTF-8
fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

fputcsv($fp, ["ID Venda", "Data", "Produto", "Quantidade", "Total (R$)"], ';');

foreach ($todas as $venda) {

    $id = $venda["id"];
    $data = date("d/m/Y H:i", strtotime($venda["date_created"]) - 10800);
    $total = number_format($venda["total_amount"], 2, ',', '.');

    foreach ($venda["order_items"] as $item) {
        fputcsv($fp, [
            $id,
            $data,
            $item["item"]["title"] ?? "—",
            $item["quantity"] ?? 1,
            $total
        ], ';');
    }
}

fclose($fp);
exit;
