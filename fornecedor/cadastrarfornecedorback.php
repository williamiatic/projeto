<?php
if (!isset($_SESSION)) session_start();
include("..\connection\connect.php");
include("..\connection\verificarlogin.php");
logado();
// Variaveis vindas da pagina cadastrarfornecedorfront.php
$nomefornecedor = mysqli_real_escape_string(connect(), trim($_POST['nomefornecedor'])); // Não pode ser Nulo
$endereco = mysqli_real_escape_string(connect(), trim($_POST['endereco'])); // Não pode ser Nulo
$cnpj = mysqli_real_escape_string(connect(), trim($_POST['cnpj'])); // Não pode ser Nulo
$cidadeid = nulo(mysqli_real_escape_string(connect(), trim($_POST['Select_Cidades'])));
$num_endereco = mysqli_real_escape_string(connect(), trim($_POST['num_endereco'])); // Não pode ser Nulo
$bairro = mysqli_real_escape_string(connect(), trim($_POST['bairro'])); // Não pode ser Nulo
$cep = mysqli_real_escape_string(connect(), trim($_POST['cep'])); // Não pode ser Nulo
$telefone = mysqli_real_escape_string(connect(), trim($_POST['telefone'])); // Não pode ser Nulo

// Select para saber se o fornecedor ja esta cadastrado. caso cadastrado retornar para a pagina cadastrarfornecedorfront.php
//$_SESSION['fornecedor_existe'] serve para mostrar notificação que o usuario ja esta cadastrado
$query = select("fornecedor", "*", "where nm_fornecedor = '{$nomefornecedor}' and empresa_id = {$_SESSION['id']}"); // {$_SESSION['id']} ID da empresa vindo quando logar no site.
if($query == true){
    echo "Fornecedor Existe!";
    $_SESSION['fornecedor_existe'] = TRUE;
    header('location: cadastrarfornecedorfront.php');
    exit;
}
// Caso passe pelo if anterior dar insert nos valores vindos da pagina cadastrarfornecedorfront.php
//$_SESSION['fornecedor_nao_existe'] serve para mostrar notificação que o fornecedor acabou de ser cadastrado
$query = insert(["nm_fornecedor", "cnpj", "cidade_id", 'empresa_id'],
                ["$nomefornecedor", "$cnpj", "$cidadeid", $_SESSION['id']],
                "fornecedor");
if($query == TRUE){
    echo "Dados Fornecedor Cadastrado! ";
    $query = select("fornecedor", "*", "where nm_fornecedor = '$nomefornecedor' and empresa_id = {$_SESSION['id']}");
    if($query == TRUE){
        $query = insert(["endereco", "num_endereco", "bairro", "cep", "telefone", "fornecedor_id"],
                        ["$endereco", "$num_endereco", "$bairro", "$cep", "$telefone", $query[0]['id_fornecedor']],
                        "dadoscadastrais");
        if($query == TRUE){
            echo "Dados fornecedor em DadosCadastrais Cadastrado! ";
            echo "Sucesso!";
            $_SESSION['fornecedor_nao_existe'] = TRUE;
            header('location: cadastrarfornecedorfront.php');
            exit;
        }
    }else{
        $query = Delete("fornecedor", "where nm_fornecedor = '$nomefornecedor' and empresa_id = {$_SESSION['id']}");
        if($query == TRUE){
            echo "Erro Ao Cadastrar Fornecedor.";
            echo "Deletado Com Sucesso!";
            $_SESSION['fornecedor_erro'] = TRUE;
            header('location: cadastrarfornecedorfront.php');
            exit;
        }
    }
}else{
    echo "Deu tudo Errado!";
    header('location: cadastrarfornecedorfront.php');
    $_SESSION['fornecedor_erro'] = TRUE;
    exit;
}
?>