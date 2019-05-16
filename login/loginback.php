<?php
session_start();
include("../Connection/connect.php");
// Teste para ver se os campos de email e Senhas estão vazios na tela loginfront.php
if(empty($_POST['email']) || empty($_POST['password'])){
    echo "Campo Vazio";
    $_SESSION['empty'] = TRUE;
    header('location: loginfront.php');
    exit();
}
// Variaveis vindas dda pagina loginfront.php
$email = mysqli_real_escape_string(connect(), $_POST['email']);
$password = mysqli_real_escape_string(connect(), $_POST['password']);

// Select para testar se o usuario e a senha estão correstos e pegar o nome para mostrar na proxima tela Se For " Empresa ".
$query = select("empresa", "*", "where email = '{$email}' and senha = md5('{$password}')");
if ($query == true) {
    echo "Empresa Logou!";
    $_SESSION['id'] = $query[0]['id_empresa'];
    $_SESSION['nome'] = $query[0]['nm_empresa'];
    header('Location: ../painel.php');
    exit();
}

// Select para testar se o usuario e a senha estão correstos e pegar o nome para mostrar na proxima tela Se For " Funcionario ".
$query = select("funcionario", "nm_funcionario, empresa_id", "where email = '{$user}' and senha = md5('{$password}')");
if ($query == True){
    echo "Funcionario Logou";
    $_SESSION['id'] = $query[0]['empresa_id'];
    $_SESSION['nome'] = $query[0]['nm_funcionario'];
    header('Location: ../painel.php');
    exit();
}else { // Os Valores Estão Invalidos!;
    echo "Valores Invalidos!";
    $_SESSION['nao_autenticado'] = TRUE;
    header('Location: loginfront.php');
    exit();
}
?>