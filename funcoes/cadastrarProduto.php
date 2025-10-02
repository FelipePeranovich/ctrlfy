<?php

$id_produto = filter_input(INPUT_POST,"id_produto",FILTER_SANITIZE_SPECIAL_CHARS);
$titulo = filter_input(INPUT_POST,"titulo",FILTER_SANITIZE_SPECIAL_CHARS);
$variacao = filter_input(INPUT_POST,"variacao",FILTER_SANITIZE_SPECIAL_CHARS);
$custo = filter_input(INPUT_POST,"custo",FILTER_SANITIZE_SPECIAL_CHARS);
$qtdmin = filter_input(INPUT_POST,"qtdmin",FILTER_SANITIZE_SPECIAL_CHARS);
$fornecedor = filter_input(INPUT_POST,"fornecedor",FILTER_SANITIZE_SPECIAL_CHARS);
$cor = filter_input(INPUT_POST,"id_produto",FILTER_SANITIZE_SPECIAL_CHARS);

if($id_produto==null){
    echo "<script>alert('ID DO PRODUTO INVÁLIDO');javascript:history.go(-1)</script>";
    die();
}

$dir_upload = "uploads/";
if (!is_dir($dir_upload)) {
    mkdir($dir_upload, 0755, true);
}
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
    $imagem_nome = uniqid("produto_") . "." . $extensao;
    $destino = $dir_upload . $imagem_nome;

    if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
        die("Erro ao fazer upload da imagem.");
    }
}

include_once '../funcoes/banco.php';
$bd = conectar();
$sql = " INSERT INTO `produto`(`id_produto`, `titulo`, `variacao`, `custo`, `qtdMin`, `fornecedor`, `cor`, `url_imagem`) values".
        "('$id_produto','$titulo','$variacao','$custo','$qtdmin','$fornecedor','$cor', '$destino') ";


$verifica_id = "select * from produto where id_produto = $id_produto";
$teste = $bd->query($verifica_id);
if($teste -> rowCount()!=0){
    echo "<script>alert('ID DO PRODUTO INVÁLIDO');javascript:history.go(-1)</script>";
    die();
}  

$bd->beginTransaction();

    $i = $bd->exec($sql);  
        if ($i != 1){
            $bd->rollBack();
        }
    else {  
        $bd->commit();       
        header("location:../produtos.php");
    }


$bd = null;

?>