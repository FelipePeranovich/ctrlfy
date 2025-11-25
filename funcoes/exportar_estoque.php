<?php
session_start();

if (empty($_SESSION['nome'])) {
    header("location:../index.php");
    exit;
}

require_once('../configapi/meligetdata.php'); // contém meli_get e token já carregado automaticamente

// =======================================
// TOKEN + USER ID
// =======================================
$tokens = meli_load_tokens();
$access_token = $tokens['access_token'] ?? null;
$user_id = $tokens['user_id'] ?? null;

if (!$access_token || !$user_id) {
    die("Token inválido ou user_id não encontrado. Refaça a conexão com o Mercado Livre.");
}

// =======================================
// BUSCAR TODOS OS ANÚNCIOS DO VENDEDOR
// =======================================
$all_ids = [];
$offset = 0;
$limit = 50;

do {
    $resp = meli_get("https://api.mercadolibre.com/users/$user_id/items/search?offset=$offset&limit=$limit", $access_token);

    if ($resp["http_code"] !== 200) break;

    $results = $resp["body"]["results"] ?? [];
    $all_ids = array_merge($all_ids, $results);

    $total = $resp["body"]["paging"]["total"] ?? 0;
    $offset += $limit;

} while ($offset < $total);

// =======================================
// PEGAR DETALHES EM LOTES
// =======================================
$produtos = [];

foreach (array_chunk($all_ids, 20) as $chunk) {
    $ids = implode(",", $chunk);
    $det = meli_get("https://api.mercadolibre.com/items?ids={$ids}", $access_token);

    if ($det["http_code"] !== 200) continue;

    foreach ($det["body"] as $item) {
        $i = $item["body"] ?? [];

        $produtos[] = [
            "ID"        => $i["id"] ?? "",
            "Título"    => $i["title"] ?? "",
            "Vendido"   => $i["sold_quantity"] ?? 0,
            "Preço"     => $i["price"] ?? 0,
            "Estoque"   => $i["available_quantity"] ?? 0,
            "Status"    => $i["status"] ?? "",
        ];
    }
}

// =======================================
// GERA O CSV
// =======================================
$arquivo = "estoque_" . date("Y-m-d_H-i") . ".csv";

header("Content-Type: text/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=\"$arquivo\"");
header("Pragma: no-cache");
header("Expires: 0");

$fp = fopen("php://output", "w");

// BOM (Excel UTF-8)
fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

fputcsv($fp, ["ID", "Título", "Vendido", "Preço", "Estoque", "Status"], ';');

// Preenche linhas
foreach ($produtos as $p) {
    fputcsv($fp, [
        $p["ID"],
        $p["Título"],
        $p["Vendido"],
        number_format($p["Preço"], 2, ',', '.'),
        $p["Estoque"],
        ucfirst($p["Status"]),
    ], ';');
}

fclose($fp);
exit;
