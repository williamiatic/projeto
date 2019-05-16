<?php
if (!isset($_SESSION)) session_start();
include("../connection/connect.php");
include("../connection/verificarlogin.php");
logado();
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$query = delete("fornecedor", "where id_fornecedor = $id");
if($query == true){
    $_SESSION['Fornecedor_Deletado'] = TRUE;
    echo "Sucesso";
}else{
    $_SESSION['fornecedor_errodel'] = TRUE;
}

header('location: listarfornecedorfront.php');

?>