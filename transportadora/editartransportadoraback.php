<?php
if (!isset($_SESSION)) session_start();
include("../connection/connect.php");
include("../connection/verificarlogin.php");
logado();
// Variaveis vindas da pagina editartransportadorafront.php
$cidadeid = mysqli_real_escape_string(connect(), $_POST['cidade']); // Não pode ser Nulo
$nometransportadora = mysqli_real_escape_string(connect(), trim($_POST['transportadora'])); // Não pode ser Nulo
$cnpj = mysqli_real_escape_string(connect(), trim($_POST['cnpj'])); // Não pode ser Nulo
$endereco = mysqli_real_escape_string(connect(), trim($_POST['endereco'])); // Não pode ser Nulo
$num_endereco = nulo(mysqli_real_escape_string(connect(), trim($_POST['num_endereco'])));
$bairro = mysqli_real_escape_string(connect(), trim($_POST['bairro']));
$cep = mysqli_real_escape_string(connect(), trim($_POST['cep'])); // Não pode ser Nulo
$telefone = mysqli_real_escape_string(connect(), trim($_POST['telefone'])); // Não pode ser Nulo
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT); // ID Transportadora

$query = update(["cidade_id", "nm_transportadora", "cnpj"],
["$cidadeid", "$nometransportadora", "$cnpj"],
"transportadora", "where id_transportadora = '$id'");
if($query == true){
    echo "Sucesso update transportadora";
    $query = update(['endereco', 'num_endereco', 'bairro', 'cep', 'telefone'],
    ["$endereco", "$numendereco", "$bairro", "$cep", "$telefone"],
    "dadoscadastrais", "where transportadora_id = '$id'");
    if($query == true){
        $_SESSION['transportadora_editada'] = True;
        header('location: listartransportadorafront.php?');
        exit;
    }else{
        $_SESSION['transportadora_erro'] = True;
        header('location: listartransportadorafront.php?');
        exit;
    }
}else{
    $_SESSION['transportadora_erro'] = True;
    echo "Erro!!!";
    header('location: listartransportadorafront.php?');
    exit;
}