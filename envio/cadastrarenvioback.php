<?php
session_start();
include("../Connection/connect.php");
include("../Backendscreen/verificarlogin.php");
logado();

// Variaveis vindas da pagina cadastrarenviofront.php
$idproduto = mysqli_real_escape_string(connect(),($_POST['Select_produto'])); // Não pode ser Nulo
$loja = mysqli_real_escape_string(connect(),($_POST['Select_loja'])); // Não pode ser Nulo
$quantidade = mysqli_real_escape_string(connect(), trim($_POST['quantidade'])); // Não pode ser Nulo
$frete = nulo(mysqli_real_escape_string(connect(), trim($_POST['frete'])));
$notafiscal = nulo(mysqli_real_escape_string(connect(), trim($_POST['notafiscal'])));
$preco = mysqli_real_escape_string(connect(), trim($_POST['preco'])); // Não pode ser Nulo
$imposto = nulo(mysqli_real_escape_string(connect(), trim($_POST['imposto'])));
$transportadora = nulo(mysqli_real_escape_string(connect(), ($_POST['transportadora'])));
if ($idproduto == 'Produto - Fornecedor'){
    echo "Opção Invalida";
}
if ($loja == 'loja'){
    echo "Opção Invalida";
}
date_default_timezone_set('America/Sao_Paulo');
$date = date('Y-m-d H:i:s');
$idempresa = $_SESSION['id'];
$query = insert(["dateped", "quantidade", "frete", "num_notafiscal", "imposto", "transportadora_id", "produto_id", "empresa_id", "preco", "loja_id", "concluido"],
                ["$date", "$quantidade", "$frete", "$notafiscal", "$imposto", "$transportadora", "$idproduto", "$idempresa", "$preco", "$loja", 0],
                "saida");
if($query == TRUE){
    $selectproduto = select("produto", "quantidade", "where id_produto = $idproduto");
    $quantidade = $selectproduto[0]['quantidade'] - $quantidade;
    $query = update("quantidade", $quantidade, "produto", "where id_produto = $idproduto and empresa_id = $idempresa");
    if($query == TRUE){
        echo "Sucesso!";
        header('location: cadastrarenviofront.php');
        exit;
    }else{
        echo "Deu Errado!";
        header('location: cadastrarenviofront.php');
        exit;
    }
}else{
    echo "Deu tudo Errado!";
    header('location: cadastrarenviofront.php');
    exit;
}
?>