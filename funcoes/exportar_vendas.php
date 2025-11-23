<?php
session_start();

if (empty($_SESSION['nome'])) {
    header("location:index.php");
    exit;
}

include_once('../configapi/meligetdata.php');
include_once('../configapi/meliCache.php');

// ============================
// BUSCA TODAS AS VENDAS (SEM PAGINAÇÃO DA TELA)
// ============================
$limite = 50;
$offset = 0;

$todas = [];

do {
    $url = "https://api.mercadolibre.com/orders/search?seller=$user_id&sort=date_desc&limit=$limite&offset=$offset";

    $resp = meli_cached_get($url, $access_token, 3);

    if (!$resp || $resp["http_code"] !== 200) break;

    $lista = $resp["body"]["results"] ?? [];
    $todas = array_merge($todas, $lista);

    $offset += $limite;

    $total = $resp["body"]["paging"]["total"] ?? 0;

} while ($offset < $total);


// ============================
// GERAR CSV PURO
// ============================

// Nome do arquivo
$arquivo = "vendas_" . date("Y-m-d_H-i") . ".csv";

// Cabeçalhos para baixar
header("Content-Type: text/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=\"$arquivo\"");
header("Pragma: no-cache");
header("Expires: 0");

// Abre saída do PHP como arquivo
$fp = fopen("php://output", "w");

// Força Excel a abrir com UTF-8 corretamente
fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

// Cabeçalho do CSV
fputcsv($fp, ["ID Venda", "Data", "Produto", "Quantidade", "Total (R$)"], ';');

// Preenche linhas
foreach ($todas as $venda) {

    $id = $venda["id"];
    $data = date("d/m/Y H:i", strtotime($venda["date_created"]) - 10800);
    $total = number_format($venda["total_amount"], 2, ',', '.');

    foreach ($venda["order_items"] as $item) {

        $titulo = $item["item"]["title"] ?? "—";
        $qtd = $item["quantity"] ?? 1;

        fputcsv($fp, [
            $id,
            $data,
            $titulo,
            $qtd,
            $total
        ], ';');
    }
}

fclose($fp);
exit;
?>
