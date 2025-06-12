<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - Ctrlfy</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/dashboard.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-light">

  <div class="d-flex flex-column flex-md-row">
    <!-- Sidebar para desktop -->
    <div class="sidebar d-none d-md-flex flex-column text-white p-3" style="width: 220px; height: 100vh;">
      <h4 class="logo">Ctrlfy</h4>
      <ul class="nav flex-column mt-4">
        <li class="nav-item"><a class="nav-link active" href="#">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="produtos.php">Produtos</a></li>
        <li class="nav-item"><a class="nav-link" href="estoque.php">Estoque</a></li>
        <li class="nav-item"><a class="nav-link" href="marketplace.php">Marketplaces</a></li>
      </ul>
      <div class="user mt-auto pt-4">João da Silva</div>
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
        <div class="sidebar-mobile p-3">
          <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link active" href="#">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="produtos.php">Produtos</a></li>
            <li class="nav-item"><a class="nav-link" href="estoque.php">Estoque</a></li>
            <li class="nav-item"><a class="nav-link" href="marketplace.php">Marketplaces</a></li>
          </ul>
          <div class="user mt-4 pt-4 text-center">João da Silva</div>
        </div>
      </div>
    </nav>


    <!-- Conteúdo principal -->
    <div class="flex-grow-1 p-4">
      <h3 class="text-orange fw-bold">Dashboard</h3>

      <div class="row text-center mt-4 mb-4 g-3">
        <div class="col-6 col-md bg-white py-3 rounded shadow-sm">
          <h5 class="text-orange">500</h5>
          <p class="mb-0">Total de produtos</p>
        </div>
        <div class="col-6 col-md bg-white py-3 rounded shadow-sm">
          <h5 class="text-success">400</h5>
          <p class="mb-0">Produtos no estoque</p>
        </div>
        <div class="col-6 col-md bg-white py-3 rounded shadow-sm">
          <h5 class="text-primary">R$ 12.400</h5>
          <p class="mb-0">Total de vendas</p>
        </div>
        <div class="col-6 col-md bg-white py-3 rounded shadow-sm">
          <h5 class="text-danger">100</h5>
          <p class="mb-0">Produtos faltando</p>
        </div>
      </div>

      <div class="row mb-4 g-3">
        <div class="col-md-8 bg-white p-3 rounded shadow-sm">
          <h6 class="fw-bold mb-3">Desempenho de Vendas</h6>
          <canvas id="lineChart" height="140"></canvas>
        </div>
        <div class="col-md-4 bg-white p-3 rounded shadow-sm">
          <h6 class="fw-bold mb-3">Vendas por Canal</h6>
          <canvas id="pieChart"></canvas>
        </div>
      </div>

      <div class="bg-white p-3 rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <h6 class="fw-bold">Faltando no estoque</h6>
          <button class="btn btn-warning btn-sm text-white">Veja tudo</button>
        </div>
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead>
              <tr>
                <th>Produto</th>
                <th>ID</th>
                <th>Estoque</th>
                <th>Limite</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Fone de Ouvido Bluetooth com Cancelamento de Ruído</td>
                <td>32424326-Z</td>
                <td>5</td>
                <td>10</td>
                <td><span class="badge bg-danger">Crítico</span></td>
              </tr>
              <tr>
                <td>Smartwatch com Monitor de Frequência Cardíaca</td>
                <td>23232334-S</td>
                <td>3</td>
                <td>8</td>
                <td><span class="badge bg-danger">Crítico</span></td>
              </tr>
              <tr>
                <td>Caixa de Som Portátil à Prova d’Água</td>
                <td>46546564-F</td>
                <td>4</td>
                <td>5</td>
                <td><span class="badge bg-warning text-dark">Médio</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Gráfico de linha
    new Chart(document.getElementById('lineChart'), {
      type: 'line',
      data: {
        labels: ['Jan', 'Fev', 'Mar', 'Maz'],
        datasets: [{
            label: 'Amazon',
            data: [15000, 16000, 16500, 18000],
            borderColor: '#FFA500',
            fill: false
          },
          {
            label: 'Mercado Livre',
            data: [10000, 10500, 11000, 12000],
            borderColor: '#00b894',
            fill: false
          },
          {
            label: 'Shopify',
            data: [5000, 5500, 6000, 7000],
            borderColor: '#0984e3',
            fill: false
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    });

    // Gráfico de pizza
    new Chart(document.getElementById('pieChart'), {
      type: 'doughnut',
      data: {
        labels: ['Amazon', 'Mercado Livre', 'Outros'],
        datasets: [{
          data: [45, 35, 20],
          backgroundColor: ['#FFA500', '#00b894', '#dfe6e9']
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    });
  </script>
</body>

</html>