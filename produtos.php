<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Produtos - Ctrlfy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/produtos.css" />
</head>

<body class="bg-light">
    <div class="d-flex flex-column flex-md-row">
        <!-- Sidebar desktop -->
        <div class="sidebar d-none d-md-flex flex-column text-white p-3" style="width: 220px; height: 100vh; background-color: #1f252f;">
            <h4 class="logo text-orange">Ctrlfy</h4>
            <ul class="nav flex-column mt-4">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active" href="#">Produtos</a></li>
                <li class="nav-item"><a class="nav-link" href="estoque.php">Estoque</a></li>
                <li class="nav-item"><a class="nav-link" href="marketplace.php">Marketplaces</a></li>
            </ul>
            <?php
          session_start();
        echo'<div class="user mt-auto pt-4">'.$_SESSION["nome"].' '. $_SESSION["sobrenome"].'</div>';
        ?>
        </div>

        <!-- Navbar Mobile -->
        <nav class="navbar navbar-dark d-md-none" style="background-color: #1f252f;">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h4 text-orange">Ctrlfy</span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mobileSidebar">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse" id="mobileSidebar">
                <div class="p-3">
                    <ul class="nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link active" href="#">Produtos</a></li>
                        <li class="nav-item"><a class="nav-link" href="estoque.php">Estoque</a></li>
                        <li class="nav-item"><a class="nav-link" href="marketplace.php">Marketplaces</a></li>
                    </ul>
                    <?php
          session_start();
        echo'<div class="user mt-auto pt-4">'.$_SESSION["nome"].' '. $_SESSION["sobrenome"].'</div>';
        ?>
                </div>
            </div>
        </nav>

        <!-- Conteúdo principal -->
        <main class="main-content p-4 flex-grow-1">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="text-orange fw-bold">Produtos</h3>
                <button class="btn btn-warning text-white">+ Adicionar Produto</button>
            </div>

            <!-- Filtros -->
            <div class="bg-white p-4 rounded shadow-sm mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Buscar por nome, SKU ou descrição..." />
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option>Todas as Categorias</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option>Todos os Estoques</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select">
                            <option>Nome A-Z</option>
                            <option>Nome Z-A</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Tabela de produtos -->
            <div class="bg-white p-3 rounded shadow-sm table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th><input type="checkbox" /></th>
                            <th>Produto</th>
                            <th>ID</th>
                            <th>Categoria</th>
                            <th>Preço</th>
                            <th>Estoque</th>
                            <th>Status</th>
                            <th>Marketplaces</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="checkbox" /></td>
                            <td>
                                <strong>Fone de Ouvido Sem Fio</strong><br>
                                <small>Adicionado: 15 Jun 2023</small>
                            </td>
                            <td>WH-001</td>
                            <td>Eletrônicos</td>
                            <td>R$ 89,99</td>
                            <td>15</td>
                            <td><span class="badge bg-success">Em Estoque</span></td>
                            <td><img src="img1.png" width="20" /></td>
                            <td>
                                <button class="btn btn-dark btn-sm"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Paginação -->
                <nav>
                    <ul class="pagination justify-content-end">
                        <li class="page-item disabled"><a class="page-link">‹</a></li>
                        <li class="page-item active"><a class="page-link">1</a></li>
                        <li class="page-item"><a class="page-link">2</a></li>
                        <li class="page-item"><a class="page-link">3</a></li>
                        <li class="page-item"><a class="page-link">›</a></li>
                    </ul>
                </nav>
            </div>

            <!-- Seção de novo produto -->
            <div class="border-top mt-4 pt-3">
                <h6 class="text-muted">Adicionar novo produto</h6>
                <table class="table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" /></th>
                            <th>Nome</th>
                            <th>ID</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>