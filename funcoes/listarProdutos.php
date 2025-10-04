<?php
    $busca = filter_input(INPUT_POST,"busca",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $fornecedor = filter_input(INPUT_POST,"fornecedor",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $ordem = filter_input(INPUT_POST,"ordem",FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    include_once '../funcoes/banco.php';
    $sql = "SELECT * FROM produtos WHERE 1";

    if(!empty($id_produto)){
        $sql .="AND(titulo LIKE %$busca%
    }


?>