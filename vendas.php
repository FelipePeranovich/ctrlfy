<?php
session_start();

if (empty($_SESSION['nome'])) {
    header("location:index.php");
}

include_once('configapi/meligetdata.php');
include_once('configapi/meliCache.php');

// =============================
// PAGINAÇÃO
// =============================
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$limite = 20;
$offset = ($pagina - 1) * $limite;

// =============================
// FILTRO POR MÊS
// =============================
$filtro_mes = isset($_GET['mes']) ? $_GET['mes'] : ''; // formato YYYY-MM

// =============================
// URL DAS VENDAS COM FILTRO DA API
// =============================
$ordersUrl = "https://api.mercadolibre.com/orders/search?seller=$user_id&sort=date_desc&offset=$offset&limit=$limite";

if ($filtro_mes) {
    // Formata datas corretamente
    $primeiroDia = $filtro_mes . "-01T00:00:00.000-03:00";
    $ultimoDiaNum = date("t", strtotime($filtro_mes . "-01"));
    $ultimoDia = $filtro_mes . "-$ultimoDiaNum" . "T23:59:59.999-03:00";

    $ordersUrl .= "&date_created.from=$primeiroDia&date_created.to=$ultimoDia";
}

// =============================
// BUSCA COM CACHE (30 minutos)
// =============================
$ordersResp = meli_cached_get($ordersUrl, $access_token, 30);
?>
<!DOCTYPE html>
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
        .venda-card {
            transition: all 0.2s ease-in-out;
        }

        .venda-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            cursor: pointer;
        }

        .venda-img {
            width: 55px;
            height: 55px;
            object-fit: cover;
        }

        .filter-form input[type="month"] {
            border-radius: 6px;
            border: 1px solid #ddd;
            padding: 6px 10px;
        }

        .filter-form button {
            border-radius: 6px;
        }

        .table .btn {
            padding: 4px 10px;
            font-size: 0.85rem;
        }

        .table-hover tbody tr:hover {
            background-color: #fff3e0;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .pagination .page-item .page-link {
            color: #ff6600;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .pagination .page-item.active .page-link {
            background-color: #ff6600;
            color: #fff;
            border-color: #ff6600;
        }

        .pagination .page-item .page-link:hover {
            background-color: #ffc07a;
            color: #fff;
        }

        @media (max-width: 767px) {
            .table-responsive {
                overflow-x: auto;
            }

            .sidebar {
                display: none !important;
            }

            .main-content {
                padding: 20px 10px;
            }
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
                <li class="nav-item"><a class="nav-link" href="estoque.php">Estoque</a></li>
                <li class="nav-item"><a class="nav-link active" href="vendas.php">Vendas</a></li>
                <li class="nav-item"><a class="nav-link" href="etiquetas.php">Etiquetas</a></li>
                <li class="nav-item"><a class="nav-link" href="marketplace.php">Marketplaces</a></li>
            </ul>
            <div class="mt-auto text-center">
                <a href="funcoes/sair.php" onclick="return confirm('Tem certeza que deseja sair?');">
                    <button class="btn btn-outline-light w-100 mb-4"><i class="bi bi-box-arrow-left"></i> Sair</button>
                </a>
                <div class="user mt-auto pt-3"><?= $_SESSION["nome"] . ' ' . $_SESSION["sobrenome"]; ?></div>
            </div>
        </div>

        <!-- Sidebar mobile colapsável -->
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
                        <li class="nav-item"><a class="nav-link" href="estoque.php">Estoque</a></li>
                        <li class="nav-item"><a class="nav-link active" href="vendas.php">Vendas</a></li>
                        <li class="nav-item"><a class="nav-link" href="etiquetas.php">Etiquetas</a></li>
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

        <!-- Conteúdo -->
        <div class="main-content flex-grow-1 p-4">
            <h3 class="text-orange fw-bold mb-4">Vendas</h3>

            <!-- FILTRO POR MÊS -->
            <!-- <form id="filtroMesForm" class="mb-4 d-flex gap-2 filter-form">
            <input type="month" id="mesFiltro" class="form-control w-auto" value="<?= htmlspecialchars($filtro_mes) ?>">
            <button type="button" id="btnFiltrar" class="btn btn-warning">Filtrar</button>
            <a href="vendas.php" class="btn btn-secondary">Limpar</a>
        </form> -->
            <a href="funcoes/exportar_vendas.php" class="btn btn-success mb-3">
                <i class="bi bi-file-earmark-excel"></i> Exportar vendas para Excel
            </a>

            <?php
            if ($ordersResp && isset($ordersResp["http_code"]) && $ordersResp["http_code"] === 200 && !empty($ordersResp["body"]["results"])) {
                $vendas = $ordersResp["body"]["results"];
            ?>
            <div class="bg-white p-3 rounded shadow-sm">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Imagem</th>
                                <th>Produtos</th>
                                <th>Data</th>
                                <th>Total (R$)</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($vendas as $order):
                                $id = $order["id"];
                                $total = number_format($order["total_amount"] ?? 0, 2, ',', '.');
                                $dataVenda = isset($order['date_created']) ? gmdate('d/m/Y H:i', strtotime($order['date_created']) - 10800) : "Data indisponível";

                                // IMAGEM VIA CACHE
                                // --- PEGA IMAGEM DO PRIMEIRO PRODUTO DO PEDIDO ---
                                $firstItem = $order['order_items'][0]['item']['id'] ?? null;
                                $imageUrl = null;

                                if ($firstItem) {

                                    // Requisição correta (SEM attributes)
                                    $itemResp = meli_get("https://api.mercadolibre.com/items/$firstItem", $access_token);

                                    if (
                                        $itemResp['http_code'] === 200
                                        && !empty($itemResp['body']['pictures'][0]['secure_url'])
                                    ) {

                                        // use secure_url sempre que existir
                                        $imageUrl = $itemResp['body']['pictures'][0]['secure_url'];
                                    } elseif (!empty($itemResp['body']['pictures'][0]['url'])) {

                                        $imageUrl = $itemResp['body']['pictures'][0]['url'];
                                    }
                                }


                                $itemsHtml = [];
                                foreach ($order["order_items"] as $oi) {
                                    $itemsHtml[] = ($oi["item"]["title"] ?? "—") . " x" . ($oi["quantity"] ?? 1);
                                }
                            ?>
                                <tr>
                                    <td><img src="<?= $imageUrl ?>" class="venda-img rounded"></td>
                                    <td><?= implode("<br>", $itemsHtml) ?></td>
                                    <td><?= $dataVenda ?></td>
                                    <td class="fw-bold text-orange">R$ <?= $total ?></td>
                                    <td>
                                        <a target="_blank" href="https://www.mercadolivre.com.br/vendas/<?= $id ?>/detalhe" class="btn btn-warning btn-sm">Ver</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

                <!-- PAGINAÇÃO -->
            <?php
                $totalVendas = $ordersResp["body"]["paging"]["total"] ?? 0;
                $totalPaginas = ceil($totalVendas / $limite);

                if ($totalPaginas > 1) {
                    echo '<nav><ul class="pagination justify-content-center mt-4">';
                    $inicio = max(1, $pagina - 2);
                    $fim = min($totalPaginas, $pagina + 2);

                    if ($pagina > 1) echo '<li class="page-item p-1"><a class="page-link" href="?pagina=' . ($pagina - 1) . '&mes=' . $filtro_mes . '">&laquo;</a></li>';
                    if ($inicio > 1) {
                        echo '<li class="page-item p-1"><a class="page-link" href="?pagina=1&mes=' . $filtro_mes . '">1</a></li>';
                        if ($inicio > 2) echo '<li class="page-item p-1 disabled"><span class="page-link">...</span></li>';
                    }
                    for ($i = $inicio; $i <= $fim; $i++) {
                        $active = ($i == $pagina) ? "active" : "";
                        echo "<li class='page-item p-1 $active'><a class='page-link' href='?pagina=$i&mes=$filtro_mes'>$i</a></li>";
                    }
                    if ($fim < $totalPaginas) {
                        if ($fim < $totalPaginas - 1) echo '<li class="page-item p-1 disabled"><span class="page-link">...</span></li>';
                        echo '<li class="page-item p-1"><a class="page-link" href="?pagina=' . $totalPaginas . '&mes=' . $filtro_mes . '">' . $totalPaginas . '</a></li>';
                    }
                    if ($pagina < $totalPaginas) echo '<li class="page-item p-1"><a class="page-link" href="?pagina=' . ($pagina + 1) . '&mes=' . $filtro_mes . '">&raquo;</a></li>';
                    echo '</ul></nav>';
                }
            } else {
                echo "<p>Nenhuma venda encontrada para este mês.</p>";
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JS para filtro funcional usando a própria API
        document.getElementById("btnFiltrar").addEventListener("click", function() {
            const mes = document.getElementById("mesFiltro").value;
            let url = "vendas.php";
            if (mes) {
                url += "?mes=" + mes + "&pagina=1"; // força página 1
            }
            window.location.href = url;
        });
    </script>

</body>

</html>