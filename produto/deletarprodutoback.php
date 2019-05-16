<?php
if (!isset($_SESSION)) session_start();
include("../connection/connect.php");
include("../connection/verificarlogin.php");
logado();
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$query = delete("produto", "where id_produto = $id");
if($query == true){
    $_SESSION['produto_Deletado'] = TRUE;
    echo "Sucesso";
}else{
    $_SESSION['produto_errodel'] = TRUE;
}
header('location: ../fornecedor/listarfornecedorfront.php');

?>