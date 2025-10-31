<!DOCTYPE html>
<?php
session_start();
if(empty($_SESSION['nome'])){
        header("location:index.php");
    }

include_once ('configapi/meligetdata.php');


?>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Etiquetas - Ctrlfy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/vendas.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        /* ===== EFEITO HOVER NOS CARDS ===== */
        .etiqueta-card {
            transition: all 0.2s ease-in-out;
        }

        .etiqueta-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            cursor: pointer; /* opcional: deixa parecer clicável */
        }
    </style>
</head>

<body class="bg-light">

    <div class="d-flex flex-column flex-md-row">
        <!-- Sidebar desktop -->
        <div class="sidebar d-none d-md-flex flex-column text-white p-3">
            <h4 class="logo">Ctrlfy</h4>
            <ul class="nav flex-column mt-4">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="produtos.php">Produtos</a></li>
                <li class="nav-item"><a class="nav-link" href="estoque.php">Estoque</a></li>
                <li class="nav-item"><a class="nav-link" href="vendas.php">Vendas</a></li>
                <li class="nav-item"><a class="nav-link active" href="etiquetas.php">Etiquetas</a></li>
                <li class="nav-item"><a class="nav-link" href="marketplace.php">Marketplaces</a></li>
            </ul>
            <div class="mt-auto text-center">
                <a href="funcoes/sair.php" onclick= "return confirm('Tem certeza que deseja sair?');"><button class="btn btn-outline-light w-100 mb-4 "><i class="bi bi-box-arrow-left"></i> Sair</button></a>
                <?php
                echo '<div class="user mt-auto pt-3">' . $_SESSION["nome"] . ' ' . $_SESSION["sobrenome"] . '</div>';
                ?>
            </div>
        </div>

        <!-- Sidebar mobile -->
        <nav class="navbar navbar-dark d-md-none" style="background-color: #1f252f;">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h4 text-orange">Ctrlfy</span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mobileSidebar">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div class="collapse" id="mobileSidebar">
                <div class="sidebar-mobile p-5 align-items-center justify-content-center">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="produtos.php">Produtos</a></li>
                        <li class="nav-item"><a class="nav-link" href="estoque.php">Estoque</a></li>
                        <li class="nav-item"><a class="nav-link" href="vendas.php">Vendas</a></li>
                        <li class="nav-item"><a class="nav-link active" href="etiquetas.php">Etiquetas</a></li>
                        <li class="nav-item"><a class="nav-link" href="marketplace.php">Marketplaces</a></li>
                    </ul>
                    <div class="mt-auto text-center">
                        <button class="btn btn-outline-light w-100 mt-5 "><i class="bi bi-box-arrow-left"></i> Sair</button>

                        <?php
                        session_start();
                        echo '<div class="user mt-auto pt-3">' . $_SESSION["nome"] . ' ' . $_SESSION["sobrenome"] . '</div>';
                        ?>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Conteúdo principal -->
        <div class="main-content flex-grow-1 p-4">
            <h3 class="text-orange fw-bold mb-4">Etiquetas</h3>
       
            <!-- Barra de ações -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                <div class="input-group w-auto vendas-search">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" placeholder="Buscar etiquetas..." />
                </div>
                <div class="d-flex gap-2 mt-2 mt-md-0">
                    <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-funnel"></i> Filtrar</button>
                    <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-file-earmark-excel"></i> Baixar Excel</button>
                </div>
            </div>

            <?php if ($erroToken): ?>
                <div >
                    <?= $erroToken ?>
                </div>
            <?php else: ?>

            <!-- Lista de vendas -->
             <?php
             if ($ordersResp['http_code'] === 200 && !empty($ordersResp['body']['results'])) {

            foreach ($ordersResp['body']['results'] as $order) {
                $id = $order['id'];
                $date = date('d/m/Y H:i', strtotime($order['date_created'] ?? ''));
                $total = number_format($order['total_amount'] ?? 0, 2, ',', '.');

                // --- CAPTURA TIPO DE ENVIO ---
                $shipping_id = $order['shipping']['id'] ?? null;
                $shippingType = 'não informado';
                $shippingStatus = 'sem status';

                if ($shipping_id) {
                $shipDetail = meli_get("https://api.mercadolibre.com/shipments/$shipping_id", $access_token);
                if ($shipDetail['http_code'] === 200) {
                    $shippingType = $shipDetail['body']['logistic_type'] ?? 'não informado';
                    $shippingStatus = $shipDetail['body']['status'] ?? 'sem status';

                    // --- Traduções ---
                    if ($shippingType === 'xp_drop_off' || $shippingType === 'xd_drop_off') {
                        $shippingType = 'Agência';
                    } if ($shippingStatus === 'ready_to_ship') {
                        $shippingStatus = 'Pronto pra enviar';
                    }
                }
            }

                // --- PEGA IMAGEM DO PRIMEIRO PRODUTO DO PEDIDO ---
                $firstItem = $order['order_items'][0]['item']['id'] ?? null;
                $imageUrl = null;

                if ($firstItem) {
                    $itemResp = meli_get("https://api.mercadolibre.com/items/$firstItem?attributes=pictures", $access_token);
                    if ($itemResp['http_code'] === 200 && !empty($itemResp['body']['pictures'][0]['url'])) {
                        $imageUrl = $itemResp['body']['pictures'][0]['url'];
                    }
                }

                // Lista dos produtos do pedido
                $itemsHtml = [];
                foreach ($order['order_items'] as $oi) {
                    $itemsHtml[] = ($oi['item']['title'] ?? '—') . ' x' . ($oi['quantity'] ?? 1);
            }
        ?>

                    <!-- Lista de Vendas -->
                    <div class="etiqueta-card bg-white rounded shadow-sm p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="badge bg-warning text-dark">#<?=$id?></span>
                        <p class="mb-1 small">Você deve despachar o pacote hoje em Correios.</p>
                        <div class="d-flex align-items-center">
                            <img src=<?=$imageUrl?> class="rounded me-2 venda-img" />
                            <div>
                                <p class="mb-0 fw-bold"><?= implode('. <br> .', $itemsHtml) ?></p>
                                <small class="text-muted"><?= $shippingType?> | <?= $shippingStatus?></td></small>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <p class="fw-bold text-orange mb-1">R$ <?=$total?></p>
                        <a target='_blank' href='https://www.mercadolivre.com.br/vendas/<?=$id?>/detalhe'><button class="btn-warning btn">Ver Venda</button></a>
                    </div>
                    </div>
                    </div>


                    <?php
                    
                }
            } else {
                echo 'Nenhuma venda encontrada.';
            }
             ?>
            

        </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>