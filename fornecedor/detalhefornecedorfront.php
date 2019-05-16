<?php
if (!isset($_SESSION)) session_start();
include("../connection/connect.php");
include("../connection/verificarlogin.php");
logado();
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8"/>
		<title>Listar</title>		
	</head>
	<body>
		<a href="../painel.php">Painel</a><br>
		<h1>Dados Fornecedor</h1>
    <?php
    $idfornecedor = filter_input(INPUT_GET,'id', FILTER_SANITIZE_NUMBER_INT);
    $query = select("fornecedor",
	"id_fornecedor, nm_fornecedor, cnpj, endereco, num_endereco, bairro, cep, telefone, nm_cidade, uf",
	"join dadoscadastrais on fornecedor_id = '$idfornecedor' and id_fornecedor = '$idfornecedor'
    join cidade on id_cidade = cidade_id");
    echo "ID: " . $query[0]['id_fornecedor'] . "<br>";
    echo "Fornecedor: " . $query[0]['nm_fornecedor'] . "<br>";
    echo "CNPJ: " . $query[0]['cnpj'] . "<br>" ;
    echo "cidade: " . $query[0]['nm_cidade'] . "<br>" ;
    echo "UF: " . $query[0]['uf'] . "<br>";
    echo "endereço: " . $query[0]['endereco'] . "<br>" ;
    echo "Num: " . $query[0]['num_endereco'] . "<br>" ;
    echo "Bairro: " . $query[0]['bairro'] . "<br>";
    echo "CEP: " . $query[0]['cep'] . "<br>";
    echo "Telefone: " . $query[0]['telefone'] . "<br>";
	echo "<a href='editarfornecedor.php?id=" . $query[0]['id_fornecedor'] . "'>Editar</a><br>";
	echo "<a href='deletarfornecedorback.php?id=" . $query[0]['id_fornecedor'] . "'>Deletar Fornecedor</a><br><hr>";