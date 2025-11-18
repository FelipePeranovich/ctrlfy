<!DOCTYPE html>
<?php
session_start();
    if(empty($_SESSION['nome'])){
        header("location:index.php");
    }

    include_once 'funcoes/banco.php';
    $bd = conectar();
    $buscaFornecedor = "select * from fornecedor order by nome_fornecedor";
    $resFornecedor = $bd->query($buscaFornecedor);
?>

<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fornecedores - Ctrlfy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/fornecedor.css" />
</head>

<body class="bg-light">

    <div class="d-flex flex-column flex-md-row">
        <!-- Sidebar para desktop -->
        <div class="sidebar d-none d-md-flex flex-column text-white p-3" style="width: 220px; height: 100vh;">
            <h4 class="logo">Ctrlfy</h4>
            <ul class="nav flex-column mt-4">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="estoque.php">Estoque</a></li>
                        <li class="nav-item"><a class="nav-link" href="vendas.php">Vendas</a></li>
                        <li class="nav-item"><a class="nav-link" href="etiquetas.php">Etiquetas</a></li>
                        <li class="nav-item"><a class="nav-link" href="marketplace.php">Marketplaces</a></li>
            </ul>
            <div class="mt-auto text-center">
                <a href="funcoes/sair.php"><button class="btn btn-outline-light w-100 mb-4 "><i class="bi bi-box-arrow-left"></i> Sair</button></a>

                <?php
                
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
                        <li class="nav-item"><a class="nav-link" href="estoque.php">Estoque</a></li>
                        <li class="nav-item"><a class="nav-link" href="vendas.php">Vendas</a></li>
                        <li class="nav-item"><a class="nav-link" href="etiquetas.php">Etiquetas</a></li>
                        <li class="nav-item"><a class="nav-link" href="marketplace.php">Marketplaces</a></li>
                    </ul>
                    <div class="mt-auto text-center">
                        <a href="funcoes/sair.php" onclick= "return confirm('Tem certeza que deseja sair?');"><button class="btn btn-outline-light w-100 mb-4 "><i class="bi bi-box-arrow-left"></i> Sair</button></a>

                        <?php
                        session_start();
                        echo '<div class="user mt-auto pt-3">' . $_SESSION["nome"] . ' ' . $_SESSION["sobrenome"] . '</div>';
                        ?>
                    </div>
                </div>
            </div>
        </nav>

        <main class="main-content p-4 flex-grow-1">
  <div class="container-fluid">

    <!-- Título -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="text-orange fw-bold">Fornecedores</h3>
    </div>

    <!-- Formulário de Cadastro -->
    <div class="card shadow-sm mb-4 p-3">
      <form action="funcoes/cadastrarFornecedor.php" method="POST" enctype="multipart/form-data">
        <div class="row align-items-end">
          <div class="col-md-6">
            <label for="nomeFornecedor" class="form-label">Nome Fornecedor</label>
            <input type="text" class="form-control" id="nomeFornecedor" name="nomeFornecedor" required>
          </div>

          <div class="col-md-6 text-end mt-3">
            <button type="submit" class="btn btn-success">Salvar Fornecedor</button>
            <button type="button" class="btn btn-secondary" onclick="confirmarVoltar()">Cancelar</button>
          </div>
        </div>
      </form>
    </div>

    <!-- Tabela de fornecedores -->
            <div class="bg-white p-3 rounded shadow-sm table-responsive" style="border-radius: 12px; overflow: hidden; border: 2px solid #dee2e6; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Fornecedor</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                     <tbody>
                        <tr>
                        <td>Amazon</td>
                        <td><span class="badge bg-success">Ativo</span></td>
                        <td>
                            <button class="btn btn-danger btn-sm">Excluir</button>
                        </td>
                        </tr>
                        <tr>
                        <td>Mercado Livre</td>
                        <td><span class="badge bg-success">Ativo</span></td>
                        <td>
                            <button class="btn btn-danger btn-sm">Excluir</button>
                        </td>
                        </tr>
                        <tr>
                        <td>Shopify</td>
                        <td><span class="badge bg-warning text-dark">Inativo</span></td>
                        <td>
                            <button class="btn btn-danger btn-sm">Excluir</button>
                        </td>
                        </tr>
                        <tr>
                        <td>Magalu</td>
                        <td><span class="badge bg-warning text-dark">Inativo</span></td>
                        <td>
                            <button class="btn btn-danger btn-sm">Excluir</button>
                        </td>
                        </tr>
                    </tbody>
                </table>
  </div>
</main>

</body>
<script>
function confirmarVoltar() {
    if (confirm('Tem certeza que deseja cancelar e voltar à página anterior?')) {
        history.back();
    }
}
</script>
</html>