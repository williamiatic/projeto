<?php
if (!isset($_SESSION)) session_start();
include("../connection/connect.php");
include("../connection/verificarlogin.php");
logado();
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$query = delete("transportadora", "where id_transportadora = $id");
if($query == true){
    $_SESSION['transportadora_Deletada'] = TRUE;
    echo "Sucesso";
}else{
    $_SESSION['transportadora_errodel'] = TRUE;
}
header('location: listartransportadorafront.php');

?>