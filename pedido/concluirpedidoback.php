<?php
if (!isset($_SESSION)) session_start();
include("../connection/connect.php");
include("../connection/verificarlogin.php");
logado();

date_default_timezone_set('America/Sao_Paulo');
$date = date('Y-m-d H:i:s'); // Setar Qual Horario (Falta Fazer)

$identrada = filter_input(INPUT_GET,'id', FILTER_SANITIZE_NUMBER_INT);
$idempresa = $_SESSION['id'];
$query = select("entrada", "*", "where id_entrada = $identrada and empresa_id = $idempresa");
$queryupdate = update(["dateentr", "concluido"], ["$date", "1"], "entrada", "where id_entrada = $identrada and empresa_id = {$_SESSION['id']}");
if ($queryupdate == TRUE){
    echo "Sucesso Update";
    $queryinsert = insert(["quantidade", "valor", "produto_id", "entrada_id", "empresa_id"],
                [$query[0]['quantidade'], $query[0]['preco'], $query[0]['produto_id'], $query[0]['id_entrada'], $_SESSION['id']],
                "itementrada");
    if($queryinsert == TRUE){
        echo "Sucesso Insert entradavalor";
        $produtoid =  $query[0]["produto_id"];
        $selectproduto = select("produto", "quantidade", "where id_produto = $produtoid");
        $quantidade = $selectproduto[0]['quantidade'] + $query[0]['quantidade'];
        $query = update("quantidade", $quantidade, "produto", "where id_produto = $produtoid and empresa_id = {$_SESSION['id']}");
        if($query == TRUE){
            echo "Sucesso!!!";
            header('location: listarpedidosfront.php');
            exit;
        }else{
            echo "Deu tudo Errado!";
            header('location: listarpedidosfront.php');
            exit;
        }
    }else{
        echo "Deu tudo Errado!";
        header('location: listarpedidosfront.php');
        exit;
    }
}else{
    echo "Deu tudo Errado!";
    header('location: listarpedidosfront.php');
    exit;
}
?>