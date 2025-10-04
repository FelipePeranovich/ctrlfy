<?php
include_once ("../funcoes/banco.php");
try{
$bd = conectar();
$bd->beginTransaction();

$id = filter_input(INPUT_GET,"id_produto",FILTER_SANITIZE_SPECIAL_CHARS);

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