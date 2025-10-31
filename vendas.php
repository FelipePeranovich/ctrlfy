<!DOCTYPE html>
<?php
session_start();
if (empty($_SESSION['nome'])) {
    header("location:index.php");
}

include_once('configapi/meligetdata.php');

// ======= PAGINAÇÃO =======
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$limite = 10; // já definido como 10
$offset = ($pagina - 1) * $limite;

// ======= BUSCA VENDAS ORDENADAS =======
$ordersUrl = "https://api.mercadolibre.com/orders/search?seller=$user_id&sort=date_desc&offset=$offset&limit=$limite";
$ordersResp = meli_get($ordersUrl, $access_token);
?>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vendas - Ctrlfy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/vendas.css" />
    <link rel="stylesheet" href="css/modais.css" />
    <style>
        /* ===== EFEITO HOVER NOS CARDS ===== */
        .venda-card {
            transition: all 0.2s ease-in-out;
        }

        .venda-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            cursor: pointer; /* opcional: deixa parecer clicável */
        }
    </style>
</head>

<body>
    <div class="d-flex flex-column flex-md-row">
        <!-- Sidebar -->
        <div class="sidebar d-none d-md-flex flex-column text-white p-3">
            <h4 class="logo">Ctrlfy</h4>
            <ul class="nav flex-column mt-4">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="produtos.php">Produtos</a></li>
                <li class="nav-item"><a class="nav-link" href="estoque.php">Estoque</a></li>
                <li class="nav-item"><a class="nav-link active" href="vendas.php">Vendas</a></li>
                <li class="nav-item"><a class="nav-link" href="etiquetas.php">Etiquetas</a></li>
                <li class="nav-item"><a class="nav-link" href="marketplace.php">Marketplaces</a></li>
            </ul>
            <div class="mt-auto text-center">
                <a href="funcoes/sair.php" onclick="return confirm('Tem certeza que deseja sair?');">
                    <button class="btn btn-outline-light w-100 mb-4"><i class="bi bi-box-arrow-left"></i> Sair</button>
                </a>
                <div class="user mt-auto pt-3">
                    <?= $_SESSION["nome"] . ' ' . $_SESSION["sobrenome"]; ?>
                </div>
            </div>
        </div>

        <!-- Conteúdo principal -->
        <div class="main-content flex-grow-1 p-4">
            <h3 class="text-orange fw-bold mb-4">Vendas</h3>

            <?php
            if ($ordersResp['http_code'] === 200 && !empty($ordersResp['body']['results'])) {
                $vendas = $ordersResp['body']['results'];

                foreach ($vendas as $order) {
                    $id = $order['id'];
                    $total = number_format($order['total_amount'] ?? 0, 2, ',', '.');
                    
                    // Data da venda
                    $dataVenda = isset($order['date_created']) 
                    ? gmdate('d/m/Y H:i', strtotime($order['date_created']) - 10800) // UTC-3
                    : 'Data não disponível';


                    // Imagem do primeiro produto
                    $firstItem = $order['order_items'][0]['item']['id'] ?? null;
                    $imageUrl = 'img/no-image.png';
                    if ($firstItem) {
                        $itemResp = meli_get("https://api.mercadolibre.com/items/$firstItem?attributes=pictures", $access_token);
                        if ($itemResp['http_code'] === 200 && !empty($itemResp['body']['pictures'][0]['url'])) {
                            $imageUrl = $itemResp['body']['pictures'][0]['url'];
                        }
                    }

                    // Produtos
                    $itemsHtml = [];
                    foreach ($order['order_items'] as $oi) {
                        $itemsHtml[] = ($oi['item']['title'] ?? '—') . ' x' . ($oi['quantity'] ?? 1);
                    }
            ?>

                    <div class="venda-card bg-white rounded shadow-sm p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="<?= $imageUrl ?>" class="rounded me-2 venda-img" />
                                <div>
                                    <p class="mb-0 fw-bold"><?= implode('<br>', $itemsHtml) ?></p>
                                </div>
                            </div>
                            <div class="text-end">
                                <small class="text-muted d-block mb-1"><?= $dataVenda ?></small>
                                <p class="fw-bold text-orange mb-1">R$ <?= $total ?></p>
                                <a target="_blank" href="https://www.mercadolivre.com.br/vendas/<?= $id ?>/detalhe">
                                    <button class="btn btn-warning btn-sm">Ver Venda</button>
                                </a>
                            </div>
                        </div>
                    </div>

            <?php
                }

                // ======= PAGINAÇÃO CONDENSADA =======
                $totalVendas = $ordersResp['body']['paging']['total'] ?? 0;
                $totalPaginas = ceil($totalVendas / $limite);

                if ($totalPaginas > 1) {
                    echo '<nav><ul class="pagination justify-content-center mt-4">';

                    $inicio = max(1, $pagina - 2);
                    $fim = min($totalPaginas, $pagina + 2);

                    // Botão anterior
                    if ($pagina > 1) {
                        echo '<li class="page-item"><a class="page-link" href="?pagina=' . ($pagina - 1) . '">&laquo;</a></li>';
                    }

                    // Primeira página
                    if ($inicio > 1) {
                        echo '<li class="page-item"><a class="page-link" href="?pagina=1">1</a></li>';
                        if ($inicio > 2) echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
                    }

                    // Páginas intermediárias
                    for ($i = $inicio; $i <= $fim; $i++) {
                        $active = ($i == $pagina) ? 'active' : '';
                        echo "<li class='page-item $active'><a class='page-link' href='?pagina=$i'>$i</a></li>";
                    }

                    // Última página
                    if ($fim < $totalPaginas) {
                        if ($fim < $totalPaginas - 1) echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
                        echo '<li class="page-item"><a class="page-link" href="?pagina=' . $totalPaginas . '">' . $totalPaginas . '</a></li>';
                    }

                    // Botão próximo
                    if ($pagina < $totalPaginas) {
                        echo '<li class="page-item"><a class="page-link" href="?pagina=' . ($pagina + 1) . '">&raquo;</a></li>';
                    }

                    echo '</ul></nav>';
                }
            } else {
                echo "<p>Nenhuma venda encontrada.</p>";
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
