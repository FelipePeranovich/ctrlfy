<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Marketplaces - Ctrlfy</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="css/marketplace.css" />
</head>
<body>
<div class="d-flex"> 
<div class="sidebar p-3 text-white">
<h4 class="logo">Ctrlfy</h4>
<ul class="nav flex-column mt-4">
<li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
<li class="nav-item"><a class="nav-link" href="#">Produtos</a></li>
<li class="nav-item"><a class="nav-link" href="estoque.php">Estoque</a></li>
<li class="nav-item"><a class="nav-link active" href="#">Marketplaces</a></li>
</ul>
<?php
session_start();
 echo'<div class="user mt-auto pt-4">'.$_SESSION["nome"].' '. $_SESSION["sobrenome"].'</div>';
?>
</div>
 
    <main class="p-4 flex-grow-1 bg-light">
<h4 class="text-orange">Marketplace</h4>
<button class="btn btn-orange mb-3">+ Cadastrar novo Marketplace</button>
 
      <div class="table-responsive">
<table class="table table-bordered bg-white">
<thead class="table-light">
<tr>
<th>Marketplace</th>
<th>Status</th>
<th>Conexão</th>
<th>Produtos</th>
<th>Ação</th>
</tr>
</thead>
<tbody>
<tr>
<td>Amazon</td>
<td><span class="badge bg-success">Ativo</span></td>
<td>20/08/2024</td>
<td>155</td>
<td>
<button class="btn btn-warning btn-sm">Editar</button>
<button class="btn btn-danger btn-sm">Excluir</button>
</td>
</tr>
<tr>
<td>Mercado Livre</td>
<td><span class="badge bg-success">Ativo</span></td>
<td>04/08/2024</td>
<td>145</td>
<td>
<button class="btn btn-warning btn-sm">Editar</button>
<button class="btn btn-danger btn-sm">Excluir</button>
</td>
</tr>
<tr>
<td>Shopify</td>
<td><span class="badge bg-warning text-dark">Inativo</span></td>
<td>22/07/2024</td>
<td>100</td>
<td>
<button class="btn btn-warning btn-sm">Editar</button>
<button class="btn btn-danger btn-sm">Excluir</button>
</td>
</tr>
<tr>
<td>Magalu</td>
<td><span class="badge bg-warning text-dark">Inativo</span></td>
<td>12/07/2024</td>
<td>85</td>
<td>
<button class="btn btn-warning btn-sm">Editar</button>
<button class="btn btn-danger btn-sm">Excluir</button>
</td>
</tr>
</tbody>
</table>
</div>
 
      <div class="row mt-4">
<div class="col-md-6">
<h6>Marketplaces disponíveis</h6>
<ul class="list-group">
<li class="list-group-item d-flex justify-content-between align-items-center">
              Ebay <button class="btn btn-orange btn-sm">+ Conectar</button>
</li>
<li class="list-group-item d-flex justify-content-between align-items-center">
              Casas Bahia <button class="btn btn-orange btn-sm">+ Conectar</button>
</li>
<li class="list-group-item d-flex justify-content-between align-items-center">
              Fast <button class="btn btn-orange btn-sm">+ Conectar</button>
</li>
<li class="list-group-item d-flex justify-content-between align-items-center">
              Carrefour <button class="btn btn-orange btn-sm">+ Conectar</button>
</li>
</ul>
</div>
 
        <div class="col-md-6">
<h6>Últimos 30 dias</h6>
<div class="card mb-2">
<div class="card-body">
<h6>Amazon</h6>
<p>Total de vendas: <strong>500</strong></p>
<p>Receita: <strong>R$5.250</strong></p>
<p class="mb-0"><small>Produto mais vendido:</small><br><strong>Fone de Ouvido Bluetooth com Cancelamento de Ruído</strong></p>
</div>
</div>
 
          <div class="card">
<div class="card-body">
<h6>Mercado Livre</h6>
<p>Total de vendas: <strong>450</strong></p>
<p>Receita: <strong>R$4.800</strong></p>
<p class="mb-0"><small>Produto mais vendido:</small><br><strong>Smartwatch com Monitor de Frequência Cardíaca</strong></p>
</div>
</div>
</div>
</div>
</main>
</div>
</body>
</html>