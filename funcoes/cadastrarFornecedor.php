<?php

$nomeFornecedor = filter_input(INPUT_POST,"nomeFornecedor",FILTER_SANITIZE_SPECIAL_CHARS);


include_once '../funcoes/banco.php';
$bd = conectar();
$sql = " INSERT INTO `fornecedor`(`id_fornecedor`, `nome_fornecedor`) values".
        "(NULL,'$nomeFornecedor') ";


$verifica_nome = "select * from fornecedor where nome_fornecedor = '$nomeFornecedor'";
$teste = $bd->query($verifica_nome);
if($teste -> rowCount()!=0){
    echo "<script>alert('NOME DO FORNECEDOR INVÁLIDO');javascript:history.go(-1)</script>";
    die();
}  

$bd->beginTransaction();

    $i = $bd->exec($sql);  
        if ($i != 1){
            $bd->rollBack();
        }
    else {  
        $bd->commit();       
        echo "<script>
  window.close();
</script>";
    }


$bd = null;

?>