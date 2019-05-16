<?php
if (!isset($_SESSION)) session_start();
include("connection/connect.php");
include("connection/verificarlogin.php");
logado();

?>
<h2>Olá, <?php echo $_SESSION['nome']?></h2>
<h2>ID Da Empresa é: <?php echo $_SESSION['id']?></h2>
<h2> <a href="fornecedor/cadastrarfornecedorfront.php">Cadastrar Fornecedor</a></h2>
<h2> <a href="fornecedor/listarfornecedorfront.php">Cadastrar Produto</a></h2>
<h2> <a href="produto/listarprodutoscadastradofront.php">Listar Produtos Cadastrados</a></h2>
<h2> <a href="produto/listarprodutosestoquefront.php">Listar Produtos em Estoque</a></h2>
<h2> <a href="transportadora/cadastrartransportadorafront.php">Cadastrar Transportadora</a></h2>
<h2> <a href="transportadora/listartransportadorafront.php">Ainda Fazer Listar Transportadora</a></h2>
<h2> <a href="loja/cadastrarlojafront.php">Cadastrar Loja</a></h2>
<h2> <a href="loja/listarlojafront.php">Listar Lojas</a></h2>
<h2> <a href="registrar/cadastrarfuncionariofront.php">Cadastrar Funcionario</a></h2>
<h2> <a href="pedido/fazerpedidofront.php">Fazer Pedido de Produtos(Pedidos)</a></h2>
<h2> <a href="pedido/listarpedidosfront.php">Listar Pedidos De Produtos(Pedidos)</a></h2>
<h2> <a href="envio/cadastrarenviofront.php">Fazer Pedido de Produtos(Envios)</a></h2>
<h2> <a href="envio/listarenviofront.php">Listar Pedido de Produtos(Envios)</a></h2>
<h2> <a href="connection/logout.php">Sair</a></h2>
