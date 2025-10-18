<?php
require __DIR__ . '/meliHelper.php';

$access_token = meli_get_valid_token();
if (!$access_token) {
    echo "Token inválido ou ausente. <a href='meliAuth.php'>Conectar Mercado Livre</a>";
    exit;
}

$tokens = meli_load_tokens();
$user_id = $tokens['user_id'] ?? null;

if (!$user_id) {
    echo "Não foi possível determinar o user_id. Faça o login novamente.";
    exit;
}

// === PRODUTOS ===
$itemsResp = meli_get("https://api.mercadolibre.com/users/{$user_id}/items/search", $access_token);

echo '<h2>Produtos vinculados</h2>';
if ($itemsResp['http_code'] === 200 && !empty($itemsResp['body']['results'])) {
    echo '<ul>';
    foreach ($itemsResp['body']['results'] as $item_id) {
        $det = meli_get("https://api.mercadolibre.com/items/{$item_id}", $access_token);
        if ($det['http_code'] === 200) {
            $title = htmlspecialchars($det['body']['title'] ?? '—');
            $avail = intval($det['body']['available_quantity'] ?? 0);
            $sold = intval($det['body']['sold_quantity'] ?? 0);
            echo "<li><b>{$title}</b> — Estoque: {$avail} — Vendidos: {$sold}</li>";
        }
    }
    echo '</ul>';
} else {
    echo 'Nenhum item encontrado.';
}

// === VENDAS ===
$ordersResp = meli_get("https://api.mercadolibre.com/orders/search?seller={$user_id}&sort=date_desc", $access_token);

echo '<h2>Vendas / Pedidos</h2>';
if ($ordersResp['http_code'] === 200 && !empty($ordersResp['body']['results'])) {
    echo '<table border="1" cellpadding="6" cellspacing="0">';
    echo '<tr><th>Pedido</th><th>Data</th><th>Status</th><th>Itens</th><th>Total</th></tr>';

    foreach ($ordersResp['body']['results'] as $order) {
        $id = $order['id'];
        $date = date('d/m/Y H:i', strtotime($order['date_created'] ?? ''));

        // Busca detalhes do pedido
        $orderDetail = meli_get("https://api.mercadolibre.com/orders/{$id}", $access_token);
        $body = $orderDetail['body'] ?? [];

        $statusOriginal = $body['status'] ?? '';
        $trackingNumber = $body['shipping']['tracking_number'] ?? '';

        // Traduz status para amigável
        if (!empty($trackingNumber)) {
            $statusAmigavel = 'Enviado';
        } elseif (in_array($statusOriginal, ['paid', 'payment_in_process'])) {
            $statusAmigavel = 'Pago';
        } elseif (in_array($statusOriginal, ['cancelled', 'cancelled_by_seller', 'cancelled_by_buyer', 'in_process'])) {
            $statusAmigavel = 'Cancelado';
        } else {
            $statusAmigavel = ucfirst($statusOriginal);
        }

        $total = number_format($order['total_amount'] ?? 0, 2, ',', '.');
        $itemsHtml = [];
        foreach ($order['order_items'] as $oi) {
            $itemsHtml[] = ($oi['item']['title'] ?? '') . ' x' . ($oi['quantity'] ?? 1);
        }

        echo "<tr>
                <td>#{$id}</td>
                <td>{$date}</td>
                <td>{$statusAmigavel}</td>
                <td>" . implode('<br>', $itemsHtml) . "</td>
                <td>R$ {$total}</td>
              </tr>";
    }

    echo '</table>';
} else {
    echo 'Nenhuma venda encontrada.';
}
?>
