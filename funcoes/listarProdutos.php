<?php
    $busca = filter_input(INPUT_POST,"busca",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $fornecedor = filter_input(INPUT_POST,"fornecedor",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $ordem = filter_input(INPUT_POST,"ordem",FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    include_once 'banco.php';
    $sql = "select * from produto p join fornecedor f where p.fk_fornecedor_id_fornecedor = f.id_fornecedor ORDER BY titulo";

    if(!empty($busca)){
        $sql .=" AND titulo LIKE '%$busca%' OR id_produto LIKE '%$busca%' OR variacao LIKE '%$busca%')";     
    }
    if(!empty($fornecedor)){
        $sql .=" AND nome_fornecedor LIKE '%$fornecedor%'";
    }
    switch($ordem){
        case 'a_z': $sql .= " ORDER BY titulo ASC"; break;
        case 'z_a': $sql .= " ORDER BY titulo DESC"; break;
    }
    // echo $sql;
    // die;
    $bd = conectar();
    $stmt = $bd->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
