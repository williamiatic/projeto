<?php
if (!isset($_SESSION)) session_start();
include("../connection/connect.php");
include("../connection/verificarlogin.php");
logado();
// Variaveis vindas da pagina cadastrarprodutofront.php
$categoria = mysqli_real_escape_string(connect(), trim($_POST['select_categoria'])); // Não pode ser Nulo
$nomeproduto = mysqli_real_escape_string(connect(), trim($_POST['nomeproduto'])); // Não pode ser Nulo
$marca = nulo(mysqli_real_escape_string(connect(), trim($_POST['marca']))); 
$descricao = nulo(mysqli_real_escape_string(connect(), trim($_POST['descricao'])));
$peso = nulo(mysqli_real_escape_string(connect(), trim($_POST['peso'])));
$controlado = mysqli_real_escape_string(connect(), trim($_POST['controlado'])); // Não pode ser Nulo
$quantidademinima = mysqli_real_escape_string(connect(), trim($_POST['quantidademinima'])); // Não pode ser Nulo
$lote = nulo(mysqli_real_escape_string(connect(), trim($_POST['lote'])));
$precounidade = mysqli_real_escape_string(connect(), trim($_POST['precounidade'])); // Não pode ser Nulo
$precolote = mysqli_real_escape_string(connect(), trim($_POST['precolote']));
// Caso passe pelo if anterior dar insert nos valores vindos da pagina ../screen/cadastrarproduto.php
//($_SESSION['user_not_exists'] serve para mostrar notificação que o usuario acabou de ser cadastrado)
$idfornecedor = filter_input(INPUT_GET,'id', FILTER_SANITIZE_NUMBER_INT); // ID Fornecedor
$query = insert(["categoria_id", "nm_produto", "marca", "descricao", "peso", "controlado", "quantidademinima", "quantidade", "empresa_id", "lote", "fornecedor_id", "precounidade", "precolote"],
                [$categoria, "$nomeproduto", "$marca", "$descricao", $peso, "$controlado", $quantidademinima, '0', $_SESSION['id'], $lote, $idfornecedor, "$precounidade", $precolote],
                "produto");
if($query == TRUE){
    $_SESSION['cadastro_sucesso'] = TRUE;
    echo "Sucesso!";
    header('location: cadastrarprodutofront.php');
    exit;
}else{
    $_SESSION['cadastro_erro'] = TRUE;
    echo "Deu Errado!";
    header('location: ../fornecedor/listarfornecedorfront.php');
    exit;
}
?>