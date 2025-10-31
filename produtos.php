<!DOCTYPE html>
<?php
session_start();
    if(empty($_SESSION['nome'])){
        header("location:index.php");
    }
    include_once 'funcoes/banco.php';
    //include_once 'funcoes/listarProdutos.php';
    $bd = conectar();
    //teste filtro
    $busca = filter_input(INPUT_GET,"busca",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $fornecedor = filter_input(INPUT_GET,"fornecedor",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $ordem = filter_input(INPUT_GET,"ordem",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   
    $sql = "select * from produto p join fornecedor f ON p.fk_fornecedor_id_fornecedor = f.id_fornecedor";

    if(!empty($busca)){
        $sql .=" WHERE ( p.titulo LIKE '%$busca%' OR p.id_produto LIKE '%$busca%' OR p.variacao LIKE '%$busca%')";     
        
    }
    if(!empty($fornecedor)){
        $sql = "select * from produto p join fornecedor f where p.fk_fornecedor_id_fornecedor = $fornecedor AND f.id_fornecedor = $fornecedor";
        
     }
    $sql .= " ORDER BY titulo";
    switch($ordem){
        case 'a_z': $sql .= " ASC"; break;
        case 'z_a': $sql .= " DESC"; break;
    }
    // echo $sql;
    // die;
    $stmt = $bd->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $buscaFornecedor = "select * from fornecedor order by nome_fornecedor";
    $resFornecedor = $bd->query($buscaFornecedor);
?>

<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Produtos - Ctrlfy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/produtos.css" />
    <link rel="stylesheet" href="css/modais.css" />
</head>

<body class="bg-light">

    <div class="d-flex flex-column flex-md-row">
        <!-- Sidebar para desktop -->
        <div class="sidebar d-none d-md-flex flex-column text-white p-3" style="width: 220px; height: 100vh;">
            <h4 class="logo">Ctrlfy</h4>
            <ul class="nav flex-column mt-4">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link active" href="produtos.php">Produtos</a></li>
                        <li class="nav-item"><a class="nav-link" href="estoque.php">Estoque</a></li>
                        <li class="nav-item"><a class="nav-link" href="vendas.php">Vendas</a></li>
                        <li class="nav-item"><a class="nav-link" href="etiquetas.php">Etiquetas</a></li>
                        <li class="nav-item"><a class="nav-link" href="marketplace.php">Marketplaces</a></li>
            </ul>
            <div class="mt-auto text-center">
                <a href="funcoes/sair.php" onclick= "return confirm('Tem certeza que deseja sair?');"><button class="btn btn-outline-light w-100 mb-4 "><i class="bi bi-box-arrow-left"></i> Sair</button></a>

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
                        <li class="nav-item"><a class="nav-link active" href="#">Produtos</a></li>
                        <li class="nav-item"><a class="nav-link" href="estoque.php">Estoque</a></li>
                        <li class="nav-item"><a class="nav-link" href="vendas.php">Vendas</a></li>
                        <li class="nav-item"><a class="nav-link" href="etiquetas.php">Etiquetas</a></li>
                        <li class="nav-item"><a class="nav-link" href="marketplace.php">Marketplaces</a></li>
                    </ul>
                    <div class="mt-auto text-center">
                        <a href="funcoes/sair.php"><button class="btn btn-outline-light w-100 mb-4 "><i class="bi bi-box-arrow-left"></i> Sair</button></a>

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
                <h3 class="text-orange fw-bold">Produtos</h3>
               <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalAdicionarProduto">+ Adicionar Produto</button>

                <div class="modal fade" id="modalAdicionarProduto" tabindex="-1" aria-labelledby="modalAdicionarProdutoLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalAdicionarProdutoLabel">Adicionar novo produto</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
                            <form action="funcoes/cadastrarProduto.php" method="POST" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="nomeProduto" class="form-label">Nome do Produto</label>
                                        <input type="text" class="form-control" id="nomeProduto" name="titulo" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="idProduto" class="form-label">ID / SKU</label>
                                        <input type="text" class="form-control" id="idProduto" name="id_produto" required >
                                    </div>
                                    <div class="mb-3">
                                        <label for="categoriaProduto" class="form-label">Descrição</label>
                                        <input type="text" class="form-control" id="categoriaProduto" name="variacao" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="precoProduto" class="form-label">Custo</label>
                                        <input type="number" class="form-control" id="precoProduto" name="custo" step="0.01" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="estoqueProduto" class="form-label">Quantidade total</label>
                                        <input type="number" class="form-control" id="quantidade" name="quantidade" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="qtdmin" class="form-label">Quantidade Minima</label>
                                        <input type="number" class="form-control" id="qtdmin" name="qtdmin" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="id_fornecedor" class="form-label">Fornecedor</label>
                                        <select name="id_fornecedor"class="form-control" id="id_fornecedor" >
                                            <?php
                                            while($for = $resFornecedor->fetch()){
                                                echo "<option value=".$for["id_fornecedor"].">".$for['nome_fornecedor']."</option>";
                                            }
                                            ?>
                                            <!-- <option value="novo" id="id_forncedor">+ Cadastrar novo fornecedor</option> -->
                                        </select> 
                                        <a href="fornecedor.php" class="mt-2" style="display:inline-block; background-color:#ff8c00; color:white; padding:6px 12px; border-radius:8px; text-decoration:none; transition:background-color 0.3s;">Cadastrar Fornecedor</a>   
                                    </div>
                                     <div class="mb-3">
                                        <label for="estoqueProduto" class="form-label">Cor</label>
                                        <input type="text" class="form-control" id="cor" name="cor" required>
                                    </div>           
                                    <div class="mb-3">
                                        <label for="imagemProduto" class="form-label">Capa do Produto</label>
                                        <input type="file" class="form-control" id="imagemProduto" name="imagem" accept="image/*">
                                    </div>

                                    <!-- Pré-visualização da imagem -->
                                    <div class="mb-3 text-center">
                                        <img id="previewImagem" src="" alt="Pré-visualização da imagem" style="max-width: 200px; display: none; border-radius: 8px; margin-top: 10px;">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Salvar Produto</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
                             
            <!-- Filtros -->
            <form action="produtos.php" method="GET">
            <div class="bg-white p-4 rounded shadow-sm mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Buscar por nome, SKU ou descrição..." name="busca" />
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="fornecedor">
                            <option value="">Todos os Fornecedores</option>
                            <?php
                             $resFornecedor = $bd->query($buscaFornecedor);
                                while($for = $resFornecedor->fetch()){
                                echo "<option value=".$for["id_fornecedor"].">".$for['nome_fornecedor']."</option>";
                                }
                             ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="ordem">
                            <option value="a_z">Nome A-Z</option>
                            <option value="z_a">Nome Z-A</option>
                        </select>
                    </div>
                    
                </div>
                </div>
                <div class="mb-3">
                    <a href="produtos.php">
                        <button class="btn btn-warning" type="submit">Atualizar</button>
                    </a>
                </div>
            
            </form>


            <!-- Tabela de produtos -->
            <div class="bg-white p-3 rounded shadow-sm table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th><input type="checkbox" /></th>
                            <th>Foto</th>
                            <th>Produto</th>
                            <th>ID</th>
                            <th>Descrição</th>
                            <th>Custo</th>
                            <th>Estoque</th>
                            <th>Fornecedor</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (count($result) > 0): ?>
                        <?php foreach ($result as $row): ?>
                        <tr>
                            <td><input type="checkbox" /></td>
                            <td><img src="funcoes/<?php echo $row["url_imagem"]?>" class="rounded me-2" style="width:100px; height:100px; object-fit:cover;" /></td>
                            <td>
                                <strong><?php echo $row["titulo"]?></strong><br>
                            </td>
                            <td><?php echo $row["id_produto"] ?></td>
                            <td><?php echo $row["variacao"] ?></td>
                            <td>R$ <?php echo number_format($row["custo"],2,',','.') ?></td>
                            <td><?php echo $row["quantidade"] ?></td>
                            <td><?php echo $row["nome_fornecedor"] ?></td>
                            <td>
                                <?php echo" <a href='edicao.php?id_produto=".$row['id_produto']."' ><button class='btn btn-dark btn-sm'><i class='bi bi-pencil' '></i></button></a>"?> 
                                <?php echo" <a href='funcoes/excluirProduto.php?id_produto=" .$row['id_produto']."' onclick=\"return confirm('Tem certeza que deseja excluir este produto?');\" ><button class='btn btn-danger btn-sm'><i class='bi bi-trash'></i></button></a>"?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: echo"Nenhum produto encontrado"; ?>
                        <?php endif; ?>
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
        </main>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Script para mostrar a imagem carregada
            document.getElementById('imagemProduto').addEventListener('change', function(event) {
                const arquivo = event.target.files[0];
                const preview = document.getElementById('previewImagem');

                if (arquivo) {
                    const leitor = new FileReader();
                    leitor.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                    leitor.readAsDataURL(arquivo);
                } else {
                    preview.src = '';
                    preview.style.display = 'none';
                }
            });

            document.getElementById('id_fornecedor').addEventListener('change', function() {
            if (this.value === 'novo') {
            window.open('fornecedor.php', '_blank');
            }
            });
            
        </script>
</body>
</html>