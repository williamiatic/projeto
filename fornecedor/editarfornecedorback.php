<?php
if (!isset($_SESSION)) session_start();
include("connection/connect.php");
include("connection/verificarlogin.php");
logado();

$nomefornecedor = mysqli_real_escape_string(connect(), trim($_POST['nomefornecedor'])); //Não Pode ser Nulo
$cnpj = mysqli_real_escape_string(connect(), trim($_POST['cnpj'])); //Não Pode ser Nulo
$endereco = mysqli_real_escape_string(connect(), trim($_POST['endereco'])); //Não Pode ser Nulo 
$num_endereco = nulo(mysqli_real_escape_string(connect(), trim($_POST['num_endereco'])));
$cidade = nulo(mysqli_real_escape_string(connect(), trim($_POST['cidade'])));
$bairro = nulo(mysqli_real_escape_string(connect(), trim($_POST['bairro'])));
$cep = nulo(mysqli_real_escape_string(connect(), trim($_POST['cep'])));
$telefone = mysqli_real_escape_string(connect(), trim($_POST['telefone'])); //Não Pode ser Nulo
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT); // ID Fornecedor

$query = update(["nm_fornecedor", "cnpj", "cidade_id"],
                ["$nomefornecedor", "$cnpj", "$cidade"],
                "fornecedor", "where id_fornecedor = $id");
if($query == TRUE){
    echo "Dados Fornecedor Atualizados! ";
    $query = select("fornecedor", "*", "where id_fornecedor = $id and empresa_id = {$_SESSION['id']}");
    if($query == TRUE){
        echo "Select Sucesso! ";
        $query = update(["endereco", "num_endereco", "bairro", "cep", "telefone", "fornecedor_id"],
                        ["$endereco", "$num_endereco", "$bairro", "$cep", "$telefone", $query[0]['id_fornecedor']],
                        "dadoscadastrais", "where fornecedor_id = $id");
        if($query == TRUE){
            echo "Dados fornecedor em Dados Cadastrais Atualizados! ";
            echo "Sucesso!";
            $_SESSION['fornecedor_atualizado'] = True;
            header('location: listarfornecedorfront.php');
            exit;
        }
    }else{
        $_SESSION['fornecedor_erro'] = True;
        echo "Erro Ao Atualizar Fornecedor. ";
        header('location: listarfornecedorfront.php');
    }
}else{
    $_SESSION['fornecedor_erro'] = True;
    echo "Deu tudo Errado!";
    header('location: listarfornecedorfront.php');
    exit;
}