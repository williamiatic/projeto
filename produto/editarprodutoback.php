<?php
if (!isset($_SESSION)) session_start();
include("../connection/connect.php");
include("../connection/verificarlogin.php");
logado();
// Variaveis vindas da pagina ../screen/editarproduto.php
$categoriaid = mysqli_real_escape_string(connect(), trim($_POST['categoria'])); // Não pode ser Nulo
$nomeproduto = mysqli_real_escape_string(connect(), trim($_POST['produto'])); // Não pode ser Nulo
$marca = nulo(mysqli_real_escape_string(connect(), trim($_POST['marca'])));
$descricao = nulo(mysqli_real_escape_string(connect(), trim($_POST['descricao'])));
$peso = nulo(mysqli_real_escape_string(connect(), trim($_POST['peso'])));
$controlado = mysqli_real_escape_string(connect(), trim($_POST['controlado'])); // Não pode ser Nulo
$quantidademinima = mysqli_real_escape_string(connect(), trim($_POST['quantidademinima'])); // Não pode ser Nulo
$quantidade = nulo(mysqli_real_escape_string(connect(), trim($_POST['quantidade'])));
$lote = nulo(mysqli_real_escape_string(connect(), trim($_POST['lote'])));
$precounidade = mysqli_real_escape_string(connect(), trim($_POST['precounidade'])); // Não pode ser Nulo
$precolote = nulo(mysqli_real_escape_string(connect(), trim($_POST['precolote'])));
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT); // ID Produto

$query = update(["categoria_id", "nm_produto", "marca", "descricao", "peso", "controlado", "quantidademinima", "quantidade", "lote", "precounidade", "precolote"],
["$categoriaid", "$nomeproduto", "$marca", "$descricao", $peso, "$controlado", $quantidademinima, $quantidade, "$lote", "$precounidade", "$precolote"],
"produto", "where id_produto = '$id'");
if($query == true){
    echo "Sucesso";
    $_SESSION['produto_editado'] = True;
}else{
    $_SESSION['produto_erro'] = True;
    echo "Erro!!!";
}
header('location: ../screen/listar.php?='. $id); // Pode Dar ERRO. Não Testado!