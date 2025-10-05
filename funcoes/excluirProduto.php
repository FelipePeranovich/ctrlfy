<?php
include_once ("../funcoes/banco.php");
try{
$bd = conectar();
$bd->beginTransaction();

$id = filter_input(INPUT_GET,"id_produto",FILTER_SANITIZE_SPECIAL_CHARS);

$getimage = "Select url_imagem from produto where id_produto= '$id'";
$caminhoImagem = $bd->query($getimage);
$res = $caminhoImagem->fetch();


if(file_exists($res['url_imagem'])) {
      unlink($res['url_imagem']);
    }
$consulta = "DELETE FROM produto WHERE id_produto = ?";

$stmt = $bd->prepare($consulta);
$stmt->execute([$id]);
$bd->commit();
}
catch (Exception $e){
  $bd->rollback();
  $bd=null;
  die();
}
header("location:../produtos.php");
?>