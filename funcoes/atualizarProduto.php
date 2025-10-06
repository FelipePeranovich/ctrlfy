<?php
include_once '../funcoes/banco.php';
$bd = conectar();

$id_produto = filter_input(INPUT_POST,"id_produto",FILTER_SANITIZE_SPECIAL_CHARS);
$titulo = filter_input(INPUT_POST,"titulo",FILTER_SANITIZE_SPECIAL_CHARS);
$variacao = filter_input(INPUT_POST,"variacao",FILTER_SANITIZE_SPECIAL_CHARS);
$custo = filter_input(INPUT_POST,"custo",FILTER_SANITIZE_SPECIAL_CHARS);
$quantidade = filter_input(INPUT_POST,"custo",FILTER_SANITIZE_SPECIAL_CHARS);
$qtdmin = filter_input(INPUT_POST,"qtdmin",FILTER_SANITIZE_SPECIAL_CHARS);
$id_fornecedor = filter_input(INPUT_POST,"id_fornecedor",FILTER_SANITIZE_SPECIAL_CHARS);
$cor = filter_input(INPUT_POST,"cor",FILTER_SANITIZE_SPECIAL_CHARS);
$imagem_antiga = $_POST['imagem'];

$dir_upload = "uploads/";

if (!is_dir($dir_upload)) {
    mkdir($dir_upload, 0755, true);
}
if (isset($_FILES['novaimagem']) && $_FILES['novaimagem']['error'] === UPLOAD_ERR_OK) {
    $extensao = pathinfo($_FILES['novaimagem']['name'], PATHINFO_EXTENSION);
    $imagem_nome = uniqid("produto_") . "." . $extensao;
    $destino = $dir_upload . $imagem_nome;
    
    if(file_exists($imagem_antiga)) {
      unlink($imagem_antiga);
    }

    if (!move_uploaded_file($_FILES['novaimagem']['tmp_name'], $destino)) {
        die("Erro ao fazer upload da imagem.");
    }
     $imagem = $destino;
} else{ 
    $imagem = $_POST['imagem'];
}

$sql = "UPDATE `produto` SET 
`variacao`='$variacao',
`custo`='$custo',
`qtdMin`='$qtdmin',
`cor`='$cor',
`url_imagem`='$imagem',
`quantidade`='$quantidade',
`fk_fornecedor_id_fornecedor`='$id_fornecedor',
`titulo`='$titulo'
 where id_produto = '$id_produto'";
 
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