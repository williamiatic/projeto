<?php
if (!isset($_SESSION)) session_start();
include("../connection/connect.php");
include("../connection/verificarlogin.php");
logado();

date_default_timezone_set('America/Sao_Paulo');
$date = date('Y-m-d H:i:s');

$idsaida = filter_input(INPUT_GET,'id', FILTER_SANITIZE_NUMBER_INT);
$idempresa = $_SESSION['id'];
$queryupdate = update(["dateentrega", "concluido"], ["$date", "1"], "saida", "where id_saida = $idsaida and empresa_id = {$_SESSION['id']}");

if ($queryupdate == TRUE){
    echo "Sucesso Update";
    $query = select("saida", "*", "where id_saida = $idsaida and empresa_id = $idempresa");
    $queryinsert = insert(["quantidade", "valor", "produto_id", "saida_id", "empresa_id"],
                [$query[0]['quantidade'], $query[0]['preco'], $query[0]['produto_id'], $query[0]['id_saida'],"$idempresa"],
                "itemsaida");
    if($queryinsert == TRUE){
        echo "Sucesso Insert saida";
        if($query == TRUE){
            echo "Sucesso!!!";
        }else{
            echo "Deu tudo Errado!";
            header('location: listarenviofront.php');
            exit;
        }
    }else{
        echo "Deu tudo Errado!";
        header('location: listarenviofront.php');
        exit;
    }
}else{
    echo "Deu tudo Errado!";
    header('location: listarenviofront.php');
    exit;
}
?>