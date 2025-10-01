<!DOCTYPE html>
<html lang="pt-br">

<head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Estoque - Ctrlfy</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
      <link rel="stylesheet" href="css/estoque.css" />
</head>

<body class="bg-light">

      <div class="d-flex flex-column flex-md-row">
            <!-- Sidebar para desktop -->
            <div class="sidebar d-none d-md-flex flex-column text-white p-3" style="width: 220px; height: 100vh;">
                  <h4 class="logo">Ctrlfy</h4>
                  <ul class="nav flex-column mt-4">
                        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="produtos.php">Produtos</a></li>
                        <li class="nav-item"><a class="nav-link active" href="estoque.php">Estoque</a></li>
                        <li class="nav-item"><a class="nav-link" href="marketplace.php">Marketplaces</a></li>
                  </ul>
                  <?php
                        session_start();
                        echo'<div class="user mt-auto pt-4">'.$_SESSION["nome"].' '. $_SESSION["sobrenome"].'</div>';
                  ?>
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
                        <div class="sidebar-mobile p-3 align-items-center justify-content-center">
                              <ul class="nav flex-column">
                                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                                    <li class="nav-item"><a class="nav-link" href="produtos.php">Produtos</a></li>
                                    <li class="nav-item"><a class="nav-link active" href="estoque.php">Estoque</a></li>
                                    <li class="nav-item"><a class="nav-link" href="marketplace.php">Marketplaces</a></li>
                              </ul>
                              <?php
          session_start();
        echo'<div class="user mt-auto pt-4">'.$_SESSION["nome"].' '. $_SESSION["sobrenome"].'</div>';
        ?>
                        </div>
                  </div>
            </nav>



            <div class="main-content flex-grow-1 ps-md-2 pt-4">
                  <div class="container-fluid">
                        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                              <h3 class="text-orange fw-bold">Estoque</h3>
                              <div class="mt-2 mt-md-0">
                                    <button class="btn btn-secondary me-2">Exportar</button>
                                    <button class="btn btn-warning text-white">+ Inserir novo produto</button>
                              </div>
                        </div>

                        <!-- Filtros -->
                        <div class="bg-white p-4 rounded shadow-sm mb-4">
                              <div class="row">
                                    <div class="col-md-4 mb-3">
                                          <input type="text" class="form-control" placeholder="Pesquise pelo título ou SKU">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                          <select class="form-select">
                                                <option selected>Todos os marketplaces</option>
                                                <option>Amazon</option>
                                                <option>Mercado Livre</option>
                                                <option>Shopify</option>
                                          </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                          <select class="form-select">
                                                <option selected>Todos os status</option>
                                                <option>Ativo</option>
                                                <option>Inativo</option>
                                                <option>Faltando</option>
                                          </select>
                                    </div>
                              </div>
                        </div>

                        <!-- Estatísticas -->
                        <div class="row text-center mb-4 g-3">
                              <div class="col-6 col-md bg-white py-3 rounded shadow-sm">
                                    <h5 class="text-orange">400</h5>
                                    <p class="mb-0">Total de produtos</p>
                              </div>
                              <div class="col-6 col-md bg-white py-3 rounded shadow-sm">
                                    <h5 class="text-success">320</h5>
                                    <p class="mb-0">Produtos ativos</p>
                              </div>
                              <div class="col-6 col-md bg-white py-3 rounded shadow-sm">
                                    <h5 class="text-warning">40</h5>
                                    <p class="mb-0">Produtos inativos</p>
                              </div>
                              <div class="col-6 col-md bg-white py-3 rounded shadow-sm">
                                    <h5 class="text-danger">40</h5>
                                    <p class="mb-0">Produtos faltando</p>
                              </div>
                        </div>

                        <!-- Tabela -->
                        <div class="bg-white p-3 rounded shadow-sm">
                              <div class="table-responsive">
                                    <table class="table align-middle">
                                          <thead>
                                                <tr>
                                                      <th>Lista</th>
                                                      <th>SKU</th>
                                                      <th>Marketplace</th>
                                                      <th>Preço</th>
                                                      <th>Status</th>
                                                </tr>
                                          </thead>
                                          <tbody>
                                                <tr>
                                                      <td><input type="checkbox" class="form-check-input me-2">Fone de Ouvido Bluetooth com Cancelamento de Ruído<br><small>ID do produto: 32424326</small></td>
                                                      <td>32424326-Z</td>
                                                      <td>Amazon</td>
                                                      <td>R$120,00</td>
                                                      <td><span class="badge bg-success">Ativo</span></td>
                                                </tr>
                                                <tr>
                                                      <td><input type="checkbox" class="form-check-input me-2">Smartwatch com Monitor de Frequência Cardíaca<br><small>ID do produto: 23232334</small></td>
                                                      <td>23232334-S</td>
                                                      <td>Shopify</td>
                                                      <td>R$100,00</td>
                                                      <td><span class="badge bg-success">Ativo</span></td>
                                                </tr>
                                                <tr>
                                                      <td><input type="checkbox" class="form-check-input me-2">Caixa de Som Portátil à Prova d’Água<br><small>ID do produto: 46546564</small></td>
                                                      <td>46546564-F</td>
                                                      <td>Amazon</td>
                                                      <td>R$350,00</td>
                                                      <td><span class="badge bg-warning text-dark">Inativo</span></td>
                                                </tr>
                                                <tr>
                                                      <td><input type="checkbox" class="form-check-input me-2">Teclado Mecânico Gamer RGB<br><small>ID do produto: 32432555</small></td>
                                                      <td>32432555-H</td>
                                                      <td>Mercado Livre</td>
                                                      <td>R$150,00</td>
                                                      <td><span class="badge bg-warning text-dark">Inativo</span></td>
                                                </tr>
                                                <tr>
                                                      <td><input type="checkbox" class="form-check-input me-2">Máquina de Café Expresso Automática<br><small>ID do produto: 87436555</small></td>
                                                      <td>87436555-R</td>
                                                      <td>Amazon</td>
                                                      <td>R$300,00</td>
                                                      <td><span class="badge bg-danger">Faltando</span></td>
                                                </tr>
                                          </tbody>
                                    </table>
                              </div>
                        </div>
                  </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>