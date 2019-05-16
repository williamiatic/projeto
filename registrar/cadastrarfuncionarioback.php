<?php
if (!isset($_SESSION)) session_start();
include("../connection/connect.php");
include("../connection/verificarlogin.php");
logado();
// Variaveis vindas da pagina cadastrarfuncionariofront.php
$name = mysqli_real_escape_string(connect(), trim($_POST['name'])); // Não Pode Ser Nulo
$email = mysqli_real_escape_string(connect(), trim($_POST['email'])); // Não Pode Ser Nulo
$password = mysqli_real_escape_string(connect(), trim(md5($_POST['password']))); // Não Pode Ser Nulo
$nivelacesso = mysqli_real_escape_string(connect(), trim($_POST['select_nivelacesso'])); // Não Pode Ser Nulo
$endereco = mysqli_real_escape_string(connect(), trim($_POST['endereco'])); // Não Pode Ser Nulo
$cidadeid = mysqli_real_escape_string(connect(), trim($_POST['Select_Cidades'])); // Não Pode Ser Nulo
$num_endereco = nulo(mysqli_real_escape_string(connect(), trim($_POST['num_endereco'])));
$bairro = nulo(mysqli_real_escape_string(connect(), trim($_POST['bairro'])));
$cep = nulo(mysqli_real_escape_string(connect(), trim($_POST['cep'])));
$telefone = mysqli_real_escape_string(connect(), trim($_POST['telefone'])); // Não Pode Ser Nulo
$idempresa = $_SESSION['id'];
// Select para saber se o usuario existe. caso exista retornar para a pagina cadastrarfuncionariofront.php
//($_SESSION['user_exists'] serve para mostrar notificação que o usuario ja esta cadastrado)
$query = select("funcionario", "*", "where nm_funcionario = '{$name}'");
if($query == true){
    echo "teste1";
    $_SESSION['user_exists'] = TRUE;
    header('location: cadastrarfuncionariofront.php');
    exit;
}

// Caso passe pelo if anterior dar insert nos valores vindos da pagina cadastrarfuncionariofront.php
//($_SESSION['user_not_exists'] serve para mostrar notificação que o usuario acabou de ser cadastrado)
$query = insert(["nm_funcionario", "email", "senha","nivelacesso","cidade_id", "data_cadastro", "empresa_id"],
                ["$name", "$email", "$password", "$nivelacesso", $cidadeid, "NOW()", "$idempresa"],
                "funcionario");
if($query == TRUE){ // Caso passe pelo primeiro INSERT dar INSERT nos dados Cadastrais
    echo "Sucesso Primeiro Insert";
    $query = select("funcionario", "*", "where nm_funcionario = '$name'");
    if ($query == true){
        echo "Sucesso Select";
        $query = insert(
        ["endereco", "num_endereco", "bairro", "cep", "telefone", "funcionario_id"],
        ["$endereco", "$num_endereco", "$bairro", "$cep", "$telefone", $query[0]['id_funcionario']],
        "dadoscadastrais");
        if($query == TRUE){ // Caso der Insert nos Dados Cadastrais mostrar que os dados foi cadastrado com sucesso
            echo "Sucesso Segundo Insert";
            $_SESSION['user_not_exists'] = TRUE;
            header('location: cadastrarfuncionariofront.php');
            exit;
        }else{ // Caso der Erro ao dar Insert nos DadosCadastrais
            echo "Deletando funcionario. Deu Erro em Dados Cadastrais";
            $query = Delete("funcionario", "where nm_funcionario = '$name'");
            $_SESSION['cadastro_erro'] = TRUE;
            header('location: cadastrarfuncionariofront.php');
            exit;
        }
    }else{ // Caso der Erro ao dar Select nos dados da empresa
        echo "Erro ao dar Select";
        $query = Delete("funcionario", "where nm_funcionario = '$name'");
        $_SESSION['cadastro_erro'] = TRUE;
        header('location: cadastrarfuncionariofront.php');
        exit;
    }
}else{ // Caso der Erro ao dar Insert nos dados da empresa
    echo "Deu tudo Errado!";
    $_SESSION['cadastro_erro'] = TRUE;
    header('location: cadastrarfuncionariofront.php');
    exit;
}
?>