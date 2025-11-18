<?php
session_start();
if (empty($_SESSION['nome'])) {
    header("location:index.php");
    exit;
}

include_once('configapi/meligetdata.php'); // JÁ inclui helper e tokens

if (empty($_SESSION['meli_user_id'])) {
    // Usuário não conectado
    $totalVendasAmount = 0;
    $totalPedidos = 0;
    $ticketMedio = 0;
    $totalProdutos = 0;
    $produtosEstoque = 0;
    $produtosFaltando = 0;
    $labelsChart = [];
    $dataChart = [];
    $labels30Dias = [];
    $data30Dias = [];
    $produtosCriticosMedios = [];
} else {

    // Dados essenciais vindos do meligetdata.php
    $user_id = $tokens["user_id"];
    $access_token = $access_token;

    // ------------------------------
    //          VENDAS
    // ------------------------------

    $totalVendasAmount = 0;
    $totalPedidos = 0;

    $ordersLimit = 50;
    $ordersOffset = 0;

    $vendasPorMes = [];
    $vendas30Dias = [];

    $hoje = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
    $inicio30Dias = (clone $hoje)->modify('-29 days');

    do {
        $ordersResp = meli_get(
            "https://api.mercadolibre.com/orders/search?seller=$user_id&sort=date_desc&limit=$ordersLimit&offset=$ordersOffset",
            $access_token
        );

        if ($ordersResp['http_code'] !== 200 || empty($ordersResp['body']['results'])) {
            break;
        }

        foreach ($ordersResp['body']['results'] as $order) {

            $totalVendasAmount += $order['total_amount'] ?? 0;
            $totalPedidos++;

            $date = new DateTime($order['date_created']);
            $date->setTimezone(new DateTimeZone('America/Sao_Paulo'));

            $mes = $date->format('Y-m');

            if (!isset($vendasPorMes[$mes])) {
                $vendasPorMes[$mes] = ['qtd' => 0, 'total' => 0];
            }

            $vendasPorMes[$mes]['qtd']++;
            $vendasPorMes[$mes]['total'] += $order['total_amount'] ?? 0;

            if ($date >= $inicio30Dias) {
                $dia = $date->format('Y-m-d');
                if (!isset($vendas30Dias[$dia])) {
                    $vendas30Dias[$dia] = 0;
                }
                $vendas30Dias[$dia] += $order['total_amount'] ?? 0;
            }
        }

        $ordersOffset += $ordersLimit;
        $totalApi = $ordersResp['body']['paging']['total'] ?? 0;

    } while ($ordersOffset < $totalApi);

    $ticketMedio = $totalPedidos > 0 ? ($totalVendasAmount / $totalPedidos) : 0;

    // Últimos 6 meses
    krsort($vendasPorMes);
    $ultimos6Meses = array_slice($vendasPorMes, 0, 6, true);

    $labelsChart = [];
    $dataChart = [];

    foreach (array_reverse($ultimos6Meses) as $mes => $info) {
        $labelsChart[] = (new DateTime($mes . '-01'))->format('M/Y');
        $dataChart[] = round($info['total'], 2);
    }

    // Últimos 30 dias
    $labels30Dias = [];
    $data30Dias = [];

    $periodo30 = new DatePeriod($inicio30Dias, new DateInterval('P1D'), (clone $hoje)->modify('+1 day'));

    foreach ($periodo30 as $dia) {
        $labels30Dias[] = $dia->format('d/m');
        $data30Dias[] = $vendas30Dias[$dia->format('Y-m-d')] ?? 0;
    }

    // ------------------------------
    //          PRODUTOS
    // ------------------------------

    $itemsResp = meli_get(
        "https://api.mercadolibre.com/users/$user_id/items/search?limit=200",
        $access_token
    );

    $itemsList = $itemsResp['body']['results'] ?? [];

    $totalProdutos = count($itemsList);

    $produtosEstoque = 0;
    $produtosFaltando = 0;

    $produtosDetalhes = [];

    foreach ($itemsList as $itemId) {

        $itemDetail = meli_get("https://api.mercadolibre.com/items/$itemId", $access_token);

        $availableQty = $itemDetail['body']['available_quantity'] ?? 0;

        $produtosEstoque += $availableQty;

        if ($availableQty == 0) $produtosFaltando++;

        $produtosDetalhes[] = [
            'title' => $itemDetail['body']['title'] ?? 'Produto',
            'id' => $itemId,
            'qty' => $availableQty,
            'limit' => 5,
        ];
    }

    $produtosCriticosMedios = array_filter($produtosDetalhes, fn($p) => $p['qty'] <= $p['limit']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - Ctrlfy</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link rel="stylesheet" href="css/dashboard.css" />
<link rel="stylesheet" href="css/modais.css" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-light">

<!-- SIDEBAR + TOPO IGUAL AO SEU — NÃO ALTEREI NADA -->

<div class="d-flex flex-column flex-md-row">

<div class="sidebar d-none d-md-flex flex-column text-white p-3" style="width:220px;height:100vh;">
<h4 class="logo">Ctrlfy</h4>
<ul class="nav flex-column mt-4">
<li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
<li class="nav-item"><a class="nav-link" href="estoque.php">Estoque</a></li>
<li class="nav-item"><a class="nav-link" href="vendas.php">Vendas</a></li>
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

<!-- CONTEÚDO PRINCIPAL -->
<div class="main-content flex-grow-1 p-4">

<h3 class="text-orange fw-bold">Dashboard</h3>

<!-- Cards de KPIs (não mexi no seu HTML) -->
<div class="row text-center mt-4 mb-4 g-3">
    <div class="col-6 col-md bg-white py-3 rounded shadow-sm">
        <h5 class="text-orange"><?= $totalProdutos ?></h5>
        <p class="mb-0">Total de produtos</p>
    </div>

    <div class="col-6 col-md bg-white py-3 rounded shadow-sm">
        <h5 class="text-success"><?= $produtosEstoque ?></h5>
        <p class="mb-0">Produtos em estoque</p>
    </div>

    <div class="col-6 col-md bg-white py-3 rounded shadow-sm">
        <h5 class="text-primary">R$
        <?= number_format($totalVendasAmount, 2, ',', '.') ?></h5>
        <p class="mb-0">Total de vendas</p>
    </div>

    <div class="col-6 col-md bg-white py-3 rounded shadow-sm">
        <h5 class="text-danger"><?= $produtosFaltando ?></h5>
        <p class="mb-0">Produtos faltando</p>
    </div>

    <div class="col-6 col-md bg-white py-3 rounded shadow-sm">
        <h5 class="text-info"><?= $totalPedidos ?></h5>
        <p class="mb-0">Pedidos realizados</p>
    </div>

    <div class="col-6 col-md bg-white py-3 rounded shadow-sm">
        <h5 class="text-warning">R$
        <?= number_format($ticketMedio, 2, ',', '.') ?></h5>
        <p class="mb-0">Ticket médio</p>
    </div>
</div>

<!-- GRÁFICOS -->
<div class="row mb-4 g-3">
    <div class="col-md-6 bg-white p-3 rounded shadow-sm">
        <h6 class="fw-bold mb-3">Desempenho de Vendas (últimos 6 meses)</h6>
        <canvas id="lineChart" height="140"></canvas>
    </div>

    <div class="col-md-6 bg-white p-3 rounded shadow-sm">
        <h6 class="fw-bold mb-3">Vendas últimos 30 dias</h6>
        <canvas id="lineChart30" height="140"></canvas>
    </div>
</div>

<!-- TABELA DE PRODUTOS CRÍTICOS -->
<div class="bg-white p-3 rounded shadow-sm mb-4">
<div class="d-flex justify-content-between align-items-center mb-2">
<h6 class="fw-bold">Produtos críticos e médios no estoque</h6>
<button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalVejaTudo">Veja tudo</button>
</div>

<div class="table-responsive">

<table class="table align-middle mb-0" id="produtosTable">
<thead>
<tr>
<th>Produto</th>
<th>ID</th>
<th>Estoque</th>
<th>Limite</th>
<th>Status</th>
</tr>
</thead>
<tbody></tbody>
</table>

<br>
<nav>
<ul class="pagination justify-content-center" id="pagination"></ul>
</nav>

</div>
</div>

<script>
// Dados PHP -> JS
const produtos = <?= json_encode(array_values($produtosCriticosMedios)) ?>;

let currentPage = 1;
const perPage = 4;
const totalPages = Math.ceil(produtos.length / perPage);

// Renderizar tabela
function renderTable() {
    const tbody = document.querySelector('#produtosTable tbody');
    tbody.innerHTML = '';

    const start = (currentPage - 1) * perPage;
    const end = start + perPage;

    produtos.slice(start, end).forEach(p => {
        const badge = p.qty == 0 ? 'bg-danger' : 'bg-warning text-dark';
        const status = p.qty == 0 ? 'Crítico' : 'Médio';

        tbody.innerHTML += `
            <tr>
                <td>${p.title}</td>
                <td>${p.id}</td>
                <td>${p.qty}</td>
                <td>${p.limit}</td>
                <td><span class="badge ${badge}">${status}</span></td>
            </tr>
        `;
    });

    // Paginação
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = '';

    for (let i = 1; i <= totalPages; i++) {
        const active = i === currentPage ? 'active' : '';
        pagination.innerHTML += `
            <li class="page-item ${active}">
                <a class="page-link" href="#">${i}</a>
            </li>
        `;
    }

    document.querySelectorAll('#pagination .page-link').forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            currentPage = parseInt(link.textContent);
            renderTable();
        });
    });
}

renderTable();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- GRÁFICOS -->
<script>
new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: <?= json_encode($labelsChart) ?>,
        datasets: [{
            label: 'Vendas (R$)',
            data: <?= json_encode($dataChart) ?>,
            borderColor: '#00b894',
            backgroundColor: 'rgba(0,184,148,0.2)',
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } }
    }
});

new Chart(document.getElementById('lineChart30'), {
    type: 'line',
    data: {
        labels: <?= json_encode($labels30Dias) ?>,
        datasets: [{
            label: 'Vendas (R$)',
            data: <?= json_encode($data30Dias) ?>,
            borderColor: '#ff7675',
            backgroundColor: 'rgba(255,118,117,0.2)',
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } }
    }
});
</script>

</body>
</html>
