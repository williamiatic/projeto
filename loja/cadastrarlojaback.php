<?php
if (!isset($_SESSION)) session_start();
include("../connection/connect.php");
include("../connection/verificarlogin.php");
logado();

// Variaveis vindas da pagina cadastrarlojafront.php
$nomeloja = mysqli_real_escape_string(connect(), trim($_POST['nomeloja'])); // Não Pode Ser Nulo
$endereco = mysqli_real_escape_string(connect(), trim($_POST['endereco'])); // Não Pode Ser Nulo 
$cnpj = mysqli_real_escape_string(connect(), trim($_POST['cnpj'])); // Não Pode Ser Nulo
$cidadeid = mysqli_real_escape_string(connect(), trim($_POST['Select_Cidades'])); // Não Pode Ser Nulo
$num_endereco = nulo(mysqli_real_escape_string(connect(), trim($_POST['num_endereco']))); 
$bairro = nulo(mysqli_real_escape_string(connect(), trim($_POST['bairro'])));
$cep = nulo(mysqli_real_escape_string(connect(), trim($_POST['cep'])));
$telefone = mysqli_real_escape_string(connect(), trim($_POST['telefone'])); // Não Pode Ser Nulo
// Select para saber se o loja existe. caso exista retornar para a pagina cadastrarlojafront.php
//$_SESSION['loja_exists'] serve para mostrar notificação que o usuario ja esta cadastrado
$query = select("loja", "*", "where nm_loja = '{$nomeloja}' and empresa_id = {$_SESSION['id']}");
if($query == true){
    echo "Loja Existe!";
    $_SESSION['loja_exists'] = TRUE;
    header('location: ../screen/cadastrarloja.php');
    exit;
}
// Caso passe pelo if anterior dar insert nos valores vindos da pagina cadastrarlojafront.php
//$_SESSION['loja_nao_existe'] serve para mostrar notificação que a loja acabou de ser cadastrada
$query = insert(["nm_loja", "cnpj", "cidade_id", 'empresa_id'],
                ["$nomeloja", "$cnpj", "$cidadeid", $_SESSION['id']],
                "loja");
if($query == TRUE){
    echo "Dados Loja Cadastrado! ";
    $query = select("loja", "*", "where nm_loja = '$nomeloja' and empresa_id = {$_SESSION['id']}");
    if($query == TRUE){
        $query = insert(["endereco", "num_endereco", "bairro", "cep", "telefone", "loja_id"],
                        ["$endereco", "$num_endereco", "$bairro", "$cep", "$telefone", $query[0]['id_loja']],
                        "dadoscadastrais");
        if($query == TRUE){
            echo "Dados Loja em DadosCadastrais Cadastrado! ";
            echo "Sucesso!";
            $_SESSION['loja_nao_existe'] = TRUE;
            header('location: cadastrarlojafront.php');
            exit;
        }
    }else{
        $query = Delete("loja", "where nm_loja = '$nomeloja' and empresa_id = {$_SESSION['id']}");
        if($query == TRUE){
            echo "Erro Ao Cadastrar Loja. ";
            echo "Deletado Com Sucesso!";
            $_SESSION['fornecedor_erro'] = TRUE;
            header('location: cadastrarlojafront.php');
            exit;
        }
    }
}else{
    echo "Deu tudo Errado!";
    $_SESSION['fornecedor_erro'] = TRUE;
    header('location: cadastrarlojafront.php');
    exit;
}
?>