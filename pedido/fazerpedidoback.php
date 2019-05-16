<?php
if (!isset($_SESSION)) session_start();
include("../connection/connect.php");
include("../connection/verificarlogin.php");
logado();
// Variaveis vindas da pagina ../screen/cadastrarfornecedor.php
$idproduto = mysqli_real_escape_string(connect(),($_POST['Select_produto'])); // Não Pode Ser Nulo
$quantidade = mysqli_real_escape_string(connect(), trim($_POST['quantidade'])); // Não Pode Ser Nulo
$frete = nulo(mysqli_real_escape_string(connect(), trim($_POST['frete']))); 
$notafiscal = nulo(mysqli_real_escape_string(connect(), trim($_POST['notafiscal'])));
$preco = mysqli_real_escape_string(connect(), trim($_POST['preco'])); // Não Pode Ser Nulo
$imposto = nulo(mysqli_real_escape_string(connect(), trim($_POST['imposto'])));
$transportadora = nulo(mysqli_real_escape_string(connect(), ($_POST['transportadora'])));
// Select para saber se o usuario existe. caso exista retornar para a pagina ../screen/cadastrarfornecedor.php
//($_SESSION['user_exists'] serve para mostrar notificação que o usuario ja esta cadastrado)

if ($idproduto == 'Produto - Fornecedor'){
    echo "Opção Invalida";
}
$date = date('Y-m-d H:i:s'); // Falta Por de onde é a Hora!

// Caso passe pelo if anterior dar insert nos valores vindos da pagina fazerpedidofront.php
$query = insert(["dateped", "quantidade", "frete", "num_notafiscal", "preco","imposto", "transportadora_id", "produto_id", "empresa_id", "concluido"],
                ["$date", "$quantidade", "$frete", "$notafiscal", "$preco", "$imposto", "$transportadora", "$idproduto", $_SESSION['id'], "0"],
                "entrada");
if($query == TRUE){
    echo "Sucesso";
    $_SESSION['pedido_cadastrado'] = True;
    header('location: fazerpedidofront.php');
    exit;
}else{
    echo "Deu tudo Errado!";
    $_SESSION['pedido_erro'] = True;
    header('location: fazerpedidofront.php');
    exit;
}
?>