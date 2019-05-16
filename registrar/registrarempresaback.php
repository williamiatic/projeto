<?php
session_start();
include("../Connection/connect.php");
// Variaveis vindas da pagina registrarempresaback.php
date_default_timezone_set('America/Sao_Paulo');
$data = date('Y-m-d H:i:s');
$name = mysqli_real_escape_string(connect(), trim($_POST['name'])); // Não pode ser Nulo!
$email = mysqli_real_escape_string(connect(), trim($_POST['email'])); // Não pode ser Nulo!
$password = nulo(mysqli_real_escape_string(connect(), trim(md5($_POST['password'])))); // Não pode ser Nulo!
$cnpj = nulo(mysqli_real_escape_string(connect(), trim($_POST['cnpj']))); // Não pode ser Nulo!
$endereco = nulo(mysqli_real_escape_string(connect(), trim($_POST['endereco']))); // Não pode ser Nulo!
$cidadeid = nulo(mysqli_real_escape_string(connect(), $_POST['Select_Cidades']));
$num_endereco = nulo(mysqli_real_escape_string(connect(), trim($_POST['num_endereco']))); // Não pode ser Nulo!
$bairro = nulo(mysqli_real_escape_string(connect(), trim($_POST['bairro']))); // Não pode ser Nulo!
$cep = nulo(mysqli_real_escape_string(connect(), trim($_POST['cep']))); // Não pode ser Nulo!
$telefone = nulo(mysqli_real_escape_string(connect(), trim($_POST['telefone']))); // Não pode ser Nulo!

// Select para saber se o email esta cadastrado. caso esteja cadastrado ir para registrarempresaback.php
//($_SESSION['user_exists'] serve para mostrar notificação que o usuario ja esta cadastrado)
$query = select("empresa", "*", "where email = '{$email}'");
if($query == true){
    $_SESSION['email_existe'] = TRUE;
    header('location: registrarempresafront.php');
    exit;
}
$query = select("empresa", "*", "where cnpj = '{$cnpj}'");
if($query == true){
    $_SESSION['cnpj_existe'] = TRUE;
    header('location: registrarempresafront.php');
    exit;
}

// Caso passe pelos if anterior dar insert nos valores vindos da pagina registrarempresaback.php
$query = insert(["nm_empresa", "email", "senha","cnpj","cidade_id", "data_cadastro", "nivelacesso"],
                ["$name", "$email", "$password", "$cnpj", $cidadeid, "$data", "5"],
                "empresa");
if($query == TRUE){ // Caso passe pelo primeiro INSERT dar INSERT nos dados Cadastrais
    $query = select("empresa", "id_empresa", "where email = '$email'");
    if ($query == true){
        $query = insert(
        ["endereco", "num_endereco", "bairro", "cep", "telefone", "empresa_id"],
        ["$endereco", "$num_endereco", "$bairro", "$cep", "$telefone", $query[0]['id_empresa']],
        "dadoscadastrais");
        if($query == TRUE){ // Caso der Insert nos Dados Cadastrais mostrar que os dados foi cadastrado com sucesso
            // $_SESSION['cadastrado'] serve para mostrar notificação que o usuario acabou de ser cadastrado
            $_SESSION['cadastrado'] = TRUE;
            header('location: registrarempresafront.php');
            exit;
        }else{ // Caso der Erro ao dar Insert nos DadosCadastrais
            $query = Delete("empresa", "where email = '$email'");
            $_SESSION['cadastro_erro'] = TRUE;
            header('location: registrarempresafront.php');
            exit;
        }
    }else{ // Caso der Erro ao dar Select nos dados da empresa
        $query = Delete("empresa", "where email = '$email'");
        $_SESSION['cadastro_erro'] = TRUE;
        header('location: registrarempresafront.php');
        exit;
    }
}else{ // Caso der Erro ao dar Insert nos dados da empresa
    $_SESSION['cadastro_erro'] = TRUE;
    header('location: registrarempresafront.php');
    exit;
}
?>