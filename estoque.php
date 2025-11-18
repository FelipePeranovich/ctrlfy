<!DOCTYPE html>
<?php
session_start();
if (empty($_SESSION['nome'])) {
    header("location:index.php");
    exit;
}

include_once ('configapi/meligetdata.php');

//require_once('configapi/meliHelper.php');


// === TOKEN ===
// $access_token = meli_get_valid_token();
// if (!$access_token) {
//     die("Token do Mercado Livre inválido. <a href='configapi/meliAuth.php'>Conectar Mercado Livre</a>");
// }

// // === USER ID ===
// $tokens = meli_load_tokens();
// $user_id = $tokens['user_id'] ?? null;
// if (!$user_id) die("Usuário do Mercado Livre não identificado.");

// === PAGINAÇÃO ===
$limit = 15;
$page = intval($_GET['page'] ?? 1);

// === BUSCAR TODOS OS PRODUTOS DO USUÁRIO ===
$all_ids = [];
$offset = 0;
$batch_limit = 50; // buscar em lotes para otimizar
do {
    $resp = meli_get("https://api.mercadolibre.com/users/$user_id/items/search?offset=$offset&limit=$batch_limit", $access_token);
    if ($resp['http_code'] !== 200) break;

    $ids = $resp['body']['results'] ?? [];
    $all_ids = array_merge($all_ids, $ids);

    $offset += $batch_limit;
    $total_items = $resp['body']['paging']['total'] ?? 0;
} while ($offset < $total_items);

// === PEGAR DETALHES EM LOTES ===
$produtos = [];
foreach (array_chunk($all_ids, 20) as $chunk) {
    $ids_query = implode(',', $chunk);
    $detailsResp = meli_get("https://api.mercadolibre.com/items?ids=$ids_query", $access_token);

    foreach ($detailsResp['body'] as $item) {
        $item = $item['body'] ?? [];
        $produtos[] = [
            'titulo' => $item['title'] ?? '',
            'vendido' => $item['sold_quantity'] ?? 0,
            'preco' => $item['price'] ?? 0,
            'status' => $item['status'] ?? 'inactive',
            'estoque' => $item['available_quantity'] ?? 0,
            'ml_id' => $item['id'] ?? '',
            'thumb' => $item['thumbnail'] ?? ''
        ];
    }
}

// === ORDENAR GLOBALMENTE PELA QUANTIDADE VENDIDA ===
usort($produtos, fn($a, $b) => $b['vendido'] <=> $a['vendido']);

// === PAGINAÇÃO LOCAL ===
$total = count($produtos);
$total_pages = ceil($total / $limit);
$produtos = array_slice($produtos, ($page - 1) * $limit, $limit);
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Estoque - Ctrlfy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/estoque.css" />
</head>

<body class="bg-light">

<div class="d-flex flex-column flex-md-row">
    <!-- Sidebar -->
    <div class="sidebar d-none d-md-flex flex-column text-white p-3" style="width: 220px; height: 100vh;">
        <h4 class="logo">Ctrlfy</h4>
        <ul class="nav flex-column mt-4">
            <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link active" href="estoque.php">Estoque</a></li>
                        <li class="nav-item"><a class="nav-link" href="vendas.php">Vendas</a></li>
                        <li class="nav-item"><a class="nav-link" href="etiquetas.php">Etiquetas</a></li>
                        <li class="nav-item"><a class="nav-link" href="marketplace.php">Marketplaces</a></li>
        </ul>
        <div class="mt-auto text-center">
            <a href="funcoes/sair.php" onclick="return confirm('Tem certeza que deseja sair?');">
                <button class="btn btn-outline-light w-100 mb-4">
                    <i class="bi bi-box-arrow-left"></i> Sair
                </button>
            </a>
            <div class="user mt-auto pt-3">
                <?= $_SESSION["nome"] . ' ' . $_SESSION["sobrenome"]; ?>
            </div>
        </div>
    </div>

    <!-- Conteúdo principal -->
    <div class="main-content flex-grow-1 ps-md-2 pt-4">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                <h3 class="text-orange fw-bold">Estoque</h3>
                <div class="mt-2 mt-md-0">
                    <button class="btn btn-secondary me-2">Exportar</button>
                    <button class="btn btn-warning text-white">+ Inserir novo produto</button>
                </div>
            </div>

            <div class="bg-white p-3 rounded shadow-sm">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Vendido</th>
                                <th>Marketplace</th>
                                <th>Preço</th>
                                <th>Estoque</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($produtos)): ?>
                                <?php foreach ($produtos as $p): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if ($p['thumb']): ?>
                                                    <img src="<?= htmlspecialchars($p['thumb']) ?>" width="50" class="me-2 rounded">
                                                <?php endif; ?>
                                                <div>
                                                    <?= htmlspecialchars($p['titulo']) ?><br>
                                                    <small>ID: <?= $p['ml_id'] ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= $p['vendido'] ?></td>
                                        <td><span class="badge bg-info text-dark">Mercado Livre</span></td>
                                        <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                                        <td><?= $p['estoque'] ?></td>
                                        <td>
                                            <?php
                                            $badge = match ($p['status']) {
                                                'active' => 'success',
                                                'paused' => 'warning',
                                                'closed' => 'secondary',
                                                default => 'dark'
                                            };
                                            ?>
                                            <span class="badge bg-<?= $badge ?>">
                                                <?= ucfirst($p['status']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center">Nenhum produto encontrado.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- PAGINAÇÃO -->
                <?php if ($total_pages > 1): ?>
                <nav class="mt-3">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
