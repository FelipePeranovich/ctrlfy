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

// Busca pedidos pagos e prontos para envio
$ordersResp = meli_get("https://api.mercadolibre.com/orders/search?seller=$user_id&order.status=paid&shipping.status=ready_to_ship&sort=date_desc", $access_token);

// echo '<h2>📦 Vendas pendentes de envio</h2>';

// if ($ordersResp['http_code'] === 200 && !empty($ordersResp['body']['results'])) {
//     echo '<table border="1" cellpadding="6" cellspacing="0">';
//     echo '<tr>
//             <th>Imagem</th>
//             <th>Pedido</th>
//             <th>Data</th>
//             <th>Tipo de Envio</th>
//             <th>Status</th>
//             <th>Itens</th>
//             <th>Total</th>
//             <th>Link</th>
//           </tr>';

//     foreach ($ordersResp['body']['results'] as $order) {
//         $id = $order['id'];
//         $date = date('d/m/Y H:i', strtotime($order['date_created'] ?? ''));
//         $total = number_format($order['total_amount'] ?? 0, 2, ',', '.');

//         // --- CAPTURA TIPO DE ENVIO ---
//         $shipping_id = $order['shipping']['id'] ?? null;
//         $shippingType = 'não informado';
//         $shippingStatus = 'sem status';

//         if ($shipping_id) {
//             $shipDetail = meli_get("https://api.mercadolibre.com/shipments/$shipping_id", $access_token);
//             if ($shipDetail['http_code'] === 200) {
//                 $shippingType = $shipDetail['body']['logistic_type'] ?? 'não informado';
//                 $shippingStatus = $shipDetail['body']['status'] ?? 'sem status';
//             }
//         }

//         // --- PEGA IMAGEM DO PRIMEIRO PRODUTO DO PEDIDO ---
//         $firstItem = $order['order_items'][0]['item']['id'] ?? null;
//         $imageUrl = null;

//         if ($firstItem) {
//             $itemResp = meli_get("https://api.mercadolibre.com/items/$firstItem?attributes=pictures", $access_token);
//             if ($itemResp['http_code'] === 200 && !empty($itemResp['body']['pictures'][0]['url'])) {
//                 $imageUrl = $itemResp['body']['pictures'][0]['url'];
//             }
//         }

//         // Lista dos produtos do pedido
//         $itemsHtml = [];
//         foreach ($order['order_items'] as $oi) {
//             $itemsHtml[] = ($oi['item']['title'] ?? '—') . ' x' . ($oi['quantity'] ?? 1);
//         }

//         echo "<tr>
//                 <td align='center'>" . ($imageUrl ? "<img src='$imageUrl' width='70'>" : '—') . "</td>
//                 <td>#{$id}</td>
//                 <td>{$date}</td>
//                 <td>{$shippingType}</td>
//                 <td>{$shippingStatus}</td>
//                 <td>" . implode('<br>', $itemsHtml) . "</td>
//                 <td>R$ {$total}</td>
//                 <td><a target='_blank' href='https://www.mercadolivre.com.br/vendas/{$id}/detalhe'>ver venda</a></td>
//               </tr>";
//     }

//     echo '</table>';
// } else {
//     echo 'Nenhuma venda encontrada.';
// }
?>