<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Marketplaces - Ctrlfy</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/marketplace.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body class="bg-light">

  <div class="d-flex flex-column flex-md-row">
    <!-- Sidebar para desktop -->
    <div class="sidebar d-none d-md-flex flex-column text-white p-3" style="width: 220px; height: 100vh;">
      <h4 class="logo">Ctrlfy</h4>
      <ul class="nav flex-column mt-4">
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="produtos.php">Produtos</a></li>
        <li class="nav-item"><a class="nav-link" href="estoque.php">Estoque</a></li>
        <li class="nav-item"><a class="nav-link" href="vendas.php">Vendas</a></li>
        <li class="nav-item"><a class="nav-link active" href="#">Marketplaces</a></li>
      </ul>
      <div class="mt-auto text-center">
        <button class="btn btn-outline-light w-100 mb-4 "><i class="bi bi-box-arrow-left"></i> Sair</button>

        <?php
        session_start();
        echo '<div class="user mt-auto pt-3">' . $_SESSION["nome"] . ' ' . $_SESSION["sobrenome"] . '</div>';
        ?>
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
            <li class="nav-item"><a class="nav-link" href="produtos.php">Produtos</a></li>
            <li class="nav-item"><a class="nav-link" href="estoque.php">Estoque</a></li>
            <li class="nav-item"><a class="nav-link" href="vendas.php">Vendas</a></li>
            <li class="nav-item"><a class="nav-link active" href="#">Marketplaces</a></li>
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
    <main class="main-content p-4 flex-grow-1">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-orange fw-bold">Marketplace</h3>
      </div>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <button class="btn btn-warning text-white">+ Cadastrar novo Marketplace</button>
      </div>


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

        <div class="col-md-6 mt-4 mt-md-0">
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>