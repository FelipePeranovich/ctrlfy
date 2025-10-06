<html lang="pt-br">
<?php
session_start();
include_once ("funcoes/banco.php");
$bd = conectar();
$id = filter_input(INPUT_GET,"id_produto",FILTER_SANITIZE_SPECIAL_CHARS);
$sql = "SELECT * FROM produto where id_produto = '$id'";
$resultado = $bd->query($sql);
$res = $resultado->fetch();
$a = $res['fk_fornecedor_id_fornecedor'];
$buscaFornecedor = "SELECT *
FROM fornecedor ORDER BY CASE 
        WHEN id_fornecedor = '$a' THEN 0
        ELSE 1
    END,
    id_fornecedor;";

$resFornecedor = $bd->query($buscaFornecedor);

?>
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
                <li class="nav-item"><a class="nav-link" href="dashboard.php" onclick= "return confirm('Tem certeza que deseja sair da edição?');">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active" href="produtos.php" onclick= "return confirm('Tem certeza que deseja sair da edição?');">Produtos</a></li>
                <li class="nav-item"><a class="nav-link" href="estoque.php" onclick= "return confirm('Tem certeza que deseja sair da edição?');">Estoque</a></li>
                <li class="nav-item"><a class="nav-link" href="vendas.php" onclick= "return confirm('Tem certeza que deseja sair da edição?');">Vendas</a></li>
                <li class="nav-item"><a class="nav-link" href="marketplace.php" onclick= "return confirm('Tem certeza que deseja sair da edição?');">Marketplaces</a></li>
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
                        <li class="nav-item"><a class="nav-link" href="dashboard.php" onclick= "return confirm('Tem certeza que deseja sair da edição?');" >Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link active" href="produtos.php" onclick= "return confirm('Tem certeza que deseja sair da edição?');">Produtos</a></li>
                        <li class="nav-item"><a class="nav-link" href="estoque.php" onclick= "return confirm('Tem certeza que deseja sair da edição?');">Estoque</a></li>
                        <li class="nav-item"><a class="nav-link" href="vendas.php" onclick= "return confirm('Tem certeza que deseja sair da edição?');">Vendas</a></li>
                        <li class="nav-item"><a class="nav-link" href="marketplace.php" onclick= "return confirm('Tem certeza que deseja sair da edição?');">Marketplaces</a></li>
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

        <!-- Conteúdo principal -->
        <div class="main-content flex-grow-1 ps-md-2 pt-4">
                  <div class="container-fluid">
                        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                              <h3 class="text-orange fw-bold">Edição</h3>
                        </div>
                    </div>
                    <form action="funcoes/atualizarProduto.php" method="POST" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="nomeProduto" class="form-label">Nome do Produto</label>
                                        <input type="text" class="form-control" id="nomeProduto" name="titulo" required value="<?=$res['titulo']?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="idProduto" class="form-label">ID / SKU</label>
                                        <input type="text" class="form-control" id="idProduto" name="id_produto" readonly value="<?=$res['id_produto']?>" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="categoriaProduto" class="form-label">Descrição</label>
                                        <input type="text" class="form-control" id="categoriaProduto" name="variacao" required value="<?=$res['variacao']?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="precoProduto" class="form-label">Custo</label>
                                        <input type="number" class="form-control" id="precoProduto" name="custo" step="0.01" required value="<?=$res['custo']?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="estoqueProduto" class="form-label">Quantidade total</label>
                                        <input type="number" class="form-control" id="quantidade" name="quantidade" required value="<?=$res['quantidade']?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="qtdmin" class="form-label">Quantidade Minima</label>
                                        <input type="number" class="form-control" id="qtdmin" name="qtdmin" required value="<?=$res['qtdMin']?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="id_fornecedor" class="form-label">Fornecedor</label>
                                        <select name="id_fornecedor"class="form-control" id="id_fornecedor" >
                                            <?php
                                            while($for = $resFornecedor->fetch()){
                                                echo "<option value=".$for["id_fornecedor"].">".$for['nome_fornecedor']."</option>";
                                            }
                                            ?>
                                            <option value="novo">+ Cadastrar novo fornecedor</option>
                                        </select>    
                                    </div>
                                     <div class="mb-3">
                                        <label for="estoqueProduto" class="form-label">Cor</label>
                                        <input type="text" class="form-control" id="cor" name="cor" required value="<?=$res['cor']?>">
                                    </div>           
                                    <div class="mb-3">
                                        <label for="imagemProduto" class="form-label">Capa do Produto</label>
                                        <input type="file" class="form-control" id="imagemProduto" name="novaimagem" accept="image/*">
                                    </div>
                                    <input type="hidden" name="imagem" value="<?=$res['url_imagem']?>">

                                    <!-- Pré-visualização da imagem -->
                                    <div class="mb-3 text-center">
                                        <img id="previewImagem" 
                                            src="funcoes/<?= $res['url_imagem'] ?>" 
                                            alt="Pré-visualização da imagem" 
                                            style="max-width: 200px; border-radius: 8px; margin-top: 10px;"
                                            <?= $res['url_imagem'] ? '' : 'style="display:none;"' ?>>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Salvar Produto</button>
                                   <a href="produtos.php" onclick= "return confirm('Tem certeza que deseja cancelar a edição?');"> <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button></a>
                                </div>
                            </form>
        </div>

        
                


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