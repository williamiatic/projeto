<?php
if (!isset($_SESSION)) session_start();
include("../connection/connect.php");
include("../connection/verificarlogin.php");
logado();

// Variaveis vindas da pagina ../screen/cadastrarfornecedor.php
$nometransportadora = mysqli_real_escape_string(connect(), trim($_POST['nometransportadora'])); // Não Pode Ser Nulo
$endereco = mysqli_real_escape_string(connect(), trim($_POST['endereco'])); // Não Pode Ser Nulo
$cnpj = mysqli_real_escape_string(connect(), trim($_POST['cnpj'])); // Não Pode Ser Nulo
$cidadeid = nulo(mysqli_real_escape_string(connect(), trim($_POST['Select_Cidades']))); // Não Pode Ser Nulo
$num_endereco = nulo(mysqli_real_escape_string(connect(), trim($_POST['num_endereco']))); 
$bairro = nulo(mysqli_real_escape_string(connect(), trim($_POST['bairro'])));
$cep = nulo(mysqli_real_escape_string(connect(), trim($_POST['cep'])));
$telefone = nulo(mysqli_real_escape_string(connect(), trim($_POST['telefone']))); // Não Pode Ser Nulo

// Select para saber se o usuario existe. caso exista retornar para a pagina ../screen/cadastrartransportadora.php
//($_SESSION['transportadora_exists'] serve para mostrar notificação que a transportadora ja esta cadastradas)
$query = select("transportadora", "*", "where cnpj = '{$cnpj}' and empresa_id = {$_SESSION['id']}");
if($query == true){
    echo "Fornecedor Existe!";
    $_SESSION['transportadora_exists'] = TRUE;
    header('location: ../screen/cadastransportadora.php');
    exit;
}
// Caso passe pelo if anterior dar insert nos valores vindos da pagina ../screen/cadastrartransportadora.php
//($_SESSION['user_not_exists'] serve para mostrar notificação que a transportadora acabou de ser cadastrada)
$query = insert(["nm_transportadora", "cnpj", "cidade_id", 'empresa_id'],
                ["$nometransportadora", "$cnpj", "$cidadeid", $_SESSION['id']],
                "transportadora");
if($query == TRUE){
    echo "Dados transportadora Cadastrado! ";
    $query = select("transportadora", "*", "where nm_transportadora = '$nometransportadora' and empresa_id = {$_SESSION['id']}");
    if($query == TRUE){
        $query = insert(["endereco", "num_endereco", "bairro", "cep", "telefone", "transportadora_id"],
                        ["$endereco", "$num_endereco", "$bairro", "$cep", "$telefone", $query[0]['id_transportadora']],
                        "dadoscadastrais");
        if($query == TRUE){
            echo "Dados transportadora em DadosCadastrais Cadastrado! ";
            echo "Sucesso!";
            $_SESSION['user_not_exists'] = TRUE;
            header('location: cadastrartransportadorafront.php');
            exit;
        }
    }else{
        $query = Delete("transportadora", "where nm_transportadora = '$nometransportadora' and empresa_id = {$_SESSION['id']}");
        if($query == TRUE){
            echo "Erro Ao Cadastrar transportadora. ";
            echo "Deletado Com Sucesso!";
            header('location: cadastrartransportadorafront.php');
            $_SESSION['fornecedor_erro'] = TRUE;
        }
    }
}else{
    echo "Deu tudo Errado!";
    $_SESSION['fornecedor_erro'] = TRUE;
    header('location: cadastrartransportadorafront.php');
    exit;
}
?>