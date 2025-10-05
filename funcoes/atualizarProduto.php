<?php
$newid_produto = filter_input(INPUT_POST,"id_produto",FILTER_SANITIZE_SPECIAL_CHARS);
$newtitulo = filter_input(INPUT_POST,"titulo",FILTER_SANITIZE_SPECIAL_CHARS);
$newvariacao = filter_input(INPUT_POST,"variacao",FILTER_SANITIZE_SPECIAL_CHARS);
$newcusto = filter_input(INPUT_POST,"custo",FILTER_SANITIZE_SPECIAL_CHARS);
$newquantidade = filter_input(INPUT_POST,"custo",FILTER_SANITIZE_SPECIAL_CHARS);
$newqtdmin = filter_input(INPUT_POST,"qtdmin",FILTER_SANITIZE_SPECIAL_CHARS);
$newid_fornecedor = filter_input(INPUT_POST,"id_fornecedor",FILTER_SANITIZE_SPECIAL_CHARS);
$newcor = filter_input(INPUT_POST,"cor",FILTER_SANITIZE_SPECIAL_CHARS);

$sql = "SELECT * FROM produtos where id_produto = $newid_produto";

?>